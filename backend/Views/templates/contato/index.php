<?php
use App\Kipedreiro\Core\View;
?>

<div class="w3-container w3-padding-32">
    <div class="w3-row">
        <div class="w3-col m12">
            <div class="w3-card-4 w3-white w3-round-large">
                <header class="w3-container w3-light-grey">
                    <h3><i class="fa fa-envelope-o"></i> Mensagens de Contato</h3>
                </header>

                <div class="w3-container w3-padding">
                    <table class="w3-table w3-striped w3-bordered w3-hoverable">
                        <thead>
                            <tr class="w3-light-grey">
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Data</th>
                                <th>Status</th>
                                <th class="w3-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($mensagens)): ?>
                                <?php foreach ($mensagens as $msg): ?>
                                    <tr class="<?= !$msg['lido'] ? 'w3-pale-yellow' : '' ?>">
                                        <td>#<?= $msg['id_contato'] ?></td>
                                        <td><?= htmlspecialchars($msg['nome_contato']) ?></td>
                                        <td><?= htmlspecialchars($msg['email_contato']) ?></td>
                                        <td><?= date('d/m/Y H:i', strtotime($msg['data_envio'])) ?></td>
                                        <td>
                                            <?php if (!$msg['lido']): ?>
                                                <span class="w3-tag w3-small w3-red">Novo</span>
                                            <?php else: ?>
                                                <span class="w3-tag w3-small w3-grey">Lido</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="w3-center">
                                            <a href="/backend/contato/ver/<?= $msg['id_contato'] ?>" class="w3-button w3-small w3-blue w3-round" title="Ler Mensagem">
                                                <i class="fa fa-eye"></i> Ler
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="w3-center w3-padding">Nenhuma mensagem encontrada.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <!-- Paginação -->
                    <?php if ($paginacao['total_paginas'] > 1): ?>
                        <div class="w3-bar w3-center w3-margin-top">
                            <?php for ($i = 1; $i <= $paginacao['total_paginas']; $i++): ?>
                                <a href="/backend/contato/listar/<?= $i ?>" class="w3-button <?= $i == $pagina_atual ? 'w3-black' : 'w3-white w3-border' ?>">
                                    <?= $i ?>
                                </a>
                            <?php endfor; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
