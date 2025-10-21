<div class="w3-container">
    <h3 class="w3-text-red">Confirmar Inativação</h3>
    
    <div class="w3-container w3-card-4 w3-padding">
        <p>Você tem certeza que deseja inativar (excluir) o serviço?</p>
        
        <h4><strong><?= htmlspecialchars($servico['nome_servico']); ?></strong></h4>
        
        <p>Esta ação não pode ser desfeita facilmente e o serviço deixará de aparecer no site público.</p>

        <form action="/backend/servico/deletar" method="POST">
            <input type="hidden" name="id_servico" value="<?= $servico['id_servico']; ?>">

            <p>
                <button type="submit" class="w3-button w3-red w3-padding">Sim, Inativar Serviço</button>
                <a href="/backend/servico/listar" class="w3-button w3-grey w3-padding">Cancelar</a>
            </p>
        </form>
    </div>
</div>