<?php
include_once 'backend/Database/Database.php';
include_once 'backend/Model/Usuario.php';
//operação ternaria
$nome = $_POST["nome"] ?? '';
$email = $_POST["email"] ?? '';
$senha = $_POST["senha"] ?? '';

$ok = registrarUsuario($db, $nome, $email, $senha);
if($ok > 0 || $ok === true){
    echo "Usuário cadastrado com sucesso!";
}else{
    echo "Erro ao cadastrar usuário!";
}