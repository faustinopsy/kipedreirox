<div style="padding: 28px;">

    <!-- Page Header -->
    <div class="adm-page-header">
        <div class="adm-page-title">
            <div class="title-icon"><i class="fa fa-users"></i></div>
            <div>
                <h1>Usuários</h1>
                <p>Gerencie os usuários do sistema</p>
            </div>
        </div>
        <a href="/backend/usuario/criar" class="adm-btn adm-btn-primary">
            <i class="fa fa-user-plus"></i> Novo Usuário
        </a>
    </div>

    <!-- Stat Cards -->
    <div class="adm-stats-grid">
        <div class="adm-stat-card verde">
            <div class="adm-stat-icon"><i class="fa fa-check-circle"></i></div>
            <div class="adm-stat-info">
                <div class="num"><?php echo $total_ativos; ?></div>
                <div class="label">Ativos</div>
            </div>
        </div>
        <div class="adm-stat-card vermelho">
            <div class="adm-stat-icon"><i class="fa fa-times-circle"></i></div>
            <div class="adm-stat-info">
                <div class="num"><?php echo $total_inativos; ?></div>
                <div class="label">Inativos</div>
            </div>
        </div>
        <div class="adm-stat-card amarelo">
            <div class="adm-stat-icon"><i class="fa fa-users"></i></div>
            <div class="adm-stat-info">
                <div class="num"><?php echo $total_usuarios; ?></div>
                <div class="label">Total</div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="adm-card">
        <div class="adm-card-header">
            <h2><i class="fa fa-list" style="margin-right:8px;color:#FFC709;"></i>Lista de Usuários</h2>
        </div>

        <?php if (isset($usuarios) && count($usuarios) > 0): ?>
        <div class="adm-card-body">
            <table class="adm-table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Tipo</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario):
                        $label_status = $usuario['status_usuario'] == "ativo" ? "Desativar" : "Ativar";
                        $isAtivo = $usuario['status_usuario'] == "ativo";
                        $isAdmin = strtolower($usuario['tipo_usuario']) == "admin";
                    ?>
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div style="width:32px;height:32px;border-radius:50%;background:#f0f4ff;display:flex;align-items:center;justify-content:center;color:#3b5bdb;font-size:0.85rem;flex-shrink:0;">
                                    <i class="fa fa-user"></i>
                                </div>
                                <strong><?= htmlspecialchars($usuario['nome_usuario']) ?></strong>
                            </div>
                        </td>
                        <td style="color:#888;"><?= htmlspecialchars($usuario['email_usuario']) ?></td>
                        <td>
                            <span class="adm-badge <?= $isAdmin ? 'admin' : 'usuario' ?>">
                                <?= htmlspecialchars($usuario['tipo_usuario']) ?>
                            </span>
                        </td>
                        <td>
                            <span class="adm-badge <?= $isAtivo ? 'ativo' : 'inativo' ?>">
                                <?= htmlspecialchars($usuario['status_usuario']) ?>
                            </span>
                        </td>
                        <td>
                            <div class="adm-actions">
                                <a class="adm-btn adm-btn-edit adm-btn-sm"
                                   href="/backend/usuario/editar/<?= htmlspecialchars($usuario['id_usuario']) ?>">
                                    <i class="fa fa-pencil"></i> Editar
                                </a>
                                <form action="/backend/usuario/deletar" method="POST" style="display:inline;"
                                      onsubmit="return confirm('Deseja realmente <?= strtolower($label_status) ?> este usuário?');">
                                    <input type="hidden" name="id_usuario" value="<?= $usuario['id_usuario']; ?>">
                                    <button type="submit" class="adm-btn adm-btn-sm <?= $isAtivo ? 'adm-btn-danger' : 'adm-btn-success' ?>">
                                        <i class="fa fa-<?= $isAtivo ? 'ban' : 'check' ?>"></i>
                                        <?php echo $label_status; ?>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="adm-pagination">
            <?php if ($paginacao['pagina_atual'] > 1): ?>
                <a href="/backend/usuario/listar/<?= $paginacao['pagina_atual'] - 1 ?>">
                    <i class="fa fa-chevron-left"></i>
                </a>
            <?php endif; ?>

            <span class="info">Página</span>
            <span class="current"><?= $paginacao['pagina_atual'] ?></span>
            <span class="info">de <?= $paginacao['ultima_pagina'] ?></span>

            <?php if ($paginacao['pagina_atual'] < $paginacao['ultima_pagina']): ?>
                <a href="/backend/usuario/listar/<?= $paginacao['pagina_atual'] + 1 ?>">
                    <i class="fa fa-chevron-right"></i>
                </a>
            <?php endif; ?>
        </div>

        <?php else: ?>
        <div class="adm-empty">
            <i class="fa fa-users"></i>
            <p>Nenhum usuário encontrado.</p>
        </div>
        <?php endif ?>
    </div>

</div>