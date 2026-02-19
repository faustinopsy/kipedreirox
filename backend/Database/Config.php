<?php

namespace App\Kipedreiro\Database;

class Config
{
    public static function get()
    {
        return [
            'database' => [
            'driver' => 'mysql',
            'mysql' => 
                  [
                    'host' => 'localhost',
                    'db_name' => 'kipedreiro',
                    'username' => 'root',
                    'password' => NULL,
                    'charset' => 'utf8',
                    'port' => NULL,
                ],
            ]
        ];
    }
}
