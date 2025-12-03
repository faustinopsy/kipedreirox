<?php
namespace App\Kipedreiro\Core;

class ChaveApi{
    private string $chave;
    public function __construct(){
        $this->chave = "9D67A537A9329E0F1E9D088A1C991F1CC728EA87D3D154B409ED3320EA940303";
    }
    private function buscaChaveAPI(){
        $headers = getallheaders();
        if (!isset($headers["Authorization"])) {
            return false;
        }
        $token = explode(" ", $headers["Authorization"])[1];
        return $token === $this->chaveAPI;
    }
    public function validarChave() {
        if (!$this->buscaChaveAPI()) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error', 'message' => 'chave de API inválida'
            ]);
            exit;
        } 
    }

}