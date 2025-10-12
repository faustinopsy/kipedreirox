<div>Sou o create</div>
    <form class="w3-container w3-white" action="/backend/usuario/atualizar/<?php echo $usuario['id_usuario']; ?>" method="post" enctype="multipart/form-data">
    <label for="Nome">Nome</label>
    <input class="w3-input w3-border" type="text" name="nome_usuario" id="nome_usuario" value="<?php echo $usuario['nome_usuario']; ?>"  required>
    <br>
    <label for="Email">Email</label>
    <input class="w3-input w3-border" type="email" name="email_usuario" id="email_usuario" value="<?php echo $usuario['email_usuario']; ?>" required>
    <br>
    <label for="Senha">Senha</label>
    <input class="w3-input w3-border" type="password" name="senha_usuario" id="senha_usuario" value="" required>
    <br>
    <label for="Tipo">Tipo</label>
    <select class="w3-select w3-input w3-border" name="tipo_usuario" id="tipo_usuario" value="<?php echo $usuario['tipo_usuario']; ?>" required>
        <option value="admin">Admin</option>
        <option value="user">User</option>
    </select>
    <br>
   
    <button type="submit">Salvar</button>
    </form>