<?php
namespace App\Kipedreiro\Controllers\Admin;

use App\Kipedreiro\Core\Flash;
use App\Kipedreiro\Core\Redirect;

abstract class PedreiroController extends AuthenticatedController{
    public function __construct() {
        parent::__construct();
        if ($this->session->get('usuario_tipo') !== 'Pedreiro') {
            Redirect::redirecionarComMensagem(
                'admin/dashboard',
                'error',
                 'Você não tem permissão para acessar esta área.'
                ); 
        }
    }
}