function carregaNavbar() {
    const navbarContainer = document.getElementById('navbar');
    if (navbarContainer) {
        navbarContainer.innerHTML = `<div class="cabecalho__barra-superior">
            <div class="container">
                <span><img src="assets/img/icon/001-phone-receiver-silhouette.png" alt="Ícone Telefone"> (11) 9 4802-0922</span>
                <span><img src="assets/img/icon/019-email-1.png" alt="Ícone Email"> contato@kipedreiro.com.br</span>
                <a href="/backend/login" class="cabecalho__login"><img src="assets/img/icon/017-profile-user-1.png" alt="Ícone Login"> Login</a>
            </div>
        </div>
        <nav class="cabecalho__principal">
            <div class="container">
                <a href="index.html">
                    <img src="assets/img/logo/KiPedreiro.png" alt="Logo Ki-Pedreiro" class="cabecalho__logo">
                </a>
                <ul class="cabecalho__menu">
                    <li><a href="index.html" class="cabecalho__link cabecalho__link--ativo">Home</a></li>
                    <li><a href="sobre.html" class="cabecalho__link">Sobre</a></li>
                    <li><a href="projetos.html" class="cabecalho__link">Portfólio</a></li>
                    <li><a href="servicos.html" class="cabecalho__link">Serviços</a></li>
                    <li><a href="contato.html" class="cabecalho__link">Contato</a></li>
                </ul>
            </div>
        </nav>`;
    }
}

carregaNavbar();