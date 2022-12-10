<?php
class CategoriasCreator extends PrintReporte
{
    public function crearReporte($id): CategoriasProduct
    {
        return new CategoriasProduct($this->data);
    }
}