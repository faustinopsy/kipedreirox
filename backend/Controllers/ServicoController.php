<?php
namespace App\Kipedreiro\Controllers;

use App\Kipedreiro\Models\Servico;
use App\Kipedreiro\Database\Database;
use App\Kipedreiro\Core\View;
use App\Kipedreiro\Core\Redirect;
use App\Kipedreiro\Core\FileManager;
use App\Kipedreiro\Controllers\Admin\AdminController;

class ServicoController extends AdminController {
    public $servico;
    public $db;
    public $gerenciarImagem;

    public function __construct() {
        parent::__construct();
        $this->db = Database::getInstance();
        $this->servico = new Servico($this->db);
        $this->gerenciarImagem = new FileManager('upload');
    }

    public function index() {
        $this->viewListarServicos();
    }

    public function viewListarServicos($pagina = 1) {
        if (empty($pagina) || $pagina <= 0) $pagina = 1;
        
        $dados = $this->servico->paginacao($pagina, 10);
        $total = $this->servico->totalDeServicos();
        $totalInativos = $this->servico->totalDeServicosInativos();
        $totalAtivos = $this->servico->totalDeServicosAtivos();
        View::render("servico/index", [
        "servicos"=> $dados['data'],
         "total_servicos"=> $total[0],
         "total_inativos" => $totalInativos[0],
         "total_ativos" => $totalAtivos[0],
         'paginacao' => $dados
        ] );
    }

    public function viewCriarServico() {
        View::render("servico/create");
    }

    public function salvarServico() {
        if (empty($_POST["nome_servico"]) || empty($_FILES['foto_servico']['name'])) {
            Redirect::redirecionarComMensagem("servico/criar", "error", "Nome e Foto são obrigatórios.");
        }

        $imagem = $this->gerenciarImagem->salvarArquivo($_FILES['foto_servico'], 'servicos');

        if ($this->servico->inserirServico(
            $_POST["nome_servico"],
            $_POST["descricao_servico"],
            $imagem
        )) {
            Redirect::redirecionarComMensagem("servico/listar", "success", "Serviço cadastrado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("servico/criar", "error", "Erro ao cadastrar serviço.");
        }
    }
    
    public function viewEditarServico(int $id) {
        $servico = $this->servico->buscarPorID($id);
        if (!$servico) {
            Redirect::redirecionarComMensagem("servico/listar", "error", "Serviço não encontrado.");
        }
        
        View::render("servico/edit", ["servico" => $servico]);
    }

    public function atualizarServico() {
        $id = (int)$_POST['id_servico'];
        $nome = $_POST['nome_servico'];
        $descricao = $_POST['descricao_servico'];
        $imagem = null;

        if (isset($_FILES['foto_servico']) && $_FILES['foto_servico']['error'] == 0 && !empty($_FILES['foto_servico']['name'])) {
            $imagem = $this->gerenciarImagem->salvarArquivo($_FILES['foto_servico'], 'servicos');
        }

        if ($this->servico->atualizarServico($id, $nome, $descricao, $imagem)) {
            Redirect::redirecionarComMensagem("servico/listar", "success", "Serviço atualizado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("servico/editar/" . $id, "error", "Erro ao atualizar serviço.");
        }
    }

    public function viewExcluirServico(int $id) {
        $servico = $this->servico->buscarPorID($id);
        if (!$servico) {
            Redirect::redirecionarComMensagem("servico/listar", "error", "Serviço não encontrado.");
        }

        View::render("servico/delete", ["servico" => $servico]);
    }

    public function deletarServico() {
        $id = (int)$_POST['id_servico'];

        if ($this->servico->deletarServico($id)) {
            Redirect::redirecionarComMensagem("servico/listar", "success", "Serviço inativado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("servico/listar", "error", "Erro ao inativar serviço.");
        }
    }
}