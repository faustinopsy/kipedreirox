<form action="/backend/registrar" method="post">
    <div>
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome_usuario" required>
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email_usuario" required>
    </div>
    <div>
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha_usuario" required>
    </div>
    <div>
        <label for="tipo">Tipo:</label>
        <select id="tipo" name="tipo_usuario" required>
            <option value="admin">Admin</option>
            <option value="user">User</option>
        </select>
    </div>
    <div>
        <label for="status">Status:</label>
        <select id="status" name="status_usuario" required>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
    </div>
    <button type="submit">Criar Usuário</button>
</form>