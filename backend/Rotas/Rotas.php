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
                '/api/sobre' => 'PublicApiController@getSobre', 

                '/servico/editar/{id}' => 'ServicoController@viewEditarServico',
                '/servico/excluir/{id}' => 'ServicoController@viewExcluirServico',

                '/sobre/listar' => 'SobreController@viewListarSobre',
                '/sobre/listar/{pagina}' => 'SobreController@viewListarSobre',
                '/sobre/criar' => 'SobreController@viewCriarSobre',
                '/sobre/editar/{id}' => 'SobreController@viewEditarSobre',
                '/sobre/excluir/{id}' => 'SobreController@viewExcluirSobre',

                '/api/produtos' => 'PublicApiController@getProdutos',

                '/orcamento/listar/1'      => 'OrcamentoController@viewListarOrcamentos',
                '/orcamento/listar/{pagina}' => 'OrcamentoController@viewListarOrcamentos',
                '/orcamento/criar'         => 'OrcamentoController@viewCriarOrcamento',
                '/orcamento/editar/{id}'   => 'OrcamentoController@viewEditarOrcamento',
                '/orcamento/cancelar/{id}' => 'OrcamentoController@viewCancelarOrcamento',
            ],
            
            "POST" => [
                '/api/servicos' => 'PublicApiController@salvarServicoAPI',
                '/api/pedidos' => 'PublicApiController@salvarPedido',
                 '/api/contato' => 'ContactController@send',
                 
                "/api/usuariosalvar" => "APIUsuarioController@salvarUsuario",
                "/usuario/atualizar/{id}" => "UsuarioController@atualizarUsuario",
                "/usuario/deletar" => "UsuarioController@deletarUsuario",
                "/usuario/salvar" => "UsuarioController@salvarUsuario",
                '/register' => 'AuthController@cadastrarUsuario',
                '/login' => 'AuthController@authenticar',

                '/servico/salvar'  => 'ServicoController@salvarServico',
                '/servico/atualizar' => 'ServicoController@atualizarServico',
                '/servico/deletar' => 'ServicoController@deletarServico',

                '/orcamento/salvar'    => 'OrcamentoController@salvarOrcamento',
                '/orcamento/atualizar' => 'OrcamentoController@atualizarOrcamento',
                '/orcamento/cancelar'  => 'OrcamentoController@cancelarOrcamento',

                '/sobre/salvar'    => 'SobreController@salvarSobre',
                '/sobre/atualizar' => 'SobreController@atualizarSobre',
                '/sobre/deletar'   => 'SobreController@deletarSobre',

               
            ]
        ];
    }
}