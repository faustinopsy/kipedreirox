<?php
session_start();

var_dump($_SESSION);
$_SESSION['flash'] = [
    'message' => 'Usuário criado com sucesso!',
    'type' => 'success'
];
$_SESSION['outro'] = 'Outro valor qualquer';

var_dump($_SESSION);