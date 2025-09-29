<?php
namespace App\Kipedreiro\Controllers;

use App\Kipedreiro\Models\Usuario;
use App\Kipedreiro\Database\Database;
use App\Kipedreiro\Core\View;
use App\Kipedreiro\Validators\UserValidator;
class UsuarioController {
    public $usuario;
    public $db;
    public $userValidator;
    public function __construct() {
        $this->db = Database::getInstance();
        $this->usuario = new Usuario($this->db);
        $this->userValidator = new UserValidator($this->usuario);
    }
    public function viewListarUsuarios() {
        $usuarios = $this->usuario->buscarUsuarios();
        View::render('usuarios/index',['usuarios' => $usuarios]);
    }
    public function viewListarUsuarioEmail() {
        $email = $_GET["email"]?? '';
        $this->userValidator->validate(['email' => $email]);    
        $usuarios = $this->usuario->buscarUsuariosPorEMail($email);
        View::render('usuarios/index',['usuarios' => $usuarios]);
    }
    public function viewCriarUsuario() {
        View::render('usuarios/create');
    }
    public function viewEditarUsuario() {
        echo "viewEditarUsuario";
    }
    public function viewExcluirUsuario() {
        echo "viewExcluirUsuario";
    }

    public function registrar(){
        $dados = $_POST;
        $this->userValidator->validate($dados);
        if($this->usuario->inseriUsuario($dados['nome_usuario'], $dados['email_usuario'], 
        $dados['senha_usuario'], $dados['tipo_usuario'], $dados['status_usuario'])){
            echo json_encode(['success' => 'Usuário criado com sucesso!'],  JSON_PRETTY_PRINT);
        } else {
            echo json_encode(['error' => 'Erro ao criar usuário.'],  JSON_PRETTY_PRINT);
        }  
    }
}