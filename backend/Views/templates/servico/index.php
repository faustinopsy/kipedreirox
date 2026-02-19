<div style="padding: 28px;">

    <!-- Page Header -->
    <div class="adm-page-header">
        <div class="adm-page-title">
            <div class="title-icon"><i class="fa fa-briefcase"></i></div>
            <div>
                <h1>Serviços</h1>
                <p>Gerencie os serviços disponíveis</p>
            </div>
        </div>
        <a href="/backend/servico/criar" class="adm-btn adm-btn-primary">
            <i class="fa fa-plus"></i> Novo Serviço
        </a>
    </div>

    <!-- Table Card -->
    <div class="adm-card">
        <div class="adm-card-header">
            <h2><i class="fa fa-list" style="margin-right:8px;color:#FFC709;"></i>Lista de Serviços</h2>
        </div>

        <?php if (isset($servicos) && count($servicos) > 0): ?>
        <div class="adm-card-body">
            <table class="adm-table">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($servicos as $servico):
                        $label = $servico["status_servico"] == 'Inativo' ? 'Ativar' : 'Desativar';
                        $isAtivo = $servico["status_servico"] != 'Inativo';
                    ?>
                    <tr>
                        <td>
                            <img src="/backend/upload/<?= htmlspecialchars($servico['foto_servico']); ?>"
                                 alt="<?= htmlspecialchars($servico['nome_servico']); ?>">
                        </td>
                        <td><strong><?= htmlspecialchars($servico['nome_servico']); ?></strong></td>
                        <td style="color:#888;max-width:280px;">
                            <?= htmlspecialchars($servico['descricao_servico']); ?>
                        </td>
                        <td>
                            <span class="adm-badge <?= $isAtivo ? 'ativo' : 'inativo' ?>">
                                <?= htmlspecialchars($servico['status_servico']); ?>
                            </span>
                        </td>
                        <td>
                            <div class="adm-actions">
                                <a href="/backend/servico/editar/<?= $servico['id_servico']; ?>"
                                   class="adm-btn adm-btn-edit adm-btn-sm">
                                    <i class="fa fa-pencil"></i> Editar
                                </a>
                                <form action="/backend/servico/deletar" method="POST" style="display:inline;"
                                      onsubmit="return confirm('Deseja realmente <?= strtolower($label) ?> este serviço?');">
                                    <input type="hidden" name="id_servico" value="<?= $servico['id_servico']; ?>">
                                    <button type="submit" class="adm-btn adm-btn-sm <?= $isAtivo ? 'adm-btn-danger' : 'adm-btn-success' ?>">
                                        <i class="fa fa-<?= $isAtivo ? 'ban' : 'check' ?>"></i>
                                        <?= $label; ?>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="adm-empty">
            <i class="fa fa-briefcase"></i>
            <p>Nenhum serviço cadastrado.</p>
        </div>
        <?php endif; ?>
    </div>

</div>