<?php
require_once '../modelos/Venta.php';

class VentaProduct implements IReporte
{
    public $cantidad, $data, $pdf, $V;
    private $venta, $rspta;

    public function __construct($data)
    {
        $this->venta = new Venta();
        $this->rspta = $this->venta->listar();
        $this->pdf = new PDF_MC_Table();
        $this->data = $data;
    }

    public function html()
    {
        $this->pdf->AddPage();

        //Seteamos el inicio del margen superior en 25 pixeles 
        $y_axis_initial = 25;

        //Seteamos el tipo de letra y creamos el título de la página. No es un encabezado no se repetirá
        $this->pdf->SetFont('Arial', 'B', 12);

        $this->pdf->Cell(40, 6, '', 0, 0, 'C');
        $this->pdf->Cell(100, 6, 'LISTA DE VENTAS', 1, 0, 'C');
        $this->pdf->Ln(10);

        //Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra
        $this->pdf->SetFillColor(232, 232, 232);
        $this->pdf->SetFont('Arial', 'B', 10);
        $this->pdf->Cell(21, 6, 'Fecha', 1, 0, 'C', 1);
        $this->pdf->Cell(48, 6, 'Usuario', 1, 0, 'C', 1);
        $this->pdf->Cell(51, 6, 'Cliente', 1, 0, 'C', 1);
        $this->pdf->Cell(25, 6, 'Documento', 1, 0, 'C', 1);
        $this->pdf->Cell(20, 6, utf8_decode('Número'), 1, 0, 'C', 1);
        $this->pdf->Cell(20, 6, 'Total', 1, 0, 'C', 1);

        $this->pdf->Ln(10);

        $this->pdf->SetWidths(array(21, 48, 51, 25, 20, 20));
        while ($reg = $this->rspta->fetch_object()) {
            $fecha = $reg->fecha;
            $usuario = $reg->usuario;
            $cliente = $reg->cliente;
            $tipo_comprobante = $reg->tipo_comprobante;
            $num_comprobante = $reg->num_comprobante;
            $total_venta = $reg->total_venta;

            $this->pdf->SetFont('Arial', '', 10);
            $this->pdf->Row(array($fecha, utf8_decode($usuario), utf8_decode($cliente), $tipo_comprobante, $num_comprobante, $total_venta));
        }

        //Mostramos el documento pdf
        $this->pdf->Output();
    }
}
