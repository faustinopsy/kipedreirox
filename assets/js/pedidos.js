function finalizarPedido() {
    if (carrinho.length === 0) {
        pedidoStatusEl.textContent = 'Seu carrinho está vazio.';
        return;
    }
    pedidoStatusEl.textContent = 'Enviando pedido...';

    fetch('/backend/api/pedidos', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(carrinho)
    })
    .then(response => response.ok ? response.json() : Promise.reject('Erro na resposta da rede'))
    .then(json => {
        if (json.status === 'success') {
            pedidoStatusEl.innerHTML = `<p style="color: green;">${json.message} (Pedido #${json.id_pedido})</p>`;
            carrinho = [];
            renderizarCarrinho();
        } else {
            throw new Error(json.message || 'Erro desconhecido ao finalizar pedido.');
        }
    })
    .catch(err => {
        console.error("Erro ao finalizar:", err);
        pedidoStatusEl.innerHTML = `<p style="color: red;">${err.message || 'Erro de conexão ao finalizar o pedido.'}</p>`;
    });
}