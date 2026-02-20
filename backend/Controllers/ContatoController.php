<?php
namespace App\Kipedreiro\Controllers;

use App\Kipedreiro\Database\Database;
use App\Kipedreiro\Models\Contato;
use App\Kipedreiro\Core\View;
use App\Kipedreiro\Utils\Redirect;

class ContatoController {

    private $db;
    private $contato;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->contato = new Contato($this->db);
    }

    public function viewListarMensagens($pagina = 1) {
        $porPagina = 10;
        $dados = $this->contato->paginacao($pagina, $porPagina);

        View::render('contato/index', [
            'mensagens'     => $dados['data'],
            'paginacao'     => $dados,
            'pagina_atual'  => $pagina
        ]);
    }

    public function viewMensagem($id) {
        $contatoMensagem = $this->contato->buscarPorID((int)$id);

        if (!$contatoMensagem) {
            Redirect::redirecionarComMensagem("contato/listar", "error", "Mensagem não encontrada.");
            return;
        }

        // Marcar como lido ao visualizar
        if (!$contatoMensagem['lido']) {
            $this->contato->marcarComoLido((int)$id);
            $contatoMensagem['lido'] = 1; // Update local view
        }

        View::render('contato/view', [
            'contatoMensagem' => $contatoMensagem
        ]);
    }
    
    public function deletarMensagem($id) {
        // Implement soft delete or hard delete if needed
        // For now not implemented in model, but can simply delete row
        // leaving empty for now
    }
}
