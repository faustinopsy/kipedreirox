<?php
namespace App\Kipedreiro\Models;
use PDO;

class Orcamento
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /* ─────────────────────────────────────────
     *  LISTAGEM / PAGINAÇÃO
     * ───────────────────────────────────────── */
    public function paginacao(int $pagina = 1, int $porPagina = 15): array
    {
        $offset = ($pagina - 1) * $porPagina;

        $sql = "SELECT o.*,
                       u.nome_usuario   AS nome_cliente,
                       c.nome_categoria AS nome_categoria,
                       (SELECT COALESCE(SUM(total_item_orcamento), 0)
                          FROM tbl_item_orcamento
                         WHERE id_orcamento = o.id_orcamento) AS valor_total
                  FROM tbl_orcamento o
             LEFT JOIN tbl_usuario  u ON u.id_usuario  = o.id_cliente
             LEFT JOIN tbl_categoria c ON c.id_categoria = o.id_categoria
              ORDER BY o.criado_em DESC, o.id_orcamento DESC
                 LIMIT :offset, :porPagina";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':offset',    $offset,    PDO::PARAM_INT);
        $stmt->bindParam(':porPagina', $porPagina, PDO::PARAM_INT);
        $stmt->execute();
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $total = (int) $this->db->query("SELECT COUNT(*) FROM tbl_orcamento")->fetchColumn();

        return [
            'data'          => $dados,
            'total'         => $total,
            'por_pagina'    => $porPagina,
            'pagina_atual'  => $pagina,
            'total_paginas' => (int) ceil($total / $porPagina),
        ];
    }

    /* ─────────────────────────────────────────
     *  BUSCA POR ID  (cabeçalho + itens)
     * ───────────────────────────────────────── */
    public function buscarPorID(int $id): ?array
    {
        // Cabeçalho
        $sql = "SELECT o.*,
                       u.nome_usuario   AS nome_cliente,
                       c.nome_categoria AS nome_categoria,
                       p.nome_usuario   AS nome_pedreiro
                  FROM tbl_orcamento o
             LEFT JOIN tbl_usuario   u ON u.id_usuario  = o.id_cliente
             LEFT JOIN tbl_categoria c ON c.id_categoria = o.id_categoria
             LEFT JOIN tbl_usuario   p ON p.id_usuario  = o.id_pedreiro
                 WHERE o.id_orcamento = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $orcamento = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$orcamento) return null;

        // Itens
        $sqlItens = "SELECT i.*, s.nome_servico
                       FROM tbl_item_orcamento i
                  LEFT JOIN tbl_servico s ON s.id_servico = i.id_servico
                      WHERE i.id_orcamento = :id";
        $stmtItens = $this->db->prepare($sqlItens);
        $stmtItens->bindParam(':id', $id, PDO::PARAM_INT);
        $stmtItens->execute();
        $orcamento['itens'] = $stmtItens->fetchAll(PDO::FETCH_ASSOC);

        return $orcamento;
    }

    /* ─────────────────────────────────────────
     *  INSERIR ORÇAMENTO
     * ───────────────────────────────────────── */
    public function inserirOrcamento(
        int    $id_cliente,
        ?int   $id_categoria,
        ?int   $id_pedreiro,
        string $descricao,
        string $status = 'Em Aberto'
    ): int|false {
        $sql = "INSERT INTO tbl_orcamento
                    (id_cliente, id_categoria, id_pedreiro, descricao_orcamento,
                     status_orcamento, data_orcamento, criado_em)
                VALUES
                    (:id_cliente, :id_categoria, :id_pedreiro, :descricao,
                     :status, NOW(), NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_cliente',   $id_cliente,   PDO::PARAM_INT);
        $stmt->bindParam(':id_categoria', $id_categoria, PDO::PARAM_INT);
        $stmt->bindParam(':id_pedreiro',  $id_pedreiro,  PDO::PARAM_INT);
        $stmt->bindParam(':descricao',    $descricao);
        $stmt->bindParam(':status',       $status);

        if ($stmt->execute()) {
            return (int) $this->db->lastInsertId();
        }
        return false;
    }

    /* ─────────────────────────────────────────
     *  INSERIR ITEM
     * ───────────────────────────────────────── */
    public function inserirItem(
        int    $id_orcamento,
        int    $id_servico,
        string $descricao,
        float  $valor_unitario,
        float  $quantidade
    ): bool {
        $total = $valor_unitario * $quantidade;
        $sql = "INSERT INTO tbl_item_orcamento
                    (id_orcamento, id_servico, descricao_item_orcamento,
                     valor_servico, qtde_solicitada, total_item_orcamento, status_item_orcamento)
                VALUES
                    (:id_orc, :id_serv, :descricao,
                     :valor, :qtde, :total, 'Pendente')";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_orc',   $id_orcamento, PDO::PARAM_INT);
        $stmt->bindParam(':id_serv',  $id_servico,   PDO::PARAM_INT);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':valor',    $valor_unitario);
        $stmt->bindParam(':qtde',     $quantidade);
        $stmt->bindParam(':total',    $total);
        return $stmt->execute();
    }

    /* ─────────────────────────────────────────
     *  ATUALIZAR CABEÇALHO
     * ───────────────────────────────────────── */
    public function atualizarOrcamento(
        int    $id,
        ?int   $id_categoria,
        ?int   $id_pedreiro,
        string $descricao,
        string $status
    ): bool {
        $finalizadoEm = in_array($status, ['Finalizado', 'Recusado']) ? date('Y-m-d H:i:s') : null;
        $sql = "UPDATE tbl_orcamento SET
                    id_categoria      = :id_categoria,
                    id_pedreiro       = :id_pedreiro,
                    descricao_orcamento = :descricao,
                    status_orcamento  = :status,
                    finalizado_em     = :finalizado_em
                WHERE id_orcamento = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id',           $id,           PDO::PARAM_INT);
        $stmt->bindParam(':id_categoria', $id_categoria, PDO::PARAM_INT);
        $stmt->bindParam(':id_pedreiro',  $id_pedreiro,  PDO::PARAM_INT);
        $stmt->bindParam(':descricao',    $descricao);
        $stmt->bindParam(':status',       $status);
        $stmt->bindParam(':finalizado_em', $finalizadoEm);
        return $stmt->execute();
    }

    /* ─────────────────────────────────────────
     *  REMOVER E RECRIAR ITENS
     * ───────────────────────────────────────── */
    public function removerItens(int $id_orcamento): bool
    {
        $sql = "DELETE FROM tbl_item_orcamento WHERE id_orcamento = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id_orcamento, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /* ─────────────────────────────────────────
     *  CANCELAR (soft-delete via status)
     * ───────────────────────────────────────── */
    public function cancelarOrcamento(int $id): bool
    {
        $sql = "UPDATE tbl_orcamento SET status_orcamento = 'Recusado', finalizado_em = NOW()
                WHERE id_orcamento = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /* ─────────────────────────────────────────
     *  CONTAGENS PARA STAT CARDS
     * ───────────────────────────────────────── */
    public function totalPorStatus(string $status): int
    {
        $sql = "SELECT COUNT(*) FROM tbl_orcamento WHERE status_orcamento = :status";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    public function totalGeral(): int
    {
        return (int) $this->db->query("SELECT COUNT(*) FROM tbl_orcamento")->fetchColumn();
    }

    /* ─────────────────────────────────────────
     *  BUSCAR CLIENTES (para select)
     * ───────────────────────────────────────── */
    public function buscarClientes(): array
    {
        $sql = "SELECT id_usuario, nome_usuario
                  FROM tbl_usuario
                 WHERE excluido_em IS NULL
                   AND tipo_usuario IN ('Cliente', 'cliente', 'user', 'usuario')
                 ORDER BY nome_usuario ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ─────────────────────────────────────────
     *  BUSCAR PROFISSIONAIS (pedreiros, etc.)
     * ───────────────────────────────────────── */
    public function buscarProfissionais(): array
    {
        $sql = "SELECT id_usuario, nome_usuario, tipo_usuario
                  FROM tbl_usuario
                 WHERE excluido_em IS NULL
                   AND tipo_usuario IN ('Pedreiro','pedreiro','Eletricista','eletricista',
                                        'Pintor','pintor','Encanador','encanador','admin')
                 ORDER BY tipo_usuario, nome_usuario ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ─────────────────────────────────────────
     *  BUSCAR CATEGORIAS
     * ───────────────────────────────────────── */
    public function buscarCategorias(): array
    {
        $sql = "SELECT id_categoria, nome_categoria FROM tbl_categoria ORDER BY nome_categoria ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
