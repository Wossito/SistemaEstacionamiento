<?php

include('../app/config.php');

$id_informacion = $_GET['id_informacion'];
$dni_cliente = $_GET['dni_cliente'];
$nombre_cliente = $_GET['nombre_cliente'];
$placa_auto = $_GET['placa_auto'];
$cargo_cliente = $_GET['cargo_cliente'];
$marca_auto = $_GET['marca_auto'];
$cubiculo = $_GET['cubiculo'];
$fecha_ingreso = $_GET['fecha_ingreso'];
$hora_ingreso = $_GET['hora_ingreso'];
$user_session = $_GET['user_session'];
$estado_ticket = "OCUPADO"; 

// Establecemos la zona horaria
date_default_timezone_set("America/Lima");
$fechaHora = date("Y-m-d h:i:s");

// Obtener datos de la tabla tb_mapeos (nro_espacio)
$sentencia_mapeo = $pdo->prepare('SELECT * FROM tb_mapeos WHERE nro_espacio = :nro_espacio');
$sentencia_mapeo->bindParam(':nro_espacio', $cubiculo);
$sentencia_mapeo->execute();
$mapeo = $sentencia_mapeo->fetch(PDO::FETCH_ASSOC);

// Obtener datos del usuario (por session o email)
$sentencia_usuario = $pdo->prepare('SELECT * FROM tb_usuarios WHERE email = :email');
$sentencia_usuario->bindParam(':email', $user_session);
$sentencia_usuario->execute();
$usuario = $sentencia_usuario->fetch(PDO::FETCH_ASSOC);

// Obtener los datos del auto
$sentencia_auto = $pdo->prepare('SELECT * FROM tb_autos WHERE placa_auto = :placa_auto');
$sentencia_auto->bindParam(':placa_auto', $placa_auto);
$sentencia_auto->execute();
$auto = $sentencia_auto->fetch(PDO::FETCH_ASSOC);

// Obtener los datos del cliente
$sentencia_cliente = $pdo->prepare('SELECT * FROM tb_clientes WHERE dni_cliente = :dni_cliente');
$sentencia_cliente->bindParam(':dni_cliente', $dni_cliente);
$sentencia_cliente->execute();
$cliente = $sentencia_cliente->fetch(PDO::FETCH_ASSOC);

// Verificar que se han obtenido correctamente los datos
if ($mapeo && $usuario && $auto && $cliente) {
    // Crear el ticket
    $sentencia_ticket = $pdo->prepare('INSERT INTO tb_tickets 
    (id_informacion, id_map, id_cliente, id_usuario, fecha_ingreso, hora_ingreso, estado_ticket, fyh_creacion, estado) 
    VALUES (:id_informacion, :id_map, :id_cliente, :id_usuario, :fecha_ingreso, :hora_ingreso, :estado_ticket, :fyh_creacion, :estado)');

    $sentencia_ticket->bindParam(':id_informacion', $id_informacion);
    $sentencia_ticket->bindParam(':id_map', $mapeo['id_map']); // Usamos el id del mapeo
    $sentencia_ticket->bindParam(':id_cliente', $cliente['id_cliente']); // Usamos el id del cliente
    $sentencia_ticket->bindParam(':id_usuario', $usuario['id_usuario']); // Usamos el id del usuario
    $sentencia_ticket->bindParam(':fecha_ingreso', $fecha_ingreso);
    $sentencia_ticket->bindParam(':hora_ingreso', $hora_ingreso);
    $sentencia_ticket->bindParam(':estado_ticket', $estado_ticket);
    $sentencia_ticket->bindParam(':fyh_creacion', $fechaHora);
    $sentencia_ticket->bindParam(':estado', $estado_del_registro);

    // Ejecutar la inserción del ticket
    if ($sentencia_ticket->execute()) {
        echo '<script>
            Swal.fire({
                icon: "success",
                title: "TICKET CREADO",
                text: "El Ticket se ha creado correctamente.",
                confirmButtonText: "Aceptar"
            }).then(() => {
                window.open("tickets/generar_ticket.php", "_blank");
                window.location.href = "../www.sistemaestacionamiento2.com/principal.php";
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
}
?>
   


