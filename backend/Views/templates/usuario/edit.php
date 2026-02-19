<div style="padding: 28px;">

    <!-- Page Header -->
    <div class="adm-page-header">
        <div class="adm-page-title">
            <div class="title-icon"><i class="fa fa-pencil"></i></div>
            <div>
                <h1>Editar Usuário</h1>
                <p>Atualize os dados do usuário</p>
            </div>
        </div>
        <a href="/backend/usuario/listar/1" class="adm-btn adm-btn-edit">
            <i class="fa fa-arrow-left"></i> Voltar
        </a>
    </div>

    <!-- Form Card -->
    <div class="adm-form-page">
        <div class="adm-form-card">
            <div class="adm-form-card-header">
                <div class="header-icon"><i class="fa fa-user"></i></div>
                <h2>Dados do Usuário</h2>
            </div>

            <form action="/backend/usuario/atualizar/<?php echo $usuario['id_usuario']; ?>" method="post" enctype="multipart/form-data">
                <div class="adm-form-card-body">

                    <div class="adm-form-group">
                        <label for="nome_usuario">Nome Completo</label>
                        <input type="text" id="nome_usuario" name="nome_usuario"
                               value="<?php echo htmlspecialchars($usuario['nome_usuario']); ?>"
                               placeholder="Nome completo" required>
                    </div>

                    <div class="adm-form-group">
                        <label for="email_usuario">E-mail</label>
                        <input type="email" id="email_usuario" name="email_usuario"
                               value="<?php echo htmlspecialchars($usuario['email_usuario']); ?>"
                               placeholder="user@email.com" required>
                    </div>

                    <div class="adm-form-group">
                        <label for="senha_usuario">Nova Senha</label>
                        <input type="password" id="senha_usuario" name="senha_usuario"
                               placeholder="Deixe em branco para manter a senha atual">
                        <p class="hint">Preencha apenas se quiser alterar a senha (mínimo 6 caracteres).</p>
                    </div>

                    <div class="adm-form-group">
                        <label for="tipo_usuario">Tipo de Perfil</label>
                        <select id="tipo_usuario" name="tipo_usuario" required>
                            <option value="" disabled>Selecione o perfil...</option>
                            <optgroup label="Clientes">
                                <option value="cliente" <?= $usuario['tipo_usuario'] == 'cliente' ? 'selected' : '' ?>>Cliente</option>
                            </optgroup>
                            <optgroup label="Profissionais">
                                <option value="pedreiro"    <?= $usuario['tipo_usuario'] == 'pedreiro'    ? 'selected' : '' ?>>Pedreiro</option>
                                <option value="eletricista" <?= $usuario['tipo_usuario'] == 'eletricista' ? 'selected' : '' ?>>Eletricista</option>
                                <option value="pintor"      <?= $usuario['tipo_usuario'] == 'pintor'      ? 'selected' : '' ?>>Pintor</option>
                                <option value="encanador"   <?= $usuario['tipo_usuario'] == 'encanador'   ? 'selected' : '' ?>>Encanador</option>
                            </optgroup>
                            <optgroup label="Sistema">
                                <option value="admin" <?= $usuario['tipo_usuario'] == 'admin' ? 'selected' : '' ?>>Administrador</option>
                                <option value="user"  <?= $usuario['tipo_usuario'] == 'user'  ? 'selected' : '' ?>>Usuário</option>
                            </optgroup>
                        </select>
                    </div>

                    <div class="adm-form-group">
                        <label for="status_usuario">Status</label>
                        <select id="status_usuario" name="status_usuario" required>
                            <option value="ativo"   <?= isset($usuario['status_usuario']) && strtolower($usuario['status_usuario']) == 'ativo'   ? 'selected' : '' ?>>Ativo</option>
                            <option value="inativo" <?= isset($usuario['status_usuario']) && strtolower($usuario['status_usuario']) == 'inativo' ? 'selected' : '' ?>>Inativo</option>
                        </select>
                    </div>

                </div>
                <div class="adm-form-card-footer">
                    <button type="submit" class="adm-btn adm-btn-primary">
                        <i class="fa fa-save"></i> Salvar Alterações
                    </button>
                    <a href="/backend/usuario/listar/1" class="adm-btn adm-btn-edit">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

</div>