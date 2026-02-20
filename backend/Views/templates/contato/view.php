<?php
use App\Kipedreiro\Core\View;
?>

<div class="w3-container w3-padding-32">
    <div class="w3-row">
        <div class="w3-col m8 w3-display-container w3-display-middle"> <!-- Centered container -->
            <div class="w3-card-4 w3-white w3-round-large">
                <header class="w3-container w3-light-grey">
                    <h3><i class="fa fa-envelope-open-o"></i> Leitura de Mensagem #<?php echo $contatoMensagem['id_contato']; ?></h3>
                </header>

                <div class="w3-container w3-padding-large">
                    <p><strong>De:</strong> <?php echo htmlspecialchars($contatoMensagem['nome_contato'] ?? ''); ?> &lt;<?php echo htmlspecialchars($contatoMensagem['email_contato'] ?? ''); ?>&gt;</p>
                    
                    <?php if (!empty($contatoMensagem['telefone_contato'])): ?>
                        <p><strong>Telefone:</strong> <?php echo htmlspecialchars($contatoMensagem['telefone_contato']); ?></p>
                    <?php endif; ?>

                    <?php if (!empty($contatoMensagem['assunto_contato'])): ?>
                        <p><strong>Assunto:</strong> <?php echo htmlspecialchars($contatoMensagem['assunto_contato']); ?></p>
                    <?php endif; ?>

                    <p><strong>Enviado em:</strong> <?php echo isset($contatoMensagem['data_envio']) ? date('d/m/Y \à\s H:i', strtotime($contatoMensagem['data_envio'])) : '-'; ?></p>
                    <hr>
                    
                    <div class="w3-panel w3-light-grey w3-leftbar w3-border-grey w3-padding-16">
                        <p style="white-space: pre-wrap;"><?php echo htmlspecialchars($contatoMensagem['mensagem_contato'] ?? ''); ?></p>
                    </div>

                    <div class="w3-margin-top w3-right-align">
                        <a href="mailto:<?php echo htmlspecialchars($contatoMensagem['email_contato'] ?? ''); ?>" class="w3-button w3-blue w3-round">
                            <i class="fa fa-reply"></i> Responder por Email
                        </a>
                        <a href="/backend/contato/listar" class="w3-button w3-grey w3-round">
                            <i class="fa fa-arrow-left"></i> Voltar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
