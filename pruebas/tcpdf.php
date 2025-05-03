<?php

// Include the main TCPDF library (search for installation path).
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

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(79,100), true, 'UTF-8', false);

// set document information
$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor('Nicola Asuni');
$pdf->setTitle('TCPDF Example 002');
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
<div>
    <p style="text-align: center">
        <b>'.$nombre_estacionamiento.'</b> <br> <br>
        '.$actividad_empresa.' <br>
        Sucursal: '.$sucursal.'<br>
        Direccion: '.$direccion.' <br>
        Zona: '.$zona.' <br>
        Pais: '.$pais.' - '.$ciudad.' <br>
        Telefono: '.$telefono.' <br>
        --------------------------------------------------------------------------------
        <div style="text-align: left">
            <b>DATOS DEL CLIENTE</b> <br>
            <b>PERSONA: </b> WOSSITO <br>
            <b>DNI: </b> 75326075  <br>
            -------------------------------------------------------------------------------- <br>
        <b>Cuviculo de estacionamiento: </b> 1 <br>
        <b>Fecha de ingreso: </b> 27/10/2024 <br>
        <b>Hora de ingreso: </b> 18:00 <br>
         -------------------------------------------------------------------------------- <br>
         <b>USUARIO:</b> JOSUE FELIPE HUAROCC COMUN
         </div>
    </p>

</div>
';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');


//Close and output PDF document
$pdf->Output('example_002.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
