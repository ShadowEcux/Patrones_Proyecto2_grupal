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

        switch ($tipo) {
            case 'ticket':
                $reporte = new TicketCreator($array);
                $reporte->render($id);
                break;
            case 'factura':
                $reporte = new FacturaCreator($array);
                $reporte->render($id);
                break;
            case 'rptUsuarios':
                $reporte = new UsersCreator($array);
                $reporte->render();
                break;
            case 'rptVenta':
                $reporte = new VentaCreator($array);
                $reporte->render();
                break;
            case 'rptClientes':
                $reporte = new ClientsCreator($array);
                $reporte->render($id);
                break;
            case 'rptIngresos':
                $reporte = new IngresosCreator($array);
                $reporte->render($id);
                break;
            case 'rptProveedores':
                $reporte = new ProvidersCreator($array);
                $reporte->render($id);
                break;
            case 'rptArticulos':
                $reporte = new ArticulosCreator($array);
                $reporte->render($id);
                break;
            case 'rptCategorias':
                $reporte = new CategoriasCreator($array);
                $reporte->render($id);
                break;
            default:
                echo "Archivo no encontrado de tipo: {$tipo}";

                break;
        }
    }
}
