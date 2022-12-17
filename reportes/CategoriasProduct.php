<?php
require_once '../modelos/Categoria.php';

class CategoriasProduct implements IReporte
{
    public $cantidad, $data, $pdf, $V;
    private $categoria, $rspta;

    public function __construct($data)
    {
        $this->categoria = new Categoria();
        $this->rspta = $this->categoria->listar();
        $this->pdf = new PDF_MC_Table();
    }

    public function html()
    {
        $this->pdf->AddPage();

        //Seteamos el inicio del margen superior en 25 pixeles 
        $y_axis_initial = 25;

        //Seteamos el tipo de letra y creamos el título de la página. No es un encabezado no se repetirá
        $this->pdf->SetFont('Arial', 'B', 12);

        $this->pdf->Cell(40, 6, '', 0, 0, 'C');
        $this->pdf->Cell(100, 6, 'LISTA DE CATEGORIAS', 1, 0, 'C');
        $this->pdf->Ln(10);

        //Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra
        $this->pdf->SetFillColor(232, 232, 232);
        $this->pdf->SetFont('Arial', 'B', 10);
        $this->pdf->Cell(70, 6, 'Nombre', 1, 0, 'C', 1);
        $this->pdf->Cell(115, 6, utf8_decode('Descripción'), 1, 0, 'C', 1);


        $this->pdf->Ln(10);

        $this->pdf->SetWidths(array(70, 115));
        while ($reg = $this->rspta->fetch_object()) {
            $nombre = $reg->nombre;
            $descripcion = $reg->descripcion;

            $this->pdf->SetFont('Arial', '', 10);
            $this->pdf->Row(array(utf8_decode($nombre), utf8_decode($descripcion)));
        }

        //Mostramos el documento pdf
        $this->pdf->Output();
    }
}
