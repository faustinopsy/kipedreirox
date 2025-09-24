<?php
namespace App\Kipedreiro\Controllers;

use App\Kipedreiro\Models\Usuario;
use App\Kipedreiro\Database\Database;

class UsuarioController {
    public $usuario;
    public $db;
    public function __construct() {
        $this->db = Database::getInstance();
        $this->usuario = new Usuario($this->db);
    }
    // index
    public function index() {
        $resultado = $this->usuario->buscarUsuarios();
        var_dump($resultado);
    }
    // registrar

    // login

    //atualizar

    // deletar

    //chamada de api

}