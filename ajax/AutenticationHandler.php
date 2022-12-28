<?php
class AutenticationHandler extends BaseHandler
{
    public function handle(): bool
    {   
        session_start();
        if (!isset($_SESSION["nombre"])) {
            return header("Location: ../vistas/login.html");
        }
        return true;
    }
}
