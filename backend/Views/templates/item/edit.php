<style>
    /* (Estilos idênticos ao create.php) */
    #autor-search-results { border: 1px solid #ccc; max-height: 150px; overflow-y: auto; background: #f9f9f9; }
    #autor-search-results div { padding: 5px 10px; cursor: pointer; }
    #autor-search-results div:hover { background: #eee; }
    #autores-selecionados-list span { display: inline-block; background: #007bff; color: white; padding: 5px 10px; margin: 5px 5px 0 0; border-radius: 5px; }
    #autores-selecionados-list span button { background: none; border: none; color: white; font-weight: bold; margin-left: 5px; }
    .campo-especifico { display: none; }
</style>

<h1>Editar Item: <?= htmlspecialchars($item['titulo_item']) ?></h1>

<form action="/backend/item/atualizar" method="POST">
    <input type="hidden" name="id_item" value="<?= $item['id_item'] ?>">

    <div class="form-row">
        <div class="form-group col-md-8">
            <label for="titulo_item">Título*</label>
            <input type="text" class="form-control" id="titulo_item" name="titulo_item" value="<?= htmlspecialchars($item['titulo_item']) ?>" required>
        </div>
        <div class="form-group col-md-4">
            <label for="tipo_item">Tipo de Item*</label>
            <select id="tipo_item" name="tipo_item" class="form-control" required>
                <option value="livro" <?= $item['tipo_item'] == 'livro' ? 'selected' : '' ?>>Livro</option>
                <option value="cd" <?= $item['tipo_item'] == 'cd' ? 'selected' : '' ?>>CD</option>
                <option value="dvd" <?= $item['tipo_item'] == 'dvd' ? 'selected' : '' ?>>DVD</option>
                <option value="revista" <?= $item['tipo_item'] == 'revista' ? 'selected' : '' ?>>Revista</option>
            </select>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="id_genero">Gênero*</label>
            <select id="id_genero" name="id_genero" class="form-control" required>
                <?php foreach ($generos as $genero): ?>
                    <option value="<?= $genero['id_genero'] ?>" <?= $item['id_genero'] == $genero['id_genero'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($genero['nome_genero']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="id_categoria">Categoria*</label>
            <select id="id_categoria" name="id_categoria" class="form-control" required>
                 <?php foreach ($categorias as $categoria): ?>
                    <option value="<?= $categoria['id_categoria'] ?>" <?= $item['id_categoria'] == $categoria['id_categoria'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($categoria['nome_categoria']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="autor-search-input">Buscar Autores/Artistas</label>
        <input type="text" id="autor-search-input" class="form-control" placeholder="Digite para buscar...">
        <div id="autor-search-results"></div>
        <div id="autores-selecionados-list" class="mt-2">
            <?php foreach ($autores_selecionados as $autor): ?>
                <span id="autor-badge-<?= $autor['id_autor'] ?>">
                    <?= htmlspecialchars($autor['nome_autor']) ?>
                    <button type="button" onclick="removerAutor(<?= $autor['id_autor'] ?>)">&times;</button>
                </span>
                <input type="hidden" name="autores_ids[]" value="<?= $autor['id_autor'] ?>" id="autor-input-<?= $autor['id_autor'] ?>">
            <?php endforeach; ?>
        </div>
    </div>

    <div class="form-group">
        <label for="descricao">Descrição</label>
        <textarea class="form-control" id="descricao" name="descricao" rows="3"><?= htmlspecialchars($item['descricao']) ?></textarea>
    </div>

    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="editora_gravadora">Editora / Gravadora</label>
            <input type="text" class="form-control" id="editora_gravadora" name="editora_gravadora" value="<?= htmlspecialchars($item['editora_gravadora']) ?>">
        </div>
        <div class="form-group col-md-4">
            <label for="ano_publicacao">Ano</label>
            <input type="number" class="form-control" id="ano_publicacao" name="ano_publicacao" min="1000" max="2099" value="<?= (int)$item['ano_publicacao'] ?>">
        </div>
        <div class="form-group col-md-4">
            <label for="estoque">Estoque</label>
            <input type="number" class="form-control" id="estoque" name="estoque" min="0" value="<?= (int)$item['estoque'] ?>">
        </div>
    </div>
    
    <div class="form-row">
        <div class="form-group col-md-4 campo-especifico" id="campo-isbn">
            <label for="isbn">ISBN (Livro)</label>
            <input type="text" class="form-control" id="isbn" name="isbn" value="<?= htmlspecialchars($item['isbn']) ?>">
        </div>
        <div class="form-group col-md-4 campo-especifico" id="campo-duracao">
            <label for="duracao_minutos">Duração (minutos) (CD/DVD)</label>
            <input type="number" class="form-control" id="duracao_minutos" name="duracao_minutos" value="<?= (int)$item['duracao_minutos'] ?>">
        </div>
        <div class="form-group col-md-4 campo-especifico" id="campo-edicao">
            <label for="numero_edicao">Nº Edição (Revista)</label>
            <input type="number" class="form-control" id="numero_edicao" name="numero_edicao" value="<?= (int)$item['numero_edicao'] ?>">
        </div>
    </div>

    <button type="submit" class="btn btn-success">Atualizar Item</button>
    <a href="/item/listar" class="btn btn-secondary">Cancelar</a>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // --- Lógica 1: Campos Condicionais (ISBN, etc.) ---
    const tipoSelect = document.getElementById('tipo_item');
    const campoIsbn = document.getElementById('campo-isbn');
    const campoDuracao = document.getElementById('campo-duracao');
    const campoEdicao = document.getElementById('campo-edicao');

    function toggleCamposEspeciais() {
        const tipo = tipoSelect.value;
        campoIsbn.style.display = 'none';
        campoDuracao.style.display = 'none';
        campoEdicao.style.display = 'none';

        if (tipo === 'livro') {
            campoIsbn.style.display = 'block';
        } else if (tipo === 'cd' || tipo === 'dvd') {
            campoDuracao.style.display = 'block';
        } else if (tipo === 'revista') {
            campoEdicao.style.display = 'block';
        }
    }
    tipoSelect.addEventListener('change', toggleCamposEspeciais);
    toggleCamposEspeciais(); // Roda na inicialização para exibir o campo correto

    // --- Lógica 2: Busca de Autores (AJAX) ---
    const searchInput = document.getElementById('autor-search-input');
    const searchResults = document.getElementById('autor-search-results');
    const selectedList = document.getElementById('autores-selecionados-list');
    
    let debounceTimer;

    searchInput.addEventListener('keyup', () => {
        clearTimeout(debounceTimer);
        const termo = searchInput.value.trim();
        
        if (termo.length < 2) {
            searchResults.innerHTML = '';
            return;
        }

        debounceTimer = setTimeout(() => {
            fetch(`/backend/ajax/buscar/autores?term=${encodeURIComponent(termo)}`)
                .then(response => response.json())
                .then(autores => {
                    searchResults.innerHTML = '';
                    autores.forEach(autor => {
                        const div = document.createElement('div');
                        div.textContent = autor.nome_autor;
                        div.dataset.id = autor.id_autor;
                        div.addEventListener('click', () => adicionarAutor(autor.id_autor, autor.nome_autor));
                        searchResults.appendChild(div);
                    });
                });
        }, 300);
    });

    window.adicionarAutor = function(id, nome) {
        if (document.querySelector(`#autores-selecionados-list input[value="${id}"]`)) {
            searchInput.value = '';
            searchResults.innerHTML = '';
            return;
        }

        const span = document.createElement('span');
        span.id = `autor-badge-${id}`;
        span.innerHTML = `${nome} <button type_button" onclick="removerAutor(${id})">&times;</button>`;
        selectedList.appendChild(span);

        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'autores_ids[]';
        input.value = id;
        input.id = `autor-input-${id}`;
        selectedList.appendChild(input);

        searchInput.value = '';
        searchResults.innerHTML = '';
    }

    window.removerAutor = function(id) {
        document.getElementById(`autor-badge-${id}`).remove();
        document.getElementById(`autor-input-${id}`).remove();
    }
});
</script>