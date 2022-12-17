<?php
class IngresosCreator extends PrintReporte
{
    public function crearReporte($id): IngresosProduct
    {
        return new IngresosProduct($id,$this->data);
    }

    public function render($id = null): void
    {
        $reporte = $this->crearReporte($id);
        if (is_null($id)) {
            $reporte->html(); 
        }
        else {
            $reporte->html2();  
        }
    }
}