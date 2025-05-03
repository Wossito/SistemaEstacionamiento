<?php
include('../app/config.php');
$nombres =$_GET["nombres"];
$email =$_GET["email"];
$password_user =$_GET["password_user"];
$id_user =$_GET["id_user"];
date_default_timezone_set("America/Lima");
$fecha_actualizacion = date("Y-m-d H:i:s");

$sentencia = $pdo->prepare("CALL sp_actualizar_usuario(:id_user, :nombres, :email, :password_user, :fecha_actualizacion)");
    
    // Vincular parámetros
    $sentencia->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $sentencia->bindParam(':nombres', $nombres, PDO::PARAM_STR);
    $sentencia->bindParam(':email', $email, PDO::PARAM_STR);
    $sentencia->bindParam(':password_user', $password_user, PDO::PARAM_STR);
    $sentencia->bindParam(':fecha_actualizacion', $fecha_actualizacion, PDO::PARAM_STR);

if($sentencia->execute()){
    echo '<script>
            Swal.fire({
                icon: "success",
                title: "EL USUARIO HA SIDO ACTUALIZAD0",
                text: "El usuario se ha actualizado correctamente.",
                confirmButtonText: "Aceptar"
            }).then(() => {
                window.location.href = "index_usuario.php";
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

