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
                
                <!-- Desktop Menu -->
                <ul class="cabecalho__menu desktop-only">
                    <li><a href="index.html" class="cabecalho__link">Home</a></li>
                    <li><a href="sobre.html" class="cabecalho__link">Sobre</a></li>
                    <li><a href="projetos.html" class="cabecalho__link">Portfólio</a></li>
                    <li><a href="servicos.html" class="cabecalho__link">Serviços</a></li>
                    <li><a href="contato.html" class="cabecalho__link">Contato</a></li>
                </ul>

                <!-- Mobile Menu Toggle -->
                <button class="menu-toggle" aria-label="Abrir menu">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </button>
            </div>
        </nav>
        
        <!-- Mobile Overlay -->
        <div class="menu-overlay">
            <button class="menu-close" aria-label="Fechar menu">&times;</button>
            <ul class="mobile-menu-links">
                <li><a href="index.html" class="mobile-link">Home</a></li>
                <li><a href="sobre.html" class="mobile-link">Sobre</a></li>
                <li><a href="projetos.html" class="mobile-link">Portfólio</a></li>
                <li><a href="servicos.html" class="mobile-link">Serviços</a></li>
                <li><a href="contato.html" class="mobile-link">Contato</a></li>
            </ul>
        </div>`;

        // Logic
        const toggleBtn = navbarContainer.querySelector('.menu-toggle');
        const closeBtn = navbarContainer.querySelector('.menu-close');
        const overlay = navbarContainer.querySelector('.menu-overlay');
        const mobileLinks = navbarContainer.querySelectorAll('.mobile-link');

        function toggleMenu() {
            overlay.classList.toggle('active');
            document.body.style.overflow = overlay.classList.contains('active') ? 'hidden' : '';
        }

        if (toggleBtn) toggleBtn.addEventListener('click', toggleMenu);
        if (closeBtn) closeBtn.addEventListener('click', toggleMenu);

        mobileLinks.forEach(link => {
            link.addEventListener('click', toggleMenu);
        });

        // Highlight active link logic
        const currentPath = window.location.pathname.replace(/\/$/, ""); // Remove trailing slash
        const allLinks = navbarContainer.querySelectorAll('a');

        allLinks.forEach(link => {
            const href = link.getAttribute('href');
            if (!href) return;

            // Handle root/home special case
            if (href === 'index.html' && (currentPath.endsWith('index.html') || currentPath.endsWith('/') || currentPath.split('/').pop() === '')) {
                link.classList.add('cabecalho__link--ativo');
                if (link.classList.contains('mobile-link')) link.classList.add('active');
                return;
            }

            // Handle other pages
            if (currentPath.endsWith(href)) {
                link.classList.add('cabecalho__link--ativo');
                if (link.classList.contains('mobile-link')) link.classList.add('active');
            }
        });
    }
}

carregaNavbar();