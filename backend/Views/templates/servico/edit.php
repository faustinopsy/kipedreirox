<div style="padding: 28px;">

    <!-- Page Header -->
    <div class="adm-page-header">
        <div class="adm-page-title">
            <div class="title-icon"><i class="fa fa-pencil"></i></div>
            <div>
                <h1>Editar Serviço</h1>
                <p>Atualize os dados de: <strong><?= htmlspecialchars($servico['nome_servico']); ?></strong></p>
            </div>
        </div>
        <a href="/backend/servico/listar" class="adm-btn adm-btn-edit">
            <i class="fa fa-arrow-left"></i> Voltar
        </a>
    </div>

    <!-- Form Card -->
    <div class="adm-form-page" style="max-width:760px;">
        <div class="adm-form-card">
            <div class="adm-form-card-header">
                <div class="header-icon"><i class="fa fa-briefcase"></i></div>
                <h2>Dados do Serviço</h2>
            </div>

            <form action="/backend/servico/atualizar" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_servico" value="<?= $servico['id_servico']; ?>">

                <div class="adm-form-card-body">

                    <div class="adm-form-group">
                        <label for="nome_servico">Nome do Serviço</label>
                        <input type="text" id="nome_servico" name="nome_servico"
                               value="<?= htmlspecialchars($servico['nome_servico']); ?>"
                               placeholder="Ex: Alvenaria, Pintura..." required>
                    </div>

                    <div class="adm-form-group">
                        <label for="descricao_servico">Descrição Curta</label>
                        <input type="text" id="descricao_servico" name="descricao_servico"
                               value="<?= htmlspecialchars($servico['descricao_servico']); ?>"
                               placeholder="Breve descrição do serviço">
                    </div>

                    <!-- Foto atual -->
                    <div class="adm-form-group">
                        <label>Foto Atual</label>
                        <div style="display:flex;align-items:center;gap:16px;margin-top:4px;">
                            <img src="/backend/upload/<?= htmlspecialchars($servico['foto_servico']); ?>"
                                 alt="Foto atual"
                                 style="width:72px;height:72px;object-fit:cover;border-radius:8px;border:2px solid #e8e9ee;">
                            <p class="hint" style="margin:0;">Esta é a foto atual. Envie uma nova abaixo para substituí-la.</p>
                        </div>
                    </div>

                    <!-- Substituir foto -->
                    <div class="adm-form-group">
                        <label for="foto_servico">Substituir Foto <span style="font-weight:400;text-transform:none;color:#aaa;">(opcional)</span></label>
                        <input type="file" id="foto_servico" name="foto_servico" accept="image/*">
                        <p class="hint">Formatos aceitos: JPG, PNG, WEBP. Deixe em branco para manter a foto atual.</p>
                    </div>

                </div>
                <div class="adm-form-card-footer">
                    <button type="submit" class="adm-btn adm-btn-primary">
                        <i class="fa fa-save"></i> Salvar Alterações
                    </button>
                    <a href="/backend/servico/listar" class="adm-btn adm-btn-edit">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

</div>