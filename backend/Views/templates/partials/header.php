<?php
use App\Kipedreiro\Core\Flash;
use App\Kipedreiro\Core\Session;

?>
<!DOCTYPE html>
<html>
<head>
<title>Kipedreiro – Admin</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="/assets/css/admin.css">
<link rel="stylesheet" href="/assets/css/toast.css">
<style>
html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
</style>
</head>
<body class="w3-light-grey">
 <?php
    $session = new Session();
    $nomeUsuario = $session->get('usuario_nome');
    if ($session->has('usuario_id')): ?>

<!-- Top bar -->
<div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
  <button class="w3-bar-item w3-button w3-hide-large w3-hover-none" onclick="w3_open();" style="color:#fff;background:transparent;border:none;">
    <i class="fa fa-bars"></i>
  </button>
  <span class="w3-bar-item" style="font-weight:800;letter-spacing:-0.5px;font-size:1rem;">
    Kipe<span style="color:#FFC709;">dreiro</span>
  </span>
</div>

<!-- Sidebar -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:260px;" id="mySidebar">

  <!-- Brand + User area -->
  <div style="background:#1e1e1e;padding:22px 20px 18px;">
    <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;">
      <div style="width:36px;height:36px;background:#FFC709;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#2a2a2a;font-size:1rem;flex-shrink:0;">
        <i class="fa fa-wrench"></i>
      </div>
      <span style="font-size:1.05rem;font-weight:800;color:#fff;letter-spacing:-0.5px;">
        Kipe<span style="color:#FFC709;">dreiro</span>
      </span>
    </div>
    <div style="display:flex;align-items:center;gap:10px;">
      <div style="width:36px;height:36px;border-radius:50%;background:rgba(255,199,9,0.15);border:2px solid rgba(255,199,9,0.3);display:flex;align-items:center;justify-content:center;color:#FFC709;font-weight:800;font-size:0.85rem;flex-shrink:0;">
        <?= strtoupper(substr(htmlspecialchars($nomeUsuario), 0, 1)); ?>
      </div>
      <div>
        <div style="font-size:0.85rem;font-weight:700;color:#fff;"><?= htmlspecialchars($nomeUsuario); ?></div>
        <div style="font-size:0.72rem;color:rgba(255,255,255,0.4);">Administrador</div>
      </div>
    </div>
  </div>

  <!-- Nav label -->
  <div class="w3-container"><h5>Menu</h5></div>

  <div class="w3-bar-block">
    <a href="#" class="w3-bar-item w3-button w3-hide-large" onclick="w3_close()">
      <i class="fa fa-times fa-fw"></i>  Fechar
    </a>
    <a href="/backend/admin/dashboard" class="w3-bar-item w3-button">
      <i class="fa fa-dashboard fa-fw"></i>  Dashboard
    </a>
    <a href="/backend/usuario/listar/1" class="w3-bar-item w3-button">
      <i class="fa fa-users fa-fw"></i>  Usuários
    </a>
    <a href="/backend/servico/listar" class="w3-bar-item w3-button">
      <i class="fa fa-briefcase fa-fw"></i>  Serviços
    </a>
    <a href="/backend/orcamento/listar/1" class="w3-bar-item w3-button">
      <i class="fa fa-file-text-o fa-fw"></i>  Orçamentos
    </a>
    <a href="/backend/portfolio/listar" class="w3-bar-item w3-button">
      <i class="fa fa-th-large fa-fw"></i>  Portfólio
    </a>
    <a href="/backend/sobre/listar" class="w3-bar-item w3-button">
      <i class="fa fa-info-circle fa-fw"></i>  Sobre Nós
    </a>
    <a href="/backend/logout" class="w3-bar-item w3-button">
      <i class="fa fa-sign-out fa-fw"></i>  Sair
    </a>
  </div>
</nav>

<!-- Overlay -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" id="myOverlay"></div>
<div class="w3-main" style="margin-left:260px;margin-top:43px;">

<?php
endif;
$mensagem = Flash::get();
if (isset($mensagem) && !empty($mensagem['message'])):
    $flashType    = htmlspecialchars($mensagem['type']    ?? 'info', ENT_QUOTES);
    $flashMessage = htmlspecialchars($mensagem['message'] ?? '',      ENT_QUOTES);
?>
<div id="flash-data"
     data-toast-type="<?= $flashType ?>"
     data-toast-message="<?= $flashMessage ?>"
     hidden></div>
<?php endif; ?>
