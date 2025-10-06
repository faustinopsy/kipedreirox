<?php

namespace App\Kipedreiro\Rotas;

class Rotas
{
    public static function get()
    {
        return [
            "GET" => [
                // o caminho da URL    o nome do controlle e o metodo do controller
                "/usuarios" => "UsuarioController@index",
                "/usuario/criar" => "UsuarioController@viewCriarUsuarios",
                "/usuario/listar" => "UsuarioController@viewListarUsuarios",
                "/usuario/editar/{id}" => "UsuarioController@viewEditarUsuarios",
                "/usuario/excluir/{id}" => "UsuarioController@viewExcluirUsuarios",
                "/servico/excluir/{id}" => "ServicoController@viewExcluirServicos",
            ],
            "POST" =>[
                "/usuario/salvar" => "UsuarioController@salvarUsuario",
                "/usuario/atualizar/{id}" => "UsuarioController@atualizarUsuario",
                "/usuario/deletar/{id}" => "UsuarioController@deletarUsuario",
            ]
        ];
    }
}
