<?php
include_once 'backend/Database/Database.php';
include_once 'backend/Model/Usuario.php';

$resultado = buscaUsuarios($db);
/* 
for($c=0; $c < count($resultado); $c++){
    echo $resultado[$c]['nome_usuario'] . "<br>";
} 

loop infinito
while(){

}
*/
// echo "<h1>Lista de Usuários</h1>";
// echo "<ul>";
// foreach($resultado as $usuario){
//     echo "<li>".$usuario['nome_usuario'] ." - ". $usuario['email_usuario'] . "</li>";
// }
// echo "</ul>";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <main>
        <h1>Lista de Usuários</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($resultado as $usuario): ?>
                    <tr>        <!-- sanitizar os dados -->
                        <td><?php echo htmlspecialchars($usuario['nome_usuario']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['email_usuario']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
</body>
</html>
