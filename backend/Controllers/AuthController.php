<?php
namespace App\Kipedreiro\Controllers;

use App\Kipedreiro\Core\View;
use App\Kipedreiro\Core\Flash;
use App\Kipedreiro\Core\Redirect;
use App\Kipedreiro\Models\Usuario;
use App\Kipedreiro\Database\Database;
use App\Kipedreiro\Core\Session;
use App\Kipedreiro\Validadores\UsuarioValidador;
use App\Kipedreiro\Core\NotificationService;

class AuthController{
    private Usuario $usuarioModel;
    private Session $session;
    private NotificationService $notificationService;

    public function __construct(){
        $db = Database::getInstance();
        $this->usuarioModel = new Usuario($db);
        $this->session = new Session();
        $this->notificationService = new NotificationService();
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
            Redirect::redirecionarComMensagem('/backend/login', 'error', 'E-mail ou senha incorretos.');
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
            $this->notificationService->enviarEmailDeBoasVindas([
                'nome_usuario' => $nome,
                'email_usuario' => $email
            ]);
            Redirect::redirecionarComMensagem('/login', 'success', 'Cadastro realizado! Por favor, faça o login.');
        } else {
            Redirect::redirecionarComMensagem('/register', 'error', 'Erro no servidor. Tente novamente.');
        }
    }

    public function viewEsqueciSenha(): void {
        View::render('auth/esqueci-senha');
    }

    public function viewFormTrocaSenha(string $token): void {
        $record = $this->usuarioModel->buscaTokenResetaSenha($token); 
        if (!$record || $this->usuarioModel->isTokenExpired($record['created_at'])) {
            Redirect::redirecionarComMensagem('/login', 'error', 'Link de redefinição inválido ou expirado.');
        }
        View::render('auth/reseta-senha', ['token' => $token]);
    }

    public function enviarLinkDoEmail(): void{
        $email = $_POST['email'] ?? null;
        $user = $this->usuarioModel->buscarUsuariosPorEMail($email);
        if ($user) {
            $userData = $user[0]; 
            $token = bin2hex(random_bytes(32));
            $this->usuarioModel->salvarTokenResetaSenha($email, $token);
            $this->notificationService->enviarEmailDeEqueciASenha($userData, $token);
        }
        Redirect::redirecionarComMensagem(
            '/esqueci-senha', 'success',
             'Se um e-mail correspondente for encontrado, um link será enviado.'
            );
    }

    public function resetaSenha(): void {
        $token = $_POST['token'] ?? null;
        $senha = $_POST['senha'] ?? null;
        $senha_confirm = $_POST['senha_confirm'] ?? null;
        $record = $this->usuarioModel->buscaTokenResetaSenha($token);

        if (!$record || $this->usuarioModel->isTokenExpired($record['created_at'])) {
            Redirect::redirecionarComMensagem('/login', 'error', 
            'Link de redefinição inválido ou expirado.');
        }
        if (empty($senha) || $senha !== $senha_confirm) {
            Redirect::redirecionarComMensagem('/reseta-senha/' . $token, 
            'error', 'As senhas não coincidem ou estão em branco.');
        }
        $this->usuarioModel->atualizarSenhaPorEmail($record['email'], $senha);
        $this->usuarioModel->marcarTokenComoUsado($record['email']);
        Redirect::redirecionarComMensagem('/login', 'success', 
        'Sua senha foi redefinida com sucesso! Faça o login.');
    }

}