<div style="padding: 28px;">

    <!-- Page Header -->
    <div class="adm-page-header">
        <div class="adm-page-title">
            <div class="title-icon"><i class="fa fa-pencil"></i></div>
            <div>
                <h1>Editar - Sobre Nós</h1>
                <p>Atualizando: <strong><?= htmlspecialchars($sobre['titulo_sobre']); ?></strong></p>
            </div>
        </div>
        <a href="/backend/sobre/listar" class="adm-btn adm-btn-edit">
            <i class="fa fa-arrow-left"></i> Voltar
        </a>
    </div>

    <!-- Form Card -->
    <div class="adm-form-page" style="max-width:900px;">
        <div class="adm-form-card">
            <div class="adm-form-card-header">
                <div class="header-icon"><i class="fa fa-info"></i></div>
                <h2>Dados Institucionais</h2>
            </div>

            <form action="/backend/sobre/atualizar" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_sobre" value="<?= $sobre['id_sobre']; ?>">
                
                <div class="adm-form-card-body">

                    <div class="adm-form-group">
                        <label for="titulo_sobre">Título Principal</label>
                        <input type="text" id="titulo_sobre" name="titulo_sobre"
                               value="<?= htmlspecialchars($sobre['titulo_sobre']); ?>" required>
                    </div>

                    <div class="adm-form-group">
                        <label for="descricao_sobre">Descrição Completa</label>
                        <textarea id="descricao_sobre" name="descricao_sobre" rows="8"><?= htmlspecialchars($sobre['descricao_sobre']); ?></textarea>
                    </div>

                    <div class="adm-form-row" style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:20px;">
                        <div class="adm-form-group">
                            <label for="missao_sobre">Missão</label>
                            <textarea id="missao_sobre" name="missao_sobre" rows="5"><?= htmlspecialchars($sobre['missao_sobre']); ?></textarea>
                        </div>
                        <div class="adm-form-group">
                            <label for="visao_sobre">Visão</label>
                            <textarea id="visao_sobre" name="visao_sobre" rows="5"><?= htmlspecialchars($sobre['visao_sobre']); ?></textarea>
                        </div>
                        <div class="adm-form-group">
                            <label for="valores_sobre">Valores</label>
                            <textarea id="valores_sobre" name="valores_sobre" rows="5"><?= htmlspecialchars($sobre['valores_sobre']); ?></textarea>
                        </div>
                    </div>

                    <!-- Foto atual -->
                    <div class="adm-form-group">
                        <label>Imagem Atual</label>
                        <div style="display:flex;align-items:center;gap:16px;margin-top:4px;">
                            <?php if (!empty($sobre['imagem_sobre'])): ?>
                                <img src="/backend/upload/<?= htmlspecialchars($sobre['imagem_sobre']); ?>"
                                     alt="Foto atual"
                                     style="width:120px;height:auto;border-radius:8px;border:2px solid #e8e9ee;">
                            <?php else: ?>
                                <div style="width:120px;height:80px;background:#eee;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#aaa;">
                                    <i class="fa fa-image"></i>
                                </div>
                            <?php endif; ?>
                            <p class="hint" style="margin:0;">Imagem exibida atualmente na página.</p>
                        </div>
                    </div>

                    <div class="adm-form-group">
                        <label for="foto_servico">Substituir Imagem <span style="font-weight:400;text-transform:none;color:#aaa;">(opcional)</span></label>
                        <input type="file" id="foto_servico" name="imagem_sobre" accept="image/*">
                        <p class="hint">Formatos: JPG, PNG, WEBP. A nova imagem será comprimida automaticamente.</p>
                    </div>

                    <!-- Image Preview -->
                    <div class="adm-img-preview-grid">
                        <div class="adm-img-preview-box">
                            <h4><i class="fa fa-image"></i> Original</h4>
                            <img id="previewOriginal" alt="Preview original">
                            <p id="infoOriginal"></p>
                        </div>
                        <div class="adm-img-preview-box">
                            <h4><i class="fa fa-compress"></i> Comprimida (WebP)</h4>
                            <img id="previewCompressed" alt="Preview comprimido">
                            <p id="infoCompressed"></p>
                        </div>
                    </div>

                </div>
                <div class="adm-form-card-footer">
                    <button type="submit" class="adm-btn adm-btn-primary">
                        <i class="fa fa-save"></i> Salvar Alterações
                    </button>
                    <a href="/backend/sobre/listar" class="adm-btn adm-btn-edit">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

</div>
<script src="/assets/js/image-compressor.js"></script>
