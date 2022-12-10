<?php
class UsersCreator extends PrintReporte
{
    public function crearReporte($id): UsersProduct
    {
        return new UsersProduct($this->data);
    }
}