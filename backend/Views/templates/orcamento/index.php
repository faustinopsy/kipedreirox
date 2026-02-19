<div style="padding: 28px;">

    <!-- Page Header -->
    <div class="adm-page-header">
        <div class="adm-page-title">
            <div class="title-icon"><i class="fa fa-file-text-o"></i></div>
            <div>
                <h1>Orçamentos</h1>
                <p>Gerencie os orçamentos de serviços</p>
            </div>
        </div>
        <a href="/backend/orcamento/criar" class="adm-btn adm-btn-primary">
            <i class="fa fa-plus"></i> Novo Orçamento
        </a>
    </div>

    <!-- Stat Cards -->
    <div class="adm-stats-grid">
        <div class="adm-stat-card azul">
            <div class="adm-stat-icon"><i class="fa fa-file-text-o"></i></div>
            <div class="adm-stat-info">
                <div class="num"><?= $total ?></div>
                <div class="label">Total</div>
            </div>
        </div>
        <div class="adm-stat-card amarelo">
            <div class="adm-stat-icon"><i class="fa fa-clock-o"></i></div>
            <div class="adm-stat-info">
                <div class="num"><?= $em_aberto ?></div>
                <div class="label">Em Aberto</div>
            </div>
        </div>
        <div class="adm-stat-card verde">
            <div class="adm-stat-icon"><i class="fa fa-check-circle"></i></div>
            <div class="adm-stat-info">
                <div class="num"><?= $aprovados ?></div>
                <div class="label">Aprovados</div>
            </div>
        </div>
        <div class="adm-stat-card verde">
            <div class="adm-stat-icon"><i class="fa fa-flag-checkered"></i></div>
            <div class="adm-stat-info">
                <div class="num"><?= $finalizados ?></div>
                <div class="label">Finalizados</div>
            </div>
        </div>
        <div class="adm-stat-card vermelho">
            <div class="adm-stat-icon"><i class="fa fa-times-circle"></i></div>
            <div class="adm-stat-info">
                <div class="num"><?= $recusados ?></div>
                <div class="label">Recusados</div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="adm-card">
        <div class="adm-card-header">
            <h2><i class="fa fa-list" style="margin-right:8px;color:#FFC709;"></i> Lista de Orçamentos</h2>
        </div>
        <div class="adm-card-body">
            <?php if (empty($orcamentos)): ?>
                <div class="adm-empty">
                    <i class="fa fa-file-text-o"></i>
                    <p>Nenhum orçamento cadastrado ainda.</p>
                </div>
            <?php else: ?>
            <table class="adm-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Categoria</th>
                        <th>Descrição</th>
                        <th>Valor Total</th>
                        <th>Status</th>
                        <th>Data</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orcamentos as $o): ?>
                    <?php
                    $statusClass = match(strtolower($o['status_orcamento'] ?? '')) {
                        'aprovado'    => 'ativo',
                        'finalizado'  => 'ativo',
                        'em aberto'   => 'admin',
                        'recusado'    => 'inativo',
                        default       => 'usuario'
                    };
                    ?>
                    <tr>
                        <td><strong>#<?= $o['id_orcamento'] ?></strong></td>
                        <td><?= htmlspecialchars($o['nome_cliente'] ?? '–') ?></td>
                        <td><?= htmlspecialchars($o['nome_categoria'] ?? '–') ?></td>
                        <td style="max-width:220px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                            <?= htmlspecialchars($o['descricao_orcamento'] ?? '–') ?>
                        </td>
                        <td>
                            <strong>R$ <?= number_format($o['valor_total'] ?? 0, 2, ',', '.') ?></strong>
                        </td>
                        <td>
                            <span class="adm-badge <?= $statusClass ?>">
                                <?= htmlspecialchars($o['status_orcamento']) ?>
                            </span>
                        </td>
                        <td><?= date('d/m/Y', strtotime($o['data_orcamento'] ?? $o['criado_em'])) ?></td>
                        <td>
                            <div class="adm-actions">
                                <a href="/backend/orcamento/editar/<?= $o['id_orcamento'] ?>" class="adm-btn adm-btn-edit adm-btn-sm">
                                    <i class="fa fa-pencil"></i> Editar
                                </a>
                                <a href="/backend/orcamento/cancelar/<?= $o['id_orcamento'] ?>" class="adm-btn adm-btn-danger adm-btn-sm">
                                    <i class="fa fa-times"></i> Cancelar
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>

        <!-- Paginação -->
        <?php if ($paginacao['total_paginas'] > 1): ?>
        <div class="adm-pagination">
            <?php if ($paginacao['pagina_atual'] > 1): ?>
                <a href="/backend/orcamento/listar/<?= $paginacao['pagina_atual'] - 1 ?>">
                    <i class="fa fa-chevron-left"></i>
                </a>
            <?php endif; ?>
            <?php for ($p = 1; $p <= $paginacao['total_paginas']; $p++): ?>
                <?php if ($p == $paginacao['pagina_atual']): ?>
                    <span class="current"><?= $p ?></span>
                <?php else: ?>
                    <a href="/backend/orcamento/listar/<?= $p ?>"><?= $p ?></a>
                <?php endif; ?>
            <?php endfor; ?>
            <?php if ($paginacao['pagina_atual'] < $paginacao['total_paginas']): ?>
                <a href="/backend/orcamento/listar/<?= $paginacao['pagina_atual'] + 1 ?>">
                    <i class="fa fa-chevron-right"></i>
                </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>

</div>
