function carregaRodape() {
    const navbarContainer = document.getElementById('footer');
    if (navbarContainer) {
        navbarContainer.innerHTML = `<div class="container">
            <div class="rodape__grid">
                <div class="rodape__coluna">
                    <h4 class="rodape__titulo">Navegação</h4>
                    <ul class="rodape__lista-links">
                        <li><a href="index.html">Home</a></li>
                        <li><a href="#">Sobre Nós</a></li>
                        <li><a href="servicos.html">Serviços</a></li>
                        <li><a href="projetos.html">Portfólio</a></li>
                        <li><a href="#">Contato</a></li>
                    </ul>
                </div>
                <div class="rodape__coluna">
                    <h4 class="rodape__titulo">Contato</h4>
                    <p>(11) 9 4802-0922</p>
                    <p>contato@kipedreiro.com.br</p>
                    <p>Rua Exemplo, 123 - São Paulo, SP</p>
                </div>
                <div class="rodape__coluna">
                    <h4 class="rodape__titulo">Siga-nos</h4>
                    <div class="rodape__redes-sociais">
                        <a href="#"><img src="assets/img/icon/facebook.svg" alt="Facebook"></a>
                        <a href="#"><img src="assets/img/icon/instagram.svg" alt="Instagram"></a>
                        <a href="#"><img src="assets/img/icon/linkedin.svg" alt="LinkedIn"></a>
                    </div>
                </div>
            </div>
            <div class="rodape__direitos">
                <p>&copy; 2025 Ki-Pedreiro. Todos os direitos reservados.</p>
            </div>
        </div>`;
    }
}

carregaRodape();