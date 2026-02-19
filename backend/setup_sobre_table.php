<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Kipedreiro\Database\Database;

try {
    $db = Database::getInstance();
    
    $sql = "CREATE TABLE IF NOT EXISTS tbl_sobre (
        id_sobre INT AUTO_INCREMENT PRIMARY KEY,
        titulo_sobre VARCHAR(255) NOT NULL,
        descricao_sobre TEXT,
        imagem_sobre VARCHAR(255),
        missao_sobre TEXT,
        visao_sobre TEXT,
        valores_sobre TEXT,
        status_sobre ENUM('ativo', 'inativo') DEFAULT 'ativo',
        criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
        atualizado_em DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    $db->exec($sql);
    echo "Tabela 'tbl_sobre' criada com sucesso!" . PHP_EOL;

} catch (Exception $e) {
    echo "Erro ao criar tabela: " . $e->getMessage() . PHP_EOL;
}
