<?php
namespace App\Kipedreiro\Models;
use PDO;

class Sobre
{
    private $db;
    public function __construct($db){
        $this->db = $db;
    }

    /* ──────────────────────────────────────
     *  SITE PÚBLICO: buscar dados ativos
     * ────────────────────────────────────── */
    public function buscarSobreAtivo(){
        $sql = "SELECT *
                  FROM tbl_sobre
                 WHERE status_sobre = 'ativo'
                 ORDER BY id_sobre DESC LIMIT 1"; // Assume we only want one active "About" section or the latest one
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* ──────────────────────────────────────
     *  ADMIN: listagem paginada
     * ────────────────────────────────────── */
    public function paginacao(int $pagina = 1, int $porPagina = 50): array
    {
        $offset = ($pagina - 1) * $porPagina;

        $sql = "SELECT * FROM tbl_sobre
                 ORDER BY criado_em DESC
                 LIMIT :offset, :porPagina";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':offset',    $offset,    PDO::PARAM_INT);
        $stmt->bindParam(':porPagina', $porPagina, PDO::PARAM_INT);
        $stmt->execute();
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $countSql = "SELECT COUNT(*) FROM tbl_sobre";
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
    public function inserirSobre(
        string  $titulo,
        string  $descricao,
        string  $imagem,
        string  $missao,
        string  $visao,
        string  $valores
    ): int|false {
        $sql = "INSERT INTO tbl_sobre
                    (titulo_sobre, descricao_sobre, imagem_sobre, missao_sobre, visao_sobre, valores_sobre, status_sobre, criado_em)
                VALUES
                    (:titulo, :descricao, :imagem, :missao, :visao, :valores, 'ativo', NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':titulo',    $titulo);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':imagem',    $imagem);
        $stmt->bindParam(':missao',    $missao);
        $stmt->bindParam(':visao',     $visao);
        $stmt->bindParam(':valores',   $valores);

        if ($stmt->execute()) {
            return (int) $this->db->lastInsertId();
        }
        return false;
    }

    public function buscarPorID(int $id): array|false
    {
        $sql = "SELECT * FROM tbl_sobre WHERE id_sobre = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizarSobre(
        int     $id,
        string  $titulo,
        string  $descricao,
        ?string $imagem,
        string  $missao,
        string  $visao,
        string  $valores
    ): bool {
        $sql = "UPDATE tbl_sobre SET
                    titulo_sobre    = :titulo,
                    descricao_sobre = :descricao,
                    missao_sobre    = :missao,
                    visao_sobre     = :visao,
                    valores_sobre   = :valores,
                    atualizado_em   = NOW()";
        if ($imagem) {
            $sql .= ", imagem_sobre = :imagem";
        }
        $sql .= " WHERE id_sobre = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id',        $id, PDO::PARAM_INT);
        $stmt->bindParam(':titulo',    $titulo);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':missao',    $missao);
        $stmt->bindParam(':visao',     $visao);
        $stmt->bindParam(':valores',   $valores);
        if ($imagem) $stmt->bindParam(':imagem', $imagem);

        return $stmt->execute();
    }

    public function deletarSobre(int $id): bool
    {
        // For 'sobre', maybe we want to actually delete or just deactivate?
        // Following 'Servico' pattern of status toggle, but usually 'About' pages are single or few.
        // Let's implement real delete for now or status toggle if we want history.
        // The prompt asked to maintain standards. 'Servico' uses status toggle.
        
        $item = $this->buscarPorID($id);
        $novoStatus = strtolower($item['status_sobre'] ?? '') === 'ativo' ? 'inativo' : 'ativo';

        $sql = "UPDATE tbl_sobre SET status_sobre = :status WHERE id_sobre = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id',     $id,        PDO::PARAM_INT);
        $stmt->bindParam(':status', $novoStatus);
        return $stmt->execute();
    }
}
