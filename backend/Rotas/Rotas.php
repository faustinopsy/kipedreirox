<?php

namespace App\Kipedreiro\Rotas;

class Rotas
{
    public static function get()
    {
        return [
            "GET" => [
                "/" => "Admin\DashboardController@index",
                "/usuarios" => "UsuarioController@index",
                "/usuario/criar" => "UsuarioController@viewCriarUsuarios",
                "/usuario/listar" => "UsuarioController@viewListarUsuarios",
                "/usuario/listar/{pagina}" => "UsuarioController@viewListarUsuarios",
                "/usuario/editar/{id}" => "UsuarioController@viewEditarUsuarios",
                "/usuario/excluir/{id}" => "UsuarioController@viewExcluirUsuarios",

                '/register' => 'AuthController@register',
                '/login' => 'AuthController@login',
                '/logout' => 'AuthController@logout',
                '/admin/dashboard' => 'Admin\DashboardController@index',

                '/esqueci-senha' => 'AuthController@viewEsqueciSenha',
                '/reseta-senha/{token}' => 'AuthController@viewFormTrocaSenha',
            ],
            
            "POST" => [
                "/usuario/salvar" => "UsuarioController@salvarUsuario",
                "/usuario/atualizar/{id}" => "UsuarioController@atualizarUsuario",
                "/usuario/deletar/{id}" => "UsuarioController@deletarUsuario",

                '/register' => 'AuthController@cadastrarUsuario',
                '/login' => 'AuthController@authenticar',

                '/esqueci-senha' => 'AuthController@enviarLinkDoEmail',
                '/reseta-senha' => 'AuthController@resetaSenha',
            ]
        ];
    }
}