<?php
global $pdo;
include('../app/config.php');

$id_informacion = $_GET['id_informacion'];
$estado_inactivo = "0";

date_default_timezone_set("America/caracas");
$fechaHora = date("Y-m-d h:i:s");

$sentencia = $pdo->prepare("CALL sp_eliminar_informacion(:id_informacion, :estado_inactivo, :fyh_eliminacion)");

// Vincular los parámetros
$sentencia->bindParam(':id_informacion', $id_informacion);
$sentencia->bindParam(':estado_inactivo', $estado_inactivo);
$sentencia->bindParam(':fyh_eliminacion', $fechaHora);

if($sentencia->execute()){
    ?>
    <script>location.href = "index_informaciones.php";</script>
    <?php
}else{
    echo "ERROR AL ELIMINAR";
}