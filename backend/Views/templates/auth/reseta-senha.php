<div class="w3-container w3-padding-32">
    <h2>Redefinir Senha</h2>
    <form action="/backend/reseta-senha" method="POST" class="w3-container w3-card-4">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token); ?>">
        
        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-lock"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" name="senha" type="password" placeholder="Nova Senha" required>
            </div>
        </div>
        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-lock"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" name="senha_confirm" type="password" placeholder="Confirmar Nova Senha" required>
            </div>
        </div>
        <button class="w3-button w3-block w3-section w3-blue w3-ripple w3-padding">Salvar Nova Senha</button>
    </form>
</div>