<?php
include('../app/config.php');
$id_map =$_GET["id_map"];
$estado_inactivo = "0";
date_default_timezone_set("America/Lima");
$fecha_eliminacion = date("Y-m-d H:i:s");

$sentencia = $pdo->prepare("UPDATE tb_mapeos SET
                                estado = :estado,
                                fyh_eliminacion = :fyh_eliminacion
                                WHERE id_map= :id");

$sentencia->bindParam(':estado', $estado_inactivo);
$sentencia->bindParam(':fyh_eliminacion', $fecha_eliminacion);
$sentencia->bindParam(':id', $id_map);

if($sentencia->execute()){
    ?>
    <script>location.href = "../parqueo"; </script>
    <?php
}