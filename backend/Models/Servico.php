<?php
namespace App\Kipedreiro\Models;
use pdo; 

class Servico{
    private $id_servico;
    private $nome_servico;
    private $descricao_servico;
    private $valor_base_servico;
    private $tipo_usuario;
    private $foto_servico;
    private $id_categoria;
    private $status_servico;
    private $criado_em;
    private $atualizado_em;
    private $db;
    // contrutor inicializa a classe e ou atributos
    public function __construct($db){
       $this->db = $db;
    }
    
    // metodo de buscar todos os Servicos read
    function buscarServicos(){
        $sql = "SELECT * FROM tbl_servico where excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // metodo de buscar todos usuario por email read
    function buscarServicosPorID($id){
        $sql = "SELECT * FROM tbl_servico where id_servico = :id and excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // metodo de inserir usuario create
    function inseriUsuario($nome, $email, $senha, $tipo, $status){
        $senha = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "INSERT INTO tbl_servico (nome_usuario, email_usuario, 
        senha_usuario, tipo_usuario, status_usuario) 
                VALUES (:nome, :email, :senha, :tipo, :status)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':status', $status);
        if($stmt->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }
    // metodo de atualizar o usuario update
    function atualizarUsuario($id, $nome, $email, $senha, $tipo, $status){
        $senha = password_hash($senha, PASSWORD_DEFAULT);
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_servico SET nome_usuario = :nome,
         email_usuario = :email, 
         senha_usuario = :senha, 
         tipo_usuario = :tipo,
         status_usuario = :status,
         atualizado_em = :atual
         WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    // metodo de deletar o usuario delete
    function excluirUsuario($id){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_servico SET
         excluido_em = :atual
         WHERE id_usuario = :id";
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