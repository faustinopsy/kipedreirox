<h1>Confirmar Exclusão</h1>

<div class="alert alert-danger" role="alert">
  Tem certeza que deseja mover o item "<strong><?= htmlspecialchars($titulo_item) ?></strong>" para a lixeira?
</div>

<form action="/backend/item/deletar" method="POST">
    <input type="hidden" name="id_item" value="<?= $id_item ?>">
    
    <button type="submit" class="btn btn-danger">Sim, Excluir</button>
    <a href="/backend/item/listar" class="btn btn-secondary">Cancelar</a>
</form>