<?php
class PermissionHandler extends BaseHandler
{
    private $permission;
    public function __construct($permission) {
        $this->permission = $permission;
    }
    public function handle(): bool
    {
        if ($_SESSION[$this->permission]!=1) {
            header("Location: noacceso.php");
        }
        return true;
    }

}