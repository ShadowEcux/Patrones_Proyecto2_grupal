<?php
require('../fpdf181/fpdf.php');
require('../reportes/Factura.php');
require('../reportes/PDF_MC_Table.php');
require('../ajax/interfaces/IReporte.php');
require('../ajax/PrintReporte.php');
require('../reportes/TicketProduct.php');
require('../reportes/FacturaProduct.php');
require('../reportes/VentaProduct.php');
require('../reportes/ProvidersProduct.php');
require('../reportes/UsersProduct.php');
require('../reportes/ClientsProduct.php');
require('../reportes/IngresosProduct.php');
require('../reportes/ArticulosProduct.php');
require('../reportes/CategoriasProduct.php');

class ReporteFactory
{
    public static function crearReporte($tipo, $id, $array)
    {
        try {
        $reporte = match ($tipo) {
            'ticket' => new TicketCreator($array),
            'factura' => new FacturaCreator($array),
            'rptUsuarios' => new UsersCreator($array),
            'rptVenta' => new VentaCreator($array),
            'rptClientes' => new ClientsCreator($array),
            'rptIngresos' => new IngresosCreator($array),
            'rptProveedores' => new ProvidersCreator($array),
            'rptArticulos' => new ArticulosCreator($array),
            'rptCategorias' => new CategoriasCreator($array),
            default => throw new InvalidArgumentException("Archivo no encontrado de tipo: {$tipo}")
        };
            $reporte->render($id);
        } catch (InvalidArgumentException $e) {
            echo 'Mensaje: ' . $e->getMessage();
        }
    }
}
