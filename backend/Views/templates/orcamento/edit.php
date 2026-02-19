<div style="padding: 28px;">

    <!-- Page Header -->
    <div class="adm-page-header">
        <div class="adm-page-title">
            <div class="title-icon"><i class="fa fa-pencil"></i></div>
            <div>
                <h1>Editar Orçamento #<?= $orcamento['id_orcamento'] ?></h1>
                <p>Cliente: <strong><?= htmlspecialchars($orcamento['nome_cliente'] ?? '–') ?></strong></p>
            </div>
        </div>
        <a href="/backend/orcamento/listar/1" class="adm-btn adm-btn-edit">
            <i class="fa fa-arrow-left"></i> Voltar
        </a>
    </div>

    <form action="/backend/orcamento/atualizar" method="POST" id="formOrcamento">
    <input type="hidden" name="id_orcamento" value="<?= $orcamento['id_orcamento'] ?>">

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;align-items:start;">

        <!-- Coluna Esquerda -->
        <div class="adm-form-card">
            <div class="adm-form-card-header">
                <div class="header-icon"><i class="fa fa-file-text-o"></i></div>
                <h2>Dados Gerais</h2>
            </div>
            <div class="adm-form-card-body">

                <div class="adm-form-group">
                    <label>Cliente</label>
                    <input type="text" value="<?= htmlspecialchars($orcamento['nome_cliente'] ?? '–') ?>" disabled
                           style="background:#f5f6fa;color:#888;">
                </div>

                <div class="adm-form-group">
                    <label for="id_categoria">Categoria</label>
                    <select id="id_categoria" name="id_categoria">
                        <option value="">Selecione...</option>
                        <?php foreach ($categorias as $cat): ?>
                        <option value="<?= $cat['id_categoria'] ?>"
                            <?= $orcamento['id_categoria'] == $cat['id_categoria'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['nome_categoria']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="adm-form-group">
                    <label for="id_pedreiro">Profissional Responsável</label>
                    <select id="id_pedreiro" name="id_pedreiro">
                        <option value="">Selecione...</option>
                        <?php foreach ($profissionais as $prof): ?>
                        <option value="<?= $prof['id_usuario'] ?>"
                            <?= $orcamento['id_pedreiro'] == $prof['id_usuario'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($prof['nome_usuario']) ?> (<?= htmlspecialchars($prof['tipo_usuario']) ?>)
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="adm-form-group">
                    <label for="status_orcamento">Status</label>
                    <select id="status_orcamento" name="status_orcamento" required>
                        <?php foreach (['Em Aberto','Aprovado','Em Andamento','Finalizado','Recusado'] as $s): ?>
                        <option value="<?= $s ?>" <?= $orcamento['status_orcamento'] == $s ? 'selected' : '' ?>>
                            <?= $s ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="adm-form-group">
                    <label for="descricao_orcamento">Descrição / Observações</label>
                    <textarea id="descricao_orcamento" name="descricao_orcamento"
                              required><?= htmlspecialchars($orcamento['descricao_orcamento'] ?? '') ?></textarea>
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

                <div id="itens-container"></div>

                <button type="button" onclick="adicionarItem()" class="adm-btn adm-btn-edit"
                        style="width:100%;justify-content:center;margin-top:8px;">
                    <i class="fa fa-plus"></i> Adicionar Item
                </button>

                <div style="margin-top:20px;padding:16px;background:#f5f6fa;border-radius:8px;border:2px solid #e8e9ee;">
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <span style="font-size:0.9rem;font-weight:700;color:#444;">VALOR TOTAL</span>
                        <span id="totalGeral" style="font-size:1.6rem;font-weight:800;color:#2a2a2a;">R$ 0,00</span>
                    </div>
                </div>

            </div>
            <div class="adm-form-card-footer">
                <button type="submit" class="adm-btn adm-btn-primary">
                    <i class="fa fa-save"></i> Salvar Alterações
                </button>
                <a href="/backend/orcamento/listar/1" class="adm-btn adm-btn-edit">Cancelar</a>
            </div>
        </div>

    </div>
    </form>

</div>

<script>
const servicos = <?php echo json_encode(array_map(fn($s) => [
    'id'    => $s['id_servico'],
    'nome'  => $s['nome_servico'],
    'valor' => (float) ($s['valor_base_servico'] ?? 0)
], $servicos)); ?>;

// Itens existentes do banco
const itensExistentes = <?php echo json_encode(array_map(fn($i) => [
    'id_servico'  => $i['id_servico'],
    'descricao'   => $i['descricao_item_orcamento'],
    'valor'       => (float)($i['valor_servico'] ?? 0),
    'quantidade'  => (float)($i['qtde_solicitada'] ?? 1),
], $orcamento['itens'] ?? [])); ?>;

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
            <select name="item_servico[${idx}]" onchange="preencherValor(this,${idx})" required>
                <option value="">Selecione...</option>
                ${optionsHtml}
            </select>
        </div>
        <div style="display:grid;grid-template-columns:1fr 100px 100px;gap:8px;">
            <div class="adm-form-group" style="margin-bottom:0;">
                <label>Descrição</label>
                <input type="text" name="item_descricao[${idx}]" value="${descricao}" placeholder="Detalhe">
            </div>
            <div class="adm-form-group" style="margin-bottom:0;">
                <label>Valor Unit.</label>
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
        const v = parseFloat(linha.querySelector('[name*="item_valor"]')?.value?.replace(',','.') ?? 0);
        const q = parseFloat(linha.querySelector('[name*="item_quantidade"]')?.value?.replace(',','.') ?? 0);
        if (!isNaN(v) && !isNaN(q)) total += v * q;
    });
    document.getElementById('totalGeral').textContent = 'R$ ' + total.toLocaleString('pt-BR',{minimumFractionDigits:2});
}

// Carrega itens existentes ao abrir
if (itensExistentes.length > 0) {
    itensExistentes.forEach(i => adicionarItem(i.id_servico, i.descricao, i.valor, i.quantidade));
} else {
    adicionarItem();
}
</script>
