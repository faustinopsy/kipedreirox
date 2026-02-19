<?php
namespace App\Kipedreiro\Models;

class Endereco{
    private $id_endereco;
    private $cep_endereco;
    private $logradouro_endereco;
    private $numero_endereco;
    private $complemento_endereco;
    private $bairro_endereco;
    private $cidade_endereco;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    // contrutor inicializa a classe e ou atributos
    public function __construct($db){
       $this->db = $db;
    }
    // metodo de buscar todos os Enderecos read
    function buscarEnderecos(){
        $sql = "SELECT * FROM tbl_endereco";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // metodo de buscar todos usuario por email read
    function buscarEnderecosPorId($id){
        $sql = "SELECT * FROM tbl_endereco where id_endereco  = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // metodo de inserir usuario create
    function inserirEndereco($id_usuario, $cep_endereco, $logradouro_endereco, $numero_endereco, $complemento_endereco, $bairro_endereco,$cidade_endereco,$uf_endereco){
        $sql = "INSERT INTO tbl_endereco (cep_endereco, logradouro_endereco,numero_endereco, complemento_endereco, bairro_endereco,cidade_endereco,uf_endereco,id_usuario) 
                VALUES (:cep_endereco, :logradouro_endereco, :numero_endereco, :complemento_endereco, :bairro_endereco,:cidade_endereco,:uf_endereco,:id_usuario)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':cep_endereco', $cep_endereco);
        $stmt->bindParam(':logradouro_endereco', $logradouro_endereco);
        $stmt->bindParam(':numero_endereco', $numero_endereco);
        $stmt->bindParam(':complemento_endereco', $complemento_endereco);
        $stmt->bindParam(':bairro_endereco', $bairro_endereco);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->bindParam(':cidade_endereco', $cidade_endereco);
        $stmt->bindParam(':uf_endereco', $uf_endereco);
        if($stmt->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }

    // metodo de atualizar o usuario update
    function atualizarEndereco($id_usuario,$id_endereco, $cep_endereco, $logradouro_endereco, $numero_endereco, $complemento_endereco, $bairro_endereco,$cidade_endereco,$uf_endereco){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_endereco 
         SET cep_endereco = :cep_endereco,
         logradouro_endereco = :logradouro_endereco, 
         numero_endereco = :numero_endereco, 
         complemento_endereco = :complemento_endereco,
         bairro_endereco = :bairro_endereco,
         cidade_endereco = :cidade_endereco,
         id_usuario = :id_usuario,
         uf_endereco = :uf_endereco,
         atualizado_em = :atual
         WHERE id_endereco = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id_endereco);
        $stmt->bindParam(':cep_endereco', $cep_endereco);
        $stmt->bindParam(':logradouro_endereco', $logradouro_endereco);
        $stmt->bindParam(':numero_endereco', $numero_endereco);
        $stmt->bindParam(':complemento_endereco', $complemento_endereco);
        $stmt->bindParam(':bairro_endereco', $bairro_endereco);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->bindParam(':cidade_endereco', $cidade_endereco);
        $stmt->bindParam(':uf_endereco', $uf_endereco);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    // metodo de deletar o usuario delete
    function excluirEndereco($id){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_endereco SET
         excluido_em = :atual
         WHERE id_endereco = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    function ativarEndereco($id){
        $dataatual = NULL;
        $sql = "UPDATE tbl_endereco SET
         excluido_em = :atual
         WHERE id_endereco = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
}