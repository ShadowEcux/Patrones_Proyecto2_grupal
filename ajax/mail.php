<?php
require_once('../modelos/Usuario.php');
require_once('../mail/mail.php');

if ($email = $_POST['email']) {
     
    $usuario = new Usuario();
    $res = $usuario->recuperar($email);
    $fetch=$res->fetch_object();
    if ($fetch) {
        $token = rand(0,9999);
        $mail = new Mail();
        $res = $mail->sendEmail($email, $token);
        if ($res) {
            echo "mensaje enviado";
        }
        // setcookie('token',$token,time()+360);
    }
}
else{
    header('Location:' . getenv('HTTP_REFERER'));
}