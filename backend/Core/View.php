<?php
namespace App\Kipedreiro\Core;

class View {
    
    public static function render($view, $data = []) {
        extract($data);
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        include __DIR__. '/../Views/templates/partials/header.php';

        include __DIR__. '/../Views/templates/' . $view . '.php';

        include __DIR__. '/../Views/templates/partials/footer.php';
    }

    public static function renderError($errorView) {
        include __DIR__. '/../Views/errors/' . $errorView . '.php';
    }
}