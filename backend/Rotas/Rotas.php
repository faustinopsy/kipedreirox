<?php
namespace App\Kipedreiro\Rotas;
class Rotas
{
    public static function get()
    {
        return [
            'GET' => [
                '/backend/usuarios' => 'UsuarioController@viewListarUsuarios',
                '/backend/usuariosemail' => 'UsuarioController@viewListarUsuarioEmail',
                '/backend/criar' => 'UsuarioController@viewCriarUsuario',
                '/backend/editar' => 'UsuarioController@viewEditarUsuario',
                '/backend/excluir' => 'UsuarioController@viewExcluirUsuario',
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
