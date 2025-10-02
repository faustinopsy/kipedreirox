<?php
namespace App\Kipedreiro\Validadores;
class UsuarioValidador{
    public static function ValidarEntradas($dados){
        $erros = [];
        if(isset($dados['nome_usuario']) && empty($dados['nome_usuario'])){
            $erros[] = "O campo nome é obrigatório.";
        }
        if(isset($dados['email_usuario']) &&  empty($dados['email_usuario'])){
            $erros[] = "O campo email é obrigatório.";
        } elseif(!filter_var($dados['email_usuario'], FILTER_VALIDATE_EMAIL)){
            $erros[] = "O campo email deve ser um endereço de email válido.";
        }
        if(isset($dados['senha_usuario']) &&   empty($dados['senha_usuario'])){
            $erros[] = "O campo senha é obrigatório.";
        } elseif(strlen($dados['senha_usuario']) < 6){
            $erros[] = "O campo senha deve ter pelo menos 6 caracteres.";
        }
        return $erros;
    }
}