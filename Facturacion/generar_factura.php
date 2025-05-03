<?php
// Include the main TCPDF library (search for installation path).
error_reporting(0);
ob_start();
require_once('../app/templeates/TCPDF-main/tcpdf.php');
include('../app/config.php');


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
    INNER JOIN tb_autos au ON cl.id_auto = au.id_auto
    ORDER BY fa.id_facturacion DESC
    LIMIT 1;
");

$query_factura->execute();
$facturas = $query_factura->fetchAll(PDO::FETCH_ASSOC);

// Iterar sobre los resultados para procesarlos
foreach($facturas as $factura){

    $nro_factura = $factura['nro_factura'];
    $fecha_factura = $factura['fecha_factura'];
    $fecha_salida = $factura['fecha_salida'];
    $hora_salida = $factura['hora_salida'];
    $tiempo = $factura['tiempo'];
    $detalle = $factura['detalle'];
    $qr = $factura['qr'];


    $id_facturacion = $factura['id_facturacion'];
    $id_ticket = $factura['id_ticket'];
    $id_informacion = $factura['id_informacion'];
    $id_map = $factura['id_map'];
    $id_cliente = $factura['id_cliente'];
    $id_usuario = $factura['id_usuario'];
    $fecha_ingreso = $factura['fecha_ingreso'];
    $hora_ingreso = $factura['hora_ingreso'];

    // Datos de estacionamiento
    $nombre_estacionamiento = $factura['nombre_estacionamiento'];
    $actividad_empresa = $factura['actividad_empresa'];
    $sucursal = $factura['sucursal'];
    $direccion = $factura['direccion'];
    $zona = $factura['zona'];
    $telefono = $factura['telefono'];
    $ciudad = $factura['ciudad'];
    $pais = $factura['pais'];

    // Datos del cliente
    $nombre_cliente = $factura['nombre_cliente'];
    $dni_cliente = $factura['dni_cliente'];
    $cargo_cliente = $factura['cargo_cliente'];

    // Datos del auto
    $placa_auto = $factura['placa_auto'];
    $marca_auto = $factura['marca_auto'];

    // Datos del usuario
    $nombre_usuario = $factura['nombres'];

    // Datos del espacio
    $nro_espacio = $factura['nro_espacio'];

    // Datos del Ticket
    $fecha_ingreso = $factura['fecha_ingreso'];
    $hora_ingreso = $factura['hora_ingreso'];
}

$fecha_ingreso = date("Y-m-d");


// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(79,141.5), true, 'UTF-8', false);

// set document information
$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor('Sistema de parqueo');
$pdf->setTitle('Factura Parking');
$pdf->setSubject('Factura Parking');
$pdf->setKeywords('TCPDF, PDF, example, test, guide');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->setMargins(5, 5, 5);

// set auto page breaks
$pdf->setAutoPageBreak(true, 5);


// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->setFont('Helvetica', '', 7);

// add a page
$pdf->AddPage();




// create some HTML content
$html = '

<div style="font-family: monospace; font-size: 8px; margin: 0 auto; padding: 0; border: 1px solid #000;"><br>
    
    <table style="width: 100%; border-collapse: collapse;"><br>
        
        <tr>
            <td style="width: 60%; padding: 5px; text-align: center;">
                <b style="font-size: 28px;">' . $nombre_estacionamiento . '</b>
            </td>
            <td style="width: 40%; padding: 5px; text-align: right;">  
            </td>
           
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; padding: 5px 0;">********************************************</td><br>
            <td style="width: 100%; padding: 5px; text-align: center;"><br><br>
                <b style="font-size: 13px;">' . $actividad_empresa . '</b><br>
                <b>Dirección: </b>' . $direccion . ' - ' . $sucursal . '<br>
                <b>Ubicacion: </b>' . $ciudad . ', ' . $pais . ' - ' . $zona . '<br>
                <b>Teléfono:</b> ' . $telefono . '<br>
            </td>
            <td style="width: 0%; padding: 5px; text-align: right;">
                <img src="car_icon.png" width="60" height="40" alt="Icono de Auto">
            </td>
        </tr>

        
        <tr>
            <td colspan="2" style="text-align: right; padding: 5px 0;">********************************************</td>
        </tr><br>

        <!-- Fila de datos del cliente, datos de salida y usuario en una sola sección -->
        <tr>
            <td colspan="2" style="padding: 5px;">
                <b>DATOS DEL CLIENTE</b><br>
                <b>Persona:</b> ' . $nombre_cliente . '<br>
                <b>Cargo:</b> ' . $cargo_cliente . ' <b>DNI:</b> ' . $dni_cliente . '<br>
                <b>Placa:</b> ' . $placa_auto . ' <b>Marca:</b> ' . $marca_auto . '<br>
                       
        <tr>
            <td colspan="2" style="text-align: right; padding: 5px 0;">**********************************************</td>
        </tr><br>

                <b>DATOS DE FACTURA NRO: </b>'.$nro_factura.'<br>
                <b>Cúbiculo de estacionamiento:</b> ' . $nro_espacio . '<br> 
                <b>Fecha Factura: </b>'.$fecha_factura.'<br>
                <b>De:</b> '. $fecha_ingreso .  '    <b>Hora: </b>' . $hora_ingreso . '<br> 
                <b>A:</b> '. $fecha_salida .  '    <b>Hora: </b>' . $hora_salida . '<br><br>
                <b>Tiempo: </b>'. $tiempo . '<br>
          <tr>
            <td colspan="2" style="text-align: right; padding: 5px 0;">**********************************************</td>
        </tr><br>
                <b style="text-align: right">USUARIO:</b> ' . $nombre_usuario . '<br>
             <tr>
            <td colspan="2" style="text-align: right; padding: 5px 0;">**********************************************</td><br>
        </tr><br><br><br><br><br><br><br><br><br>
                <br><b style="text-align: center; font-size: 10px">  ¡Gracias por su preferencia!</b>
            </td>
        </tr>

    </table>

</div>
';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->SetAlpha(0.1); // Establece la transparencia al 50%
$pdf->Image('../public/imagenes/LOGO.png', 14, 40, 50, 50, '', '', 'T', false, 300, '', false, false, 0, false, false, false);
$pdf->SetAlpha(1); // Restablece la transparencia al 100% para otros elementos
$pdf->Image('../public/imagenes/carrop-removebg-preview.png', 34.5, -5.5,45, 45, '', '', 'T', false, 300, '', false, false, 0, false, false, false);

$style = array(
    'border' => 0,
    'vpadding' => '3',
    'hpadding' => '3',
    'fgcolor' => array(0, 0, 0),
    'bgcolor' => false, //array(255,255,255)
    'module_width' => 1, // width of a single module in points
    'module_height' => 1 // height of a single module in points
);

$pdf->write2DBarcode($qr,'QRCODE,L',  26.5,100,27,27, $style);
ob_end_clean();

//Close and output PDF document
$pdf->Output('factura.pdf', 'I');
error_reporting(E_ALL);
//============================================================+
// END OF FILE
//============================================================+
