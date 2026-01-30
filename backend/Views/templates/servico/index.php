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
            <?php foreach ($servicos as $servico): 
                $label = $servico["status_servico"] =='Inativo' ? 'Ativar' : 'Desativar';
                ?>
                <tr>
                    <td><img src="/backend/upload/<?= htmlspecialchars($servico['foto_servico']); ?>" style="width:100px;"></td>
                    <td><?= htmlspecialchars($servico['nome_servico']); ?></td>
                    <td><?= htmlspecialchars($servico['descricao_servico']); ?></td>
                    <td>
                        <a href="/backend/servico/editar/<?= $servico['id_servico']; ?>" class="w3-button w3-tiny w3-khaki">Editar</a>                        
                        <form action="/backend/servico/deletar" method="POST" style="display:inline;" onsubmit="return confirm('Deseja realmente <?= strtolower($label); ?> este serviço?');">
                            <input type="hidden" name="id_servico" value="<?= $servico['id_servico']; ?>">
                            <button type="submit" class="w3-button w3-tiny <?= $servico["status_servico"] == 'Inativo' ? 'w3-green' : 'w3-red' ?>">
                                <?= $label; ?>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    </div>