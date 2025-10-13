<div class="w3-container w3-padding-32">
    <h2>Esqueci a Senha</h2>
    <p>Digite seu e-mail e enviaremos um link para você redefinir sua senha.</p>
    <form action="/backend/esqueci-senha" method="POST" class="w3-container w3-card-4">
        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-envelope-o"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" name="email" type="email" placeholder="Email" required>
            </div>
        </div>
        <button class="w3-button w3-block w3-section w3-blue w3-ripple w3-padding">Enviar Link</button>
    </form>
</div>