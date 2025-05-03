<?php
include('../app/config.php');
include('../layout/admin/datos_usuario_sesion.php');
global $pdo;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include('../layout/admin/head.php'); ?>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <?php include('../layout/admin/menu.php'); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <br>
        <div class="container">
            <h2>LISTADO DE FACTURAS</h2>
            <br>
            <script>
                $(document).ready(function() {
                    $('#Tabla_Facturas').DataTable( {
                        "pageLength": 10,
                        "language": {
                            "emptyTable": "No hay información",
                            "info": "Mostrando _START_ a _END_ de _TOTAL_ Espacios",
                            "infoEmpty": "Mostrando 0 a 0 de 0 Espacios",
                            "infoFiltered": "(Filtrado de _MAX_ total Espacios)",
                            "infoPostFix": "",
                            "thousands": ",",
                            "lengthMenu": "Mostrar _MENU_ Espacios",
                            "loadingRecords": "Cargando...",
                            "processing": "Procesando...",
                            "search": "Buscador:",
                            "zeroRecords": "Sin resultados encontrados",
                            "paginate": {
                                "first": "Primero",
                                "last": "Ultimo",
                                "next": "Siguiente",
                                "previous": "Anterior"
                            }
                        }
                    });
                } );
            </script>
            <div class="row">
                <div class="col-md-12">

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">FACTURAS REGISTRADAS</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>

                        </div>

                        <div class="card-body">
                            <table id="Tabla_Facturas"class="table table-bordered table-sm table-striped">
                                <thead>
                                <th style="text-align: center">Nro Factura</th>
                                <th>Usuario</th>
                                <th>Fecha de Facturacion</th>
                                <th>Hora Facturacion</th>
                                <th>DNI</th>
                                <th>Nombre Cliente</th>
                                <th><center>Accion<center></th>
                                </thead>
        
                                <tbody>
                                <?php

                            // Facturas Registrados
                            $checkQuery = $pdo->prepare("SELECT 
                            fa.id_facturacion, fa.nro_factura, fa.fecha_factura, fa.hora_salida, fa.id_cliente,
                            us.nombres
                            FROM tb_facturaciones fa
                            INNER JOIN tb_usuarios us on fa.id_usuario = us.id_usuario
                            WHERE fa.estado = '1' ");
$checkQuery->execute();
$datos_facturas = $checkQuery->fetchAll(PDO::FETCH_ASSOC);
foreach ($datos_facturas as $datos_factura) {
    $id_facturacion = $datos_factura['id_facturacion'];
    $nro_factura = $datos_factura ['nro_factura'];
    $fecha_factura = $datos_factura ['fecha_factura'];
    $hora_salida = $datos_factura ['hora_salida'];
    $id_cliente = $datos_factura ['id_cliente'];
    $nombre_usuario = $datos_factura['nombres'];

    $contador_cliente=0;
    $checkQuery = $pdo->prepare("SELECT * FROM tb_clientes WHERE estado = '1' and id_cliente= '$id_cliente'");
    $checkQuery->execute();
    $dato_clientes = $checkQuery->fetchAll(PDO::FETCH_ASSOC);
    foreach ($dato_clientes as $dato_cliente) {
        $contador_cliente++;
        $dni_cliente = $dato_cliente['dni_cliente'];
        $nombre_cliente = $dato_cliente['nombre_cliente'];

    }
    ?>


    <tr>
        <td style="text-align: center"><?php echo $nro_factura; ?></td>
        <td><?php echo $nombre_usuario;?></td>
        <td><?php echo $fecha_factura; ?></td>
        <td><?php echo $hora_salida;?></td>
        <td><?php echo $dni_cliente; ?></td>
        <td><?php echo $nombre_cliente; ?></td>
        <td>
            <center>
                <a href="re-imprimir_factura.php?id=<?php echo $id_facturacion; ?>" class="btn btn-success" target="_blank">Ver</a>
            </center>
        </td>
    </tr>
    <?php
}
?>
                                </tbody>
                            
                            </table>

                            <hr>
            <a href="reporte_facturas.php" class="btn btn-primary" target="_blank">Generar reporte
                <i class="fa fa">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-bar-graph" viewBox="0 0 16 16">
                        <path d="M10 13.5a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-6a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v6zm-2.5.5a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-1zm-3 0a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-1z"/>
                        <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                    </svg>
                </i>
            </a>
            <hr>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- /.content-wrapper -->

    <?php include('../layout/admin/footer.php'); ?>

</div>
<?php include('../layout/admin/footer_links.php'); ?>
</body>
</html>

