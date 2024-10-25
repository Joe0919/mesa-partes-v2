<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class clsMail
{
    private $mail = null;

    function __construct()
    {
        $this->mail = new PHPMailer(true); 
        $this->mail->isSMTP();
        $this->mail->SMTPAuth = true;
        $this->mail->SMTPSecure = 'tls';
        $this->mail->Host = $_ENV['SMTP_HOST'];
        $this->mail->Port = $_ENV['SMTP_PORT'];
        $this->mail->Username = $_ENV['SMTP_USERNAME'];
        $this->mail->Password = $_ENV['SMTP_PASSWORD']; 
    }

    public function metEnviar(string $titulo, string $nombre, string $correo, string $asunto, string $body)
    {
        try {

            $bodyHTML = $this->cargarPlantilla($body);

            $this->mail->setFrom($_ENV['SMTP_USERNAME'], $titulo); 
            $this->mail->addAddress($correo, $nombre);
            $this->mail->Subject = $asunto;
            $this->mail->Body = $bodyHTML;
            $this->mail->isHTML(true);
            $this->mail->CharSet = "UTF-8";

            return $this->mail->send();
        } catch (Exception $e) {
            echo "Error al enviar el correo: {$this->mail->ErrorInfo}";
            return "Error al enviar el correo: {$this->mail->ErrorInfo}";
        }
    }

    private function cargarPlantilla($body)
    {
        $plantilla = file_get_contents(URL . '/public/templates/bodyHtml.html');

        // Reemplazar marcadores de posición
        $plantilla = str_replace('{ cuerpo }', $body, $plantilla); // Reemplaza el marcador con el contenido del cuerpo

        return $plantilla;
    }
}
