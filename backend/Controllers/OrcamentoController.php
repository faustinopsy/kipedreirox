<?php
namespace App\Kipedreiro\Controllers;

use App\Kipedreiro\Models\Orcamento;
use App\Kipedreiro\Models\Servico;
use App\Kipedreiro\Database\Database;
use App\Kipedreiro\Core\View;
use App\Kipedreiro\Core\Redirect;
use App\Kipedreiro\Controllers\Admin\AdminController;

class OrcamentoController extends AdminController
{
    private Orcamento $orcamento;
    private Servico   $servico;
    private $db;

    public function __construct()
    {
        parent::__construct();
        $this->db       = Database::getInstance();
        $this->orcamento = new Orcamento($this->db);
        $this->servico   = new Servico($this->db);
    }

    /* ─────────────────────────── LISTAR ─────────────────────────── */
    public function viewListarOrcamentos(int $pagina = 1): void
    {
        if ($pagina <= 0) $pagina = 1;

        $dados = $this->orcamento->paginacao($pagina);

        View::render('orcamento/index', [
            'orcamentos'    => $dados['data'],
            'paginacao'     => $dados,
            'total'         => $this->orcamento->totalGeral(),
            'em_aberto'     => $this->orcamento->totalPorStatus('Em Aberto'),
            'aprovados'     => $this->orcamento->totalPorStatus('Aprovado'),
            'finalizados'   => $this->orcamento->totalPorStatus('Finalizado'),
            'recusados'     => $this->orcamento->totalPorStatus('Recusado'),
        ]);
    }

    /* ─────────────────────────── CRIAR ──────────────────────────── */
    public function viewCriarOrcamento(): void
    {
        View::render('orcamento/create', [
            'clientes'      => $this->orcamento->buscarClientes(),
            'profissionais' => $this->orcamento->buscarProfissionais(),
            'categorias'    => $this->orcamento->buscarCategorias(),
            'servicos'      => $this->servico->buscarServicosTrabalho(),
        ]);
    }

    public function salvarOrcamento(): void
    {
        $id_cliente   = (int) ($_POST['id_cliente']   ?? 0);
        $id_categoria = (int) ($_POST['id_categoria'] ?? 0) ?: null;
        $id_pedreiro  = (int) ($_POST['id_pedreiro']  ?? 0) ?: null;
        $descricao    = trim($_POST['descricao_orcamento'] ?? '');

        if (!$id_cliente || !$descricao) {
            Redirect::redirecionarComMensagem('orcamento/criar', 'error', 'Cliente e descrição são obrigatórios.');
            return;
        }

        $id_orcamento = $this->orcamento->inserirOrcamento(
            $id_cliente, $id_categoria, $id_pedreiro, $descricao
        );

        if (!$id_orcamento) {
            Redirect::redirecionarComMensagem('orcamento/criar', 'error', 'Erro ao criar orçamento.');
            return;
        }

        // Salvar itens
        $servicos   = $_POST['item_servico']     ?? [];
        $descricoes = $_POST['item_descricao']   ?? [];
        $valores    = $_POST['item_valor']        ?? [];
        $quantidades = $_POST['item_quantidade'] ?? [];

        foreach ($servicos as $i => $id_servico) {
            if (empty($id_servico)) continue;
            $this->orcamento->inserirItem(
                $id_orcamento,
                (int)   $id_servico,
                        $descricoes[$i]   ?? '',
                (float) str_replace(',', '.', $valores[$i]    ?? 0),
                (float) str_replace(',', '.', $quantidades[$i] ?? 1)
            );
        }

        Redirect::redirecionarComMensagem('orcamento/listar/1', 'success', 'Orçamento criado com sucesso!');
    }

    /* ─────────────────────────── EDITAR ─────────────────────────── */
    public function viewEditarOrcamento(int $id): void
    {
        $orcamento = $this->orcamento->buscarPorID($id);
        if (!$orcamento) {
            Redirect::redirecionarComMensagem('orcamento/listar/1', 'error', 'Orçamento não encontrado.');
            return;
        }

        View::render('orcamento/edit', [
            'orcamento'     => $orcamento,
            'clientes'      => $this->orcamento->buscarClientes(),
            'profissionais' => $this->orcamento->buscarProfissionais(),
            'categorias'    => $this->orcamento->buscarCategorias(),
            'servicos'      => $this->servico->buscarServicosTrabalho(),
        ]);
    }

    public function atualizarOrcamento(): void
    {
        $id           = (int) ($_POST['id_orcamento'] ?? 0);
        $id_categoria = (int) ($_POST['id_categoria'] ?? 0) ?: null;
        $id_pedreiro  = (int) ($_POST['id_pedreiro']  ?? 0) ?: null;
        $descricao    = trim($_POST['descricao_orcamento'] ?? '');
        $status       = $_POST['status_orcamento'] ?? 'Em Aberto';

        if (!$id) {
            Redirect::redirecionarComMensagem('orcamento/listar/1', 'error', 'Orçamento inválido.');
            return;
        }

        $this->orcamento->atualizarOrcamento($id, $id_categoria, $id_pedreiro, $descricao, $status);

        // Recriar itens
        $this->orcamento->removerItens($id);
        $servicos    = $_POST['item_servico']     ?? [];
        $descricoes  = $_POST['item_descricao']   ?? [];
        $valores     = $_POST['item_valor']        ?? [];
        $quantidades = $_POST['item_quantidade']  ?? [];

        foreach ($servicos as $i => $id_servico) {
            if (empty($id_servico)) continue;
            $this->orcamento->inserirItem(
                $id,
                (int)   $id_servico,
                        $descricoes[$i]   ?? '',
                (float) str_replace(',', '.', $valores[$i]    ?? 0),
                (float) str_replace(',', '.', $quantidades[$i] ?? 1)
            );
        }

        Redirect::redirecionarComMensagem('orcamento/listar/1', 'success', 'Orçamento atualizado com sucesso!');
    }

    /* ─────────────────────────── CANCELAR ───────────────────────── */
    public function viewCancelarOrcamento(int $id): void
    {
        $orcamento = $this->orcamento->buscarPorID($id);
        if (!$orcamento) {
            Redirect::redirecionarComMensagem('orcamento/listar/1', 'error', 'Orçamento não encontrado.');
            return;
        }
        View::render('orcamento/delete', ['orcamento' => $orcamento]);
    }

    public function cancelarOrcamento(): void
    {
        $id = (int) ($_POST['id_orcamento'] ?? 0);
        if ($this->orcamento->cancelarOrcamento($id)) {
            Redirect::redirecionarComMensagem('orcamento/listar/1', 'success', 'Orçamento cancelado.');
        } else {
            Redirect::redirecionarComMensagem('orcamento/listar/1', 'error', 'Erro ao cancelar orçamento.');
        }
    }
}
