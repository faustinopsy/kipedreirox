<?php

namespace App\Kipedreiro\Validators;


class UserValidator
{
    protected $userModel;
    public function __construct($userModel)
    {
        $this->userModel = $userModel;
    }
    public function validate($data, $atualizacao = false)
    {
        $errors = [];
        if (isset($data['nome_usuario']) && empty($data['nome_usuario'])) {
            $errors[] = 'o nome é obrigatório.';
        } 
        if (isset($data['nome_usuario']) &&  (strlen($data['nome_usuario']) < 3 || strlen($data['nome_usuario']) > 50)) {
            $errors[] = 'o nome precisa ser maior que 3 carateres e menor de 50 caracteres.';
        }
        if (isset($data['email_usuario']) && empty($data['email_usuario'])) {
            $errors[] = 'O email é obrigatório.';
        } elseif (!filter_var($data['email_usuario'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email com formato inválido.';
        } elseif (!$atualizacao && $this->userModel->emailExists($data['email_usuario'])) {
            $errors[] = 'Email já existe.';
        }
        if (!$atualizacao) {
            if (isset($data['password']) &&  empty($data['password'])) {
                $errors[] = 'A senha é obrigatória.';
            }
            if (isset($data['password']) && strlen($data['password']) < 6) {
                $errors[] = 'A senha precisa ter mais de 6 caracteres.';
            }
        } elseif (!empty($data['password']) && strlen($data['password']) < 6) {
            $errors[] = 'A senha precisa ter mais de 6 caracteres.';
        }
        echo json_encode($errors, JSON_UNESCAPED_UNICODE);
        exit;
    }
}