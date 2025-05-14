<?php
require 'vendor/autoload.php';  // Carrega todas as dependências

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$mail->Username = $_ENV['EMAIL_USER'];
$mail->Password = $_ENV['EMAIL_PASS'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function enviarEmail($para, $assunto, $mensagemHtml) {
    $mail = new PHPMailer(true);

    try {

        $mail->SMTPDebug = 2;
        $mail->Debugoutput = 'html';


        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // ou outro serviço
        $mail->SMTPAuth = true; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';

        $mail->setFrom('a.eletrica18@gmail.com', 'Auto Elétrica');
        $mail->addAddress($para);

        $mail->isHTML(true);
        $mail->Subject = $assunto;
        $mail->Body    = $mensagemHtml;

        $mail->send();
        echo "E-mail envido com sucesso";
    } catch (Exception $e) {
        echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
        return false;
    }
}
/*
$destino = "bruno.cruz9653@gmail.com";
$assunto = "Serviço finalizado";
$mensagem = "<h2>Serviço Finalizado</h2>
                <p>O serviço solicitado já foi finalizado.</p>
                <p>Por gentileza, compareça até a auto elétrica para verificação.</p>
                <p></p>";
enviarEmail($destino, $assunto, $mensagem)
?>*/
