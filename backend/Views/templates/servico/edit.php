<div class="w3-container">
    <h3>Editando Serviço: <?= htmlspecialchars($servico['nome_servico']); ?></h3>
    
    <form action="/backend/servico/atualizar" method="POST" enctype="multipart/form-data" class="w3-container w3-card-4">
        
        <input type="hidden" name="id_servico" value="<?= $servico['id_servico']; ?>">

        <p>
        <label class="w3-text-blue"><b>Nome do Serviço</b></label>
        <input class="w3-input w3-border" name="nome_servico" type="text" value="<?= htmlspecialchars($servico['nome_servico']); ?>" required>
        </p>
        
        <p>
        <label class="w3-text-blue"><b>Descrição Curta</b></label>
        <input class="w3-input w3-border" name="descricao_servico" type="text" value="<?= htmlspecialchars($servico['descricao_servico']); ?>">
        </p>

        <p>
            <label class="w3-text-blue"><b>Foto Principal (Atual)</b></label><br>
            <img src="/backend/upload/<?= htmlspecialchars($servico['foto_servico']); ?>" style="width:150px; border: 1px solid #ccc; padding: 4px;">
        </p>

        <p>
        <label class="w3-text-blue"><b>Substituir Foto</b></label>
        <input class="w3-input w3-border" name="foto_servico" type="file">
        <small>Deixe em branco para manter a foto atual.</small>
        </p>

        <p>
        <button type="submit" class="w3-button w3-blue">Salvar Alterações</button>
        <a href="/backend/servico/listar" class="w3-button w3-grey">Cancelar</a>
        </p>

    </form>
</div>