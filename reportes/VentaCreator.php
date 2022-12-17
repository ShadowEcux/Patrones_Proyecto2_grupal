<?php
class VentaCreator extends PrintReporte
{
    public function crearReporte($id): VentaProduct
    {
        return new VentaProduct($this->data);
    }
}