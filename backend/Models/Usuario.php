<?php
namespace App\Kipedreiro\Models;
use PDO;
class Usuario{
    private $id_usuario;
    private $nome_usuario;
    private $email_usuario;
    private $senha_usuario;
    private $tipo_usuario;
    private $status_usuario;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    // contrutor inicializa a classe e ou atributos
    public function __construct($db){
       $this->db = $db;
    }
    // metodo de buscar todos os usuarios read
    function buscarUsuarios(){
        $sql = "SELECT * FROM tbl_usuario";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function totalDeUsuarios(){
        $sql = "SELECT count(*) as total FROM tbl_usuario";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    
    function totalDeUsuariosInativos(){
        $sql = "SELECT count(*) as total FROM tbl_usuario where excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    function totalDeUsuariosAtivos(){
        $sql = "SELECT count(*) as total FROM tbl_usuario where excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function paginacao(int $pagina = 1, int $por_pagina = 10): array{
        $totalQuery = "SELECT COUNT(*) FROM `tbl_usuario`";
        $totalStmt = $this->db->query($totalQuery);
        $total_de_registros = $totalStmt->fetchColumn();
        $offset = ($pagina - 1) * $por_pagina;
        $dataQuery = "SELECT * FROM `tbl_usuario` LIMIT :limit OFFSET :offset";
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

    public function paginacaoAPI(int $pagina = 1, int $por_pagina = 10): array{
        $totalQuery = "SELECT COUNT(*) FROM `tbl_usuario`";
        $totalStmt = $this->db->query($totalQuery);
        $total_de_registros = $totalStmt->fetchColumn();
        $offset = ($pagina - 1) * $por_pagina;
        $dataQuery = "SELECT * FROM `tbl_usuario` LIMIT :limit OFFSET :offset";
        $dataStmt = $this->db->prepare($dataQuery);
        $dataStmt->bindValue(':limit', $por_pagina, PDO::PARAM_INT);
        $dataStmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $dataStmt->execute();
        $dados = $dataStmt->fetchAll(PDO::FETCH_ASSOC);
        $lastPage = ceil($total_de_registros / $por_pagina);

        return [
            'data' => $dados
        ];
    }

    function buscarUsuariosInativos(){
    $sql = "SELECT * FROM tbl_usuario where excluido_em IS NOT NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // metodo de buscar todos usuario por email read
    function buscarUsuariosPorEMail($email){
        $sql = "SELECT * FROM tbl_usuario where email_usuario = :email and excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function buscarUsuariosPorID(int $id){
        $sql = "SELECT * FROM tbl_usuario where id_usuario = :id_usuario";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_usuario', $id); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function buscarUsuariosPorEMailInativo($email){
        $sql = "SELECT * FROM tbl_usuario where email_usuario = :email and excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // metodo de inserir usuario create
    function inseriUsuario(
        $nome, 
        $email, 
        $senha, 
        $tipo, 
        $status,
        $imagem=""){
        $senha = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "INSERT INTO tbl_usuario (nome_usuario, email_usuario, 
        senha_usuario, tipo_usuario, status_usuario, foto_usuario) 
                VALUES (:nome, :email, :senha, :tipo, :status, :foto)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':foto', $imagem);
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
        $sql = "UPDATE tbl_usuario SET nome_usuario = :nome,
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
    // metodo de inativar o usuario delete
    function excluirUsuario($id){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_usuario SET
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
// metodo de ativar o usuario excluido
    function ativarUsuario($id){
        $dataatual = NULL;
        $sql = "UPDATE tbl_usuario SET
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

    public function checarCredenciais(string $email, string $senha) {
        $usuario = $this->buscarUsuariosPorEMail($email);
        if (count($usuario) !== 1) {
            return false;
        }
        $usuario = $usuario[0];
        if (password_verify($senha, $usuario['senha_usuario'])) {
            return $usuario;
        }
        return false;
    }
}