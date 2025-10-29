<?php
namespace App\Kipedreiro\Models;
use PDO;
use Exception; // Usaremos para as transações

/**
 * Model para gerenciar a tabela tbl_itens (Livros, CDs, DVDs, Revistas)
 * Lida com o relacionamento N:N com Autores (tbl_item_autores)
 */
class Item {

    // Propriedades da tbl_itens
    private $id_item;
    private $titulo_item;
    private $tipo_item; // enum('livro', 'cd', 'dvd', 'revista')
    private $id_genero;
    private $id_categoria;
    private $descricao;
    private $ano_publicacao;
    private $editora_gravadora;
    private $estoque;
    private $isbn;
    private $duracao_minutos;
    private $numero_edicao;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    // --- MÉTODOS DE ESCRITA (CREATE, UPDATE, DELETE) ---
    // Estes são os métodos mais complexos devido ao relacionamento N:N

    /**
     * Insere um novo item e seus autores associados usando uma transação.
     * @param array $dadosItem - Um array associativo com os dados da tbl_itens.
     * Ex: ['titulo_item' => 'Meu Livro', 'tipo_item' => 'livro', ...]
     * @param array $autores_ids - Um array de IDs de autores. Ex: [1, 5, 12]
     * @return int|false - Retorna o ID do novo item ou false em caso de falha.
     */
    function inserirItem(array $dadosItem, array $autores_ids){
        
        // Separa as chaves e valores para a query SQL
        $colunas = implode(', ', array_keys($dadosItem));
        $placeholders = ':' . implode(', :', array_keys($dadosItem));

        $sqlItem = "INSERT INTO tbl_itens ($colunas) VALUES ($placeholders)";
        $sqlPivot = "INSERT INTO tbl_item_autores (id_item, id_autor) VALUES (:id_item, :id_autor)";

        try {
            $this->db->beginTransaction();

            // 1. Inserir o item principal
            $stmtItem = $this->db->prepare($sqlItem);
            foreach ($dadosItem as $coluna => &$valor) {
                // bindValue é mais seguro no loop do que bindParam
                $stmtItem->bindValue(":$coluna", $valor);
            }
            
            if (!$stmtItem->execute()) {
                throw new Exception("Falha ao inserir o item principal.");
            }
            
            $idNovoItem = $this->db->lastInsertId();

            // 2. Inserir os relacionamentos na tabela pivot
            if (!empty($autores_ids)) {
                $stmtPivot = $this->db->prepare($sqlPivot);
                foreach ($autores_ids as $id_autor) {
                    $stmtPivot->bindParam(':id_item', $idNovoItem, PDO::PARAM_INT);
                    $stmtPivot->bindParam(':id_autor', $id_autor, PDO::PARAM_INT);
                    if (!$stmtPivot->execute()) {
                        throw new Exception("Falha ao inserir autor ID: $id_autor.");
                    }
                }
            }

            // Se tudo deu certo, comita a transação
            $this->db->commit();
            return $idNovoItem;

        } catch (Exception $e) {
            // Se algo deu errado, desfaz tudo
            $this->db->rollBack();
            // error_log($e->getMessage()); // Opcional: logar o erro
            return false;
        }
    }

    /**
     * Atualiza um item e seus autores associados usando uma transação.
     * @param int $id_item - O ID do item a ser atualizado.
     * @param array $dadosItem - Array associativo com os dados da tbl_itens.
     * @param array $autores_ids - Array de IDs de autores.
     * @return bool - True em sucesso, false em falha.
     */
    function atualizarItem(int $id_item, array $dadosItem, array $autores_ids){
        
        $dadosItem['atualizado_em'] = date('Y-m-d H:i:s');
        
        // Monta a parte SET da query
        $setParts = [];
        foreach ($dadosItem as $coluna => $valor) {
            $setParts[] = "$coluna = :$coluna";
        }
        $setString = implode(', ', $setParts);

        $sqlItem = "UPDATE tbl_itens SET $setString WHERE id_item = :id_item";
        $sqlDeletePivot = "DELETE FROM tbl_item_autores WHERE id_item = :id_item";
        $sqlInsertPivot = "INSERT INTO tbl_item_autores (id_item, id_autor) VALUES (:id_item, :id_autor)";

        try {
            $this->db->beginTransaction();

            // 1. Atualizar o item principal
            $stmtItem = $this->db->prepare($sqlItem);
            $stmtItem->bindParam(':id_item', $id_item, PDO::PARAM_INT);
            foreach ($dadosItem as $coluna => &$valor) {
                $stmtItem->bindValue(":$coluna", $valor);
            }

            if (!$stmtItem->execute()) {
                throw new Exception("Falha ao atualizar o item principal.");
            }

            // 2. Excluir os relacionamentos de autores antigos
            $stmtDelete = $this->db->prepare($sqlDeletePivot);
            $stmtDelete->bindParam(':id_item', $id_item, PDO::PARAM_INT);
            if (!$stmtDelete->execute()) {
                throw new Exception("Falha ao limpar autores antigos.");
            }

            // 3. Inserir os novos relacionamentos
            if (!empty($autores_ids)) {
                $stmtInsert = $this->db->prepare($sqlInsertPivot);
                foreach ($autores_ids as $id_autor) {
                    $stmtInsert->bindParam(':id_item', $id_item, PDO::PARAM_INT);
                    $stmtInsert->bindParam(':id_autor', $id_autor, PDO::PARAM_INT);
                    if (!$stmtInsert->execute()) {
                        throw new Exception("Falha ao inserir novo autor ID: $id_autor.");
                    }
                }
            }

            $this->db->commit();
            return true;

        } catch (Exception $e) {
            $this->db->rollBack();
            // error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Inativa um item (Soft Delete)
     */
    function excluirItem(int $id){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_itens SET excluido_em = :atual WHERE id_item = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':atual', $dataatual);
        return $stmt->execute();
    }

    /**
     * Re-ativa um item que foi excluído
     */
    function ativarItem(int $id){
        $sql = "UPDATE tbl_itens SET excluido_em = NULL WHERE id_item = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }


    // --- MÉTODOS DE LEITURA (READ) ---

    /**
     * Busca um item específico pelo seu ID (sem joins, rápido)
     * Para preencher o formulário de edição.
     */
    function buscarItemPorID(int $id){
        $sql = "SELECT * FROM tbl_itens WHERE id_item = :id_item";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_item', $id, PDO::PARAM_INT); 
        $stmt->execute();
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($item) {
            // Busca os IDs dos autores associados
            $item['autores_ids'] = $this->buscarAutoresDoItem($id);
        }
        return $item;
    }

    /**
     * Helper para buscar os IDs dos autores de um item
     */
    function buscarAutoresDoItem(int $id_item){
        $sql = "SELECT id_autor FROM tbl_item_autores WHERE id_item = :id_item";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_item', $id_item, PDO::PARAM_INT);
        $stmt->execute();
        // Retorna um array simples de IDs. Ex: [1, 5, 12]
        return $stmt->fetchAll(PDO::FETCH_COLUMN); 
    }


    // --- MÉTODOS DE PAGINAÇÃO E CONTAGEM (COM RELACIONAMENTOS) ---

    /**
     * Paginação de itens com dados relacionados (Gênero, Categoria e Autores)
     * Usa GROUP_CONCAT para listar os autores sem duplicar linhas de item.
     */
    public function paginacao(int $pagina = 1, int $por_pagina = 10, string $tipo = null): array {
        
        $whereClause = "i.excluido_em IS NULL";
        $params = [];
        if ($tipo) {
            $whereClause .= " AND i.tipo_item = :tipo";
            $params[':tipo'] = $tipo;
        }

        // 1. Contagem Total
        $totalQuery = "SELECT COUNT(DISTINCT i.id_item) FROM tbl_itens i WHERE $whereClause";
        $totalStmt = $this->db->prepare($totalQuery);
        $totalStmt->execute($params);
        $total_de_registros = $totalStmt->fetchColumn();

        // 2. Busca dos Dados Paginados
        $offset = ($pagina - 1) * $por_pagina;
        
        $dataQuery = "
            SELECT 
                i.*, 
                g.nome_genero, 
                c.nome_categoria,
                (SELECT GROUP_CONCAT(a.nome_autor SEPARATOR ', ') 
                 FROM tbl_item_autores ia
                 JOIN tbl_autores a ON ia.id_autor = a.id_autor
                 WHERE ia.id_item = i.id_item
                 AND a.excluido_em IS NULL) AS autores
            FROM 
                tbl_itens i
            LEFT JOIN 
                tbl_generos g ON i.id_genero = g.id_genero
            LEFT JOIN 
                tbl_categorias c ON i.id_categoria = c.id_categoria
            WHERE 
                $whereClause
            GROUP BY
                i.id_item
            ORDER BY 
                i.titulo_item ASC
            LIMIT :limit OFFSET :offset
        ";

        $dataStmt = $this->db->prepare($dataQuery);
        $dataStmt->bindValue(':limit', $por_pagina, PDO::PARAM_INT);
        $dataStmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        foreach ($params as $key => $value) {
            $dataStmt->bindValue($key, $value);
        }
        
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

    // --- Métodos de Contagem Simples ---

    function totalDeItens(string $tipo = null){
        $sql = "SELECT count(*) as total FROM tbl_itens";
        $params = [];
        if ($tipo) {
            $sql .= " WHERE tipo_item = :tipo";
            $params[':tipo'] = $tipo;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }
    
    function totalDeItensInativos(string $tipo = null){
        $sql = "SELECT count(*) as total FROM tbl_itens WHERE excluido_em IS NOT NULL";
        $params = [];
        if ($tipo) {
            $sql .= " AND tipo_item = :tipo";
            $params[':tipo'] = $tipo;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    function totalDeItensAtivos(string $tipo = null){
        $sql = "SELECT count(*) as total FROM tbl_itens WHERE excluido_em IS NULL";
        $params = [];
        if ($tipo) {
            $sql .= " AND tipo_item = :tipo";
            $params[':tipo'] = $tipo;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }
}