<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
class Mail{
 
protected $mail;

public function __construct()
{
    $this->mail = new PHPMailer(true);
}

public function sendEmail($to,$token)
{
    try {
        //Server settings
        $this->mail->SMTPDebug = 0;                   //Enable verbose debug output
        $this->mail->isSMTP();                                            //Send using SMTP
        $this->mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $this->mail->Username   = 'patronessabado@gmail.com';                     //SMTP username
        $this->mail->Password   = 'oognwxmlivlohdyu';                               //SMTP password
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $this->mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $this->mail->SMTPSecure = 'smtp';
        //Recipients
        $this->mail->setFrom('from@example.com', 'Mailer');
        $this->mail->addAddress($to);     //Add a recipient
        //Content
        $this->mail->isHTML(true);                                  //Set email format to HTML
        $this->mail->Subject = 'Recuperación de contraseña';
        $this->mail->Body    = 'Mensaje de Recuperacion </br>
                                <b> <a href="http://localhost/patrones/vistas/cambiar_contraseña.php?token='.$token.'">Recuperar Contraseña</a> </b>';
        $this->mail->AltBody = 'Para usuarios';
        $this->mail->CharSet = 'UTF-8';
        $this->mail->send();
        return true;
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
    }
}

}



