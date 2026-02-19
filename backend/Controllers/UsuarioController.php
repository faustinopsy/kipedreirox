<?php
namespace App\Kipedreiro\Controllers;

use App\Kipedreiro\Models\Usuario;
use App\Kipedreiro\Database\Database;
use App\Kipedreiro\Core\View;
use App\Kipedreiro\Core\Redirect;
use App\Kipedreiro\Validadores\UsuarioValidador;
use App\Kipedreiro\Core\FileManager;
use App\Kipedreiro\Controllers\Admin\AuthenticatedController;
use App\Kipedreiro\Controllers\Admin\AdminController;

class UsuarioController extends AdminController{
    public $usuario;
    public $db;
    public $gerenciarImagem;
    public function __construct() {
        parent::__construct();
        $this->db = Database::getInstance();
        $this->usuario = new Usuario($this->db);
        $this->gerenciarImagem = new FileManager('upload');
    }
    public function salvarUsuario(){
       $erros = UsuarioValidador::ValidarEntradas($_POST);
       if(!empty($erros)){
            Redirect::redirecionarComMensagem("usuario/criar", "error", implode("<br>", $erros));
            return;
       }

       // Usuários não possuem foto no formulário de cadastro admin
       $imagem = null;

        if($this->usuario->inseriUsuario(
            $_POST["nome_usuario"],
            $_POST["email_usuario"],
            $_POST["senha_usuario"],
            $_POST["tipo_usuario"],
            "Ativo",
            $imagem
        )){
            Redirect::redirecionarComMensagem("usuario/listar/1", "success", "Usuário cadastrado com sucesso!");
        }else{
            Redirect::redirecionarComMensagem("usuario/criar", "error", "Erro ao cadastrar usuário!");
        }
    }
    public function index() {
        $resultado = $this->usuario->buscarUsuarios();
        var_dump($resultado);
    }  
    public function viewListarUsuarios($pagina=1){
        if(empty($pagina) || $pagina <= 0){
            $pagina = 1;
        }
        $totalAtivos = $this->usuario->totalDeUsuariosAtivos();
        $dados = $this->usuario->paginacao($pagina);
        $total = $this->usuario->totalDeUsuarios();
        $totalInativos = $this->usuario->totalDeUsuariosInativos();
        
        View::render("usuario/index", 
        [
        "usuarios"=> $dados['data'],
         "total_usuarios"=> $total[0],
         "total_inativos" => $totalInativos[0],
         "total_ativos" => $totalAtivos[0],
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
       View::render("usuario/delete", ["id_usuario"=> $id ]);
    }
    public function relatorioUsuario($id, $data1, $data2){
        View::render("usuario/relatorio", 
            ["id"=> $id, "data1"=> $data1, "data2"=> $data2]
        );
    }
    
    public function atualizarUsuario($id){
        $erros = UsuarioValidador::ValidarEntradas($_POST, true);
        if(!empty($erros)){
            Redirect::redirecionarComMensagem("usuario/editar/$id", "error", implode("<br>", $erros));
            return;
        }

        $nome   = $_POST['nome_usuario'];
        $email  = $_POST['email_usuario'];
        $senha  = $_POST['senha_usuario'] ?? '';
        $tipo   = $_POST['tipo_usuario'];
        $status = $_POST['status_usuario'];

        if ($this->usuario->atualizarUsuario($id, $nome, $email, $senha, $tipo, $status)) {
             Redirect::redirecionarComMensagem("usuario/listar/1", "success", "Usuário atualizado com sucesso!");
        } else {
             Redirect::redirecionarComMensagem("usuario/editar/$id", "error", "Erro ao atualizar usuário.");
        }
    }
    public function deletarUsuario(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_usuario'])) {
            $id = (int)$_POST['id_usuario'];
            
            // Buscar usuário para verificar status atual
            $dados = $this->usuario->buscarUsuariosPorID($id);
            
            if (!empty($dados)) {
                $usuario = $dados[0];
                
                // Se excluido_em for nulo, o usuário está ativo, então inativa
                if ($usuario['excluido_em'] === null) {
                    if ($this->usuario->excluirUsuario($id)) {
                        Redirect::redirecionarComMensagem("usuario/listar", "success", "Usuário inativado com sucesso!");
                    } else {
                        Redirect::redirecionarComMensagem("usuario/listar", "error", "Erro ao inativar usuário.");
                    }
                } else {
                    // Se não for nulo, está inativo, então ativa
                    if ($this->usuario->ativarUsuario($id)) {
                        Redirect::redirecionarComMensagem("usuario/listar", "success", "Usuário ativado com sucesso!");
                    } else {
                        Redirect::redirecionarComMensagem("usuario/listar", "error", "Erro ao ativar usuário.");
                    }
                }
            } else {
                Redirect::redirecionarComMensagem("usuario/listar", "error", "Usuário não encontrado.");
            }
        } else {
            Redirect::redirecionarComMensagem("usuario/listar", "error", "Requisição inválida.");
        }
    }

}