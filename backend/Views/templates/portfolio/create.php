<div style="padding: 28px;">

    <!-- Page Header -->
    <div class="adm-page-header">
        <div class="adm-page-title">
            <div class="title-icon"><i class="fa fa-plus-circle"></i></div>
            <div>
                <h1>Novo Projeto</h1>
                <p>Adicione um projeto ao portfólio</p>
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

            <form action="/backend/portfolio/salvar" method="POST" enctype="multipart/form-data">
                <div class="adm-form-card-body">

                    <div class="adm-form-group">
                        <label for="titulo_portfolio">Nome do Projeto</label>
                        <input type="text" id="titulo_portfolio" name="titulo_portfolio"
                               placeholder="Ex: Reforma Residencial Vila Olímpia..." required>
                    </div>

                    <div class="adm-form-row" style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
                        <div class="adm-form-group">
                            <label for="cliente_portfolio">Nome do Cliente</label>
                            <input type="text" id="cliente_portfolio" name="cliente_portfolio"
                                   placeholder="Ex: João Silva ou Construtora XYZ">
                        </div>
                        <div class="adm-form-group">
                            <label for="data_projeto">Data do Projeto</label>
                            <input type="date" id="data_projeto" name="data_projeto"
                                   value="<?= date('Y-m-d'); ?>">
                        </div>
                    </div>

                    <div class="adm-form-group">
                        <label for="descricao_portfolio">Descrição do Trabalho</label>
                        <textarea id="descricao_portfolio" name="descricao_portfolio" rows="5"
                                  placeholder="Detalhes sobre o que foi feito..."></textarea>
                    </div>

                    <div class="adm-form-group">
                        <label for="foto_servico">Imagem do Projeto</label>
                        <input type="file" id="foto_servico" name="imagem_portfolio" accept="image/*" required>
                        <p class="hint">Formatos: JPG, PNG, WEBP. A imagem será comprimida automaticamente.</p>
                    </div>

                    <!-- Image Preview (Reusing the JS) -->
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
                        <i class="fa fa-save"></i> Salvar Projeto
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
