<?php
require_once "../modelos/Ingreso.php";

class IngresosProduct implements IReporte
{
    public $cantidad, $data, $pdf, $V;
    private $ingreso, $rspta;

    public function __construct($id, $data)
    {

        $this->ingreso = new Ingreso();
        if (is_null($id)) {
            $this->rspta = $this->ingreso->listar();
            $this->pdf = new PDF_MC_Table();
            
        } else {
            $this->rspta = $this->ingreso->ingresocabecera($id);
            $this->rsptad = $this->ingreso->ingresodetalle($id);
            $this->pdf = new PDF_Invoice('P', 'mm', 'A4');
            $this->data = $data;
        }
    }

    public function html()
    {
        
        $this->pdf->AddPage();

        //Seteamos el inicio del margen superior en 25 pixeles 
        $y_axis_initial = 25;

        //Seteamos el tipo de letra y creamos el título de la página. No es un encabezado no se repetirá
        $this->pdf->SetFont('Arial', 'B', 12);

        $this->pdf->Cell(40, 6, '', 0, 0, 'C');
        $this->pdf->Cell(100, 6, 'LISTA DE INGRESOS', 1, 0, 'C');
        $this->pdf->Ln(10);
        
        //Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra
        $this->pdf->SetFillColor(232, 232, 232);
        $this->pdf->SetFont('Arial', 'B', 10);
        $this->pdf->Cell(21, 6, 'Fecha', 1, 0, 'C', 1);
        $this->pdf->Cell(48, 6, 'Usuario', 1, 0, 'C', 1);
        $this->pdf->Cell(51, 6, 'Proveedor', 1, 0, 'C', 1);
        $this->pdf->Cell(25, 6, 'Documento', 1, 0, 'C', 1);
        $this->pdf->Cell(20, 6, utf8_decode('Número'), 1, 0, 'C', 1);
        $this->pdf->Cell(20, 6, 'Total', 1, 0, 'C', 1);

        $this->pdf->Ln(10);

        $this->pdf->SetWidths(array(21, 48, 51, 25, 20, 20));
        while ($reg = $this->rspta->fetch_object()) {

            $fecha = $reg->fecha;
            $usuario = $reg->usuario;
            $proveedor = $reg->proveedor;
            $tipo_comprobante = $reg->tipo_comprobante;
            $num_comprobante = $reg->num_comprobante;
            $total_compra = $reg->total_compra;

            $this->pdf->SetFont('Arial', '', 10);
            $this->pdf->Row(array($fecha, utf8_decode($usuario), utf8_decode($proveedor), utf8_decode($tipo_comprobante), $num_comprobante, $total_compra));
        }

        //Mostramos el documento pdf
        $this->pdf->Output();
    }

    public function html2()
    {
        $regv = $this->rspta->fetch_object();

        $this->pdf->AddPage();

        //Enviamos los datos de la empresa al método addSociete de la clase Factura
        $this->pdf->addSociete(
            utf8_decode($this->data['empresa']),
            $this->data['documento'] . "\n" .
                utf8_decode("Dirección: ") . utf8_decode($this->data['direccion']) . "\n" .
                utf8_decode("Teléfono: ") . $this->data['telefono'] . "\n" .
                "Email : " . $this->data['email'],
            $this->data['logo'],
            $this->data['ext_logo']
        );
        $this->pdf->fact_dev("$regv->tipo_comprobante ", "$regv->serie_comprobante-$regv->num_comprobante");
        $this->pdf->temporaire("");
        $this->pdf->addDate($regv->fecha);

        //Enviamos los datos del cliente al método addClientAdresse de la clase Factura
        $this->pdf->addClientAdresse(utf8_decode($regv->proveedor), "Domicilio: " . utf8_decode($regv->direccion), $regv->tipo_documento . ": " . $regv->num_documento, "Email: " . $regv->email, "Telefono: " . $regv->telefono);

        //Establecemos las columnas que va a tener la sección donde mostramos los detalles de la venta
        $cols = array(
            "CODIGO" => 23,
            "DESCRIPCION" => 78,
            "CANTIDAD" => 22,
            "P.C." => 25,
            "P.V." => 20,
            "SUBTOTAL" => 22
        );
        $this->pdf->addCols($cols);
        $cols = array(
            "CODIGO" => "L",
            "DESCRIPCION" => "L",
            "CANTIDAD" => "C",
            "P.C." => "R",
            "P.V." => "R",
            "SUBTOTAL" => "C"
        );
        $this->pdf->addLineFormat($cols);
        $this->pdf->addLineFormat($cols);
        //Actualizamos el valor de la coordenada "y", que será la ubicación desde donde empezaremos a mostrar los datos
        $y = 89;

        //Obtenemos todos los detalles de la venta actual


        while ($regd = $this->rsptad->fetch_object()) {
            $line = array(
                "CODIGO" => "$regd->codigo",
                "DESCRIPCION" => utf8_decode("$regd->articulo"),
                "CANTIDAD" => "$regd->cantidad",
                "P.C." => "$regd->precio_compra",
                "P.V." => "$regd->precio_venta",
                "SUBTOTAL" => "$regd->subtotal"
            );
            $size = $this->pdf->addLine($y, $line);
            $y   += $size + 2;
        }

        //Convertimos el total en letras
        require_once "Letras.php";
        $V = new EnLetras();
        $con_letra = strtoupper($V->ValorEnLetras($regv->total_compra, "NUEVOS SOLES"));
        $this->pdf->addCadreTVAs("---" . $con_letra);

        //Mostramos el impuesto
        $this->pdf->addTVAs($regv->impuesto, $regv->total_compra, "S/ ");
        $this->pdf->addCadreEurosFrancs("IGV" . " $regv->impuesto %");
        $this->pdf->Output('Reporte de Venta', 'I');
    }
}
