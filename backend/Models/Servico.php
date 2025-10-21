<?php
namespace App\Kipedreiro\Models;
use pdo; 

class Servico
{
    private $db;
    public function __construct($db){
        $this->db = $db;
    }

    public function buscarServicosAtivos(){
        $sql = "SELECT nome_servico, descricao_servico, foto_servico 
                FROM tbl_servico 
                WHERE status_servico = 'ativo' 
                ORDER BY criado_em DESC LIMIT 4";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function paginacao(int $pagina = 1, int $porPagina = 50){
        $offset = ($pagina - 1) * $porPagina;
        $sql = "SELECT * FROM tbl_servico 
                LIMIT :offset, :porPagina";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':porPagina', $porPagina, PDO::PARAM_INT);
        $stmt->execute();
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $totalStmt = $this->db->query("SELECT COUNT(*) FROM tbl_servico");
        $total = $totalStmt->fetchColumn();
        $totalPaginas = ceil($total / $porPagina);

        return [
            'data' => $dados,
            'total' => (int) $total,
            'por_pagina' => (int) $porPagina,
            'pagina_atual' => (int) $pagina,
            'total_paginas' => (int) $totalPaginas
        ];
    }

    public function inserirServico(string $nome, string $descricao, string $foto){
        $sql = "INSERT INTO tbl_servico (nome_servico, descricao_servico, foto_servico, status_servico, criado_em) 
                VALUES (:nome, :descricao, :foto, 'Ativo', NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':foto', $foto);
        
        if($stmt->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }

    public function buscarPorID(int $id){
        $sql = "SELECT * FROM tbl_servico WHERE id_servico = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizarServico(int $id, string $nome, string $descricao, ?string $foto){
        $sql = "UPDATE tbl_servico SET 
                    nome_servico = :nome, 
                    descricao_servico = :descricao, 
                    atualizado_em = NOW()";
        if ($foto) {
            $sql .= ", foto_servico = :foto";
        }
        
        $sql .= " WHERE id_servico = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descricao', $descricao);
        if ($foto) {
            $stmt->bindParam(':foto', $foto);
        }
        
        return $stmt->execute();
    }

    public function deletarServico(int $id){
        $status = $this->buscarPorID($id);
        $status = $status['status_servico'] == 'ativo' ? 'Inativo' : 'ativo';

        $sql = "UPDATE tbl_servico SET status_servico = :status WHERE id_servico = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }
}