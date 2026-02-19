<?php
namespace App\Kipedreiro\Controllers;

use App\Kipedreiro\Core\View;
use App\Kipedreiro\Core\Flash;
use App\Kipedreiro\Core\Redirect;
use App\Kipedreiro\Models\Usuario;
use App\Kipedreiro\Database\Database;
use App\Kipedreiro\Core\Session;
use App\Kipedreiro\Validadores\UsuarioValidador;

class AuthController{
    private Usuario $usuarioModel;
    private Session $session;

    public function __construct(){
        $db = Database::getInstance();
        $this->usuarioModel = new Usuario($db);
        $this->session = new Session();
    }

    public function login(): void {
        View::render('auth/login');
    }

    public function register(): void{
        View::render('auth/register');
    }

    public function logout(): void {
        $this->session->destroy();
        Redirect::redirecionarComMensagem('/login', 'success', 'Você saiu com segurança.');
    }
    
    public function authenticar(): void {
        $email = $_POST['email_usuario'] ?? null;
        $senha = $_POST['senha_usuario'] ?? null;
        $usuario = $this->usuarioModel->checarCredenciais($email, $senha);
        if ($usuario) {
            session_regenerate_id(true);
            $this->session->set('usuario_id', $usuario['id_usuario']);
            $this->session->set('usuario_nome', $usuario['nome_usuario']);
            $this->session->set('usuario_tipo', $usuario['tipo_usuario']);
            
            Redirect::redirecionarPara('/admin/dashboard'); 
        } else {
            Redirect::redirecionarComMensagem('/login', 'error', 'E-mail ou senha incorretos.');
        }
    }

    public function cadastrarUsuario(): void {
        $erros = UsuarioValidador::ValidarEntradas($_POST);
        if (!empty($erros)) {
            Redirect::redirecionarComMensagem('/register', 'erros', implode("<br>", $erros));
        }
        $nome = $_POST['nome_usuario'] ?? null;
        $email = $_POST['email_usuario'] ?? null;
        $senha = $_POST['senha_usuario'] ?? null;
        $senha_confirm = $_POST['senha_confirm'] ?? null;
        if ($senha != $senha_confirm) {
            Redirect::redirecionarComMensagem('/register', 'erros', 'As senhas não conferem.');
        }
        
        if (!empty($this->usuarioModel->buscarUsuariosPorEMail($email))){
            Redirect::redirecionarComMensagem('/register', 'erros', 'Erro ao cadastrar, problema no seu e-mail.');
        }
        $novoUsuarioId = $this->usuarioModel->inseriUsuario($nome, $email, $senha, 'usuario', 'Ativo', 'null');
        if ($novoUsuarioId) {
            Redirect::redirecionarComMensagem('/login', 'success', 'Cadastro realizado! Por favor, faça o login.');
        } else {
            Redirect::redirecionarComMensagem('/register', 'error', 'Erro no servidor. Tente novamente.');
        }
    }

}