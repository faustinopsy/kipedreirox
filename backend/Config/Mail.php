<?php
namespace App\Kipedreiro\Config;

class Mail{
    public static function get(){
        return [
            'host' => 'smtp.gmail.com',
            'port' => 587,
            'username'=> 'xxxxxxxxx@gmail.com',
            'password'=> 'xxxxxxxxxx',
            'encryption'=> 'tls',
            'from_address'=> 'noreply@kipedreiro.com',
            'from_name'=> 'Kipedreiro',
            
        ];
    }
}