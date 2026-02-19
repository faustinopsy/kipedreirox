<?php
namespace App\Kipedreiro\Models;
use PDO;

class Portfolio
{
    private $db;
    public function __construct($db){
        $this->db = $db;
    }

    /* ──────────────────────────────────────
     *  SITE PÚBLICO: listagem paginada
     * ────────────────────────────────────── */
    public function buscarPortfolioAtivo(int $pagina = 1, int $porPagina = 6): array
    {
        $offset = ($pagina - 1) * $porPagina;

        // Fetch items
        $sql = "SELECT *
                  FROM tbl_portfolio
                 WHERE status_portfolio = 'ativo'
                 ORDER BY id_portfolio DESC
                 LIMIT :offset, :porPagina";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':offset',    $offset,    PDO::PARAM_INT);
        $stmt->bindParam(':porPagina', $porPagina, PDO::PARAM_INT);
        $stmt->execute();
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Count total for pagination meta
        $countSql = "SELECT COUNT(*) FROM tbl_portfolio WHERE status_portfolio = 'ativo'";
        $countStmt = $this->db->prepare($countSql);
        $countStmt->execute();
        $total = (int) $countStmt->fetchColumn();

        return [
            'data'          => $dados,
            'total'         => $total,
            'por_pagina'    => $porPagina,
            'pagina_atual'  => $pagina,
            'total_paginas' => (int) ceil($total / $porPagina),
        ];
    }

    /* ──────────────────────────────────────
     *  ADMIN: listagem paginada
     * ────────────────────────────────────── */
    public function paginacao(int $pagina = 1, int $porPagina = 20): array
    {
        $offset = ($pagina - 1) * $porPagina;

        $sql = "SELECT * FROM tbl_portfolio
                 ORDER BY criado_em DESC
                 LIMIT :offset, :porPagina";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':offset',    $offset,    PDO::PARAM_INT);
        $stmt->bindParam(':porPagina', $porPagina, PDO::PARAM_INT);
        $stmt->execute();
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $countSql = "SELECT COUNT(*) FROM tbl_portfolio";
        $countStmt = $this->db->prepare($countSql);
        $countStmt->execute();
        $total = (int) $countStmt->fetchColumn();

        return [
            'data'          => $dados,
            'total'         => $total,
            'por_pagina'    => $porPagina,
            'pagina_atual'  => $pagina,
            'total_paginas' => (int) ceil($total / $porPagina),
        ];
    }

    /* ──────────────────────────────────────
     *  CRUD
     * ────────────────────────────────────── */
    public function inserirPortfolio(
        string  $titulo,
        string  $descricao,
        string  $imagem,
        string  $cliente,
        string  $dataProjeto
    ): int|false {
        $sql = "INSERT INTO tbl_portfolio
                    (titulo_portfolio, descricao_portfolio, imagem_portfolio, cliente_portfolio, data_projeto, status_portfolio, criado_em)
                VALUES
                    (:titulo, :descricao, :imagem, :cliente, :data, 'ativo', NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':titulo',    $titulo);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':imagem',    $imagem);
        $stmt->bindParam(':cliente',   $cliente);
        $stmt->bindParam(':data',      $dataProjeto);

        if ($stmt->execute()) {
            return (int) $this->db->lastInsertId();
        }
        return false;
    }

    public function buscarPorID(int $id): array|false
    {
        $sql = "SELECT * FROM tbl_portfolio WHERE id_portfolio = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizarPortfolio(
        int     $id,
        string  $titulo,
        string  $descricao,
        ?string $imagem,
        string  $cliente,
        string  $dataProjeto
    ): bool {
        $sql = "UPDATE tbl_portfolio SET
                    titulo_portfolio    = :titulo,
                    descricao_portfolio = :descricao,
                    cliente_portfolio   = :cliente,
                    data_projeto        = :data,
                    atualizado_em       = NOW()";
        if ($imagem) {
            $sql .= ", imagem_portfolio = :imagem";
        }
        $sql .= " WHERE id_portfolio = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id',        $id, PDO::PARAM_INT);
        $stmt->bindParam(':titulo',    $titulo);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':cliente',   $cliente);
        $stmt->bindParam(':data',      $dataProjeto);
        if ($imagem) $stmt->bindParam(':imagem', $imagem);

        return $stmt->execute();
    }

    public function deletarPortfolio(int $id): bool
    {
        // Alternar status (Soft Delete / Toggle)
        $item = $this->buscarPorID($id);
        $novoStatus = strtolower($item['status_portfolio'] ?? '') === 'ativo' ? 'inativo' : 'ativo';

        $sql = "UPDATE tbl_portfolio SET status_portfolio = :status WHERE id_portfolio = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id',     $id,        PDO::PARAM_INT);
        $stmt->bindParam(':status', $novoStatus);
        return $stmt->execute();
    }
}
