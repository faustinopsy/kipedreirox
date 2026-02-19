<?php
namespace App\Kipedreiro\Models;
use PDO;

class Servico
{
    private $db;
    public function __construct($db){
        $this->db = $db;
    }

    /* ──────────────────────────────────────
     *  SITE PÚBLICO: só serviços tipo=site
     * ────────────────────────────────────── */
    public function buscarServicosAtivos(){
        $sql = "SELECT nome_servico, descricao_servico, foto_servico
                  FROM tbl_servico
                 WHERE status_servico = 'ativo'
                   AND tipo_servico   = 'site'
                 ORDER BY criado_em DESC LIMIT 4";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ──────────────────────────────────────
     *  ADMIN: listagem paginada (todos os
     *  tipos, filtrável por tipo)
     * ────────────────────────────────────── */
    public function paginacao(int $pagina = 1, int $porPagina = 50, ?string $tipo = null): array
    {
        $offset = ($pagina - 1) * $porPagina;

        $where = $tipo ? "WHERE tipo_servico = :tipo" : "";
        $sql = "SELECT * FROM tbl_servico $where
                 ORDER BY criado_em DESC
                 LIMIT :offset, :porPagina";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':offset',    $offset,    PDO::PARAM_INT);
        $stmt->bindParam(':porPagina', $porPagina, PDO::PARAM_INT);
        if ($tipo) $stmt->bindParam(':tipo', $tipo);
        $stmt->execute();
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $countSql = $tipo
            ? "SELECT COUNT(*) FROM tbl_servico WHERE tipo_servico = :tipo"
            : "SELECT COUNT(*) FROM tbl_servico";
        $countStmt = $this->db->prepare($countSql);
        if ($tipo) $countStmt->bindParam(':tipo', $tipo);
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
     *  SERVIÇOS DE TRABALHO (para orçamento)
     * ────────────────────────────────────── */
    public function buscarServicosTrabalho(): array
    {
        $sql = "SELECT id_servico, nome_servico, descricao_servico, valor_base_servico
                  FROM tbl_servico
                 WHERE status_servico = 'ativo'
                   AND tipo_servico   = 'trabalho'
                 ORDER BY nome_servico ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ──────────────────────────────────────
     *  CRUD
     * ────────────────────────────────────── */
    public function inserirServico(
        string  $nome,
        string  $descricao,
        string  $foto,
        string  $tipo = 'trabalho',
        ?float  $valor_base = null
    ): int|false {
        $sql = "INSERT INTO tbl_servico
                    (nome_servico, descricao_servico, foto_servico,
                     tipo_servico, valor_base_servico, status_servico, criado_em)
                VALUES
                    (:nome, :descricao, :foto,
                     :tipo, :valor, 'Ativo', NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome',      $nome);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':foto',      $foto);
        $stmt->bindParam(':tipo',      $tipo);
        $stmt->bindParam(':valor',     $valor_base);

        if ($stmt->execute()) {
            return (int) $this->db->lastInsertId();
        }
        return false;
    }

    public function buscarPorID(int $id): array|false
    {
        $sql = "SELECT * FROM tbl_servico WHERE id_servico = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizarServico(
        int     $id,
        string  $nome,
        string  $descricao,
        ?string $foto,
        string  $tipo = 'trabalho',
        ?float  $valor_base = null
    ): bool {
        $sql = "UPDATE tbl_servico SET
                    nome_servico        = :nome,
                    descricao_servico   = :descricao,
                    tipo_servico        = :tipo,
                    valor_base_servico  = :valor,
                    atualizado_em       = NOW()";
        if ($foto) {
            $sql .= ", foto_servico = :foto";
        }
        $sql .= " WHERE id_servico = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id',        $id, PDO::PARAM_INT);
        $stmt->bindParam(':nome',      $nome);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':tipo',      $tipo);
        $stmt->bindParam(':valor',     $valor_base);
        if ($foto) $stmt->bindParam(':foto', $foto);

        return $stmt->execute();
    }

    public function deletarServico(int $id): bool
    {
        $servico = $this->buscarPorID($id);
        $novoStatus = strtolower($servico['status_servico'] ?? '') === 'ativo' ? 'Inativo' : 'ativo';

        $sql = "UPDATE tbl_servico SET status_servico = :status WHERE id_servico = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id',     $id,        PDO::PARAM_INT);
        $stmt->bindParam(':status', $novoStatus);
        return $stmt->execute();
    }
}