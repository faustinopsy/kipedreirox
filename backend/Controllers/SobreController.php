<?php
namespace App\Kipedreiro\Controllers;

use App\Kipedreiro\Models\Sobre;
use App\Kipedreiro\Database\Database;
use App\Kipedreiro\Core\View;
use App\Kipedreiro\Core\Redirect;
use App\Kipedreiro\Core\FileManager;
use App\Kipedreiro\Controllers\Admin\AdminController;

class SobreController extends AdminController {
    public $sobre;
    public $db;
    public $gerenciarImagem;

    public function __construct() {
        parent::__construct();
        $this->db = Database::getInstance();
        $this->sobre = new Sobre($this->db);
        $this->gerenciarImagem = new FileManager('upload');
    }

    public function index() {
        $this->viewListarSobre();
    }

    public function viewListarSobre($pagina = 1) {
        if (empty($pagina) || $pagina <= 0) $pagina = 1;

        $dados = $this->sobre->paginacao($pagina, 10);

        View::render("sobre/index", [
            "registros" => $dados['data'],
            'paginacao' => $dados
        ]);
    }

    public function viewCriarSobre() {
        View::render("sobre/create");
    }

    public function salvarSobre() {
        if (empty($_POST["titulo_sobre"]) || empty($_FILES['imagem_sobre']['name'])) {
            Redirect::redirecionarComMensagem("sobre/criar", "error", "Título e Imagem são obrigatórios.");
            return;
        }

        $imagem     = $this->gerenciarImagem->salvarArquivo($_FILES['imagem_sobre'], 'sobre');
        
        if ($this->sobre->inserirSobre(
            $_POST["titulo_sobre"],
            $_POST["descricao_sobre"] ?? '',
            $imagem,
            $_POST["missao_sobre"] ?? '',
            $_POST["visao_sobre"] ?? '',
            $_POST["valores_sobre"] ?? ''
        )) {
            Redirect::redirecionarComMensagem("sobre/listar", "success", "Registro criado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("sobre/criar", "error", "Erro ao criar registro.");
        }
    }

    public function viewEditarSobre(int $id) {
        $registro = $this->sobre->buscarPorID($id);
        if (!$registro) {
            Redirect::redirecionarComMensagem("sobre/listar", "error", "Registro não encontrado.");
            return;
        }
        View::render("sobre/edit", ["sobre" => $registro]);
    }

    public function atualizarSobre() {
        $id         = (int) $_POST['id_sobre'];
        $titulo     = $_POST['titulo_sobre'];
        $descricao  = $_POST['descricao_sobre'] ?? '';
        $missao     = $_POST['missao_sobre'] ?? '';
        $visao      = $_POST['visao_sobre'] ?? '';
        $valores    = $_POST['valores_sobre'] ?? '';
        $imagem     = null;

        if (isset($_FILES['imagem_sobre']) && $_FILES['imagem_sobre']['error'] == 0 && !empty($_FILES['imagem_sobre']['name'])) {
            $imagem = $this->gerenciarImagem->salvarArquivo($_FILES['imagem_sobre'], 'sobre');
        }

        if ($this->sobre->atualizarSobre($id, $titulo, $descricao, $imagem, $missao, $visao, $valores)) {
            Redirect::redirecionarComMensagem("sobre/listar", "success", "Registro atualizado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("sobre/editar/" . $id, "error", "Erro ao atualizar registro.");
        }
    }

    public function viewExcluirSobre(int $id) {
        $registro = $this->sobre->buscarPorID($id);
        if (!$registro) {
            Redirect::redirecionarComMensagem("sobre/listar", "error", "Registro não encontrado.");
            return;
        }
        View::render("sobre/delete", ["sobre" => $registro]);
    }

    public function deletarSobre() {
        $id = (int) $_POST['id_sobre'];
        if ($this->sobre->deletarSobre($id)) {
            Redirect::redirecionarComMensagem("sobre/listar", "success", "Status alterado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("sobre/listar", "error", "Erro ao alterar status.");
        }
    }
}
