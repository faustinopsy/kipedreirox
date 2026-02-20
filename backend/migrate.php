<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Kipedreiro\Database\Config;

echo "Iniciando migração do banco de dados...\n";

// Carregar configurações
$config = Config::get();
$dbConfig = $config['database']['mysql'];

$host = $dbConfig['host'];
$user = $dbConfig['username'];
$pass = $dbConfig['password'];
$dbname = $dbConfig['db_name'];

try {
    // 1. Conectar ao MySQL sem selecionar o banco
    $pdo = new PDO("mysql:host=$host;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 2. Criar o banco se não existir
    echo "Verificando banco de dados '$dbname'...\n";
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
    echo "Banco de dados '$dbname' verificado/criado.\n";

    // 3. Selecionar o banco
    $pdo->exec("USE `$dbname`");

    // 4. Ler o arquivo SQL
    $sqlFile = __DIR__ . '/Database/bancodedados.sql';
    if (!file_exists($sqlFile)) {
        die("Erro: Arquivo '$sqlFile' não encontrado.\n");
    }

    echo "Lendo arquivo SQL...\n";
    $sql = file_get_contents($sqlFile);

    // 5. Executar o SQL (simples, assumindo que o dump é compatível)
    // Para dumps grandes ou com triggers/procedures, seria melhor usar linha de comando mysql
    // Mas para este caso, vamos tentar via PDO exec
    
    // O PDO não executa múltiplos statements em uma única chamada de forma confiável em todos os drivers
    // Mas o MySQL usually permite se configurado, ou podemos tentar executar o bloco inteiro.
    // Dumps do mysqldump geralmente funcionam bem se passados inteiros para o exec() ou prepare()
    
    echo "Importando tabelas e dados...\n";
    $pdo->exec($sql);
    
    echo "Migração concluída com sucesso! Banco '$dbname' está pronto.\n";

} catch (PDOException $e) {
    echo "Erro durante a migração: " . $e->getMessage() . "\n";
    exit(1);
}
