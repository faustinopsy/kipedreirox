<?php
namespace App\Kipedreiro\Models;
use PDO;

class Contato
{
    private $db;
    public function __construct($db){
        $this->db = $db;
    }

    /* ──────────────────────────────────────
     *  ADMIN: listagem paginada
     * ────────────────────────────────────── */
    public function paginacao(int $pagina = 1, int $porPagina = 20): array
    {
        $offset = ($pagina - 1) * $porPagina;

        $sql = "SELECT * FROM tbl_contato
                 ORDER BY data_envio DESC
                 LIMIT :offset, :porPagina";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':offset',    $offset,    PDO::PARAM_INT);
        $stmt->bindParam(':porPagina', $porPagina, PDO::PARAM_INT);
        $stmt->execute();
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $countSql = "SELECT COUNT(*) FROM tbl_contato";
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
     *  CRUD / AÇÕES
     * ────────────────────────────────────── */
    public function inserirMensagem(string $nome, string $email, string $mensagem, ?string $telefone = null, ?string $assunto = null): bool
    {
        $sql = "INSERT INTO tbl_contato (nome_contato, email_contato, mensagem_contato, telefone_contato, assunto_contato, data_envio)
                VALUES (:nome, :email, :mensagem, :telefone, :assunto, NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome',     $nome);
        $stmt->bindParam(':email',    $email);
        $stmt->bindParam(':mensagem', $mensagem);
        $stmt->bindValue(':telefone', $telefone, PDO::PARAM_STR); // bindValue supports null
        $stmt->bindValue(':assunto',  $assunto,  PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function buscarPorID(int $id): array|false
    {
        $sql = "SELECT * FROM tbl_contato WHERE id_contato = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function marcarComoLido(int $id): bool
    {
        $sql = "UPDATE tbl_contato SET lido = 1 WHERE id_contato = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
     public function contarMensagensNaoLidas(): int
    {
        $sql = "SELECT COUNT(*) FROM tbl_contato WHERE lido = 0";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }
}
