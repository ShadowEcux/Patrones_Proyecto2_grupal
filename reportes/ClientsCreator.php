<?php
class ClientsCreator extends PrintReporte
{
    public function crearReporte($id): ClientsProduct
    {
        return new ClientsProduct($this->data);
    }
}