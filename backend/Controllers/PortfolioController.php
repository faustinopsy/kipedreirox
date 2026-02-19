<?php
namespace App\Kipedreiro\Controllers;

use App\Kipedreiro\Models\Portfolio;
use App\Kipedreiro\Database\Database;
use App\Kipedreiro\Core\View;
use App\Kipedreiro\Core\Redirect;
use App\Kipedreiro\Core\FileManager;
use App\Kipedreiro\Controllers\Admin\AdminController;

class PortfolioController extends AdminController {
    public $portfolio;
    public $db;
    public $gerenciarImagem;

    public function __construct() {
        parent::__construct();
        $this->db = Database::getInstance();
        $this->portfolio = new Portfolio($this->db);
        $this->gerenciarImagem = new FileManager('upload');
    }

    public function index() {
        $this->viewListarPortfolio();
    }

    public function viewListarPortfolio($pagina = 1) {
        if (empty($pagina) || $pagina <= 0) $pagina = 1;

        $dados = $this->portfolio->paginacao($pagina, 10);

        View::render("portfolio/index", [
            "registros" => $dados['data'],
            'paginacao' => $dados
        ]);
    }

    public function viewCriarPortfolio() {
        View::render("portfolio/create");
    }

    public function salvarPortfolio() {
        if (empty($_POST["titulo_portfolio"]) || empty($_FILES['imagem_portfolio']['name'])) {
            Redirect::redirecionarComMensagem("portfolio/criar", "error", "Título e Imagem são obrigatórios.");
            return;
        }

        $imagem = $this->gerenciarImagem->salvarArquivo($_FILES['imagem_portfolio'], 'portfolio');
        
        // Data format handling if needed, assuming YYYY-MM-DD from HTML input date
        $dataProjeto = $_POST["data_projeto"] ?? date('Y-m-d');

        if ($this->portfolio->inserirPortfolio(
            $_POST["titulo_portfolio"],
            $_POST["descricao_portfolio"] ?? '',
            $imagem,
            $_POST["cliente_portfolio"] ?? '',
            $dataProjeto
        )) {
            Redirect::redirecionarComMensagem("portfolio/listar", "success", "Projeto cadastrado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("portfolio/criar", "error", "Erro ao cadastrar projeto.");
        }
    }

    public function viewEditarPortfolio(int $id) {
        $registro = $this->portfolio->buscarPorID($id);
        if (!$registro) {
            Redirect::redirecionarComMensagem("portfolio/listar", "error", "Registro não encontrado.");
            return;
        }
        View::render("portfolio/edit", ["portfolio" => $registro]);
    }

    public function atualizarPortfolio() {
        $id         = (int) $_POST['id_portfolio'];
        $titulo     = $_POST['titulo_portfolio'];
        $descricao  = $_POST['descricao_portfolio'] ?? '';
        $cliente    = $_POST['cliente_portfolio'] ?? '';
        $dataProjeto= $_POST['data_projeto'] ?? date('Y-m-d');
        $imagem     = null;

        if (isset($_FILES['imagem_portfolio']) && $_FILES['imagem_portfolio']['error'] == 0 && !empty($_FILES['imagem_portfolio']['name'])) {
            $imagem = $this->gerenciarImagem->salvarArquivo($_FILES['imagem_portfolio'], 'portfolio');
        }

        if ($this->portfolio->atualizarPortfolio($id, $titulo, $descricao, $imagem, $cliente, $dataProjeto)) {
            Redirect::redirecionarComMensagem("portfolio/listar", "success", "Projeto atualizado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("portfolio/editar/" . $id, "error", "Erro ao atualizar projeto.");
        }
    }

    public function viewExcluirPortfolio(int $id) {
        $registro = $this->portfolio->buscarPorID($id);
        if (!$registro) {
            Redirect::redirecionarComMensagem("portfolio/listar", "error", "Registro não encontrado.");
            return;
        }
        View::render("portfolio/delete", ["portfolio" => $registro]);
    }

    public function deletarPortfolio() {
        $id = (int) $_POST['id_portfolio'];
        if ($this->portfolio->deletarPortfolio($id)) {
            Redirect::redirecionarComMensagem("portfolio/listar", "success", "Status alterado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("portfolio/listar", "error", "Erro ao alterar status.");
        }
    }
}
