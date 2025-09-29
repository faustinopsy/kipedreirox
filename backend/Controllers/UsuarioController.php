<?php
namespace App\Kipedreiro\Controllers;

use App\Kipedreiro\Models\Usuario;
use App\Kipedreiro\Database\Database;
use App\Kipedreiro\Core\View;
class UsuarioController {
    public $usuario;
    public $db;
    public function __construct() {
        $this->db = Database::getInstance();
        $this->usuario = new Usuario($this->db);
    }
    public function viewListarUsuarios() {
        $usuarios = $this->usuario->buscarUsuarios();
        View::render('usuarios/index',['usuarios' => $usuarios]);
    }
    public function viewListarUsuarioEmail() {
        $email = $_GET["email"]?? '';
        if(empty($email)){
            http_response_code(405);
            echo json_encode(["error"=> "o email não pode ser vazio"]);
           exit;
        }
        $usuarios = $this->usuario->buscarUsuariosPorEMail($email);
        View::render('usuarios/index',['usuarios' => $usuarios]);
    }
    public function viewCriarUsuario() {
        echo "viewCriarUsuario";
    }
    public function viewEditarUsuario() {
        echo "viewEditarUsuario";
    }
    public function viewExcluirUsuario() {
        echo "viewExcluirUsuario";
    }

}