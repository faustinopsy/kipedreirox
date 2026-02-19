<div style="padding: 28px;">

    <!-- Page Header -->
    <div class="adm-page-header">
        <div class="adm-page-title">
            <div class="title-icon"><i class="fa fa-info-circle"></i></div>
            <div>
                <h1>Sobre Nós</h1>
                <p>Gerencie as informações institucionais da empresa</p>
            </div>
        </div>
        <a href="/backend/sobre/criar" class="adm-btn adm-btn-primary">
            <i class="fa fa-plus"></i> Novo Item
        </a>
    </div>

    <!-- Filtros / Busca (opcional, mantendo simples por enquanto) -->
    
    <!-- Tabela -->
    <div class="adm-card">
        <table class="adm-table">
            <thead>
                <tr>
                    <th width="60">ID</th>
                    <th width="80">Imagem</th>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Status</th>
                    <th width="140" class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($registros)): ?>
                    <?php foreach ($registros as $item): ?>
                        <tr>
                            <td>#<?= $item['id_sobre']; ?></td>
                            <td>
                                <?php if($item['imagem_sobre']): ?>
                                    <img src="/backend/upload/<?= htmlspecialchars($item['imagem_sobre']); ?>" 
                                         alt="Img" 
                                         style="width:40px;height:40px;border-radius:4px;object-fit:cover;">
                                <?php else: ?>
                                    <div style="width:40px;height:40px;background:#eee;border-radius:4px;"></div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?= htmlspecialchars($item['titulo_sobre']); ?></strong>
                            </td>
                            <td>
                                <?= htmlspecialchars(substr($item['descricao_sobre'], 0, 50)) . '...'; ?>
                            </td>
                            <td>
                                <span class="status-badge status-<?= strtolower($item['status_sobre']) === 'ativo' ? 'success' : 'danger'; ?>">
                                    <?= ucfirst($item['status_sobre']); ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="/backend/sobre/editar/<?= $item['id_sobre']; ?>" class="action-btn edit" title="Editar">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a href="/backend/sobre/excluir/<?= $item['id_sobre']; ?>" class="action-btn delete" title="Status">
                                    <i class="fa fa-sync-alt"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align:center;padding:30px;color:#777;">
                            Nenhum registro encontrado.
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
                <a href="/backend/sobre/listar/<?= $i; ?>" class="<?= $i == $paginacao['pagina_atual'] ? 'active' : ''; ?>">
                    <?= $i; ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>

</div>
