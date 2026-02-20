<?php
namespace App\Kipedreiro;
require __DIR__ ."/../vendor/autoload.php";
use App\Kipedreiro\Rotas\Rotas;
use Exception;
use Bramus\Router\Router;
$router = new Router();

// define('API_KEY', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855');

// function verAutorizacao() {
//     $headers = getallheaders();
//     try {
//         if ((isset($headers['X-API-KEY']) && $headers['X-API-KEY'] === API_KEY) || (isset($headers['X-Api-Key']) && $headers['X-Api-Key'] === API_KEY)) {
//             return true;
//         } else {
//             throw new Exception("Chave de Api Invalida");
//         }
//     } catch (Exception $e) {
//         echo json_encode(["status"=> false, "message" => $e->getMessage()]);
//         http_response_code(401);
//         exit();
//     }
// }
// verAutorizacao();


// Configurar Base Path dinamicamente
$scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$router->setBasePath($scriptName);

$rotas = Rotas::get();
$router->setNamespace('\App\Kipedreiro\Controllers');
                    //metodoHttp =GET POST    rota= URL
foreach ($rotas as $metodoHttp => $rota) {
    foreach ($rota as $uri => $acao) {
        $metodoBramus = strtolower($metodoHttp);
        $router->{$metodoBramus}($uri, $acao); //a mágica acontece aqui
    }
}
$router->set404(function () {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    require __DIR__ . '/Views/templates/errors/404.php';
});

try {
    $router->run();
} catch (\Throwable $e) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error');
    // Log do erro (opcional, mas recomendado)
    error_log($e->getMessage());
    
    $errorMessage = $e->getMessage();
    require __DIR__ . '/Views/templates/errors/500.php';
}