<?php
namespace App\Kipedreiro\Controllers;

use App\Kipedreiro\Database\Database;
use App\Kipedreiro\Models\Usuario;

class ApiUsuarioController{
    private $usuarioModel;
    public function __construct(){
        $db = Database::getInstance();
        $this->usuarioModel = new Usuario($db);
    }

    public function getUsuarios() {
        $dados = $this->usuarioModel->paginacaoNova(1,5);
        foreach ($dados['data'] as &$usuario) {
            unset($usuario['senha_usuario']);
            unset($usuario['total']);
            unset($usuario['por_pagina']);
            unset($usuario['pagina_atual']);
            unset($usuario['ultima_pagina']);
            unset($usuario['de']);
            unset($usuario['para']);
        }
        
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode([
            'status' => 'success',
            'data' => $dados
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        
        exit;
    }

    public function salvarusuario() {
        header('Content-Type: application/json');
        $dadosUsuarios = json_decode(file_get_contents('php://input'), true);
        if (empty($dadosUsuarios) || !is_array($dadosUsuarios)) {
            echo json_encode(['status' => 'error', 'message' => 'Nenhum item recebido no dadosUsuarios .']);
            exit;
        }
        $novousuarioId = $this->usuarioModel->criarusuario($dadosUsuarios);
        if ($novousuarioId) {
            http_response_code(201);
            echo json_encode([
                'status' => 'success', 'message' => 'usuario recebido com sucesso!',  'id_usuario' => $novousuarioId
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'status' => 'error', 'message' => 'Ocorreu um erro ao processar seu usuario. Tente novamente.'
            ]);
        }
        exit;
    }
}