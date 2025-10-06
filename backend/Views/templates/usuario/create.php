<div>Sou o create</div>
<form action="/backend/usuario/salvar" method="post" enctype="multipart/form-data">
<label for="Nome">Nome</label>
<input type="text" name="nome_usuario" id="nome_usuario" required>
<br>
<label for="Email">Email</label>
<input type="email" name="email_usuario" id="email_usuario" required>
<br>
<label for="Senha">Senha</label>
<input type="password" name="senha_usuario" id="senha_usuario" required>
<br>
<label for="Tipo">Tipo</label>
<select name="tipo_usuario" id="tipo_usuario" required>
    <option value="admin">Admin</option>
    <option value="user">User</option>
</select>
<br>
<label for="imagem" >Imagem</label>
<input type="file" name="imagem" id="imagem" accept="image/*">
<button type="submit">Salvar</button>
</form>