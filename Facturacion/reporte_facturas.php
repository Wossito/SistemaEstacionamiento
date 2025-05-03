<?php

// Include the main TCPDF library (search for installation path).
require_once('../app/templeates/TCPDF-main/tcpdf.php');
include('../app/config.php');


//cargar el encabezado
$query_informacions = $pdo->prepare("SELECT * FROM tb_informaciones WHERE estado = '1' ");
$query_informacions->execute();
$informacions = $query_informacions->fetchAll(PDO::FETCH_ASSOC);
foreach($informacions as $informacion){
    $id_informacion = $informacion['id_informacion'];
    $nombre_parqueo = $informacion['nombre_estacionamiento'];
    $actividad_empresa = $informacion['actividad_empresa'];
    $sucursal = $informacion['sucursal'];
    $direccion = $informacion['direccion'];
    $zona = $informacion['zona'];
    $telefono = $informacion['telefono'];
    $departamento_ciudad = $informacion['ciudad'];
    $pais = $informacion['pais'];
}


// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor('Josue Felipe');
$pdf->setTitle('REPORTE FACTURAS');
$pdf->setSubject('TCPDF Tutorial');
$pdf->setKeywords('TCPDF, PDF, example, test, guide');

$PDF_HEADER_TITLE = $nombre_parqueo;
$PDF_HEADER_STRING = $direccion.' Telf: '.$telefono;
$PDF_HEADER_LOGO = 'carro2.png';
// set default header data
$pdf->setHeaderData($PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $PDF_HEADER_TITLE, $PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->setMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->setHeaderMargin(PDF_MARGIN_HEADER);
$pdf->setFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->setFont('Helvetica', '', 11);

// add a page
$pdf->AddPage();

// create some HTML content
$html = '
<P><b>Reporte del Listado de Facturas</b></P>
<table border="1" cellpadding="4" style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif;">
    <tr>
        <td style="background-color: #4CAF50; color: white; text-align: center; font-weight: bold; padding: 12px; width: 40px;">Nro</td>
        <td style="background-color: #4CAF50; color: white; text-align: center; font-weight: bold; padding: 12px; width: 80;">Nro Factura</td>
        <td style="background-color: #4CAF50; color: white; text-align: center; font-weight: bold; padding: 12px; width: 100px;">Usuario</td>
        <td style="background-color: #4CAF50; color: white; text-align: center; font-weight: bold; padding: 12px; width: 150px;">Fecha Factura</td>
        <td style="background-color: #4CAF50; color: white; text-align: center; font-weight: bold; padding: 12px; width: 100px;">Hora Factura</td>
        <td style="background-color: #4CAF50; color: white; text-align: center; font-weight: bold; padding: 12px;">DNI Cliente</td>
        <td style="background-color: #4CAF50; color: white; text-align: center; font-weight: bold; padding: 12px;">Nombre</td>
    </tr>
    
';

$contador = 0;
$query_factura = $pdo->prepare("
SELECT 
fa.id_facturacion, fa.nro_factura, fa.fecha_factura, fa.fecha_salida, fa.hora_salida, fa.tiempo, fa.tiempo, fa.detalle, fa.qr,
t.fecha_ingreso, t.hora_ingreso,
i.nombre_estacionamiento, i.actividad_empresa, i.sucursal, i.direccion, i.zona, i.telefono, i.ciudad, i.pais,
cl.dni_cliente, cl.nombre_cliente, cl.cargo_cliente,
au.placa_auto, au.marca_auto,
us.nombres,
m.nro_espacio
FROM tb_facturaciones fa
INNER JOIN tb_tickets t ON t.id_ticket = fa.id_ticket
INNER JOIN tb_mapeos m ON fa.id_map = m.id_map
INNER JOIN tb_usuarios us ON fa.id_usuario = us.id_usuario
INNER JOIN tb_informaciones i ON fa.id_informacion = i.id_informacion
INNER JOIN tb_clientes cl ON fa.id_cliente = cl.id_cliente
INNER JOIN tb_autos au ON cl.id_auto = au.id_auto;
");
$query_factura->execute();
$facturas = $query_factura->fetchAll(PDO::FETCH_ASSOC);

foreach($facturas as $factura){

    $nro_factura = $factura['nro_factura'];
    $fecha_factura = $factura['fecha_factura'];
    $fecha_salida = $factura['fecha_salida'];
    $hora_salida = $factura['hora_salida'];

    // Datos del cliente
    $nombre_cliente = $factura['nombre_cliente'];
    $dni_cliente = $factura['dni_cliente'];


    // Datos del usuario
    $nombre_usuario = $factura['nombres'];
    $contador ++;


    $html .= '
    <tr>
    <td style="text-align: center">'.$contador.'</td>
    <td style="text-align: center">'.$nro_factura.'</td>
    <td style="text-align: center">'.$nombre_usuario.'</td>
    <td style="text-align: center">'.$fecha_factura.'</td>
    <td style="text-align: center">'.$hora_salida.'</td>
    <td style="text-align: center">'.$dni_cliente.'</td>
    <td style="text-align: center">'.$nombre_cliente.'</td>
    </tr>
    ';
}
$html.='
</table>
';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

//Close and output PDF document
$pdf->Output('example_004.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+