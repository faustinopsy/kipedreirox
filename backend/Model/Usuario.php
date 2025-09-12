<?php
/*
função é um bloco { } de codigo que pode ser reutilizado
e pode receber ( parametros )
e ele fica esperando ser chamado

*/

/* Executa uma instrução preparada passando um array de valores */
function buscaUsuarios($db){
    $sql = 'SELECT id_usuario, nome_usuario, email_usuario FROM tbl_usuario';
    $statment = $db->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    $statment->execute();
    return $resultado = $statment->fetchAll();
}

function buscarUsuarioPorId($db, $id){
    $sql = 'SELECT id_usuario, nome_usuario, email_usuario FROM tbl_usuario WHERE id_usuario = :id';
    $statment = $db->prepare($sql);
    $statment->bindParam(':id', $id);
    return $statment->execute();
}

function registrarUsuario($db, $nome, $email, $senha){
    $sql = 'INSERT INTO tbl_usuario (nome_usuario, email_usuario, senha_usuario) 
    VALUES (:nome, :email, :senha)';
    $statment = $db->prepare($sql);
    $statment->bindParam(':nome', $nome);
    $statment->bindParam(':email', $email);
    $statment->bindParam(':senha', $senha);
    return $statment->execute();
}

// $ok = registrarUsuario($db, 'rodrigo', 'rodrigo2@xxx.com', '123456');
// echo $ok;
//$resultado = buscaUsuarios($db);
//var_dump($resultado);