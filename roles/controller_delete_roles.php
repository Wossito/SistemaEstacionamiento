<?php
include('../app/config.php');
$id_rol =$_GET["id_rol"];
$estado_inactivo = "0";
date_default_timezone_set("America/Lima");
$fecha_eliminacion = date("Y-m-d H:i:s");

$sentencia = $pdo->prepare("CALL sp_eliminar_rol(:id_rol, :estado_inactivo, :fecha_eliminacion)");

// Vincular parámetros
$sentencia->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
$sentencia->bindParam(':estado_inactivo', $estado_inactivo, PDO::PARAM_INT);
$sentencia->bindParam(':fecha_eliminacion', $fecha_eliminacion, PDO::PARAM_STR);

if($sentencia->execute()){
    ?>
    <script>location.href = "../roles"; </script>
    <?php
} else {
    ?>
    <?php
}