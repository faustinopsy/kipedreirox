<div class="w3-container">
    <h3>Novo Serviço</h3>
    <form action="/servico/salvar" method="POST" enctype="multipart/form-data" class="w3-container w3-card-4">
        
        <p>
        <label class="w3-text-blue"><b>Nome do Serviço</b></label>
        <input class="w3-input w3-border" name="nome_servico" type="text" required>
        </p>
        
        <p>
        <label class="w3-text-blue"><b>Descrição Curta</b></label>
        <input class="w3-input w3-border" name="descricao_servico" type="text">
        </p>

        <p>
        <label class="w3-text-blue"><b>Foto Principal</b></label>
        <input class="w3-input w3-border" name="foto_servico" type="file" required>
        </p>

        <p>
        <button class="w3-button w3-blue">Salvar Serviço</button>
        </p>

    </form>
</div>