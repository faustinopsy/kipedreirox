<?php
namespace App\Kipedreiro;
require_once __DIR__.'/../vendor/autoload.php';
use App\Kipedreiro\Rotas\Rotas;

$rotas = Rotas::get();

$metodo = $_SERVER["REQUEST_METHOD"] ?? '';
$uri = $_SERVER["REQUEST_URI"] ?? '';
$caminho = parse_url($uri, PHP_URL_PATH); 

if (!array_key_exists($metodo, $rotas)) {
    http_response_code(405);
    echo json_encode(['error' => 'Método HTTP não suportado']);
    exit;
}

$rotasEspecificas = $rotas[$metodo];
if (!array_key_exists($caminho, $rotasEspecificas)) {
    http_response_code(404);
    echo json_encode(['error' => 'Rota não encontrada']);
    exit;
}

$controllerMetodo = explode('@', $rotasEspecificas[$caminho]);
$nomeController = $controllerMetodo[0];
$metodoDaClasse = $controllerMetodo[1];
$classeController = "\\App\\Kipedreiro\\Controllers\\{$nomeController}";
if (!class_exists($classeController)) {
    http_response_code(500);
    echo json_encode(['error' => 'Controlador não encontrado']);
    exit;
}

$controller = new $classeController();
if (!method_exists($controller, $metodoDaClasse)) {
    http_response_code(500);
    echo json_encode(['error' => 'Ação não encontrada no controlador']);
    exit;
}

$controller->$metodoDaClasse();