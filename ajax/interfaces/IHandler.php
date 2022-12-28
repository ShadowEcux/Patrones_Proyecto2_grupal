<?php

interface IHandler{

    public function setNext(BaseHandler $next);
    public function handle();
    
}