<?php

namespace App\Kipedreiro\Rotas;

class Rotas
{
    public static function get()
    {
        return [
            'GET' => [
                '/backend/buscarusuarios' => 'UsuarioController@index',
                '/backend/buscarusuarioid' => 'UsuarioController@buscarUsuarioId',
            ],
            'POST' => [
                '/backend/registrar' => 'UsuarioController@registrar',
                '/backend/login' => 'UsuarioController@login',
                '/backend/atualizar' => 'UsuarioController@atualizar',
                '/backend/deletar' => 'UsuarioController@deletar',
            ],
        ];
    }
}
