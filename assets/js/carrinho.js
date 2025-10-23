function renderizarCarrinho() {
    cartItemsEl.innerHTML = '';
    let total = 0;
    let totalItens = 0;
    carrinho.forEach(item => {
        const precoItemTotal = (item.preco * item.quantidade).toFixed(2);
        const itemHtml = `
            <li class="cart-item">
                ${item.nome} - R$ ${parseFloat(item.preco).toFixed(2)} x ${item.quantidade} = R$ ${precoItemTotal}
                <button class="btn-remove-cart w3-button w3-tiny w3-red w3-padding-small" 
                        data-id="${item.id}" 
                        style="margin-left: 10px;">
                    Remover 1
                </button>
            </li>`;
        cartItemsEl.insertAdjacentHTML('beforeend', itemHtml);
        total += item.preco * item.quantidade;
        totalItens += item.quantidade;
    });

    cartCountEl.textContent = totalItens;
    cartTotalEl.textContent = total.toFixed(2);
    salvarCarrinhoLocalStorage(); 
}



function adicionarAoCarrinho(id, nome, preco) {
    const itemExistente = carrinho.find(item => item.id === id);
    if (itemExistente) {
        itemExistente.quantidade++;
    } else {
        carrinho.push({ id, nome, preco: parseFloat(preco), quantidade: 1 });
    }
    renderizarCarrinho();
}

function removerDoCarrinho(id) {
    const itemIndex = carrinho.findIndex(item => item.id === id);
    if (itemIndex > -1) { 
        if (carrinho[itemIndex].quantidade > 1) {
            carrinho[itemIndex].quantidade--;
        } else {
            carrinho.splice(itemIndex, 1); 
        }
        renderizarCarrinho();
    }
}

