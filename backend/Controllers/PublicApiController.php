<?php
namespace App\Kipedreiro\Controllers;

use App\Kipedreiro\Models\Servico;
use App\Kipedreiro\Database\Database;

class PublicApiController{
    private $servicoModel;

    public function __construct(){
        $db = Database::getInstance();
        $this->servicoModel = new Servico($db);
    }

    public function getServicos() {
        $dados = $this->servicoModel->buscarServicosAtivos();
        foreach ($dados as &$servico) {
            $servico['caminho_imagem'] = '/backend/upload/' . $servico['foto_servico'];
    
        }
        unset($servico); 
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'data' => $dados
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        
        exit;
    }
}