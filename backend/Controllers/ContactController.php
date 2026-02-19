<?php

namespace App\Kipedreiro\Controllers;

use App\Kipedreiro\Core\EmailService;

class ContactController
{
    public function send()
    {
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!$input) {
            $input = $_POST;
        }

        $nome = $input['nome'] ?? '';
        $email = $input['email'] ?? '';
        $mensagem = $input['mensagem'] ?? ''; 
        
        if (empty($nome) || empty($email)) {
            echo json_encode(['status' => false, 'message' => 'Campos obrigatórios faltando.']);
            return;
        }

            // Send email
        $emailService = new EmailService();
        
        $subject = "Novo contato pelo site: $nome";
        $body = "Nome: $nome <br>Email: $email <br>Mensagem: (Sem mensagem, formulário antigo tinha senha)";
        
        $body = "Nome: $nome <br>Email: $email";
        if (!empty($input['mensagem'])) {
            $body .= "<br>Mensagem: " . nl2br($input['mensagem']);
        }
        // Send to admin (placeholder email)
        $sent = $emailService->send('admin@kipedreiro.com', $subject, $body);

        if ($sent) {
           echo json_encode(['status' => true, 'message' => 'Mensagem enviada com sucesso!']);
        } else {
           echo json_encode(['status' => false, 'message' => 'Erro ao enviar mensagem. Tente novamente.']);
        }
    }
}
