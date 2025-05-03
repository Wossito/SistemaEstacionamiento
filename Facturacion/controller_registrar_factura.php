<?php

include('../app/config.php');

$id_informacion = $_GET['id_informacion'];
$nro_factura = $_GET['nro_factura'];
$id_cliente = $_GET['id_cliente'];
$fecha_ingreso = $_GET['fecha_ingreso'];
$hora_ingreso = $_GET['hora_ingreso'];
$cubiculo = $_GET['cubiculo'];
$user_sesion = $_GET['user_sesion'];


date_default_timezone_set("America/Lima");
$fechaHora = date("Y-m-d h:i:s");
$dia = date("d");
$mes = date('m');
if($mes=="1")$mes = "Enero";
if($mes=="2")$mes = "Febrero";
if($mes=="3")$mes = "Marzo";
if($mes=="4")$mes = "Abril";
if($mes=="5")$mes = "Mayo";
if($mes=="6")$mes = "Junio";
if($mes=="7")$mes = "Julio";
if($mes=="8")$mes = "Agosto";
if($mes=="9")$mes = "Septiembre";
if($mes=="10")$mes = "Octubre";
if($mes=="11")$mes = "Noviembre";
if($mes=="12")$mes = "Diciembre";
$ano = date('Y');

///////////// recuperar el departamento o ciudad de la tabla informaciones
$query_info = $pdo->prepare("SELECT * FROM tb_informaciones WHERE id_informacion = '$id_informacion' AND estado = '1' ");
$query_info->execute();
$infos = $query_info->fetchAll(PDO::FETCH_ASSOC);
foreach($infos as $info){
    $ciudad = $info['ciudad'];
}
$fecha_factura = $ciudad.", ".$dia." de ".$mes." de ".$ano;

//////////////////// CALCULA LA DIFERENCIA ENTRE EL TIEMPO DE ENTRADA Y DE SALIDA /////////////////////////////

$fecha_salida = date('Y-m-d');
$fecha_salida_para_calcular = date('Y/m/d');
$hora_salida = date('H:i');

$fecha_hora_ingreso = $fecha_ingreso." ".$hora_ingreso;
$fecha_hora_salida = $fecha_salida." ".$hora_salida;

$fecha_hora_ingreso  = new DateTime($fecha_hora_ingreso);
$fecha_hora_salida = new DateTime($fecha_hora_salida);
$diff = $fecha_hora_ingreso ->diff($fecha_hora_salida);

$tiempo = $diff->days." días con ".$diff->h." horas con ".$diff->i." minutos ";
//////////////////// CALCULA LA DIFERENCIA ENTRE EL TIEMPO DE ENTRADA Y DE SALIDA /////////////////////////////

$detalle = "Servicio de parqueo de ".$tiempo;

// Obtener datos de la tabla tb_mapeos (nro_espacio)
$sentencia_mapeo = $pdo->prepare('SELECT * FROM tb_mapeos WHERE nro_espacio = :nro_espacio');
$sentencia_mapeo->bindParam(':nro_espacio', $cubiculo);
$sentencia_mapeo->execute();
$mapeo = $sentencia_mapeo->fetch(PDO::FETCH_ASSOC);


// Obtener datos del usuario (por session o email)
$sentencia_usuario = $pdo->prepare('SELECT * FROM tb_usuarios WHERE email = :email');
$sentencia_usuario->bindParam(':email', $user_sesion);
$sentencia_usuario->execute();
$usuario = $sentencia_usuario->fetch(PDO::FETCH_ASSOC);

// Obtener los datos del auto
$sentencia_auto = $pdo->prepare('SELECT * FROM tb_tickets WHERE hora_ingreso = :hora_ingreso');
$sentencia_auto->bindParam(':hora_ingreso', $hora_ingreso);
$sentencia_auto->execute();
$ticket = $sentencia_auto->fetch(PDO::FETCH_ASSOC);

////// DATOS DEL CLIENTE ///////////

$query_clientes = $pdo->prepare("SELECT 
                                cl.dni_cliente, cl.nombre_cliente, cl.cargo_cliente,
                                au.placa_auto, au.marca_auto
                                FROM tb_clientes cl
                                INNER JOIN tb_autos au ON cl.id_auto = au.id_auto
                                WHERE cl.id_cliente = '$id_cliente' AND cl.estado = '1' ");
$query_clientes->execute();
$datos_clientes = $query_clientes->fetchAll(PDO::FETCH_ASSOC);
foreach($datos_clientes as $datos_cliente){
    $dni_cliente = $datos_cliente['dni_cliente'];
    $nombre_cliente=$datos_cliente['nombre_cliente'];
    $placa_auto=$datos_cliente['placa_auto'];
    $cargo_cliente=$datos_cliente['cargo_cliente'];
    $marca_auto=$datos_cliente['marca_auto'];
}

/////////////////

$qr = "FACTURA REALIZADA por el Sistema de Estacionamiento de la UCV\n" .
    "Al cliente: " . $nombre_cliente . " con DNI: " . $dni_cliente . "\n" .
    "Vehiculo con numero de placa: " . $placa_auto . "\n" .
    "Factura generada en la fecha: " . $fecha_factura . " a hr: " . $hora_salida;


$sentencia = $pdo->prepare('INSERT INTO tb_facturaciones
(id_informacion,id_cliente,id_map,id_usuario,id_ticket,nro_factura,fecha_factura,fecha_salida,hora_salida,tiempo,detalle,qr, fyh_creacion, estado)
VALUES ( :id_informacion,:id_cliente,:id_map,:id_usuario,:id_ticket,:nro_factura,:fecha_factura,:fecha_salida,:hora_salida,:tiempo,:detalle,:qr,:fyh_creacion,:estado)');

$sentencia->bindParam(':id_informacion',$id_informacion);
$sentencia->bindParam(':id_cliente',$id_cliente);
$sentencia->bindParam(':id_map',$mapeo['id_map']);
$sentencia->bindParam(':id_usuario',$usuario['id_usuario']);
$sentencia->bindParam(':id_ticket',$ticket['id_ticket']);
$sentencia->bindParam(':nro_factura',$nro_factura);
$sentencia->bindParam(':fecha_factura',$fecha_factura);
$sentencia->bindParam(':fecha_salida',$fecha_salida);
$sentencia->bindParam(':hora_salida',$hora_salida);
$sentencia->bindParam(':tiempo',$tiempo);
$sentencia->bindParam(':detalle',$detalle);
$sentencia->bindParam(':qr',$qr);
$sentencia->bindParam('fyh_creacion',$fechaHora);
$sentencia->bindParam('estado',$estado_del_registro);

if($sentencia->execute()){

    $estado_espacio = "LIBRE";
    date_default_timezone_set("America/Lima");
    $fechaHora = date("Y-m-d h:i:s");
    $sentencia = $pdo->prepare("UPDATE tb_mapeos SET
    estado_espacio = :estado_espacio,
    fyh_actualizacion = :fyh_actualizacion 
    WHERE nro_espacio = :nro_espacio");
    $sentencia->bindParam(':estado_espacio',$estado_espacio);
    $sentencia->bindParam(':fyh_actualizacion',$fechaHora);
    $sentencia->bindParam(':nro_espacio',$cubiculo);
    $sentencia->execute();


    $estado_espacio_ticket = "FACTURADO";
    $sentencia_ticket = $pdo->prepare("UPDATE tb_tickets SET
    estado_ticket = :estado_ticket WHERE estado='1'");
    $sentencia_ticket->bindParam(':estado_ticket',$estado_espacio_ticket);
    $sentencia_ticket->execute();

    
    echo '<script>
        Swal.fire({
            icon: "success",
            title: "Factura Exitosa",
            text: "La Factura ha sido registrada correctamente.",
            confirmButtonText: "Aceptar"
        }).then(() => {
            window.open("facturacion/generar_factura.php", "_blank");
            location.href = "../www.sistemaestacionamiento2.com/principal.php";
        });
    </script>';

}else{
    echo '<script>
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Error al registrar en la base de datos.",
            confirmButtonText: "Aceptar"
        });
    </script>';
}
