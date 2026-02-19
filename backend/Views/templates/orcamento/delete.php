<div style="padding: 28px;">

    <!-- Page Header -->
    <div class="adm-page-header">
        <div class="adm-page-title">
            <div class="title-icon"><i class="fa fa-times-circle"></i></div>
            <div>
                <h1>Cancelar Orçamento</h1>
                <p>Confirme o cancelamento abaixo</p>
            </div>
        </div>
        <a href="/backend/orcamento/listar/1" class="adm-btn adm-btn-edit">
            <i class="fa fa-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="adm-form-page" style="max-width:600px;">
        <div class="adm-form-card">
            <div class="adm-form-card-header" style="background:#dc2626;">
                <div class="header-icon" style="background:rgba(255,255,255,0.15);color:#fff;">
                    <i class="fa fa-exclamation-triangle"></i>
                </div>
                <h2>Confirmar Cancelamento</h2>
            </div>
            <div class="adm-form-card-body">
                <p style="color:#444;font-size:0.95rem;margin-bottom:20px;">
                    Tem certeza que deseja <strong>cancelar</strong> o orçamento abaixo?
                    O status será alterado para <strong>Recusado</strong>.
                </p>

                <div style="background:#f5f6fa;border-radius:8px;padding:16px;border:1px solid #e8e9ee;">
                    <div style="display:flex;gap:16px;flex-wrap:wrap;">
                        <div>
                            <div style="font-size:0.72rem;color:#888;text-transform:uppercase;letter-spacing:1px;">Orçamento</div>
                            <div style="font-weight:800;font-size:1rem;">#<?= $orcamento['id_orcamento'] ?></div>
                        </div>
                        <div>
                            <div style="font-size:0.72rem;color:#888;text-transform:uppercase;letter-spacing:1px;">Cliente</div>
                            <div style="font-weight:700;"><?= htmlspecialchars($orcamento['nome_cliente'] ?? '–') ?></div>
                        </div>
                        <div>
                            <div style="font-size:0.72rem;color:#888;text-transform:uppercase;letter-spacing:1px;">Status Atual</div>
                            <div style="font-weight:700;"><?= htmlspecialchars($orcamento['status_orcamento']) ?></div>
                        </div>
                    </div>
                    <hr style="margin:14px 0;">
                    <p style="margin:0;font-size:0.9rem;color:#555;">
                        <?= htmlspecialchars($orcamento['descricao_orcamento'] ?? '') ?>
                    </p>
                </div>
            </div>
            <div class="adm-form-card-footer">
                <form action="/backend/orcamento/cancelar" method="POST">
                    <input type="hidden" name="id_orcamento" value="<?= $orcamento['id_orcamento'] ?>">
                    <button type="submit" class="adm-btn adm-btn-danger">
                        <i class="fa fa-times"></i> Confirmar Cancelamento
                    </button>
                </form>
                <a href="/backend/orcamento/listar/1" class="adm-btn adm-btn-edit">
                    Voltar sem cancelar
                </a>
            </div>
        </div>
    </div>

</div>
