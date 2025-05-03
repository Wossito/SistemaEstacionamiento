<?php
// Include the main TCPDF library (search for installation path).
error_reporting(0);
ob_start();

// Incluye las bibliotecas y archivos necesarios
require_once('../app/templeates/TCPDF-main/tcpdf.php');
include('../app/config.php');

// CARGAR EL ENCABEZADO
$query_informacions = $pdo->prepare("SELECT * FROM tb_informaciones WHERE estado = '1' ");
$query_informacions->execute();
$informacions = $query_informacions->fetchAll(PDO::FETCH_ASSOC);
foreach ($informacions as $informacion) {
    $id_informacion = $informacion['id_informacion'];
    $nombre_estacionamiento = $informacion['nombre_estacionamiento'];
    $actividad_empresa = $informacion['actividad_empresa'];
    $sucursal = $informacion['sucursal'];
    $direccion = $informacion['direccion'];
    $zona = $informacion['zona'];
    $telefono = $informacion['telefono'];
    $ciudad = $informacion['ciudad'];
    $pais = $informacion['pais'];
}


// CARGAR DATOS DEL CLIENTE

$query_tickets = $pdo->prepare("SELECT * FROM tb_tickets WHERE estado = '1' ");
$query_tickets->execute();
$tickets = $query_tickets->fetchAll(PDO::FETCH_ASSOC);
foreach($tickets as $ticket){
    $id_ticket = $ticket['id_ticket'];
    $dni_cliente = $ticket['dni_cliente'];
    $nombre_cliente=$ticket['nombre_cliente'];
    $placa_cliente=$ticket['placa_cliente'];
    $cargo_cliente=$ticket['cargo_cliente'];
    $marca_cliente=$ticket['marca_cliente'];
    $cuviculo = $ticket['cuviculo'];
    $fecha_ingreso = $ticket['fecha_ingreso'];
    $hora_ingreso = $ticket['hora_ingreso'];
    $user_sesion = $ticket['user_sesion'];
}


// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(78,130), true, 'UTF-8', false);

// set document information
$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor('Josue Felipe');
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
$pdf->setAutoPageBreak(TRUE, 5);

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
                <b>Placa:</b> ' . $placa_cliente . ' <b>Marca:</b> ' . $marca_cliente . '<br>
                <b>Fecha Facturación :</b>HOY<br>
                       
        <tr>
            <td colspan="2" style="text-align: right; padding: 5px 0;">*********************************************</td>
        </tr><br>

                <b>DATOS DE FACTURA</b><br>
                <b>Cúbiculo de estacionamiento:</b> ' . $cuviculo . '<br> 
                <b>De:</b> '. $fecha_ingreso .  '    <b>Hora: </b>' . $hora_ingreso . '<br> 
                <b>A:</b> '. $fecha_ingreso .  '    <b>Hora: </b>' . $hora_ingreso . '<br> 
                <b>Tiempo Total:</b> ' . $hora_ingreso . '<br>
          <tr>
            <td colspan="2" style="text-align: right; padding: 5px 0;">*********************************************</td>
        </tr><br>
                <b style="text-align: right">USUARIO:</b> ' . $user_sesion . '<br>
             <tr>
            <td colspan="2" style="text-align: right; padding: 5px 0;">*********************************************</td><br>
        </tr><br><br><br><br><br>
                <p style="text-align: center;">   ¡Gracias por su preferencia!</p>
            </td>
        </tr>

    </table>

</div>
';

$pdf->writeHTML($html, true, false, true, false, '');

// Agregar la imagen centrada
$pdf->SetAlpha(0.1); // Establece la transparencia al 50%
$pdf->Image('../public/imagenes/LOGO.png', 14, 40, 50, 50, '', '', 'T', false, 300, '', false, false, 0, false, false, false);
$pdf->SetAlpha(1); // Restablece la transparencia al 100% para otros elementos
$pdf->Image('../public/imagenes/carrop-removebg-preview.png', 34.5, -5.5,45, 45, '', '', 'T', false, 300, '', false, false, 0, false, false, false);
$pdf->Image('../public/imagenes/QR.png', 28.5, 96.4, 20, 20, '', '', 'T', false, 300, '', false, false, 0, false, false, false);

ob_end_clean();
// output the HTML content
//Close and output PDF document
$pdf->Output('example_002.pdf', 'I');
error_reporting(E_ALL);
//============================================================+
// END OF FILE
//============================================================+<?php
