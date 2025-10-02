<?php
namespace App\Kipedreiro\Core;
class Flash{
    //     static = metodo da classe
    //     chamos o metodo sem instanciar a classe // sem  criar o objeto
    public static function set($type, $message) {
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message
        ];
    }

    public static function get(){
        if (!isset($_SESSION)) {
            session_start();
        }
        if (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            //unset($_SESSION['flash']);
            return $flash;
        }
        return null;
    }
}