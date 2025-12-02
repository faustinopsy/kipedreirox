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
                '/api/usuarios' => 'ApiUsuarioController@getUsuarios',
                '/servico/editar/{id}' => 'ServicoController@viewEditarServico',
                '/servico/excluir/{id}' => 'ServicoController@viewExcluirServico',

                '/api/produtos' => 'PublicApiController@getProdutos',

                // --- NOVAS ROTAS DE ITEM (SEBO) ---
                '/item/listar' => 'ItemController@viewListarItens',
                '/item/listar/{pagina}' => 'ItemController@viewListarItens',
                '/item/criar' => 'ItemController@viewCriarItem',
                '/item/editar/{id}' => 'ItemController@viewEditarItem',
                '/item/excluir/{id}' => 'ItemController@viewExcluirItem',

                // --- NOVAS ROTAS AJAX (Para formulário de Item) ---
                '/ajax/buscar/autores' => 'ItemController@ajaxBuscarAutores',
                '/ajax/buscar/categorias' => 'ItemController@ajaxBuscarCategorias',
            ],
            
            "POST" => [
                 '/api/pedidos' => 'PublicApiController@salvarPedido',
                 
                "/usuario/salvar" => "UsuarioController@salvarUsuario",
                "/usuario/atualizar/{id}" => "UsuarioController@atualizarUsuario",
                "/usuario/deletar/{id}" => "UsuarioController@deletarUsuario",

                '/register' => 'AuthController@cadastrarUsuario',
                '/login' => 'AuthController@authenticar',

                '/servico/salvar' => 'ServicoController@salvarServico',
                '/servico/atualizar' => 'ServicoController@atualizarServico',
                '/servico/deletar' => 'ServicoController@deletarServico',

                '/item/salvar' => 'ItemController@salvarItem',
                '/item/atualizar' => 'ItemController@atualizarItem',
                '/item/deletar' => 'ItemController@deletarItem',
               
            ]
        ];
    }
}