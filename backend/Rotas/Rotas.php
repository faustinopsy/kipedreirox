<?php
namespace App\Kipedreiro\Rotas;
class Rotas
{
    public static function get()
    {
        return [
            'GET' => [
                '/backend/usuario/usuarios' => 'UsuarioController@viewListarUsuarios',
                '/backend/usuario/usuariosemail' => 'UsuarioController@viewListarUsuarioEmail',
                '/backend/usuario/criar' => 'UsuarioController@viewCriarUsuario',
                '/backend/usuario/editar' => 'UsuarioController@viewEditarUsuario',
                '/backend/usuario/excluir' => 'UsuarioController@viewExcluirUsuario',
            ],
            'POST' => [
                '/backend/usuario/registrar' => 'UsuarioController@registrar',
                '/backend/usuario/login' => 'UsuarioController@login',
                '/backend/usuario/atualizar' => 'UsuarioController@atualizar',
                '/backend/usuario/deletar' => 'UsuarioController@deletar',
            ],
        ];
    }
}
