<?php
namespace App\Kipedreiro\Models;
use PDO;

/**
 * Model para gerenciar a tabela tbl_autores
 * Segue o padrão de soft-delete (excluido_em)
 */
class Autor {

    private $id_autor;
    private $nome_autor;
    private $biografia;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;

    // Construtor inicializa a conexão PDO
    public function __construct($db){
        $this->db = $db;
    }

    // --- MÉTODOS DE LEITURA (READ) ---

    /**
     * Busca todos os autores ativos (não excluídos)
     */
    function buscarAutores(){
        $sql = "SELECT * FROM tbl_autores WHERE excluido_em IS NULL ORDER BY nome_autor ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca todos os autores inativos (excluídos)
     */
    function buscarAutoresInativos(){
        $sql = "SELECT * FROM tbl_autores WHERE excluido_em IS NOT NULL ORDER BY nome_autor ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca um autor específico pelo seu ID (ativo ou inativo)
     */
    function buscarAutorPorID(int $id){
        $sql = "SELECT * FROM tbl_autores WHERE id_autor = :id_autor";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_autor', $id, PDO::PARAM_INT); 
        $stmt->execute();
        // Usamos fetch pois esperamos apenas um resultado
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    /**
     * Método para busca dinâmica (autocomplete) no formulário de itens.
     * Retorna apenas autores ativos.
     */
    function buscarAutoresPorNome(string $termo, int $limite = 10){
        $sql = "SELECT id_autor, nome_autor FROM tbl_autores 
                WHERE nome_autor LIKE :termo AND excluido_em IS NULL 
                ORDER BY nome_autor ASC 
                LIMIT :limite";
        $stmt = $this->db->prepare($sql);
        $termoLike = '%' . $termo . '%';
        $stmt->bindParam(':termo', $termoLike);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // --- MÉTODOS DE CONTAGEM (STATS) ---

    function totalDeAutores(){
        $sql = "SELECT count(*) as total FROM tbl_autores";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_COLUMN); // Retorna só o número
    }
    
    function totalDeAutoresInativos(){
        $sql = "SELECT count(*) as total FROM tbl_autores WHERE excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    function totalDeAutoresAtivos(){
        $sql = "SELECT count(*) as total FROM tbl_autores WHERE excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    // --- MÉTODO DE PAGINAÇÃO ---

    /**
     * Paginação de autores (inclui ativos e inativos, seguindo seu padrão)
     */
    public function paginacao(int $pagina = 1, int $por_pagina = 10, bool $ativos = false): array{
        
        $whereClause = $ativos ? "WHERE excluido_em IS NULL" : "";

        $totalQuery = "SELECT COUNT(*) FROM `tbl_autores` $whereClause";
        $totalStmt = $this->db->query($totalQuery);
        $total_de_registros = $totalStmt->fetchColumn();
        
        $offset = ($pagina - 1) * $por_pagina;
        
        $dataQuery = "SELECT * FROM `tbl_autores` $whereClause ORDER BY nome_autor ASC LIMIT :limit OFFSET :offset";
        $dataStmt = $this->db->prepare($dataQuery);
        $dataStmt->bindValue(':limit', $por_pagina, PDO::PARAM_INT);
        $dataStmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $dataStmt->execute();
        $dados = $dataStmt->fetchAll(PDO::FETCH_ASSOC);
        
        $lastPage = ceil($total_de_registros / $por_pagina);

        return [
            'data' => $dados,
            'total' => (int) $total_de_registros,
            'por_pagina' => (int) $por_pagina,
            'pagina_atual' => (int) $pagina,
            'ultima_pagina' => (int) $lastPage,
            'de' => $offset + 1,
            'para' => $offset + count($dados)
        ];
    }

    // --- MÉTODOS DE ESCRITA (CREATE, UPDATE, DELETE) ---

    /**
     * Insere um novo autor no banco de dados
     */
    function inserirAutor(string $nome, string $biografia = null){
        $sql = "INSERT INTO tbl_autores (nome_autor, biografia) 
                VALUES (:nome, :biografia)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':biografia', $biografia);
        
        if($stmt->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }

    /**
     * Atualiza um autor existente
     */
    function atualizarAutor(int $id, string $nome, string $biografia = null){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_autores SET 
                  nome_autor = :nome,
                  biografia = :biografia, 
                  atualizado_em = :atual
                WHERE id_autor = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':biografia', $biografia);
        $stmt->bindParam(':atual', $dataatual);
        
        return $stmt->execute(); // Retorna true em sucesso, false em falha
    }

    /**
     * Inativa um autor (Soft Delete)
     */
    function excluirAutor(int $id){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_autores SET
                  excluido_em = :atual
                WHERE id_autor = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':atual', $dataatual);
        
        return $stmt->execute();
    }

    /**
     * Re-ativa um autor que foi excluído
     */
    function ativarAutor(int $id){
        $sql = "UPDATE tbl_autores SET
                  excluido_em = NULL
                WHERE id_autor = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
}