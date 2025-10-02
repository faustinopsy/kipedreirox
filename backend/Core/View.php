<?php
namespace App\Kipedreiro\Core;
class View{
    public static function render($nomeView, $dados = []){
        // extrair os dados do array para variaveis
        extract($dados);
        // incluir o arquivo da view
        require_once __DIR__."/../Views/templates/partials/header.php";
        require_once __DIR__."/../Views/templates/{$nomeView}.php";
        require_once __DIR__."/../Views/templates/partials/footer.php";
    }
}