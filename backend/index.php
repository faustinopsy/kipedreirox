<?php
namespace App\Kipedreiro;
require __DIR__ ."/../vendor/autoload.php";

use Bramus\Router\Router;
use App\Kipedreiro\Rotas\Rotas;

$router = new Router();
$rotas = Rotas::get();

$router->setNamespace('\App\Kipedreiro\Controllers');

foreach ($rotas as $metodoHttp => $rota) {
    foreach ($rota as $uri => $acao) {
        $metodoBramus = strtolower($metodoHttp);
        $router->{$metodoBramus}($uri, $acao);
    }
}

$router->set404(function () {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    echo '404, Rota não Encontrada!';
});

$router->run();