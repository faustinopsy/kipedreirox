<?php
namespace App\Kipedreiro\Core;
use App\Kipedreiro\Core\Flash;
class Redirect{
    public static function to($url){
        header("Location: $url");
        exit;
    }

    public static function back(){
        if(isset($_SERVER['HTTP_REFERER'])){
            $url = $_SERVER['HTTP_REFERER'];
            self::to($url);
        } else {
            self::to('/');
        }
    }

    public static function redirecionarComMensagem($caminho, $mensagem, $tipo = 'success'){
        Flash::set($mensagem, $tipo);
        self::to($caminho);
    }
}