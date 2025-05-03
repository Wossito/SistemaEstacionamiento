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

    date_default_timezone_set("America/Lima");
    $fechaHora = date("Y-m-d h:i:s");


    $sentencia = $pdo->prepare("CALL sp_insertar_informacion(
        :nombre_estacionamiento, :actividad_empresa, :sucursal, :direccion, :zona, :telefono, :ciudad, :pais, :fyh_creacion, :estado
    )");

    // Vincular los parámetros
    $sentencia->bindParam(':nombre_estacionamiento', $nombre_estacionamiento);
    $sentencia->bindParam(':actividad_empresa', $actividad_empresa);
    $sentencia->bindParam(':sucursal', $sucursal);
    $sentencia->bindParam(':direccion', $direccion);
    $sentencia->bindParam(':zona', $zona);
    $sentencia->bindParam(':telefono', $telefono);
    $sentencia->bindParam(':ciudad', $ciudad);
    $sentencia->bindParam(':pais', $pais);
    $sentencia->bindParam(':fyh_creacion', $fechaHora);
    $sentencia->bindParam(':estado', $estado_del_registro);

    if($sentencia->execute()){
        echo '<script>
            Swal.fire({
                icon: "success",
                title: "INFORMACIÓN CREADA",
                text: "La información se ha creado correctamente.",
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

