<div class="container">Listar usuarios</div>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Tipo</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($usuarios as $key => $usuario): ?>
            <tr>
                <td><?php echo htmlspecialchars($usuario["id_usuario"]); ?></td>
                <td><?php echo htmlspecialchars($usuario["nome_usuario"]); ?></td>
                <td><?php echo htmlspecialchars($usuario["email_usuario"]); ?></td>
                <td><?php echo htmlspecialchars($usuario["tipo_usuario"]); ?></td>
                <td><?php echo htmlspecialchars($usuario["status_usuario"]); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    
</table>