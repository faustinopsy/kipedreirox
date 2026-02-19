<?php
namespace App\Kipedreiro\Models;
use PDO;

class Pedido{
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    public function criarPedido(array $itensCarrinho){
        $this->db->beginTransaction();
        try {
            $valorTotalCalculado = 0;
            foreach ($itensCarrinho as $item) {
                $valorTotalCalculado += $item['preco'] * $item['quantidade'];
            }

            $sqlPedido = "INSERT INTO tbl_pedidos (valor_total, data_pedido) VALUES (:valor_total, NOW())";
            $stmtPedido = $this->db->prepare($sqlPedido);
            $stmtPedido->bindParam(':valor_total', $valorTotalCalculado);
            $stmtPedido->execute();
            $idPedido = $this->db->lastInsertId();
            $sqlItem = "INSERT INTO tbl_pedido_itens (id_pedido, id_produto, quantidade, preco_unitario) 
                        VALUES (:id_pedido, :id_produto, :quantidade, :preco_unitario)";
            $stmtItem = $this->db->prepare($sqlItem);
            foreach ($itensCarrinho as $item) {
                $stmtItem->bindParam(':id_pedido', $idPedido, PDO::PARAM_INT);
                $stmtItem->bindParam(':id_produto', $item['id'], PDO::PARAM_INT);
                $stmtItem->bindParam(':quantidade', $item['quantidade'], PDO::PARAM_INT);
                $stmtItem->bindParam(':preco_unitario', $item['preco']);
                $stmtItem->execute();
            }
            $this->db->commit();

            return (int)$idPedido;
        } catch (\Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
}