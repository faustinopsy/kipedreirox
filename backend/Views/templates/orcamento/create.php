<div style="padding: 28px;">

    <!-- Page Header -->
    <div class="adm-page-header">
        <div class="adm-page-title">
            <div class="title-icon"><i class="fa fa-plus-circle"></i></div>
            <div>
                <h1>Novo Orçamento</h1>
                <p>Vincule um cliente a serviços e defina os valores</p>
            </div>
        </div>
        <a href="/backend/orcamento/listar/1" class="adm-btn adm-btn-edit">
            <i class="fa fa-arrow-left"></i> Voltar
        </a>
    </div>

    <form action="/backend/orcamento/salvar" method="POST" id="formOrcamento">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;align-items:start;">

        <!-- Coluna Esquerda: dados gerais -->
        <div class="adm-form-card">
            <div class="adm-form-card-header">
                <div class="header-icon"><i class="fa fa-user"></i></div>
                <h2>Dados Gerais</h2>
            </div>
            <div class="adm-form-card-body">

                <div class="adm-form-group">
                    <label for="id_cliente">Cliente *</label>
                    <select id="id_cliente" name="id_cliente" required>
                        <option value="">Selecione o cliente...</option>
                        <?php foreach ($clientes as $c): ?>
                        <option value="<?= $c['id_usuario'] ?>">
                            <?= htmlspecialchars($c['nome_usuario']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="adm-form-group">
                    <label for="id_categoria">Categoria</label>
                    <select id="id_categoria" name="id_categoria">
                        <option value="">Selecione a categoria...</option>
                        <?php foreach ($categorias as $cat): ?>
                        <option value="<?= $cat['id_categoria'] ?>">
                            <?= htmlspecialchars($cat['nome_categoria']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="adm-form-group">
                    <label for="id_pedreiro">Profissional Responsável</label>
                    <select id="id_pedreiro" name="id_pedreiro">
                        <option value="">Selecione o profissional...</option>
                        <?php foreach ($profissionais as $prof): ?>
                        <option value="<?= $prof['id_usuario'] ?>">
                            <?= htmlspecialchars($prof['nome_usuario']) ?> (<?= htmlspecialchars($prof['tipo_usuario']) ?>)
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="adm-form-group">
                    <label for="descricao_orcamento">Descrição / Observações *</label>
                    <textarea id="descricao_orcamento" name="descricao_orcamento"
                              placeholder="Descreva o serviço solicitado, localização, detalhes..."
                              required></textarea>
                </div>

            </div>
        </div>

        <!-- Coluna Direita: itens -->
        <div class="adm-form-card">
            <div class="adm-form-card-header">
                <div class="header-icon"><i class="fa fa-list-ul"></i></div>
                <h2>Itens do Orçamento</h2>
            </div>
            <div class="adm-form-card-body">

                <div id="itens-container">
                    <!-- linha de item gerada por JS -->
                </div>

                <button type="button" onclick="adicionarItem()" class="adm-btn adm-btn-edit" style="width:100%;justify-content:center;margin-top:8px;">
                    <i class="fa fa-plus"></i> Adicionar Item
                </button>

                <!-- Total -->
                <div style="margin-top:20px;padding:16px;background:#f5f6fa;border-radius:8px;border:2px solid #e8e9ee;">
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <span style="font-size:0.9rem;font-weight:700;color:#444;">VALOR TOTAL ESTIMADO</span>
                        <span id="totalGeral" style="font-size:1.6rem;font-weight:800;color:#2a2a2a;">R$ 0,00</span>
                    </div>
                </div>

            </div>
            <div class="adm-form-card-footer">
                <button type="submit" class="adm-btn adm-btn-primary">
                    <i class="fa fa-save"></i> Salvar Orçamento
                </button>
                <a href="/backend/orcamento/listar/1" class="adm-btn adm-btn-edit">Cancelar</a>
            </div>
        </div>

    </div>
    </form>

</div>

<script>
// Serviços disponíveis (tipo=trabalho)
const servicos = <?php echo json_encode(array_map(fn($s) => [
    'id'    => $s['id_servico'],
    'nome'  => $s['nome_servico'],
    'valor' => (float) ($s['valor_base_servico'] ?? 0)
], $servicos)); ?>;

let itemIndex = 0;

function adicionarItem(servico_id = '', descricao = '', valor = '', quantidade = 1) {
    const idx = itemIndex++;
    const container = document.getElementById('itens-container');

    const optionsHtml = servicos.map(s =>
        `<option value="${s.id}" data-valor="${s.valor}" ${s.id == servico_id ? 'selected' : ''}>${s.nome}</option>`
    ).join('');

    const linha = document.createElement('div');
    linha.className = 'item-linha';
    linha.style.cssText = 'border:1px solid #e8e9ee;border-radius:8px;padding:14px;margin-bottom:12px;background:#fafafa;position:relative;';
    linha.innerHTML = `
        <button type="button" onclick="this.parentElement.remove();calcularTotal()"
            style="position:absolute;top:8px;right:10px;background:none;border:none;color:#dc2626;cursor:pointer;font-size:1rem;">
            <i class="fa fa-times"></i>
        </button>
        <div class="adm-form-group" style="margin-bottom:10px;">
            <label>Serviço</label>
            <select name="item_servico[${idx}]" class="item-servico" onchange="preencherValor(this, ${idx})" required>
                <option value="">Selecione...</option>
                ${optionsHtml}
            </select>
        </div>
        <div style="display:grid;grid-template-columns:1fr 100px 100px;gap:8px;">
            <div class="adm-form-group" style="margin-bottom:0;">
                <label>Descrição</label>
                <input type="text" name="item_descricao[${idx}]" value="${descricao}" placeholder="Detalhe do serviço">
            </div>
            <div class="adm-form-group" style="margin-bottom:0;">
                <label>Valor Unit. (R$)</label>
                <input type="number" name="item_valor[${idx}]" id="valor_${idx}" step="0.01" min="0"
                       value="${valor}" oninput="calcularTotal()" required>
            </div>
            <div class="adm-form-group" style="margin-bottom:0;">
                <label>Qtd</label>
                <input type="number" name="item_quantidade[${idx}]" id="qtde_${idx}" step="0.01" min="0.01"
                       value="${quantidade}" oninput="calcularTotal()" required>
            </div>
        </div>
    `;
    container.appendChild(linha);
    calcularTotal();
}

function preencherValor(select, idx) {
    const opt = select.options[select.selectedIndex];
    const val = parseFloat(opt?.dataset?.valor ?? 0);
    const input = document.getElementById('valor_' + idx);
    if (input && val > 0) input.value = val.toFixed(2);
    calcularTotal();
}

function calcularTotal() {
    let total = 0;
    document.querySelectorAll('.item-linha').forEach(linha => {
        const valor = parseFloat(linha.querySelector('[name*="item_valor"]')?.value?.replace(',','.') ?? 0);
        const qtde  = parseFloat(linha.querySelector('[name*="item_quantidade"]')?.value?.replace(',','.') ?? 0);
        if (!isNaN(valor) && !isNaN(qtde)) total += valor * qtde;
    });
    document.getElementById('totalGeral').textContent = 'R$ ' + total.toLocaleString('pt-BR', {minimumFractionDigits:2});
}

// Começa com 1 item vazio
adicionarItem();
</script>
