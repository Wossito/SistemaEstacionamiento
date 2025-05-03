<?php
include('../app/config.php');
include('../layout/admin/datos_usuario_sesion.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include('../layout/admin/head.php');?>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <?php include('../layout/admin/menu.php');?>
    <div class="wrapper">

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <br>
            <div class="container">

                <?php
                $id_cliente = $_GET['id'];

                // Consulta para obtener los datos del cliente
                $query_cliente = $pdo->prepare("SELECT * FROM tb_clientes WHERE id_cliente = :id AND estado = '1'");
                $query_cliente->bindParam(':id', $id_cliente);
                $query_cliente->execute();
                $cliente = $query_cliente->fetch(PDO::FETCH_ASSOC);

                if ($cliente) {
                    $dni_cliente = $cliente['dni_cliente'];
                    $nombre_cliente = $cliente['nombre_cliente'];
                    $cargo_cliente = $cliente['cargo_cliente'];
                    $id_auto = $cliente['id_auto'];

                    // Consulta para obtener los datos del auto relacionado
                    $query_auto = $pdo->prepare("SELECT * FROM tb_autos WHERE id_auto = :id_auto AND estado = '1'");
                    $query_auto->bindParam(':id_auto', $id_auto);
                    $query_auto->execute();
                    $auto = $query_auto->fetch(PDO::FETCH_ASSOC);

                    // Verificar si se encontró el auto
                    if ($auto) {
                        $placa_auto = $auto['placa_auto'];
                        $marca_auto = $auto['marca_auto'];
                    } else {
                        $placa_auto = '';
                        $marca_auto = '';
                    }
                } else {
                    die('Cliente no encontrado');
                }
                ?>

                <div style="margin: 0px 0px 0px 10px;">
                    <h2>ACTUALIZACIÓN DEL CLIENTE</h2>
                </div>
                <div class="container">
                    <div class  ="row">
                        <div class="col-md-8">
                            <div class="card card-primary" style="border: 1px solid #000000">
                                <div class="card-header">
                                    <h3 class="card-title">EDICIÓN DEL CLIENTE</h3>
                                </div>

                                <div class="card-body">
                                    <!-- DNI del Cliente -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="dni_cliente">DNI/CARNET</label>
                                            <input type="text" class="form-control" id="dni_cliente" value="<?php echo $dni_cliente; ?>">
                                        </div>
                                    </div>

                                    <!-- Nombre y Cargo del Cliente -->
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label for="nombre_cliente">Nombre del Cliente</label>
                                            <input type="text" class="form-control" id="nombre_cliente" value="<?php echo $nombre_cliente; ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="cargo_cliente">Cargo del Cliente</label>
                                            <input type="text" class="form-control" id="cargo_cliente" value="<?php echo $cargo_cliente; ?>">
                                        </div>
                                    </div>

                                    <!-- Marca y Placa del Auto -->
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label for="marca_auto">Marca del Auto</label>
                                            <input type="text" class="form-control" id="marca_auto" value="<?php echo $marca_auto; ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="placa_auto">Placa del Auto</label>
                                            <input type="text" class="form-control" id="placa_auto" value="<?php echo $placa_auto; ?>">
                                        </div>
                                    </div>

                                    <br>

                                    <!-- Botones de Acción -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button class="btn btn-success btn-block" id="btn_actualizar">ACTUALIZAR</button>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="<?php echo $URL;?>/clientes/index_clientes.php" class="btn btn-default btn-block">CANCELAR</a>
                                        </div>
                                    </div>

                                    <div id="respuesta"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- /.content-wrapper -->
    <?php include('../layout/admin/footer.php');?>
    <?php include('../layout/admin/footer_links.php');?>

</body>
</html>

<script>
    $('#btn_actualizar').click(function () {
        var dni_cliente = $('#dni_cliente').val();
        var nombre_cliente = $('#nombre_cliente').val();
        var placa_auto = $('#placa_auto').val();
        var cargo_cliente = $('#cargo_cliente').val();
        var marca_auto = $('#marca_auto').val();
        var id_cliente = '<?php echo $id_cliente; ?>';

        if (dni_cliente == "") {
            alert("DEBE INTRODUCIR EL DNI/CARNET...");
            $('#dni_cliente').focus();
        } else if (nombre_cliente == "") {
            alert("DEBE INTRODUCIR EL NOMBRE DEL CLIENTE...");
            $('#nombre_cliente').focus();
        } else if (placa_auto == "") {
            alert("DEBE INTRODUCIR LA PLACA DEL AUTO...");
            $('#placa_auto').focus();
        } else if (cargo_cliente == "") {
            alert("DEBE INTRODUCIR EL CARGO DEL CLIENTE...");
            $('#cargo_cliente').focus();
        } else if (marca_auto == "") {
            alert("DEBE INTRODUCIR LA MARCA DEL AUTO...");
            $('#marca_auto').focus();
        } else {
            var url = 'controller_update_clientes.php';
            $.get(url, {
                dni_cliente: dni_cliente,
                nombre_cliente: nombre_cliente,
                placa_auto: placa_auto,
                cargo_cliente: cargo_cliente,
                marca_auto: marca_auto,
                id_cliente: id_cliente
            }, function(response) {
                $('#respuesta').html(response);
            });
        }
    });
</script>
