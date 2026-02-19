<div style="padding: 28px;">

    <!-- Welcome Banner -->
    <div class="adm-welcome-card">
        <div class="adm-welcome-text">
            <h1>Olá, <span><?= htmlspecialchars($nomeUsuario); ?> 👋</span></h1>
            <p>Bem-vindo ao painel de administração do Kipedreiro.</p>
        </div>
        <div class="adm-welcome-badge">
            <span>Perfil</span>
            <strong><?= htmlspecialchars($Tipo); ?></strong>
        </div>
    </div>

    <!-- Quick Navigation -->
    <div class="adm-page-header">
        <div class="adm-page-title">
            <div class="title-icon"><i class="fa fa-th-large"></i></div>
            <div>
                <h1>Acesso Rápido</h1>
                <p>Gerencie usuários e serviços</p>
            </div>
        </div>
    </div>

    <div class="adm-nav-grid">
        <a href="/backend/usuario/listar/1" class="adm-nav-card">
            <div class="nav-icon"><i class="fa fa-users"></i></div>
            <div class="nav-label">Usuários</div>
            <div class="nav-sub">Listar e gerenciar</div>
        </a>
        <a href="/backend/usuario/criar" class="adm-nav-card">
            <div class="nav-icon"><i class="fa fa-user-plus"></i></div>
            <div class="nav-label">Novo Usuário</div>
            <div class="nav-sub">Cadastrar usuário</div>
        </a>
        <a href="/backend/servico/listar" class="adm-nav-card">
            <div class="nav-icon"><i class="fa fa-briefcase"></i></div>
            <div class="nav-label">Serviços</div>
            <div class="nav-sub">Listar e gerenciar</div>
        </a>
        <a href="/backend/servico/criar" class="adm-nav-card">
            <div class="nav-icon"><i class="fa fa-plus-circle"></i></div>
            <div class="nav-label">Novo Serviço</div>
            <div class="nav-sub">Cadastrar serviço</div>
        </a>
        <a href="/backend/logout" class="adm-nav-card" style="border-color: #fee2e2;">
            <div class="nav-icon" style="background:#fee2e2; color:#dc2626;"><i class="fa fa-sign-out"></i></div>
            <div class="nav-label" style="color:#dc2626;">Sair</div>
            <div class="nav-sub">Encerrar sessão</div>
        </a>
    </div>

</div>