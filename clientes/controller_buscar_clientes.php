

    <?php
    include('../app/config.php');
    global $pdo;

    // Recibir los datos del cliente
    $dni = $_GET['dni'];
    $id_map = $_GET['id_map'];

    // Inicializar variables
    $id_cliente = '';
    $nombre_cliente = '';
    $cargo_cliente = '';
    $placa_auto = '';
    $marca_auto = '';

    // Consulta para buscar cliente por DNI y su vehículo
    $query_buscar = $pdo->prepare("
        SELECT c.id_cliente, c.nombre_cliente, c.cargo_cliente, a.placa_auto, a.marca_auto
        FROM tb_clientes c
        INNER JOIN tb_autos a ON c.id_auto = a.id_auto
        WHERE c.estado = '1' AND c.dni_cliente = :dni
    ");
    $query_buscar->bindParam(':dni', $dni, PDO::PARAM_STR);
    $query_buscar->execute();
    $resultado = $query_buscar->fetch(PDO::FETCH_ASSOC);
    if ($resultado) {

        $id_cliente = $resultado['id_cliente'];
        $nombre_cliente = $resultado['nombre_cliente'];
        $cargo_cliente = $resultado['cargo_cliente'];
        $placa_auto = $resultado['placa_auto'];
        $marca_auto = $resultado['marca_auto'];
        
        echo "
        <script>
            Swal.fire({
                icon: 'success',
                title: 'CLIENTE ENCONTRADO',
                text: 'Los datos del cliente han sido cargados correctamente.',
                confirmButtonText: 'Aceptar'
            });
        </script>";
        ?>
        <!-- Mostrar datos del cliente -->
        <div class="form-group row">
            <label for="nombre_cliente" class="col-sm-3 col-form-label">NOMBRE:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="nombre_cliente<?php echo $id_map; ?>" value="<?php echo $nombre_cliente; ?>" disabled>
            </div>
        </div>
        <div class="form-group row">
            <label for="placa_auto" class="col-sm-3 col-form-label">PLACA:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="placa_auto<?php echo $id_map; ?>" value="<?php echo $placa_auto; ?>" disabled>
            </div>
        </div>
        <div class="form-group row">
            <label for="cargo_cliente" class="col-sm-3 col-form-label">CARGO:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="cargo_cliente<?php echo $id_map; ?>" value="<?php echo $cargo_cliente; ?>" disabled>
            </div>
        </div>
        <div class="form-group row">
            <label for="marca_auto" class="col-sm-3 col-form-label">MARCA:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="marca_auto<?php echo $id_map; ?>" value="<?php echo $marca_auto; ?>" disabled>
            </div>
        </div>
        <?php
    } else {
        // Si no se encuentra el cliente
        echo "
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'CLIENTE NO REGISTRADO',
                text: 'Este cliente no ha sido encontrado en la base de datos.',
                confirmButtonText: 'Aceptar'
            });
        </script>";
        ?>
        <!-- Formulario para registrar nuevo cliente -->
        <div class="form-group row">
            <label for="nombre_cliente" class="col-sm-3 col-form-label">NOMBRE:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="nombre_cliente<?php echo $id_map; ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="placa_auto" class="col-sm-3 col-form-label">PLACA:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="placa_auto<?php echo $id_map; ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="cargo_cliente" class="col-sm-3 col-form-label">CARGO:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="cargo_cliente<?php echo $id_map; ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="marca_auto" class="col-sm-3 col-form-label">MARCA:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="marca_auto<?php echo $id_map; ?>">
            </div>
        </div>
        <?php
    }
 
// Consultar tickets ocupados
$query_tickets = $pdo->prepare("
    SELECT COUNT(*) FROM tb_tickets t 
    INNER JOIN tb_clientes c ON t.id_cliente = c.id_cliente
    WHERE c.dni_cliente = :dni 
    AND t.estado_ticket = 'OCUPADO' 
    AND t.estado = '1'
");
$query_tickets->bindParam(':dni', $dni, PDO::PARAM_STR);
$query_tickets->execute();
$contador_ticket = $query_tickets->fetchColumn();

// Si no hay tickets ocupados, habilitar el botón de registro
if ($contador_ticket == 0) {
    echo "<script>$('#btn_registrar_ticket{$id_map}').removeAttr('disabled');</script>";
} else {
    echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Vehículo ya registrado',
                text: 'Este vehículo ya está dentro del estacionamiento',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                document.getElementById('btn_registrar_ticket{$id_map}').disabled = true;
            });
          </script>";
}
?>