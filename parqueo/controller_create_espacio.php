<?php
include('../app/config.php');
$nro_espacio =$_GET["nro_espacio"];
$estado_espacio =$_GET["estado_espacio"];
$obs =$_GET["obs"];


date_default_timezone_set("America/Lima");
$fecha_hora = date("Y-m-d H:i:s");

   // Preparar la llamada al procedimiento almacenado
   $sentencia = $pdo->prepare("CALL sp_crear_mapeo(:nro_espacio, :estado_espacio, :obs, :fyh_creacion, :estado)");

   // Vincular los parámetros
   $sentencia->bindParam(':nro_espacio', $nro_espacio, PDO::PARAM_INT);
   $sentencia->bindParam(':estado_espacio', $estado_espacio, PDO::PARAM_STR);
   $sentencia->bindParam(':obs', $obs, PDO::PARAM_STR);
   $sentencia->bindParam(':fyh_creacion', $fecha_hora, PDO::PARAM_STR);
   $sentencia->bindParam(':estado', $estado_del_registro, PDO::PARAM_INT);
   
if($sentencia->execute()){
    echo '<script>
            Swal.fire({
                icon: "success",
                title: "ESPACIO CREADO",
                text: "El espacio ha sido creado correctamente.",
                confirmButtonText: "Aceptar"
            }).then(() => {
                window.location.href = "mapeo_de_vehiculos.php";
            });
          </script>';
} else {
    echo '<script>
            Swal.fire({
                icon: "error",
                title: "ERROR",
                text: "Error al registrar a la base de datos.",
                confirmButtonText: "Aceptar"
            });
          </script>';
}

