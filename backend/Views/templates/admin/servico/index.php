<div class="w3-container">
    <h3>Gerenciar Serviços</h3>
    <a href="/backend/servico/criar" class="w3-button w3-blue">Adicionar Novo Serviço</a>
    
    <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
        <thead>
            <tr class="w3-blue">
                <th>Foto</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($servicos as $servico): ?>
                <tr>
                    <td><img src="/backend/upload/<?= htmlspecialchars($servico['foto_servico']); ?>" style="width:100px;"></td>
                    <td><?= htmlspecialchars($servico['nome_servico']); ?></td>
                    <td><?= htmlspecialchars($servico['descricao_servico']); ?></td>
                    <td>
                        <a href="/backend/servico/editar/<?= $servico['id_servico']; ?>" class="w3-button w3-tiny w3-khaki">Editar</a>
                        
                        <a href="/backend/servico/excluir/<?= $servico['id_servico']; ?>" class="w3-button w3-tiny w3-red">Inativar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    </div>