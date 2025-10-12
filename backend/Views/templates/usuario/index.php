  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> My Dashboard</b></h5>
  </header>

  <div class="w3-row-padding w3-margin-bottom">
    
    <div class="w3-quarter">
      <div class="w3-container w3-teal w3-padding-16">
        <div class="w3-left"><i class="fa fa-users  w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $total_ativos; ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Ativos</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-red w3-padding-16">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $total_inativos; ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Inativos</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-blue w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $total_usuarios; ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Total de Usuarios</h4>
      </div>
    </div>
  </div>
    <a href="/backend/usuario/criar" class="w3-button w3-teal">Criar Usuário</a>
<?php if (isset($usuarios) && count($usuarios) > 0): ?>
    <table border="1" cellpadding="5" cellspacing="0" class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
        <thead>
            <tr>
                <th>Nome</th><th>Email</th><th>Tipo</th><th>Status</th><th>Editar</th><th>Excluir</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): 
            $cor = $usuario['status_usuario'] == "ativo"? "" : "orange";
            $label_status = $usuario['status_usuario'] == "ativo"? "Desativar" : "Ativar";
            ?>
                <tr style="background-color: <?php echo $cor; ?>">
                    <td><?= htmlspecialchars($usuario['nome_usuario']) ?></td>
                    <td><?= htmlspecialchars($usuario['email_usuario']) ?></td>
                    <td><?= htmlspecialchars($usuario['tipo_usuario']) ?></td>
                    <td><?= htmlspecialchars($usuario['status_usuario']) ?></td>
                    <td>
                      <a class="w3-button w3-round w3-blue w3-hover-red w3-padding-large w3-margin-right" 
                      href="/backend/usuario/editar/<?= htmlspecialchars($usuario['id_usuario']) ?>">Editar</a>
                    </td>
                    <td>
                      <a class="w3-button w3-round w3-red w3-hover-red w3-padding-large w3-margin-right" 
                      href="/backend/usuario/excluir/<?= htmlspecialchars($usuario['id_usuario']) ?>"><?php echo $label_status; ?></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="paginacao-controls" style="display:flex; justify-content:space-between; align-items:center; margin-top:20px;">
    <div class="page-selector" style="display:flex; align-items:center;">
        <div class="page-nav">
            <?php if ($paginacao['pagina_atual'] > 1): ?>
                <a href="/backend/usuario/listar/<?= $paginacao['pagina_atual'] - 1 ?>">Anterior</a>
            <?php endif; ?>
            <span style="margin:0 10px;">Página <?= $paginacao['pagina_atual'] ?> de <?= $paginacao['ultima_pagina'] ?></span>
            <?php if ($paginacao['pagina_atual'] < $paginacao['ultima_pagina']): ?>
                <a href="/backend/usuario/listar/<?= $paginacao['pagina_atual'] + 1 ?>">Próximo</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php else: ?>
    <div>Nenhum usuário encontrado.</div>
<?php endif ?>