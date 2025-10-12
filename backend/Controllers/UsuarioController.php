<?php
namespace App\Kipedreiro\Controllers;

use App\Kipedreiro\Models\Usuario;
use App\Kipedreiro\Database\Database;
use App\Kipedreiro\Core\View;
use App\Kipedreiro\Core\Redirect;
use App\Kipedreiro\Validadores\UsuarioValidador;
use App\Kipedreiro\Core\FileManager;

class UsuarioController {
    public $usuario;
    public $db;
    public $gerenciarImagem;
    public function __construct() {
        $this->db = Database::getInstance();
        $this->usuario = new Usuario($this->db);
        $this->gerenciarImagem = new FileManager('upload');
    }
    public function salvarUsuario(){
       $erros = UsuarioValidador::ValidarEntradas($_POST);
       if(!empty($erros)){
            Redirect::redirecionarComMensagem("usuario/criar","error", implode("<br>", $erros));
       }
       //novo caminho =                                (arquivo          ,subdiretorio)
       $imagem =  $this->gerenciarImagem->salvarArquivo($_FILES['imagem'], 'usuario');
        if($this->usuario->inseriUsuario(
            $_POST["nome_usuario"],
            $_POST["email_usuario"],
            $_POST["senha_usuario"],
            $_POST["tipo_usuario"],
            "Ativo",
            $imagem
        )){
            Redirect::redirecionarComMensagem("usuario/listar","success","Usuário cadastrado com sucesso!");
        }else{
            Redirect::redirecionarComMensagem("usuario/criar","error","Erro ao cadastrar usuário!");
        }
    }
    public function index() {
        $resultado = $this->usuario->buscarUsuarios();
        var_dump($resultado);
    }  
    public function viewListarUsuarios($pagina=1){
        $pagina = isset($pagina) ? $pagina : 1;
        $dados = $this->usuario->paginacao($pagina);
        $total = $this->usuario->totalDeUsuarios();
        $total_inativos = $this->usuario->totalDeUsuariosInativos();
        $total_ativos = $this->usuario->totalDeUsuariosAtivos();
        View::render("usuario/index", 
        [
        "usuarios"=> $dados['data'],
         "total_usuarios"=> $total[0],
         "total_inativos" => $total_inativos[0],
         "total_ativos" => $total_ativos[0],
         'paginacao' => $dados
        ] 
        );
    }
    public function viewCriarUsuarios(){
        View::render("usuario/create");
    }
    public function viewEditarUsuarios(int $id){
        $dados = $this->usuario->buscarUsuariosPorID($id);
        foreach($dados as $usuario){
                $dados = $usuario;
        }
        View::render("usuario/edit", ["usuario"=> $dados ]);
    }
    public function viewExcluirUsuarios($id){
       if($this->usuario->excluirUsuario($id)){
            Redirect::redirecionarComMensagem("usuario/listar","success","Usuário excluído com sucesso!");
       }else{
            Redirect::redirecionarComMensagem("usuario/listar","error","Erro ao excluir usuário!");
       }
    }
    public function relatorioUsuario($id, $data1, $data2){
        View::render("usuario/relatorio", 
            ["id"=> $id, "data1"=> $data1, "data2"=> $data2]
        );
    }
    
    public function atualizarUsuario($id){
        $erros = UsuarioValidador::ValidarEntradas($_POST);
        if(!empty($erros)){
            Redirect::redirecionarComMensagem("usuario/editar/"+$id,"error", implode("<br>", $erros));
        }
       $this->usuario->atualizarUsuario(
            $id,  
            $_POST["nome_usuario"],
            $_POST["email_usuario"],
            $_POST["senha_usuario"],
            $_POST["tipo_usuario"],
            $_POST["status_usuario"]
        );
    }
    public function deletarUsuario($id){
        $dados = $this->usuario->buscarUsuariosPorID($id);
        var_dump($dados);exit;
        
       $this->usuario->excluirUsuario($id);
    }

}