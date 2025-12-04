<?php
namespace App\Kipedreiro\Core;
use App\Kipedreiro\Core\EmailService;

class NotificacaoEmail{
    private $emailService;
    public function __construct(){
        $this->emailService = new EmailService();
    }
    public function esqueciASenha(string $email, string $token): void {
        $assunto = "Redefinição de Senha";
        $mensagem = "Clique no link para redefinir sua senha: ";
        $mensagem .= "http://localhost:4000/backend/redefinir-senha?token=" . urlencode($token);
        $this->emailService->send($email, $assunto, $mensagem);
    }
    public function boasVindas(string $email, string $nome): void {
        $assunto = "Bem-vindo ao Kipedreiro!";
        $mensagem = "<b><h2>Olá " . htmlspecialchars($nome) . "</h2></b>,\n\n";
        $mensagem .= "<p>Obrigado por se registrar no Kipedreiro. !</p>\n\n";
        $mensagem .= "<p>Atenciosamente,\nEquipe Kipedreiro</p>";
        $this->emailService->send($email, $assunto, $mensagem);

    }

}