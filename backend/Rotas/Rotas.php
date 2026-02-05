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

                '/servico/listar' => 'ServicoController@viewListarServicos',
                '/servico/listar/{pagina}' => 'ServicoController@viewListarServicos',
                '/servico/criar' => 'ServicoController@viewCriarServico',
                '/api/servicos' => 'PublicApiController@getServicos',
                '/api/usuarios/{pagina}' => 'APIUsuarioController@getUsuarios',
                '/api/usuarios' => 'APIUsuarioController@getUsuarios',
                '/servico/editar/{id}' => 'ServicoController@viewEditarServico',
                '/servico/excluir/{id}' => 'ServicoController@viewExcluirServico',

                '/api/produtos' => 'PublicApiController@getProdutos',
            ],
            
            "POST" => [
                '/api/pedidos' => 'PublicApiController@salvarPedido',
                 '/api/contato' => 'ContactController@send',
                 
                "/api/usuariosalvar" => "APIUsuarioController@salvarUsuario",
                "/usuario/atualizar/{id}" => "UsuarioController@atualizarUsuario",
                "/usuario/deletar" => "UsuarioController@deletarUsuario",

                '/register' => 'AuthController@cadastrarUsuario',
                '/login' => 'AuthController@authenticar',

                '/servico/salvar' => 'ServicoController@salvarServico',
                '/servico/atualizar' => 'ServicoController@atualizarServico',
                '/servico/deletar' => 'ServicoController@deletarServico',

               
            ]
        ];
    }
}