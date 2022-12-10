<?php
require_once "../modelos/Usuario.php";
        $usuario = new Usuario();

class UsersProduct implements IReporte
{
    public $cantidad, $data, $pdf, $V;
    private $usuario;

    public function __construct($data)
    {
        $this->usuario = new Usuario();
        $this->rspta = $this->usuario->listar();
        $this->pdf = new PDF_MC_Table();
        $this->data = $data;
    }

    public function html()
    {
        //Agregamos la primera página al documento pdf
        $this->pdf->AddPage();

        //Seteamos el inicio del margen superior en 25 pixeles 
        $y_axis_initial = 25;

        //Seteamos el tipo de letra y creamos el título de la página. No es un encabezado no se repetirá
        $this->pdf->SetFont('Arial', 'B', 12);
        $this->pdf->Cell(40, 6, '', 0, 0, 'C');
        $this->pdf->Cell(100, 6, 'LISTA DE USUARIOS', 1, 0, 'C');
        $this->pdf->Ln(10);

        //Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra
        $this->pdf->SetFillColor(232, 232, 232);
        $this->pdf->SetFont('Arial', 'B', 10);
        $this->pdf->Cell(40, 6, 'Nombre', 1, 0, 'C', 1);
        $this->pdf->Cell(20, 6, 'Documento', 1, 0, 'C', 1);
        $this->pdf->Cell(22, 6, utf8_decode('Número'), 1, 0, 'C', 1);
        $this->pdf->Cell(25, 6, utf8_decode('Teléfono'), 1, 0, 'C', 1);
        $this->pdf->Cell(46, 6, 'Email', 1, 0, 'C', 1);
        $this->pdf->Cell(32, 6, utf8_decode('Login'), 1, 0, 'C', 1);

        $this->pdf->Ln(10);

        //Table with rows and columns
        $this->pdf->SetWidths(array(40, 20, 22, 25, 46, 32));

        while ($reg = $this->rspta->fetch_object()) {
            $nombre = $reg->nombre;
            $tipo_documento = $reg->tipo_documento;
            $num_documento = $reg->num_documento;
            $telefono = $reg->telefono;
            $email = $reg->email;
            $login = $reg->login;

            $this->pdf->SetFont('Arial', '', 10);
            $this->pdf->Row(array(utf8_decode($nombre), $tipo_documento, $num_documento, $telefono, $email, utf8_decode($login)));
        }

        //Mostramos el documento pdf
        $this->pdf->Output();
    }
}
