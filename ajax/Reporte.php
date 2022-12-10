<?php
require('../ajax/ReporteFactory.php');
require('../reportes/TicketCreator.php');
require('../reportes/FacturaCreator.php');
require('../reportes/VentaCreator.php');
require('../reportes/ProvidersCreator.php');
require('../reportes/UsersCreator.php');
require('../reportes/ClientsCreator.php');
require('../reportes/IngresosCreator.php');
require('../reportes/ArticulosCreator.php');
require('../reportes/CategoriasCreator.php');

$empresa = 'Soluciones Innovadoras Perú S.A.C.';
$documento = '20477157772';
$direccion = 'Chongoyape, José Gálvez 1368';
$telefono = '931742904';
$email = 'jcarlos.ad7@gmail.com';
$logo = "../reportes/logo.jpg";
$ext_logo = "jpg";
$array = [
    'empresa'=>$empresa,
    'documento' => $documento,
    'direccion' => $direccion,
    'telefono' => $telefono,
    'email' => $email,
    'logo' => $logo,
    'ext_logo' => $ext_logo
];
$tipo = $_GET['tipo'];
$id = $_GET['id']??null;
ReporteFactory::crearReporte($tipo, $id, $array);
