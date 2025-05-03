<?php
include('../app/config.php');
$nombres =$_GET["nombres"];
$email =$_GET["email"];
$password_user =$_GET["password_user"];
date_default_timezone_set("America/Lima");
$fecha_hora = date("Y-m-d H:i:s");

$sentencia = $pdo->prepare("CALL sp_crear_usuario(:nombres, :email, :password_user, :fyh_creacion, :estado)");

$sentencia->bindParam(':nombres', $nombres);
$sentencia->bindParam(':email', $email);
$sentencia->bindParam(':password_user', $password_user);
$sentencia->bindParam(':fyh_creacion', $fecha_hora);
$sentencia->bindParam(':estado', $estado_del_registro);

if($sentencia->execute()){
    echo '<script>
            Swal.fire({
                icon: "success",
                title: "USUARIO CREADO",
                text: "El Usuario se ha creado correctamente.",
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
