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
        $this->mail = new PHPMailer();
        //Server settings
        // $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $this->mail->isSMTP();                                            //Send using SMTP
        $this->mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $this->mail->Username   = 'jllalli0919@gmail.com';                     //SMTP username
        $this->mail->Password   = 'rxufpfwrzrvwsuhb';                               //SMTP password
        $this->mail->SMTPSecure = 'tls';                                  //Enable implicit TS;            //Enable implicit TLS encryption
        $this->mail->Port       = 587;
    }


    public function metEnviar(string $titulo, string $nombre, string $correo, string $asunto, string $bodyHTML)
    {
        try {
            $this->mail->setFrom("jllalli0919@gmail.com", $titulo);
            $this->mail->addAddress($correo, $nombre);
            $this->mail->Subject = $asunto;
            $this->mail->Body = $bodyHTML;
            $this->mail->isHTML(true);
            $this->mail->CharSet = "UTF-8";
            $this->mail->send();

            return  'Email enviado';

        } catch (Exception $e) {
            echo "Error al enviar email: $e";
        }
    }
}
