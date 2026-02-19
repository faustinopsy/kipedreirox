<div style="padding: 28px;">

    <!-- Page Header -->
    <div class="adm-page-header">
        <div class="adm-page-title">
            <div class="title-icon"><i class="fa fa-plus-circle"></i></div>
            <div>
                <h1>Novo Serviço</h1>
                <p>Preencha os dados para cadastrar um serviço</p>
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

            <form action="/backend/servico/salvar" method="POST" enctype="multipart/form-data">
                <div class="adm-form-card-body">

                    <div class="adm-form-group">
                        <label for="nome_servico">Nome do Serviço</label>
                        <input type="text" id="nome_servico" name="nome_servico"
                               placeholder="Ex: Alvenaria, Pintura, Elétrica..." required>
                    </div>

                    <div class="adm-form-group">
                        <label for="descricao_servico">Descrição Curta</label>
                        <input type="text" id="descricao_servico" name="descricao_servico"
                               placeholder="Breve descrição do serviço">
                    </div>

                    <div class="adm-form-group">
                        <label for="tipo_servico">Visibilidade do Serviço</label>
                        <select id="tipo_servico" name="tipo_servico" required>
                            <option value="trabalho" selected>Interno (Trabalho - Orçamentos)</option>
                            <option value="site">Público (Site - Vitrine)</option>
                        </select>
                        <p class="hint">"Interno" aparece apenas para criar orçamentos. "Público" é exibido no site para clientes.</p>
                    </div>

                    <div class="adm-form-group">
                        <label for="foto_servico">Foto Principal</label>
                        <input type="file" id="foto_servico" name="foto_servico"
                               accept="image/*" required>
                        <p class="hint">Formatos aceitos: JPG, PNG, WEBP. A imagem será comprimida automaticamente.</p>
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
                        <i class="fa fa-save"></i> Salvar Serviço
                    </button>
                    <a href="/backend/servico/listar" class="adm-btn adm-btn-edit">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

</div>

<script src="/assets/js/image-compressor.js"></script>