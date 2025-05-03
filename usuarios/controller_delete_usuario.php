<?php
include('../app/config.php');
$id_user =$_GET["id_user"];
$estado_inactivo = "0";
date_default_timezone_set("America/Lima");
$fecha_eliminacion = date("Y-m-d H:i:s");

// Preparar llamada al procedimiento almacenado
$sentencia = $pdo->prepare("CALL sp_eliminar_usuario(:id_user, :estado_inactivo, :fecha_eliminacion)");

// Vincular parámetros
$sentencia->bindParam(':id_user', $id_user, PDO::PARAM_INT);
$sentencia->bindParam(':estado_inactivo', $estado_inactivo, PDO::PARAM_STR);
$sentencia->bindParam(':fecha_eliminacion', $fecha_eliminacion, PDO::PARAM_STR);

if($sentencia->execute()){
    ?>
    <script>location.href = "../usuarios"; </script>
    <?php
}

