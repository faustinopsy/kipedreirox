<?php

namespace App\Kipedreiro\Rotas;

class Rotas
{
    public static function get()
    {
        return [
            "GET" => [
                // o caminho da URL    o nome do controlle e o metodo do controller
                "/backend/usuarios" => "UsuarioController@index",
                "/backend/usuario/criar" => "UsuarioController@viewCriarUsuarios",
                "/backend/usuario/listar" => "UsuarioController@viewListarUsuarios",
                "/backend/usuario/editar" => "UsuarioController@viewEditarUsuarios",
                "/backend/usuario/excluir" => "UsuarioController@viewExcluirUsuarios",
                "/backend/servico/excluir" => "ServicoController@viewExcluirServicos",
            ],
            "POST" =>[
                "/backend/usuario/salvar" => "UsuarioController@salvarUsuario",
                "/backend/usuario/atualizar" => "UsuarioController@atualizarUsuario",
                "/backend/usuario/deletar" => "UsuarioController@deletarUsuario",
            ]
        ];
    }
}
