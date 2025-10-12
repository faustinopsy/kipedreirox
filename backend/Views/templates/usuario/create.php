<div>Sou o create</div>
<form class="w3-container w3-card-4" action="/backend/usuario/salvar" method="post" enctype="multipart/form-data">
<label for="Nome">Nome</label>
<input class="w3-input w3-border" type="text" name="nome_usuario" id="nome_usuario" required>
<br>
<label for="Email">Email</label>
<input class="w3-input w3-border" type="email" name="email_usuario" id="email_usuario" required>
<br>
<label for="Senha">Senha</label>
<input class="w3-input w3-border" type="password" name="senha_usuario" id="senha_usuario" required>
<br>
<label for="Tipo">Tipo</label>
<select class="w3-input w3-border" name="tipo_usuario" id="tipo_usuario" required>
    <option value="admin">Admin</option>
    <option value="user">User</option>
</select>
<br>
<button type="submit">Salvar</button>
</form>