<?php
require_once('../modelos/Usuario.php');
require_once('../mail/mail.php');

if ($email = $_POST['email']) {
     
    $usuario = new Usuario();
    $res = $usuario->recuperar($email);
    $fetch=$res->fetch_object();
    if ($fetch) {
        $token = rand(1, 9999);
        $mail = new Mail();
        $res = $mail->sendEmail($email, $token);
        // setcookie('token',0,0);
        setcookie('token',$token,time()+3600,  '/');
        setcookie('user',$fetch->idusuario,time()+3600,  '/');
        if ($res) {
            header('Location: ../ajax/index.php');
        }
        else {
            echo "Ha ocurrido algo mal..";
        }
    }
}
else{
    header('Location:' . getenv('HTTP_REFERER'));
}