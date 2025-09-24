<?php
namespace App\Kipedreiro;
require_once __DIR__.'/../vendor/autoload.php';

use App\Kipedreiro\Controllers\UsuarioController;

$caminho = $_SERVER["REQUEST_URI"];
$metodo = $_SERVER["REQUEST_METHOD"];
$rotas = [
    'GET' => [
        '/backend/buscarusuarios' => 'UsuarioController@index',

    ],
    'POST' => [
        '/backend/registrar' => 'UsuarioController@registrar',
        '/backend/login' => 'UsuarioController@login',
        '/backend/atualizar' => 'UsuarioController@atualizar',
        '/backend/deletar' => 'UsuarioController@deletar',
    ],
];
switch ($metodo) {
    case 'GET':
        $rotasEspecificas = $rotas['GET'];
         if (array_key_exists($caminho, $rotasEspecificas)) {
            $controllerAction = explode('@', $rotasEspecificas[$caminho]);
            $controllerName = $controllerAction[0];
            $actionName = $controllerAction[1];
            // Instancia o controlador e chama a ação
            $controllerClass = "\\App\\Kipedreiro\\Controllers\\{$controllerName}";
            $controller = new $controllerClass();

            if (method_exists($controller, $actionName)) {
                 $controller->$actionName();
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Ação não encontrada']);
                exit;
            }
         } else {
            http_response_code(404);
            echo json_encode(['error' => 'Rota não encontrada']);
            exit;
         }
        break;
    case 'POST':
        
        break;
   default:
        // Método HTTP não suportado
        http_response_code(405);
        echo json_encode(['error' => 'Método HTTP não suportado']);
        exit;
}
   