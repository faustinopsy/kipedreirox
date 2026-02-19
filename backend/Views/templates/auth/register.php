<style>
/* ===== AUTH PAGE - REGISTER ===== */
/* (shares .auth-page, .auth-brand, .auth-form-panel, .auth-group, .auth-btn from login.php)
   The styles below are standalone — safe to have on both pages. */
.auth-page {
    min-height: 100vh;
    display: flex;
    background: #f0f2f5;
    font-family: 'Raleway', 'Helvetica', sans-serif;
}

.auth-brand {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 42%;
    min-height: 100vh;
    background: #2a2a2a;
    padding: 60px 40px;
    position: relative;
    overflow: hidden;
}

.auth-brand::before {
    content: '';
    position: absolute;
    top: -80px;
    right: -80px;
    width: 320px;
    height: 320px;
    background: rgba(255, 199, 9, 0.08);
    border-radius: 50%;
}

.auth-brand::after {
    content: '';
    position: absolute;
    bottom: -60px;
    left: -60px;
    width: 240px;
    height: 240px;
    background: rgba(255, 199, 9, 0.06);
    border-radius: 50%;
}

.auth-brand-logo {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 48px;
    z-index: 1;
}

.auth-brand-logo .logo-icon {
    width: 52px;
    height: 52px;
    background: #FFC709;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    color: #2a2a2a;
}

.auth-brand-logo .logo-text {
    font-size: 1.6rem;
    font-weight: 800;
    color: #fff;
    letter-spacing: -0.5px;
}

.auth-brand-logo .logo-text span {
    color: #FFC709;
}

.auth-brand-tagline {
    z-index: 1;
    text-align: center;
}

.auth-brand-tagline h2 {
    font-size: 2rem;
    font-weight: 700;
    color: #fff;
    margin: 0 0 16px;
    line-height: 1.2;
    text-align: center;
}

.auth-brand-tagline h2 em {
    font-style: normal;
    color: #FFC709;
}

.auth-brand-tagline p {
    font-size: 1rem;
    color: rgba(255,255,255,0.55);
    line-height: 1.7;
    max-width: 300px;
    margin: 0 auto;
}

.auth-brand-divider {
    width: 48px;
    height: 3px;
    background: #FFC709;
    border-radius: 2px;
    margin: 24px auto;
}

.auth-form-panel {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 60px 40px;
    background: #fff;
}

.auth-form-box {
    width: 100%;
    max-width: 420px;
}

.auth-form-box .auth-title {
    font-size: 1.9rem;
    font-weight: 800;
    color: #2a2a2a;
    margin: 0 0 6px;
}

.auth-form-box .auth-subtitle {
    font-size: 0.95rem;
    color: #888;
    margin: 0 0 32px;
}

.auth-form-box .auth-subtitle a {
    color: #FFC709;
    font-weight: 600;
    text-decoration: none;
    transition: color 0.2s;
}

.auth-form-box .auth-subtitle a:hover {
    color: #e0a800;
}

.auth-group {
    margin-bottom: 20px;
}

.auth-group label {
    display: block;
    font-size: 0.85rem;
    font-weight: 700;
    color: #444;
    margin-bottom: 8px;
    letter-spacing: 0.4px;
    text-transform: uppercase;
}

.auth-input-wrap {
    position: relative;
}

.auth-input-wrap i {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #bbb;
    font-size: 1rem;
    pointer-events: none;
    transition: color 0.2s;
}

.auth-input-wrap input {
    width: 100%;
    padding: 14px 16px 14px 44px;
    border: 2px solid #EAEAEA;
    border-radius: 10px;
    font-size: 0.95rem;
    font-family: 'Raleway', sans-serif;
    color: #333;
    background: #fafafa;
    transition: border-color 0.25s, background 0.25s, box-shadow 0.25s;
    outline: none;
}

.auth-input-wrap input:focus {
    border-color: #FFC709;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(255, 199, 9, 0.12);
}

.auth-input-wrap:focus-within i {
    color: #FFC709;
}

.auth-btn {
    width: 100%;
    padding: 15px;
    background: #FFC709;
    color: #2a2a2a;
    font-size: 1rem;
    font-weight: 800;
    font-family: 'Raleway', sans-serif;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    letter-spacing: 0.5px;
    transition: background 0.25s, transform 0.15s, box-shadow 0.25s;
    margin-top: 8px;
    box-shadow: 0 4px 16px rgba(255, 199, 9, 0.3);
}

.auth-btn:hover {
    background: #e0a800;
    transform: translateY(-1px);
    box-shadow: 0 6px 24px rgba(255, 199, 9, 0.4);
}

.auth-btn:active {
    transform: translateY(0);
}

/* Password strength indicator (register only) */
.auth-password-hint {
    font-size: 0.78rem;
    color: #aaa;
    margin-top: 6px;
}

@media (max-width: 768px) {
    .auth-page {
        flex-direction: column;
    }
    .auth-brand {
        width: 100%;
        min-height: auto;
        padding: 40px 24px;
    }
    .auth-brand-tagline h2 { font-size: 1.5rem; }
    .auth-form-panel {
        padding: 40px 24px;
    }
}
</style>

<div class="auth-page">

    <!-- Left: Brand Panel -->
    <div class="auth-brand">
        <div class="auth-brand-logo">
            <div class="logo-icon"><i class="fa fa-wrench"></i></div>
            <div class="logo-text">Kipe<span>dreiro</span></div>
        </div>
        <div class="auth-brand-tagline">
            <h2>Comece <em>agora</em><br>mesmo!</h2>
            <div class="auth-brand-divider"></div>
            <p>Crie sua conta gratuita e gerencie seus serviços e equipe em minutos.</p>
        </div>
    </div>

    <!-- Right: Form Panel -->
    <div class="auth-form-panel">
        <div class="auth-form-box">
            <h1 class="auth-title">Criar Conta</h1>
            <p class="auth-subtitle">Já tem uma conta? <a href="/backend/login">Faça o login</a></p>

            <form action="/backend/register" method="POST" autocomplete="off">

                <div class="auth-group">
                    <label for="reg-nome">Nome Completo</label>
                    <div class="auth-input-wrap">
                        <input id="reg-nome" type="text" name="nome_usuario" placeholder="Seu nome completo" required>
                        <i class="fa fa-user"></i>
                    </div>
                </div>

                <div class="auth-group">
                    <label for="reg-email">E-mail</label>
                    <div class="auth-input-wrap">
                        <input id="reg-email" type="email" name="email_usuario" placeholder="seu@email.com" required>
                        <i class="fa fa-envelope-o"></i>
                    </div>
                </div>

                <div class="auth-group">
                    <label for="reg-senha">Senha</label>
                    <div class="auth-input-wrap">
                        <input id="reg-senha" type="password" name="senha_usuario" placeholder="Mínimo 6 caracteres" required>
                        <i class="fa fa-lock"></i>
                    </div>
                    <p class="auth-password-hint">Use ao menos 6 caracteres, incluindo letras e números.</p>
                </div>

                <div class="auth-group">
                    <label for="reg-senha-confirm">Confirmar Senha</label>
                    <div class="auth-input-wrap">
                        <input id="reg-senha-confirm" type="password" name="senha_confirm" placeholder="Repita a senha" required>
                        <i class="fa fa-shield"></i>
                    </div>
                </div>

                <button type="submit" class="auth-btn">Criar minha conta</button>
            </form>
        </div>
    </div>

</div>