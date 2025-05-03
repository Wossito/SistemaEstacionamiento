<?php
include('../app/config.php');
include('../layout/admin/datos_usuario_sesion.php');
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
            <h2>LISTADO DE ESPACIOS</h2>
            <br>
            <script>
                $(document).ready(function() {
                    $('#Tabla_Espacios').DataTable( {
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
                <div class="col-md-10">
                    <table id="Tabla_Espacios" class="table table-bordered table-sm table-striped">
                        <thead>
                        <th><center>Nro<center></th>
                        <th>Nro Espacio</th>
                        <th><center>Acción<center></th>
                        </thead>
                        
                        <tbody>
                        <?php
                        $contador = 0;
                        $query_mapeos = $pdo->prepare("SELECT * FROM tb_mapeos WHERE estado = '1' ");
                        $query_mapeos->execute();
                        $mapeos = $query_mapeos->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($mapeos as $mapeo) {
                            $id_map = $mapeo['id_map'];
                            $nro_espacio = $mapeo['nro_espacio'];
                            $contador++;
                            ?>
                            <tr>
                                <td><?php echo $contador; ?></td>
                                <td><?php echo $nro_espacio; ?></td>
                                <td>
                                    <center>
                                        <button class="btn btn-danger borrar2" data-id="<?php echo $id_map; ?>">Borrar</button>
                                    </center>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                        
                    </table>
                    <hr>
            <a href="reporte_espacios.php" class="btn btn-primary" target="_blank">Generar reporte
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
    <!-- /.content-wrapper -->

    <?php include('../layout/admin/footer.php'); ?>
    <?php include('../layout/admin/footer_links.php'); ?>
</body>
</html>

<script>
    $(document).on('click', '.borrar2', function () {
        var id_map = $(this).data('id');
        Swal.fire({
            title: '¿Estás seguro de eliminar el espacio?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, borrar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.get('controller_delete_espacio.php', {id_map: id_map}, function(datos) {
                    $('#respuesta').html(datos);
                    Swal.fire({
                        title: "ELIMINADO!",
                        text: "El espacio ha sido Eliminado",
                        icon: "success"
                    }).then(() => {
                        location.reload();
                    });
                });
            }
        });
    });

</script>