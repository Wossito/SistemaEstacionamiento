<?php
global $pdo;
include('../app/config.php');

$id_cliente = $_GET['id_cliente'];
$estado_inactivo = "0";
date_default_timezone_set("America/Lima");
$fecha_eliminacion = date("Y-m-d H:i:s");

$sentencia = $pdo->prepare("CALL EliminarCliente(:id_cliente, :estado, :fyh_eliminacion)");

$sentencia->bindParam(':id_cliente', $id_cliente);
$sentencia->bindParam(':estado', $estado_inactivo);
$sentencia->bindParam(':fyh_eliminacion', $fecha_eliminacion);

if ($sentencia->execute()) {
    echo '<script>
            Swal.fire({
                icon: "success",
                title: "CLIENTE ELIMINADO",
                text: "El cliente ha sido eliminado correctamente.",
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
                text: "Hubo un problema al eliminar el cliente.",
                confirmButtonText: "Aceptar"
            });
          </script>';
}
?>
