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
$pdf->setTitle('REPORTE ESPACIOS');
$pdf->setSubject('TCPDF Tutorial');
$pdf->setKeywords('TCPDF, PDF, example, test, guide');

$PDF_HEADER_TITLE = $nombre_parqueo;
$PDF_HEADER_STRING = $direccion.' Telf: '.$telefono;
$PDF_HEADER_LOGO = 'auto1.jpg';
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
<P><b>Reporte del Listado de Espacios</b></P>
<table border="1" cellpadding="4" style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif;">
    <tr>
        <td style="background-color: #4CAF50; color: white; text-align: center; font-weight: bold; padding: 12px; width: 40px;">Nro</td>
        <td style="background-color: #4CAF50; color: white; text-align: center; font-weight: bold; padding: 12px; width: 100px;">DNI/Carnet</td>
        <td style="background-color: #4CAF50; color: white; text-align: center; font-weight: bold; padding: 12px; width: 100px;">Nombres</td>
        <td style="background-color: #4CAF50; color: white; text-align: center; font-weight: bold; padding: 12px; width: 100px;">Cargo</td>
        <td style="background-color: #4CAF50; color: white; text-align: center; font-weight: bold; padding: 12px;">Placa</td>
        <td style="background-color: #4CAF50; color: white; text-align: center; font-weight: bold; padding: 12px;">Marca</td>   
         </tr>
    
';

$contador_cliente = 0;
$query_clientes = $pdo->prepare("SELECT 
                                cl.dni_cliente, cl.nombre_cliente, cl.id_cliente, cl.cargo_cliente,
                                au.placa_auto, au.marca_auto
                                FROM tb_clientes cl
                                INNER JOIN tb_autos au on cl.id_auto = au.id_auto
                                WHERE cl.estado = '1'  ");
$query_clientes->execute();
$datos_clientes = $query_clientes->fetchAll(PDO::FETCH_ASSOC);
foreach($datos_clientes as $datos_cliente){
    $contador_cliente = $contador_cliente + 1;
    $id_cliente = $datos_cliente['id_cliente'];
    $dni_cliente = $datos_cliente['dni_cliente'];
    $nombre_cliente = $datos_cliente['nombre_cliente'];
    $cargo_cliente = $datos_cliente['cargo_cliente'];
    $marca_auto = $datos_cliente['marca_auto'];
    $placa_auto = $datos_cliente['placa_auto'];

    $html .= '
    <tr>
    <td style="text-align: center">'.$contador_cliente.'</td>
    <td style="text-align: center">'.$dni_cliente.'</td>
    <td style="text-align: center">'.$nombre_cliente.'</td>
    <td style="text-align: center">'.$cargo_cliente.'</td>
    <td style="text-align: center">'.$placa_auto.'</td>
    <td style="text-align: center">'.$marca_auto.'</td>
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