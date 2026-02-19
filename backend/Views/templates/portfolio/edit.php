<div style="padding: 28px;">

    <!-- Page Header -->
    <div class="adm-page-header">
        <div class="adm-page-title">
            <div class="title-icon"><i class="fa fa-pencil"></i></div>
            <div>
                <h1>Editar Projeto</h1>
                <p>Atualizando: <strong><?= htmlspecialchars($portfolio['titulo_portfolio']); ?></strong></p>
            </div>
        </div>
        <a href="/backend/portfolio/listar" class="adm-btn adm-btn-edit">
            <i class="fa fa-arrow-left"></i> Voltar
        </a>
    </div>

    <!-- Form Card -->
    <div class="adm-form-page" style="max-width:900px;">
        <div class="adm-form-card">
            <div class="adm-form-card-header">
                <div class="header-icon"><i class="fa fa-briefcase"></i></div>
                <h2>Dados do Projeto</h2>
            </div>

            <form action="/backend/portfolio/atualizar" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_portfolio" value="<?= $portfolio['id_portfolio']; ?>">
                
                <div class="adm-form-card-body">

                    <div class="adm-form-group">
                        <label for="titulo_portfolio">Nome do Projeto</label>
                        <input type="text" id="titulo_portfolio" name="titulo_portfolio"
                               value="<?= htmlspecialchars($portfolio['titulo_portfolio']); ?>" required>
                    </div>

                    <div class="adm-form-row" style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
                        <div class="adm-form-group">
                            <label for="cliente_portfolio">Nome do Cliente</label>
                            <input type="text" id="cliente_portfolio" name="cliente_portfolio"
                                   value="<?= htmlspecialchars($portfolio['cliente_portfolio']); ?>">
                        </div>
                        <div class="adm-form-group">
                            <label for="data_projeto">Data do Projeto</label>
                            <input type="date" id="data_projeto" name="data_projeto"
                                   value="<?= $portfolio['data_projeto']; ?>">
                        </div>
                    </div>

                    <div class="adm-form-group">
                        <label for="descricao_portfolio">Descrição do Trabalho</label>
                        <textarea id="descricao_portfolio" name="descricao_portfolio" rows="6"><?= htmlspecialchars($portfolio['descricao_portfolio']); ?></textarea>
                    </div>

                    <!-- Foto atual -->
                    <div class="adm-form-group">
                        <label>Imagem Atual</label>
                        <div style="display:flex;align-items:center;gap:16px;margin-top:4px;">
                            <?php if (!empty($portfolio['imagem_portfolio'])): ?>
                                <img src="/backend/upload/<?= htmlspecialchars($portfolio['imagem_portfolio']); ?>"
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
                        <input type="file" id="foto_servico" name="imagem_portfolio" accept="image/*">
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
                    <a href="/backend/portfolio/listar" class="adm-btn adm-btn-edit">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

</div>
<script src="/assets/js/image-compressor.js"></script>
