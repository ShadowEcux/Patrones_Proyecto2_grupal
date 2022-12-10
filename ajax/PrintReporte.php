<?php
abstract class PrintReporte
{
    protected $data;
    public function __construct($array)
    {
        $this->data['empresa'] = $array['empresa'];
        $this->data['documento'] = $array['documento'];
        $this->data['direccion'] = $array['direccion'];
        $this->data['telefono'] = $array['telefono'];
        $this->data['email'] = $array['email'];
        $this->data['logo'] = $array['logo'];
        $this->data['ext_logo'] = $array['ext_logo'];
    }

    abstract public function crearReporte($id):IReporte;

    public function render($id=null):void
    {
        $reporte = $this->crearReporte($id);
        $reporte->html();
    }
}
