<?php
include('../layout/admin/head.php');
include('../app/config.php');

$nombre = $_POST['nombre'];
$email = $_POST['email'];
$id_user = $_POST['id_user'];
$id_rol = $_POST['rol']; // Cambiado para usar el ID del rol

    // Preparar la consulta para actualizar el rol del usuario
    $sentencia = $pdo->prepare("CALL sp_actualizar_rol_usuario(:id_user, :id_rol)");

    // Vincular los parámetros
    $sentencia->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $sentencia->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);

    // Ejecutar la consulta
if($sentencia->execute()){
    ?>
    <script>location.href = "asignar_roles.php";</script>
    <?php
}


