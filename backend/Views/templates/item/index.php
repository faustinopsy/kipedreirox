<style>
    /* Estilos simples para paginação */
    .paginacao { display: flex; list-style: none; padding: 0; }
    .paginacao li { margin: 0 5px; }
    .paginacao li.disabled span { color: #ccc; }
    .paginacao li.active span { font-weight: bold; }
</style>

<h1>Gerenciamento de Itens do Sebo</h1>

<a href="/backend/item/criar" class="btn btn-primary mb-3">Adicionar Novo Item</a>

<div class="card-deck mb-3">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Total de Itens</h5>
            <p class="card-text"><?= $total_itens ?? 0 ?></p>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Itens Ativos</h5>
            <p class="card-text"><?= $total_ativos ?? 0 ?></p>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Itens Inativos (Lixeira)</h5>
            <p class="card-text"><?= $total_inativos ?? 0 ?></p>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Título</th>
                <th>Tipo</th>
                <th>Gênero</th>
                <th>Categoria</th>
                <th>Autores/Artistas</th>
                <th>Estoque</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($itens)): ?>
                <tr>
                    <td colspan="7" class="text-center">Nenhum item encontrado.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($itens as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['titulo_item']) ?></td>
                        <td><?= htmlspecialchars(ucfirst($item['tipo_item'])) ?></td>
                        <td><?= htmlspecialchars($item['nome_genero']) ?></td>
                        <td><?= htmlspecialchars($item['nome_categoria']) ?></td>
                        <td><?= htmlspecialchars($item['autores'] ?? 'N/A') ?></td>
                        <td><?= (int)$item['estoque'] ?></td>
                        <td>
                            <a href="/backend/item/editar/<?= $item['id_item'] ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="/backend/item/excluir/<?= $item['id_item'] ?>" class="btn btn-sm btn-danger">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<nav>
    <ul class="paginacao">
        <?php $pag = $paginacao; ?>
        
        <li class="<?= ($pag['pagina_atual'] <= 1) ? 'disabled' : '' ?>">
            <a href="/backend/item/listar/<?= $pag['pagina_atual'] - 1 ?>">Anterior</a>
        </li>
        
        <li class="active">
            <span>Página <?= $pag['pagina_atual'] ?> de <?= $pag['ultima_pagina'] ?></span>
        </li>

        <li class="<?= ($pag['pagina_atual'] >= $pag['ultima_pagina']) ? 'disabled' : '' ?>">
            <a href="/backend/item/listar/<?= $pag['pagina_atual'] + 1 ?>">Próxima</a>
        </li>
    </ul>
    <p>Mostrando de <?= $pag['de'] ?> até <?= $pag['para'] ?> de <?= $pag['total'] ?> registros.</p>
</nav>