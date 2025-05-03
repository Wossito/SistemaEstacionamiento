<?php
include('../app/config.php');
$nombre =$_GET["nombre"];
date_default_timezone_set("America/Lima");
$fecha_hora = date("Y-m-d H:i:s");

$sentencia = $pdo->prepare("CALL sp_insertar_rol(:nombre, :fyh_creacion, :estado)");

    // Vincular parámetros
    $sentencia->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $sentencia->bindParam(':fyh_creacion', $fecha_hora, PDO::PARAM_STR);
    $sentencia->bindParam(':estado', $estado_del_registro, PDO::PARAM_INT);

if($sentencia->execute()){
echo '<script>
            Swal.fire({
                icon: "success",
                title: "ROL REGISGTRADO",
                text: "El Rol ha sido registrado correctamente.",
                confirmButtonText: "Aceptar"
            }).then(() => {
                window.location.href = "index_roles.php";
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

?>