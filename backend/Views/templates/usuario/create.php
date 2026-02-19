<div style="padding: 28px;">

    <!-- Page Header -->
    <div class="adm-page-header">
        <div class="adm-page-title">
            <div class="title-icon"><i class="fa fa-user-plus"></i></div>
            <div>
                <h1>Novo Usuário</h1>
                <p>Preencha os dados para cadastrar um usuário</p>
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

            <form action="/backend/usuario/salvar" method="post" enctype="multipart/form-data">
                <div class="adm-form-card-body">

                    <div class="adm-form-group">
                        <label for="nome_usuario">Nome Completo</label>
                        <input type="text" id="nome_usuario" name="nome_usuario"
                               placeholder="Ex: João da Silva" required>
                    </div>

                    <div class="adm-form-group">
                        <label for="email_usuario">E-mail</label>
                        <input type="email" id="email_usuario" name="email_usuario"
                               placeholder="user@email.com" required>
                    </div>

                    <div class="adm-form-group">
                        <label for="senha_usuario">Senha</label>
                        <input type="password" id="senha_usuario" name="senha_usuario"
                               placeholder="Mínimo 6 caracteres" required>
                        <p class="hint">Use ao menos 6 caracteres incluindo letras e números.</p>
                    </div>

                    <div class="adm-form-group">
                        <label for="tipo_usuario">Tipo de Perfil</label>
                        <select id="tipo_usuario" name="tipo_usuario" required>
                            <option value="" disabled selected>Selecione o perfil...</option>
                            <optgroup label="Clientes">
                                <option value="cliente">Cliente</option>
                            </optgroup>
                            <optgroup label="Profissionais">
                                <option value="pedreiro">Pedreiro</option>
                                <option value="eletricista">Eletricista</option>
                                <option value="pintor">Pintor</option>
                                <option value="encanador">Encanador</option>
                            </optgroup>
                            <optgroup label="Sistema">
                                <option value="admin">Administrador</option>
                                <option value="user">Usuário</option>
                            </optgroup>
                        </select>
                    </div>

                </div>
                <div class="adm-form-card-footer">
                    <button type="submit" class="adm-btn adm-btn-primary">
                        <i class="fa fa-save"></i> Salvar Usuário
                    </button>
                    <a href="/backend/usuario/listar/1" class="adm-btn adm-btn-edit">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

</div>