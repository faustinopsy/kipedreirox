<?php
namespace App\Kipedreiro\Controllers;

use App\Kipedreiro\Models\Usuario;
use App\Kipedreiro\Database\Database;
use App\Kipedreiro\Core\View;
use App\Kipedreiro\Core\Redirect;
use App\Kipedreiro\Validadores\UsuarioValidador;

class UsuarioController {
    public $usuario;
    public $db;
    public function __construct() {
        $this->db = Database::getInstance();
        $this->usuario = new Usuario($this->db);
    }
    public function index() {
        $resultado = $this->usuario->buscarUsuarios();
        var_dump($resultado);
    }  
    public function viewListarUsuarios(){
        $dados = $this->usuario->buscarUsuarios();
        View::render("usuario/index", ["usuarios"=> $dados] );
    }
    public function viewCriarUsuarios(){
        View::render("usuario/create");
    }
    public function viewEditarUsuarios($id){
        View::render("usuario/edit", ["id"=> $id]);
    }
    public function viewExcluirUsuarios(){
       View::render("usuario/delete");
    }
    public function relatorioUsuario($id, $data1, $data2){
        View::render("usuario/relatorio", ["id"=> $id, "data1"=> $data1, "data2"=> $data2]);
    }
    public function salvarUsuario(){
       $erros = UsuarioValidador::ValidarEntradas($_POST);
       if(!empty($erros)){
            Redirect::redirecionarComMensagem("usuario/criar","error", implode("<br>", $erros));
       }
        if($this->usuario->inseriUsuario(
            $_POST["nome_usuario"],
            $_POST["email_usuario"],
            $_POST["senha_usuario"],
            $_POST["tipo_usuario"],
            "Ativo"
        )){
            Redirect::redirecionarComMensagem("usuario/listar","success","Usuário cadastrado com sucesso!");
        }else{
            Redirect::redirecionarComMensagem("usuario/criar","error","Erro ao cadastrar usuário!");
        }
    }
    public function atualizarUsuario(){
        echo "Atualizar Usuario";
    }
    public function deletarUsuario(){
        echo "Deletar Usuario";
    }

}