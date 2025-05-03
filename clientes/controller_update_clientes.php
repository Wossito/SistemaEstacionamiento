<?php
include('../app/config.php');
global $pdo;

// Obtener los datos del formulario
$id_cliente = $_GET["id_cliente"];
$dni_cliente = $_GET["dni_cliente"];
$nombre_cliente = $_GET["nombre_cliente"];
$placa_auto = $_GET["placa_auto"];
$cargo_cliente = $_GET["cargo_cliente"];
$marca_auto = $_GET["marca_auto"];
date_default_timezone_set("America/Lima");
$fecha_actualizacion = date("Y-m-d H:i:s");


    // Actualizar los datos del auto usando la placa como identificador
    $sentencia = $pdo->prepare("CALL sp_ActualizarClienteYAuto(:id_cliente, :dni_cliente, :nombre_cliente, :cargo_cliente, :placa_auto, :marca_auto, :fecha_actualizacion)");

$sentencia->bindParam(':id_cliente', $id_cliente);
$sentencia->bindParam(':dni_cliente', $dni_cliente);
$sentencia->bindParam(':nombre_cliente', $nombre_cliente);
$sentencia->bindParam(':placa_auto', $placa_auto);
$sentencia->bindParam(':cargo_cliente', $cargo_cliente);
$sentencia->bindParam(':marca_auto', $marca_auto);
$sentencia->bindParam(':fecha_actualizacion', $fecha_actualizacion);
    
    if ($sentencia->execute()) {
       
    echo '<script>
        Swal.fire({
            icon: "success",
            title: "CLIENTE Y AUTO ACTUALIZADOS",
            text: "Los datos se han actualizado correctamente.",
            confirmButtonText: "Aceptar"
        }).then(() => {
            window.location.href = "index_clientes.php";
        });
    </script>';
} else {
    echo '<script>
    Swal.fire({
        icon: "error",
        title: "ERROR",
        text: "Error al registrar el ticket en la base de datos.",
        confirmButtonText: "Aceptar"
    });
  </script>';
}
?>

