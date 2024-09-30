<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

class clsMail
{
    private $mail = null;

    function __construct()
    {
        $this->mail = new PHPMailer(true); 
        $this->mail->isSMTP();
        $this->mail->SMTPAuth = true;
        $this->mail->SMTPSecure = 'tls';
        $this->mail->Host = "smtp.gmail.com";
        $this->mail->Port = 587;
        $this->mail->Username = "jllalli0919@gmail.com";
        $this->mail->Password = "ummhgsjknnuogmcw"; 
    }

    public function metEnviar(string $titulo, string $nombre, string $correo, string $asunto, string $body)
    {
        try {

            $bodyHTML = $this->cargarPlantilla($body);

            $this->mail->setFrom("jllalli0919@gmail.com", $titulo); 
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
