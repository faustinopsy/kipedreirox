<div style="padding: 28px;">

    <!-- Page Header -->
    <div class="adm-page-header">
        <div class="adm-page-title">
            <div class="title-icon"><i class="fa fa-th-large"></i></div>
            <div>
                <h1>Portfólio</h1>
                <p>Gerencie os projetos realizados</p>
            </div>
        </div>
        <a href="/backend/portfolio/criar" class="adm-btn adm-btn-primary">
            <i class="fa fa-plus"></i> Novo Projeto
        </a>
    </div>
    
    <!-- Tabela -->
    <div class="adm-card">
        <table class="adm-table">
            <thead>
                <tr>
                    <th width="60">ID</th>
                    <th width="80">Imagem</th>
                    <th>Título</th>
                    <th>Cliente</th>
                    <th>Data</th>
                    <th>Status</th>
                    <th width="140" class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($registros)): ?>
                    <?php foreach ($registros as $item): ?>
                        <tr>
                            <td>#<?= $item['id_portfolio']; ?></td>
                            <td>
                                <?php if($item['imagem_portfolio']): ?>
                                    <img src="/backend/upload/<?= htmlspecialchars($item['imagem_portfolio']); ?>" 
                                         alt="Img" 
                                         style="width:40px;height:40px;border-radius:4px;object-fit:cover;">
                                <?php else: ?>
                                    <div style="width:40px;height:40px;background:#eee;border-radius:4px;"></div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?= htmlspecialchars($item['titulo_portfolio']); ?></strong>
                            </td>
                            <td>
                                <?= htmlspecialchars($item['cliente_portfolio']); ?>
                            </td>
                             <td>
                                <?= date('d/m/Y', strtotime($item['data_projeto'])); ?>
                            </td>
                            <td>
                                <span class="status-badge status-<?= strtolower($item['status_portfolio']) === 'ativo' ? 'success' : 'danger'; ?>">
                                    <?= ucfirst($item['status_portfolio']); ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="/backend/portfolio/editar/<?= $item['id_portfolio']; ?>" class="action-btn edit" title="Editar">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a href="/backend/portfolio/excluir/<?= $item['id_portfolio']; ?>" class="action-btn delete" title="Status">
                                    <i class="fa fa-sync-alt"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align:center;padding:30px;color:#777;">
                            Nenhum projeto encontrado.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Paginação -->
    <?php if (isset($paginacao) && $paginacao['total_paginas'] > 1): ?>
        <div class="adm-pagination">
            <?php for ($i = 1; $i <= $paginacao['total_paginas']; $i++): ?>
                <a href="/backend/portfolio/listar/<?= $i; ?>" class="<?= $i == $paginacao['pagina_atual'] ? 'active' : ''; ?>">
                    <?= $i; ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>

</div>
