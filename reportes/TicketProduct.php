<?php
require_once '../modelos/Venta.php';
class TicketProduct implements IReporte
{
    public $cantidad, $data, $print;
    private $id, $venta, $reg;
    public function __construct($id,$data, $print)
    {
        $this->id = $id;
        $this->venta = new Venta();
        $rspta = $this->venta->ventacabecera($id);
        $this->reg = $rspta->fetch_object();
        $this->print = $print;
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

        echo "
    <html>" . $this->print . "
<!-- codigo imprimir -->
<br>
<table border='0' align='center' width='300px'>
    <tr>
        <td align='center'>
        <!-- Mostramos los datos de la empresa en el documento HTML -->
        .::<strong>".$this->data['empresa']."</strong>::.<br>".
        $this->data['documento']."<br>
        ".$this->data['direccion']." .' - '.".$this->data['telefono']."<br>
        </td>
    </tr>
    <tr>
        <td align='center'>" . $this->reg->fecha . "</td>
    </tr>
    <tr>
      <td align='center'></td>
    </tr>
    <tr>
        <!-- Mostramos los datos del cliente en el documento HTML -->
        <td>Cliente:" . $this->reg->cliente . "</td>
    </tr>
    <tr>
        <td>" . $this->reg->tipo_documento . "': '" . $this->reg->num_documento . "</td>
    </tr>
    <tr>
        <td>Nº de venta:" . $this->reg->serie_comprobante . "' - '" . $this->reg->num_comprobante . " </td>
    </tr>
</table>
<br>
<!-- Mostramos los detalles de la venta en el documento HTML -->
<table border='0' align='center' width='300px'>
    <tr>
        <td>CANT.</td>
        <td>DESCRIPCIÓN</td>
        <td align='right'>IMPORTE</td>
    </tr>
    <tr>
      <td colspan='3'>==========================================</td>
    </tr>" . $this->registros() . "
 
    <!-- Mostramos los totales de la venta en el documento HTML -->
    <tr>
    <td>&nbsp;</td>
    <td align='right'><b>TOTAL:</b></td>
    <td align='right'><b>S/" . $this->reg->total_venta . "</b></td>
    </tr>
    <tr>
      <td colspan='3'>Nº de artículos: $this->cantidad</td>
    </tr>
    <tr>
      <td colspan='3'>&nbsp;</td>
    </tr>      
    <tr>
      <td colspan='3' align='center'>¡Gracias por su compra!</td>
    </tr>
    <tr>
      <td colspan='3' align='center'>IncanatoIT</td>
    </tr>
    <tr>
      <td colspan='3' align='center'>Chiclayo - Perú</td>
    </tr>
    
</table>
<br>
</div>
<p>&nbsp;</p>

</body>
</html>



    ";
    }
}
