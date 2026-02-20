<?php
namespace App\Kipedreiro\Core;

class ChaveApi{
    private string $chaveAPI;
    public function __construct(){
        $this->chaveAPI = "9D67A537A9329E0F1E9D088A1C991F1CC728EA87D3D154B409ED3320EA940303";
    }
    private function buscaChaveAPI(){
        $headers = getallheaders();
        
        // Normaliza headers (alguns servidores enviam minúsculo)
        $authHeader = null;
        if (isset($headers["Authorization"])) {
            $authHeader = $headers["Authorization"];
        } elseif (isset($headers["authorization"])) {
            $authHeader = $headers["authorization"];
        }

        if (!$authHeader) {
            return false;
        }
        
        // Esperado: "Bearer TOKEN"
        $parts = explode(" ", $authHeader);
        
        // Verifica se tem 2 partes e se a primeira é Bearer
        if (count($parts) < 2 || strcasecmp($parts[0], 'Bearer') != 0) {
            return false;
        }

        $token = $parts[1];
        return hash_equals($this->chaveAPI, $token); // hash_equals proteje contra timing attacks
    }

    public function validarChave() {
        if (!$this->buscaChaveAPI()) {
            http_response_code(401); // 401 Unauthorized é o correto para falta de credenciais validas
            echo json_encode([
                'status' => 'error', 
                'message' => 'Acesso não autorizado. Chave de API inválida ou ausente.',
                'code' => 401
            ]);
            exit;
        } 
    }

}