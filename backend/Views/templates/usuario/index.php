<div>listar usuarios</div>
<?php if (isset($usuarios) && count($usuarios) > 0): ?>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Tipo</th>
                <th>Status</th>
                <th>Foto</th>
                <th>Editar</th>
                <th>Excluir</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= htmlspecialchars($usuario['nome_usuario']) ?></td>
                    <td><?= htmlspecialchars($usuario['email_usuario']) ?></td>
                    <td><?= htmlspecialchars($usuario['tipo_usuario']) ?></td>
                    <td><?= htmlspecialchars($usuario['status_usuario']) ?></td>
                    <td><img src="/backend/upload/<?= htmlspecialchars($usuario['foto']) ?>" style="width:200px"></td>
                    <td><a href="/backend/usuario/editar/<?= htmlspecialchars($usuario['id_usuario']) ?>">Editar</a></td>
                    <td><a href="/backend/usuario/excluir/<?= htmlspecialchars($usuario['id_usuario']) ?>">Excluir</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div>Nenhum usuário encontrado.</div>
<?php endif ?>