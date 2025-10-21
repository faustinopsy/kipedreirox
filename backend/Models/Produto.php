<?php
namespace App\Kipedreiro\Models;
use PDO;

class Produto{
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function buscarProdutosAtivos() {
        $sql = "SELECT id_produto, nome_produto, preco_produto, foto_produto FROM tbl_produto WHERE status_produto = 'Ativo'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}