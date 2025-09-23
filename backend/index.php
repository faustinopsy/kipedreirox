<?php
namespace App\Kipedreiro;
require_once __DIR__.'/../vendor/autoload.php';

use App\Kipedreiro\Controllers\UsuarioController;

// var_dump($_SERVER["REQUEST_URI"]);
// echo "\n\n\n\n";
// var_dump($_SERVER["REQUEST_METHOD"]);
// exit;
if($_SERVER["REQUEST_URI"] =="/backend/buscarusuarios" && $_SERVER["REQUEST_METHOD"] =="GET")
{
    $controller = new UsuarioController();
    $resultado = $controller->index();
    var_dump($resultado);

}else
{
    echo 'rota não encontrada';
}