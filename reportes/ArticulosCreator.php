<?php
class ArticulosCreator extends PrintReporte
{
    public function crearReporte($id): ArticulosProduct
    {
        return new ArticulosProduct($this->data);
    }
}