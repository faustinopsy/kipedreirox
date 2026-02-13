<?php
namespace App\Kipedreiro\Controllers;

use OpenApi\Attributes as OA;

use App\Kipedreiro\Models\Servico;
use App\Kipedreiro\Database\Database;
use App\Kipedreiro\Models\Produto;
use App\Kipedreiro\Models\Pedido;


#[OA\Info(title: "Kipedreiro API", version: "1.0.0")]
class PublicApiController{
    private $servicoModel;
    private $produtoModel;
    private $pedidoModel;
    public function __construct(){
        $db = Database::getInstance();
        $this->servicoModel = new Servico($db);
        $this->produtoModel = new Produto($db);
        $this->pedidoModel = new Pedido($db);
    }

    #[OA\Get(
        path: "/api/servicos",
        summary: "Listar serviços ativos"
    )]
    #[OA\Response(
        response: 200,
        description: "Lista de serviços ativos"
    )]
    public function getServicos() {
        $dados = $this->servicoModel->buscarServicosAtivos();
        foreach ($dados as &$servico) {
            $servico['caminho_imagem'] = '/backend/upload/' . $servico['foto_servico'];
            // converter a imagem em base64
            $caminho_imagem = dirname(__DIR__) . '/upload/' . $servico['foto_servico'];
            if(file_exists($caminho_imagem)){
                $tipo = pathinfo($caminho_imagem, PATHINFO_EXTENSION);
                $dados_imagem = file_get_contents($caminho_imagem);
                $base64 = base64_encode($dados_imagem);
                $servico['image_base64'] = 'data:image/' . $tipo . ';base64,' . $base64;
            }else{
                 $servico['image_base64'] = "";
            }
        }
        unset($servico); 
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode([
            'status' => 'success',
            'data' => $dados
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        
        exit;
    }

    public function getProdutos(){
        header('Content-Type: application/json');
        $dados = $this->produtoModel->buscarProdutosAtivos();
        http_response_code(200);
        echo json_encode(['status' => 'success', 'data' => $dados], JSON_UNESCAPED_SLASHES);
        exit;
    }

    #[OA\Post(
        path: "/api/servicos",
        summary: "Cadastrar novo serviço",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "nome_servico", type: "string", example: "Construção"),
                    new OA\Property(property: "descricao_servico", type: "string", example: "Descrição do serviço..."),
                    new OA\Property(property: "image_base64", type: "string", description: "Imagem em formato Base64 (data:image/...)")
                ]
            )
        )
    )]
    #[OA\Response(
        response: 201,
        description: "Serviço cadastrado com sucesso"
    )]
    public function salvarServicoAPI() {
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);

        // Check if input follows the wrapper structure or flat structure
        $dados = $input;
        if (isset($input['data']) && is_array($input['data']) && count($input['data']) > 0) {
            $dados = $input['data'][0];
        }

        if (empty($dados['nome_servico']) || empty($dados['descricao_servico'])) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Campos obrigatórios faltando (nome_servico, descricao_servico).'], JSON_UNESCAPED_SLASHES);
            exit;
        }

        $nome = $dados['nome_servico'];
        $descricao = $dados['descricao_servico'];
        $foto_caminho_banco = ''; // Default if no image

        // Handle Base64 Image
        if (!empty($dados['image_base64'])) {
            $base64_string = $dados['image_base64'];
            
            // Extract extension and data
            if (preg_match('/^data:image\/(\w+);base64,/', $base64_string, $type)) {
                $base64_string = substr($base64_string, strpos($base64_string, ',') + 1);
                $type = strtolower($type[1]); // jpg, png, gif, webp
                
                if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png', 'webp' ])) {
                    http_response_code(400);
                    echo json_encode(['status' => 'error', 'message' => 'Formato de imagem inválido.']);
                    exit;
                }
                
                $data = base64_decode($base64_string);
                if ($data === false) {
                    http_response_code(400);
                    echo json_encode(['status' => 'error', 'message' => 'Falha ao decodificar imagem Base64.']);
                    exit;
                }

                // Generate filename and save
                $filename = uniqid() . '.' . $type;
                $upload_dir = dirname(__DIR__) . '/upload/servicos/';
                
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                
                if(file_put_contents($upload_dir . $filename, $data)) {
                    $foto_caminho_banco = 'servicos/' . $filename;
                } else {
                    http_response_code(500);
                    echo json_encode(['status' => 'error', 'message' => 'Erro ao salvar arquivo de imagem.']);
                    exit;
                }
            }
        }

        $id = $this->servicoModel->inserirServico($nome, $descricao, $foto_caminho_banco);

        if ($id) {
            http_response_code(201);
            echo json_encode([
                'status' => 'success',
                'message' => 'Serviço cadastrado com sucesso!',
                'data' => [[
                    'id_servico' => $id,
                    'nome_servico' => $nome,
                    'descricao_servico' => $descricao,
                    'foto_servico' => $foto_caminho_banco,
                    'caminho_imagem' => '/backend/upload/' . $foto_caminho_banco,
                    'image_base64' => '' // Don't echo back the massive base64 string
                ]]
            ], JSON_UNESCAPED_SLASHES);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Erro ao inserir serviço no banco de dados.']);
        }
        exit;
    }

    public function salvarPedido() {
        header('Content-Type: application/json');
        $carrinho = json_decode(file_get_contents('php://input'), true);
        if (empty($carrinho) || !is_array($carrinho)) {
            echo json_encode(['status' => 'error', 'message' => 'Nenhum item recebido no carrinho.']);
            exit;
        }
        $novoPedidoId = $this->pedidoModel->criarPedido($carrinho);
        if ($novoPedidoId) {
            http_response_code(201);
            echo json_encode([
                'status' => 'success', 'message' => 'Pedido recebido com sucesso!',  'id_pedido' => $novoPedidoId
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'status' => 'error', 'message' => 'Ocorreu um erro ao processar seu pedido. Tente novamente.'
            ]);
        }
        exit;
    }
}