<?php
namespace App\Kipedreiro\Models;
use PDO;

/**
 * Model para gerenciar a tabela tbl_categorias
 * Segue o padrão de soft-delete (excluido_em)
 */
class Categoria {

    private $id_categoria;
    private $nome_categoria;
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
     * Busca todas as categorias ativas (não excluídas)
     */
    function buscarCategorias(){
        $sql = "SELECT * FROM tbl_categorias WHERE excluido_em IS NULL ORDER BY nome_categoria ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca todas as categorias inativas (excluídas)
     */
    function buscarCategoriasInativas(){
        $sql = "SELECT * FROM tbl_categorias WHERE excluido_em IS NOT NULL ORDER BY nome_categoria ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca uma categoria específica pelo seu ID (ativa ou inativa)
     */
    function buscarCategoriaPorID(int $id){
        $sql = "SELECT * FROM tbl_categorias WHERE id_categoria = :id_categoria";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_categoria', $id, PDO::PARAM_INT); 
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // ID é único
    }

    /**
     * Método para busca dinâmica (autocomplete) no formulário de itens.
     * Retorna apenas categorias ativas.
     */
    function buscarCategoriasPorNome(string $termo, int $limite = 10){
        $sql = "SELECT id_categoria, nome_categoria FROM tbl_categorias 
                WHERE nome_categoria LIKE :termo AND excluido_em IS NULL 
                ORDER BY nome_categoria ASC 
                LIMIT :limite";
        $stmt = $this->db->prepare($sql);
        $termoLike = '%' . $termo . '%';
        $stmt->bindParam(':termo', $termoLike);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // --- MÉTODOS DE CONTAGEM (STATS) ---

    function totalDeCategorias(){
        $sql = "SELECT count(*) as total FROM tbl_categorias";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_COLUMN); 
    }
    
    function totalDeCategoriasInativas(){
        $sql = "SELECT count(*) as total FROM tbl_categorias WHERE excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    function totalDeCategoriasAtivas(){
        $sql = "SELECT count(*) as total FROM tbl_categorias WHERE excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    // --- MÉTODO DE PAGINAÇÃO ---

    public function paginacao(int $pagina = 1, int $por_pagina = 10): array{
        
        $totalQuery = "SELECT COUNT(*) FROM `tbl_categorias`";
        $totalStmt = $this->db->query($totalQuery);
        $total_de_registros = $totalStmt->fetchColumn();
        
        $offset = ($pagina - 1) * $por_pagina;
        
        $dataQuery = "SELECT * FROM `tbl_categorias` ORDER BY nome_categoria ASC LIMIT :limit OFFSET :offset";
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
     * Insere uma nova categoria no banco de dados
     */
    function inserirCategoria(string $nome){
        $sql = "INSERT INTO tbl_categorias (nome_categoria) VALUES (:nome)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        
        if($stmt->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }

    /**
     * Atualiza uma categoria existente
     */
    function atualizarCategoria(int $id, string $nome){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_categorias SET 
                  nome_categoria = :nome,
                  atualizado_em = :atual
                WHERE id_categoria = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':atual', $dataatual);
        
        return $stmt->execute();
    }

    /**
     * Inativa uma categoria (Soft Delete)
     */
    function excluirCategoria(int $id){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_categorias SET
                  excluido_em = :atual
                WHERE id_categoria = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':atual', $dataatual);
        
        return $stmt->execute();
    }

    /**
     * Re-ativa uma categoria que foi excluída
     */
    function ativarCategoria(int $id){
        $sql = "UPDATE tbl_categorias SET
                  excluido_em = NULL
                WHERE id_categoria = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
}