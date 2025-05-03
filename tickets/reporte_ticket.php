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
$pdf->setTitle('REPORTE TICKET');
$pdf->setSubject('TCPDF Tutorial');
$pdf->setKeywords('TCPDF, PDF, example, test, guide');

$PDF_HEADER_TITLE = $nombre_parqueo;
$PDF_HEADER_STRING = $direccion.' Telf: '.$telefono;
$PDF_HEADER_LOGO = 'carro2-removebg-preview.png';
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
<P><b>Reporte del Listado de Tickets</b></P>
<table border="1" cellpadding="4" style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif;">
    <tr>
        <td style="background-color: #4CAF50; color: white; text-align: center; font-weight: bold; padding: 12px; width: 50px;">Nro Ticket</td>
        <td style="background-color: #4CAF50; color: white; text-align: center; font-weight: bold; padding: 12px; width: 100px;">Usuario</td>
        <td style="background-color: #4CAF50; color: white; text-align: center; font-weight: bold; padding: 12px; width: 100px;">Fecha Ingreso</td>
        <td style="background-color: #4CAF50; color: white; text-align: center; font-weight: bold; padding: 12px; width: 100px;">Hora Ingreso</td>
        <td style="background-color: #4CAF50; color: white; text-align: center; font-weight: bold; padding: 12px; width: 100px;">Estado Ticket</td>
        <td style="background-color: #4CAF50; color: white; text-align: center; font-weight: bold; padding: 12px;">DNI</td>
        <td style="background-color: #4CAF50; color: white; text-align: center; font-weight: bold; padding: 12px;">Nombre</td>
    </tr>
    
';

$contador = 0;
$query_ticket = $pdo->prepare("
        SELECT 
    t.id_ticket, t.fecha_ingreso, t.hora_ingreso, t.estado_ticket,
    i.nombre_estacionamiento, i.actividad_empresa, i.sucursal, i.direccion, i.zona, i.telefono, i.ciudad, i.pais,
    cl.dni_cliente, cl.nombre_cliente, cl.cargo_cliente,
    au.placa_auto, au.marca_auto,
    us.nombres,
    m.nro_espacio
    FROM tb_tickets t
    INNER JOIN tb_mapeos m ON m.id_map = t.id_map
    INNER JOIN tb_usuarios us ON us.id_usuario = t.id_usuario
    INNER JOIN tb_informaciones i ON t.id_informacion = i.id_informacion
    INNER JOIN tb_clientes cl ON t.id_cliente = cl.id_cliente
    INNER JOIN tb_autos au ON cl.id_auto = au.id_auto
    ORDER BY t.id_ticket asc ;
    ");
$query_ticket->execute();
$tickets = $query_ticket->fetchAll(PDO::FETCH_ASSOC);

foreach($tickets as $ticket){
    
    $id_ticket = $ticket['id_ticket'];
    $fecha_ingreso = $ticket['fecha_ingreso'];
    $hora_ingreso = $ticket['hora_ingreso'];
    $estado_ticket = $ticket['estado_ticket'];

    // Datos del cliente
    $nombre_cliente = $ticket['nombre_cliente'];
    $dni_cliente = $ticket['dni_cliente'];


    // Datos del usuario
    $nombre_usuario = $ticket['nombres'];

    $fecha_ingreso = date("Y-m-d");

    $html .= '
    <tr>
    <td style="text-align: center">'.$id_ticket.'</td>
    <td style="text-align: center">'.$nombre_usuario.'</td>
    <td style="text-align: center">'.$fecha_ingreso.'</td>
    <td style="text-align: center">'.$hora_ingreso.'</td>
    <td style="text-align: center">'.$estado_ticket.'</td>
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