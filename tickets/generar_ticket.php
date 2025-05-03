<?php
// Include the main TCPDF library (search for installation path).
error_reporting(0);
ob_start();
require_once('../app/templeates/TCPDF-main/tcpdf.php');
include('../app/config.php');

$query_tickets = $pdo->prepare("
SELECT 
t.id_ticket, t.fecha_ingreso, t.hora_ingreso,
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
ORDER BY t.id_ticket DESC
Limit 1;
");

$query_tickets->execute();
$tickets = $query_tickets->fetchAll(PDO::FETCH_ASSOC);

// Iterar sobre los resultados para procesarlos
foreach($tickets as $ticket){
    $id_ticket = $ticket['id_ticket'];
    $id_informacion = $ticket['id_informacion'];
    $id_map = $ticket['id_map'];
    $id_cliente = $ticket['id_cliente'];
    $id_usuario = $ticket['id_usuario'];
    $fecha_ingreso = $ticket['fecha_ingreso'];
    $hora_ingreso = $ticket['hora_ingreso'];

    // Datos de estacionamiento
    $nombre_estacionamiento = $ticket['nombre_estacionamiento'];
    $actividad_empresa = $ticket['actividad_empresa'];
    $sucursal = $ticket['sucursal'];
    $direccion = $ticket['direccion'];
    $zona = $ticket['zona'];
    $telefono = $ticket['telefono'];
    $ciudad = $ticket['ciudad'];
    $pais = $ticket['pais'];

    // Datos del cliente
    $nombre_cliente = $ticket['nombre_cliente'];
    $dni_cliente = $ticket['dni_cliente'];
    $cargo_cliente = $ticket['cargo_cliente'];

    // Datos del auto
    $placa_auto = $ticket['placa_auto'];
    $marca_auto = $ticket['marca_auto'];

    // Datos del usuario
    $nombre_usuario = $ticket['nombres'];

    // Datos del espacio
    $nro_espacio = $ticket['nro_espacio'];
}
$fecha_ingreso = date("Y-m-d");

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(78,108), true, 'UTF-8', false);

// set document information
$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor('Josue Felipe');
$pdf->setTitle('Ticket Parking');
$pdf->setSubject('TCPDF Tutorial');
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

// INSERTAR DATOS AL PDF POR HML
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
            <td colspan="2" style="text-align: right; padding: 5px 0;">*********************************************</td>
        </tr><br>

                <b>DATOS DE ENTRADA</b><br>
                <b>Cúbiculo de estacionamiento:</b> ' . $nro_espacio . '<br> 
                <b>Fecha de ingreso:</b> ' . $fecha_ingreso . ' <br> 
                <b>Hora de ingreso: </b>' . $hora_ingreso . ' <br>
          <tr>
            <td colspan="2" style="text-align: right; padding: 5px 0;">*********************************************</td>
        </tr><br>

                <b>USUARIO:</b> ' . $nombre_usuario . '<br>
             <tr>
            <td colspan="2" style="text-align: right; padding: 5px 0;">*********************************************</td>
        </tr>
                <br><b style="text-align: center; font-size: 10px">¡Gracias por su preferencia!</b>
            </td>
        </tr>

    </table>
</div>
';
$pdf->writeHTML($html, true, false, true, false, '');

// Agregar la imagen centrada
$pdf->SetAlpha(0.1);
$pdf->Image('../public/imagenes/LOGO.png', 14, 35, 50, 50, '', '', 'T', false, 300, '', false, false, 0, false, false, false);
$pdf->SetAlpha(1); // Restablece la transparencia al 100% para otros elementos
$pdf->Image('../public/imagenes/carrop-removebg-preview.png', 34.5, -5.5,45, 45, '', '', 'T', false, 300, '', false, false, 0, false, false, false);

// output the HTML content

//Close and output PDF document
$pdf->Output('example_002.pdf', 'I');
error_reporting(E_ALL);
//============================================================+
// END OF FILE
//============================================================+<?php
