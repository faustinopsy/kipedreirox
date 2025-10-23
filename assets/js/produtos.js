
const produtosContainer = document.getElementById('produtos-lista');
const cartCountEl = document.getElementById('cart-count');
const cartItemsEl = document.getElementById('cart-items');
const cartTotalEl = document.getElementById('cart-total');
const btnFinalizar = document.getElementById('btn-finalizar');
const pedidoStatusEl = document.getElementById('pedido-status');
let carrinho = [];
const localStorageKey = 'carrinhoKiPedreiro'; 
function renderizarProdutos(produtos) {
    produtosContainer.innerHTML = '';
    produtos.forEach(produto => {
        const precoFormatado = parseFloat(produto.preco_produto).toFixed(2);
        const cardHtml = `
            <div class="produto-card">
                <img src="${produto.carrinho_imagem || produto.caminho_imagem}" alt="${produto.nome_produto}"> 
                <h3>${produto.nome_produto}</h3>
                <p>R$ ${precoFormatado}</p>
                <button class="btn-add-cart" 
                        data-id="${produto.id_produto}" 
                        data-nome="${produto.nome_produto}" 
                        data-preco="${produto.preco_produto}">
                    Adicionar ao Carrinho
                </button>
            </div>
        `;
        produtosContainer.insertAdjacentHTML('beforeend', cardHtml);
    });
}

function inicializar() {
    carregarCarrinhoLocalStorage();
    renderizarCarrinho();
    fetch('/backend/api/produtos')
        .then(response => response.ok ? response.json() : Promise.reject('Erro ao carregar produtos'))
        .then(json => {
            if (json.status === 'success' && json.data) {
                renderizarProdutos(json.data);
            } else {
                throw new Error(json.message || 'Erro ao buscar produtos da API.');
            }
        })
        .catch(err => {
            console.error("Erro ao carregar produtos:", err);
            produtosContainer.innerHTML = `<p style="color: red;">${err.message || 'Não foi possível carregar os produtos.'}</p>`;
        });

    
    produtosContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-add-cart')) {
            const { id, nome, preco } = e.target.dataset;
            adicionarAoCarrinho(id, nome, preco);
        }
    });

    cartItemsEl.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-remove-cart')) {
            const id = e.target.dataset.id;
            removerDoCarrinho(id);
        }
    });

    btnFinalizar.addEventListener('click', finalizarPedido);
}
function salvarCarrinhoLocalStorage() {
    localStorage.setItem(localStorageKey, JSON.stringify(carrinho));
}

function carregarCarrinhoLocalStorage() {
    const carrinhoSalvo = localStorage.getItem(localStorageKey);
    if (carrinhoSalvo) {
        carrinho = JSON.parse(carrinhoSalvo);
    }
}

inicializar();