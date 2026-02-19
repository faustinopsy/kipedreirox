<div style="padding: 28px;">

    <div class="adm-page-header">
        <div class="adm-page-title">
            <div class="title-icon"><i class="fa fa-trash"></i></div>
            <div>
                <h1>Alterar Status</h1>
                <p>Alterar visibilidade do item</p>
            </div>
        </div>
        <a href="/backend/sobre/listar" class="adm-btn adm-btn-edit">
            <i class="fa fa-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="adm-form-page" style="max-width:600px;">
        <div class="adm-form-card">
            <div class="adm-form-card-header" style="background-color: #fee2e2; color: #991b1b;">
                <div class="header-icon" style="background-color: #fecaca; color: #991b1b;"><i class="fa fa-exclamation-triangle"></i></div>
                <h2>Atenção</h2>
            </div>

            <form action="/backend/sobre/deletar" method="POST">
                <input type="hidden" name="id_sobre" value="<?= $sobre['id_sobre']; ?>">
                
                <div class="adm-form-card-body">
                    <p style="font-size:1.1rem;color:#333;margin-bottom:12px;">
                        Você está prestes a alterar o status do item:
                    </p>
                    <div style="background:#f9fafb;padding:16px;border-radius:8px;border:1px solid #e5e7eb;margin-bottom:20px;">
                        <h3 style="margin:0 0 8px 0;font-size:1.2rem;"><?= htmlspecialchars($sobre['titulo_sobre']); ?></h3>
                        <p style="margin:0;color:#666;"><?= htmlspecialchars(substr($sobre['descricao_sobre'], 0, 100)) . '...'; ?></p>
                    </div>

                    <p>
                        Status atual: <strong><?= ucfirst($sobre['status_sobre']); ?></strong>. 
                        Deseja trocar para <strong><?= strtolower($sobre['status_sobre']) === 'ativo' ? 'Inativo' : 'Ativo'; ?></strong>?
                    </p>
                </div>

                <div class="adm-form-card-footer">
                    <button type="submit" class="adm-btn adm-btn-primary" style="background-color: #ef4444; border-color:#ef4444;">
                        <i class="fa fa-sync-alt"></i> Confirmar Alteração
                    </button>
                    <a href="/backend/sobre/listar" class="adm-btn adm-btn-edit">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
