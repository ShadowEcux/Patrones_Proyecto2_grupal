<?php
class ProvidersCreator extends PrintReporte
{
    public function crearReporte($id): ProvidersProduct
    {
        return new ProvidersProduct($id, $this->data);
    }
}