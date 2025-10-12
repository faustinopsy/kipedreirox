<div class="w3-container w3-padding-32 w3-center">
    <h2>Criar Nova Conta</h2>
    <form action="/backend/register" method="POST" class="w3-container w3-card-4 w3-light-grey w3-text-blue w3-margin">
        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-user"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" name="nome_usuario" type="text" placeholder="Nome Completo" required>
            </div>
        </div>
        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-envelope-o"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" name="email_usuario" type="email" placeholder="Email" required>
            </div>
        </div>
        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-lock"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" name="senha_usuario" type="password" placeholder="Senha" required>
            </div>
        </div>
        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-lock"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" name="senha_confirm" type="password" placeholder="Confirmar Senha" required>
            </div>
        </div>
        <button class="w3-button w3-block w3-section w3-blue w3-ripple w3-padding">Registrar</button>
    </form>
    <div class="w3-container w3-center">
        <p>Já tem uma conta? <a href="/backend/login">Faça o login aqui</a>.</p>
    </div>
</div>