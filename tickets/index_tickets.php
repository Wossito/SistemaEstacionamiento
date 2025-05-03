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
            <h2>LISTADO DE TICKETS</h2>
            <br>
            <script>
                $(document).ready(function() {
                    $('#Tabla_Tickets').DataTable( {
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
                            <h3 class="card-title">TICKETS REGISTRADOS</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>

                        </div>

                        <div class="card-body">
                            <table id="Tabla_Tickets"class="table table-bordered table-sm table-striped">
                                <thead>
                                <th style="text-align: center">Id Ticket</th>
                                <th>Usuario</th>
                                <th>Fecha Ingreso</th>
                                <th>Hora Ingreso</th>
                                <th>Estado Ticket</th>
                                <th>DNI</th>
                                <th>Nombre Cliente</th>
                                <th><center>Accion<center></th>
                                </thead>
        
                                <tbody>
                                <?php

                            // Facturas Registrados
                            $checkQuery = $pdo->prepare("SELECT 
                            ti.id_ticket, ti.fecha_ingreso, ti.hora_ingreso, ti.estado_ticket, ti.id_cliente,
                            us.nombres
                            FROM tb_tickets ti
                            INNER JOIN tb_usuarios us on ti.id_usuario = us.id_usuario
                            WHERE ti.estado = '1' ");
$checkQuery->execute();
$datos_tickets = $checkQuery->fetchAll(PDO::FETCH_ASSOC);
foreach ($datos_tickets as $datos_ticket) {
    $id_ticket = $datos_ticket['id_ticket'];
    $fecha_ingreso = $datos_ticket['fecha_ingreso'];
    $hora_ingreso = $datos_ticket ['hora_ingreso'];
    $estado_ticket = $datos_ticket ['estado_ticket'];
    $id_cliente = $datos_ticket ['id_cliente'];
    $nombre_usuario = $datos_ticket['nombres'];

    $contador_cliente=0;
    $checkQuery = $pdo->prepare("SELECT * FROM tb_clientes WHERE estado = '1' and id_cliente= '$id_cliente'");
    $checkQuery->execute();
    $dato_clientes = $checkQuery->fetchAll(PDO::FETCH_ASSOC);
    foreach ($dato_clientes as $dato_cliente) {
        $contador_cliente++;
        $dni_cliente = $dato_cliente['dni_cliente'];
        $nombre_cliente = $dato_cliente['nombre_cliente'];

    }
    $fecha_ingreso = date("Y-m-d");

    ?>


    <tr>
        <td style="text-align: center"><?php echo $id_ticket; ?></td>
        <td><?php echo $nombre_usuario;?></td>
        <td><?php echo $fecha_ingreso; ?></td>
        <td><?php echo $hora_ingreso;?></td>
        <td><?php echo $estado_ticket;?></td>
        <td><?php echo $dni_cliente; ?></td>
        <td><?php echo $nombre_cliente; ?></td>
        <td>
            <center>
                <a href="re-imprimir_ticket.php?id=<?php echo $id_ticket; ?>" class="btn btn-success" target="_blank">Ver</a>
            </center>
        </td>
    </tr>
    <?php
}
?>
                                </tbody>
                            
                            </table>

                            <hr>
            <a href="reporte_ticket.php" class="btn btn-primary" target="_blank">Generar reporte
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