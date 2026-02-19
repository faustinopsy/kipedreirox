<?php
namespace App\Kipedreiro\Core;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\Kipedreiro\Config\Mail;

class EmailService{
    private PHPMailer $mailer;
    private array $config;
    public function __construct(){
        $this->config = Mail::get();
        $this->mailer = new PHPMailer(true); 
        $this->configure();
    }

    private function configure(): void{
        // $this->mailer->SMTPDebug = SMTP::DEBUG_SERVER;
        $this->mailer->isSMTP();
        $this->mailer->Host       = $this->config['host'];
        $this->mailer->SMTPAuth   = ($this->config['username'] !== null);
        $this->mailer->Username   = $this->config['username'];
        $this->mailer->Password   = $this->config['password'];
        $this->mailer->SMTPSecure = $this->config['encryption'];
        $this->mailer->Port       = $this->config['port'];
        $this->mailer->CharSet    = PHPMailer::CHARSET_UTF8;
    }
                            //destino      assunto        mensagem
    public function send(string $to, string $subject, string $message): bool{
        try {
            $this->mailer->setFrom($this->config['from_address'], $this->config['from_name']);
            $this->mailer->addAddress($to);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = $subject;
            $this->mailer->Body    = $message;
            $this->mailer->AltBody = strip_tags($message);
            return $this->mailer->send();

        } catch (Exception $e) {
            return false;
        }
    }
}
