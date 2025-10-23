<?php
namespace App\Kipedreiro\Controllers;

use App\Kipedreiro\Models\Servico;
use App\Kipedreiro\Database\Database;
use App\Kipedreiro\Models\Produto;
use App\Kipedreiro\Models\Pedido;

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

    public function getServicos() {
        $dados = $this->servicoModel->buscarServicosAtivos();
        foreach ($dados as &$servico) {
            $servico['caminho_imagem'] = '/backend/upload/' . $servico['foto_servico'];
    
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
                'status' => 'success', 
                'message' => 'Pedido recebido com sucesso!', 
                'id_pedido' => $novoPedidoId
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'status' => 'error', 
                'message' => 'Ocorreu um erro ao processar seu pedido. Tente novamente.'
            ]);
        }
        exit;
    }
}