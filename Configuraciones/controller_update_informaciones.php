<?php
global $pdo;
include('../app/config.php');

$nombre_estacionamiento = $_GET['nombre_estacionamiento'];
$actividad_empresa = $_GET['actividad_empresa'];
$sucursal = $_GET['sucursal'];
$direccion = $_GET['direccion'];
$zona = $_GET['zona'];
$telefono = $_GET['telefono'];
$ciudad = $_GET['ciudad'];
$pais = $_GET['pais'];
$id_informacion = $_GET['id_informacion'];

date_default_timezone_set("America/Lima");
$fechaHora = date("Y-m-d H:i:s");

$sentencia = $pdo->prepare("CALL sp_actualizar_informacion(
    :id_informacion, 
    :nombre_estacionamiento, 
    :actividad_empresa, 
    :sucursal, 
    :direccion, 
    :zona, 
    :telefono, 
    :ciudad, 
    :pais, 
    :fyh_actualizacion
)");

// Vincular los parámetros
$sentencia->bindParam(':id_informacion', $id_informacion);
$sentencia->bindParam(':nombre_estacionamiento', $nombre_estacionamiento);
$sentencia->bindParam(':actividad_empresa', $actividad_empresa);
$sentencia->bindParam(':sucursal', $sucursal);
$sentencia->bindParam(':direccion', $direccion);
$sentencia->bindParam(':zona', $zona);
$sentencia->bindParam(':telefono', $telefono);
$sentencia->bindParam(':ciudad', $ciudad);
$sentencia->bindParam(':pais', $pais);
$sentencia->bindParam(':fyh_actualizacion', $fechaHora);

if($sentencia->execute()){
    echo '<script>
            Swal.fire({
                icon: "success",
                title: "INFORMACIÓN ACTUALIZADA",
                text: "La información se ha actualizado correctamente.",
                confirmButtonText: "Aceptar"
            }).then(() => {
                window.location.href = "index_informaciones.php";
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
