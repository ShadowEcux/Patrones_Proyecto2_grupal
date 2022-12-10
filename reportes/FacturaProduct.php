<?php
require_once '../modelos/Venta.php';
require_once "Letras.php";
class FacturaProduct implements IReporte
{
    public $cantidad, $data, $pdf, $V;
    private $id, $venta, $reg;

    public function __construct($id, $data)
    {
        $this->id = $id;
        $this->venta = new Venta();
        $rspta = $this->venta->ventacabecera($id);
        $this->reg = $rspta->fetch_object();
        $this->pdf = new PDF_Invoice('P', 'mm', 'A4');
        $this->V = new EnLetras();
        $this->data = $data;
    }

    public function registros()
    {
        $html = '';
        $rsptad = $this->venta->ventadetalle($this->id);
        while ($regd = $rsptad->fetch_object()) {
            $html .= "<tr>
        <td>$regd->cantidad</td>
        <td>$regd->articulo
        <td align='right'>S/$regd->subtotal</td>
        </tr>";
            $this->cantidad += $regd->cantidad;
        }
        return $html;
    }



    public function html()
    {
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
        $this->pdf->fact_dev((int)$this->reg->tipo_comprobante, (int)$this->reg->serie_comprobante - (int)$this->reg->num_comprobante);
        $this->pdf->temporaire("");
        $this->pdf->addDate($this->reg->fecha);

        //Enviamos los datos del cliente al método addClientAdresse de la clase Factura
        $this->pdf->addClientAdresse(utf8_decode($this->reg->cliente), "Domicilio: " . utf8_decode($this->reg->direccion), $this->reg->tipo_documento . ": " . $this->reg->num_documento, "Email: " . $this->reg->email, "Telefono: " . $this->reg->telefono);

        //Establecemos las columnas que va a tener la sección donde mostramos los detalles de la venta
        $cols = array(
            "CODIGO" => 23,
            "DESCRIPCION" => 78,
            "CANTIDAD" => 22,
            "P.U." => 25,
            "DSCTO" => 20,
            "SUBTOTAL" => 22
        );
        $this->pdf->addCols($cols);
        $cols = array(
            "CODIGO" => "L",
            "DESCRIPCION" => "L",
            "CANTIDAD" => "C",
            "P.U." => "R",
            "DSCTO" => "R",
            "SUBTOTAL" => "C"
        );
        $this->pdf->addLineFormat($cols);
        $this->pdf->addLineFormat($cols);
        //Actualizamos el valor de la coordenada "y", que será la ubicación desde donde empezaremos a mostrar los datos
        $y = 89;

        //Obtenemos todos los detalles de la venta actual
        $rsptad = $this->venta->ventadetalle($_GET["id"]);

        while ($regd = $rsptad->fetch_object()) {
            $line = array(
                "CODIGO" => "$regd->codigo",
                "DESCRIPCION" => utf8_decode("$regd->articulo"),
                "CANTIDAD" => "$regd->cantidad",
                "P.U." => "$regd->precio_venta",
                "DSCTO" => "$regd->descuento",
                "SUBTOTAL" => "$regd->subtotal"
            );
            $size = $this->pdf->addLine($y, $line);
            $y   += $size + 2;
        }
        $con_letra=strtoupper($this->V->ValorEnLetras($this->reg->total_venta,"NUEVOS SOLES"));
        $this->pdf->addCadreTVAs("---".$con_letra);
        
        //Mostramos el impuesto
        $this->pdf->addTVAs( $this->reg->impuesto, $this->reg->total_venta,"S/ ");
        $this->pdf->addCadreEurosFrancs("IGV". $this->reg->impuesto." %");
        $this->pdf->Output('Reporte de Venta','I');
    }
}
