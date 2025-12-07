<?php
namespace App\Kipedreiro\Controllers;

use App\Kipedreiro\Database\Database;
use App\Kipedreiro\Models\Usuario;
use App\Kipedreiro\Core\ChaveApi;
class APIUsuarioController{
    private $usuarioModel;
    private $chaveAPI;
    public function __construct(){
        $this->chaveAPI = new ChaveApi();
        $this->chaveAPI->validarChave();
        $db = Database::getInstance();
        $this->usuarioModel = new Usuario($db);
        
    }
    
    public function getUsuarios($pagina=0) {
        $registros_por_pagina = $pagina===0 ? 200 : 5;
        $pagina = $pagina===0 ? 1 : (int)$pagina;
        $dados = $this->usuarioModel->paginacaoAPI($pagina, $registros_por_pagina);
        foreach($dados['data'] as &$usuario) {
            unset($usuario['senha_usuario']);
        }
        unset($usuario);
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode([
            'status' => 'success',
            'data' => $dados
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        
        exit;
    }
    public function salvarUsuario() {
        header('Content-Type: application/json');
        $usuario = json_decode(file_get_contents('php://input'), true);
        if (empty($usuario) || !is_array($usuario)) {
            echo json_encode(['status' => 'error', 'message' => 'Nenhum item recebido no carrinho.']);
            exit;
        }
        
        $novoPedidoId = $this->usuarioModel->inseriUsuario(
            $usuario["nome_usuario"],
            $usuario["email_usuario"],
            $usuario["senha_usuario"] || '',
            $usuario["tipo_usuario"],
            $usuario["status_usuario"] || 'Ativo'
        );
        if ($novoPedidoId) {
            http_response_code(201);
            echo json_encode([
                'status' => 'success', 'message' => 'cadastrado com sucesso!',  'id_pedido' => $novoPedidoId
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