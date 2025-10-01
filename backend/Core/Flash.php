<?php
namespace App\Kipedreiro\Core;

class Flash{
    public static function set($message, $type = 'success'){
        if(!session_id()){
            session_start();
        }
        $_SESSION['flash'] = [
            'message' => $message,
            'type' => $type
        ];
    }

    public static function get(){
        if(!session_id()){
            session_start();
        }
        if(isset($_SESSION['flash'])){
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $flash;
        }
        return null;
    }
}