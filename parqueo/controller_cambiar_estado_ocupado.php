<?php
include('../app/config.php');
$cubiculo = $_GET["cubiculo"];
$estado_espacio = "OCUPADO";

date_default_timezone_set("America/Lima");
$fecha_actualizacion = date("Y-m-d H:i:s");

$sentencia = $pdo->prepare("UPDATE tb_mapeos SET
                                estado_espacio = :estado_espacio,
                                fyh_actualizacion = :fyh_actualizacion
                                WHERE nro_espacio = :nro_espacio");

$sentencia->bindParam(':estado_espacio', $estado_espacio);
$sentencia->bindParam(':fyh_actualizacion', $fecha_actualizacion);
$sentencia->bindParam(':nro_espacio', $cubiculo);

$sentencia->execute();
?>

