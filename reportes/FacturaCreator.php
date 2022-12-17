<?php
class FacturaCreator extends PrintReporte
{
    public function crearReporte($id): FacturaProduct
    {
        return new FacturaProduct($id, $this->data);
    }
}