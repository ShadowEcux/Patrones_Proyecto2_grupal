<?php

use BaseHandler as GlobalBaseHandler;

require('../ajax/interfaces/IHandler.php');
class BaseHandler  implements IHandler
{
    private $next;

    
    public function setNext(BaseHandler $next)
    {
        $this->next = $next;

        return $next->handle();
    }
    public function handle():bool
    {
        if (!$this->next) {
            return true;
        }

        return false;
    }


}
