<?php

include('../app/config.php');

$id_ticket = $_GET['id'];
$cubiculo = $_GET['cubiculo'];


$estado_inactivo = "0";

date_default_timezone_set("America/Lima");
$fechaHora = date("Y-m-d h:i:s");

$sentencia = $pdo->prepare("CALL sp_actualizar_estado_ticket(:id_ticket, :estado, :fyh_eliminacion)");

$sentencia->bindParam(':id_ticket', $id_ticket);
$sentencia->bindParam(':estado', $estado_inactivo);
$sentencia->bindParam(':fyh_eliminacion', $fechaHora);


if($sentencia->execute()){

    // ACTUALIZANDO EL ESTADO DEL CUBICULO
    $estado_espacio = "LIBRE";
    $sentencia2 = $pdo->prepare("CALL sp_actualizar_estado_cubiculo(:nro_espacio, :estado_espacio, :fyh_actualizacion)");

    $sentencia2->bindParam(':nro_espacio', $cubiculo);
    $sentencia2->bindParam(':estado_espacio', $estado_espacio);
    $sentencia2->bindParam(':fyh_actualizacion', $fechaHora);

    if($sentencia2->execute()){
        echo "se actualizo el estado del civuculo a libre";
        ?>
        <script>location.href = "../principal.php";</script>
        <?php

    }else{
        echo "error al actualizar el campo nro de espacio del cuviculo";
    }

}else{
    echo "error al eliminar el registro";
}
