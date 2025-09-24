<?php
// Cole aqui o array $carrinho que você criou no exercício 8.
$carrinho = [
    ['nome' => 'Teclado Mecânico', 'preco' => 350.50],
    ['nome' => 'Mouse Gamer', 'preco' => 110.50],
    ['nome' => 'Headset 7.1', 'preco' => 499.96]
];

$total = 0;
foreach ($carrinho as $item) {
    $total += $item['preco'];
}
echo "O total do carrinho é R$ " . number_format($total, 2);
// 1. Inicie um loop foreach para percorrer o $carrinho.
// 2. A cada iteração, some o valor da chave 'preco' do item à variável $total.
// 3. Após o loop, imprima o valor total formatado: "O total do carrinho é R$ XXX.XX".