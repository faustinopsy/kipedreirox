<?php
namespace App\Kipedreiro\Models;
use PDO;

/**
 * Model para gerenciar a tabela tbl_generos
 * Segue o padrão de soft-delete (excluido_em)
 */
class Genero {

    private $id_genero;
    private $nome_genero;
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
     * Busca todos os gêneros ativos (não excluídos)
     */
    function buscarGeneros(){
        $sql = "SELECT * FROM tbl_generos WHERE excluido_em IS NULL ORDER BY nome_genero ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca todos os gêneros inativos (excluídos)
     */
    function buscarGenerosInativos(){
        $sql = "SELECT * FROM tbl_generos WHERE excluido_em IS NOT NULL ORDER BY nome_genero ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca um gênero específico pelo seu ID (ativo ou inativo)
     */
    function buscarGeneroPorID(int $id){
        $sql = "SELECT * FROM tbl_generos WHERE id_genero = :id_genero";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_genero', $id, PDO::PARAM_INT); 
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // ID é único
    }

    /**
     * Método para busca dinâmica (autocomplete) no formulário de itens.
     * Retorna apenas gêneros ativos.
     */
    function buscarGenerosPorNome(string $termo, int $limite = 10){
        $sql = "SELECT id_genero, nome_genero FROM tbl_generos 
                WHERE nome_genero LIKE :termo AND excluido_em IS NULL 
                ORDER BY nome_genero ASC 
                LIMIT :limite";
        $stmt = $this->db->prepare($sql);
        $termoLike = '%' . $termo . '%';
        $stmt->bindParam(':termo', $termoLike);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // --- MÉTODOS DE CONTAGEM (STATS) ---

    function totalDeGeneros(){
        $sql = "SELECT count(*) as total FROM tbl_generos";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_COLUMN); 
    }
    
    function totalDeGenerosInativos(){
        $sql = "SELECT count(*) as total FROM tbl_generos WHERE excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    function totalDeGenerosAtivos(){
        $sql = "SELECT count(*) as total FROM tbl_generos WHERE excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    // --- MÉTODO DE PAGINAÇÃO ---

    public function paginacao(int $pagina = 1, int $por_pagina = 10): array{
        
        $totalQuery = "SELECT COUNT(*) FROM `tbl_generos`";
        $totalStmt = $this->db->query($totalQuery);
        $total_de_registros = $totalStmt->fetchColumn();
        
        $offset = ($pagina - 1) * $por_pagina;
        
        $dataQuery = "SELECT * FROM `tbl_generos` ORDER BY nome_genero ASC LIMIT :limit OFFSET :offset";
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
     * Insere um novo gênero no banco de dados
     */
    function inserirGenero(string $nome){
        $sql = "INSERT INTO tbl_generos (nome_genero) VALUES (:nome)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        
        if($stmt->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }

    /**
     * Atualiza um gênero existente
     */
    function atualizarGenero(int $id, string $nome){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_generos SET 
                  nome_genero = :nome,
                  atualizado_em = :atual
                WHERE id_genero = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':atual', $dataatual);
        
        return $stmt->execute();
    }

    /**
     * Inativa um gênero (Soft Delete)
     */
    function excluirGenero(int $id){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_generos SET
                  excluido_em = :atual
                WHERE id_genero = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':atual', $dataatual);
        
        return $stmt->execute();
    }

    /**
     * Re-ativa um gênero que foi excluído
     */
    function ativarGenero(int $id){
        $sql = "UPDATE tbl_generos SET
                  excluido_em = NULL
                WHERE id_genero = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
}