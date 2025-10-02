<?php
namespace App\Kipedreiro\Core;
use App\Kipedreiro\Core\Flash;

class Redirect {
    public static function redirecionarPara($url){
        header("Location". $url);
        exit;
    }
    public static function redirecionarComMensagem($url, $type, $message){
        Flash::set($type, $message);
        self::redirecionarPara($url);
    }
    public static function voltarPaginaAnteriorComMensagem($type, $message){
        $url = $_SERVER['HTTP_REFERER'] ?? '/';
        self::redirecionarComMensagem($url, $type, $message);
    }
}