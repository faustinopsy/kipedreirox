<div style="padding: 28px;">

    <!-- Page Header -->
    <div class="adm-page-header">
        <div class="adm-page-title">
            <div class="title-icon"><i class="fa fa-plus-circle"></i></div>
            <div>
                <h1>Novo Registro - Sobre Nós</h1>
                <p>Preencha os dados institucionais</p>
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

            <form action="/backend/sobre/salvar" method="POST" enctype="multipart/form-data">
                <div class="adm-form-card-body">

                    <div class="adm-form-group">
                        <label for="titulo_sobre">Título Principal</label>
                        <input type="text" id="titulo_sobre" name="titulo_sobre"
                               placeholder="Ex: Nossa História, Quem Somos..." required>
                    </div>

                    <div class="adm-form-group">
                        <label for="descricao_sobre">Descrição Completa</label>
                        <textarea id="descricao_sobre" name="descricao_sobre" rows="5"
                                  placeholder="Conte a história da empresa..."></textarea>
                    </div>

                    <div class="adm-form-row" style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:20px;">
                        <div class="adm-form-group">
                            <label for="missao_sobre">Missão</label>
                            <textarea id="missao_sobre" name="missao_sobre" rows="4" placeholder="Nossa missão é..."></textarea>
                        </div>
                        <div class="adm-form-group">
                            <label for="visao_sobre">Visão</label>
                            <textarea id="visao_sobre" name="visao_sobre" rows="4" placeholder="Queremos ser..."></textarea>
                        </div>
                        <div class="adm-form-group">
                            <label for="valores_sobre">Valores</label>
                            <textarea id="valores_sobre" name="valores_sobre" rows="4" placeholder="Ética, Qualidade..."></textarea>
                        </div>
                    </div>

                    <div class="adm-form-group">
                        <label for="foto_servico">Imagem Institucional</label>
                        <input type="file" id="foto_servico" name="imagem_sobre" accept="image/*" required>
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
                        <i class="fa fa-save"></i> Salvar
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
