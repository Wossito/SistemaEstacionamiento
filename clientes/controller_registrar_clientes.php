<?php
global $pdo;
include('../app/config.php');

$dni_cliente = $_GET['dni_cliente'];
$nombre_cliente = $_GET['nombre_cliente'];
$cargo_cliente = $_GET['cargo_cliente'];
$marca_auto = $_GET['marca_auto'];
$placa_auto = $_GET['placa_auto']; // En este caso, la placa es para la tabla tb_autos

date_default_timezone_set("America/Lima");
$fechaHora = date("Y-m-d h:i:s");

// Verificar si el cliente ya está registrado en la base de datos
$contador_cliente = 0;
$checkQuery = $pdo->prepare("SELECT * FROM tb_clientes WHERE dni_cliente = :dni_cliente AND estado = '1'");
$checkQuery->bindParam(':dni_cliente', $dni_cliente);
$checkQuery->execute();
$datos_cliente = $checkQuery->fetchAll(PDO::FETCH_ASSOC);
foreach ($datos_cliente as $dato_cliente) {
    $contador_cliente++;
}

if ($contador_cliente == 0) {
    // Primero, insertar el auto en la tabla tb_autos
    $sentencia_auto = $pdo->prepare('INSERT INTO tb_autos
    (placa_auto, marca_auto, fyh_creacion, estado)
    VALUES (:placa_auto, :marca_auto, :fyh_creacion, :estado)');

    $sentencia_auto->bindParam(':placa_auto', $placa_auto);
    $sentencia_auto->bindParam(':marca_auto', $marca_auto);
    $sentencia_auto->bindParam(':fyh_creacion', $fechaHora);
    $sentencia_auto->bindParam(':estado', $estado_del_registro);

    if ($sentencia_auto->execute()) {
        // Obtener el ID del auto recién insertado
        $id_auto = $pdo->lastInsertId();

        // Ahora insertar el cliente en la tabla tb_clientes
        $sentencia_cliente = $pdo->prepare('INSERT INTO tb_clientes
        (dni_cliente, nombre_cliente, cargo_cliente, id_auto, fyh_creacion, estado)
        VALUES (:dni_cliente, :nombre_cliente, :cargo_cliente, :id_auto, :fyh_creacion, :estado)');

        $sentencia_cliente->bindParam(':dni_cliente', $dni_cliente);
        $sentencia_cliente->bindParam(':nombre_cliente', $nombre_cliente);
        $sentencia_cliente->bindParam(':cargo_cliente', $cargo_cliente);
        $sentencia_cliente->bindParam(':id_auto', $id_auto);
        $sentencia_cliente->bindParam(':fyh_creacion', $fechaHora);
        $sentencia_cliente->bindParam(':estado', $estado_del_registro);

        if ($sentencia_cliente->execute()) {
            echo 'REGISTRADO';
        } else {
            echo 'error en la inserción del cliente';
        }
    } else {
        echo 'error en la inserción del auto';
    }
} else {
    echo "CLIENTE REGISTRADO ANTERIORMENTE";
}





