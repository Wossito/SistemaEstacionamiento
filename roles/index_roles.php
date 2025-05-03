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
            <h2>LISTADO DE ROLES</h2>
        <br>
            <script>
                $(document).ready(function() {
                    $('#Tabla_Roles').DataTable( {
                        "pageLength": 5,
                        "language": {
                            "emptyTable": "No hay información",
                            "info": "Mostrando _START_ a _END_ de _TOTAL_ Roles",
                            "infoEmpty": "Mostrando 0 a 0 de 0 Roles",
                            "infoFiltered": "(Filtrado de _MAX_ total Roles)",
                            "infoPostFix": "",
                            "thousands": ",",
                            "lengthMenu": "Mostrar _MENU_ Usuarios",
                            "loadingRecords": "Cargando...",
                            "processing": "Procesando...",
                            "search": "Buscador:",
                            "zeroRecords": "Sin resultados encontrados",
                            "paginate": {
                                "next": "Siguiente",
                                "previous": "Anterior"
                            }
                        }
                    });
                } );
            </script>

            <div class="row">
                <div class="col-md-6">
                    <table id="Tabla_Roles" class="table table-bordered table-sm table-striped">
                        
                        <thead>
                        <th><center>Nro<center></th>
                        <th>Nombres</th>
                        <th><center>Acción<center></th>
                        </thead>

                        <tbody>
                        <?php
                        $contador = 0;
                        $query_roles = $pdo->prepare("SELECT * FROM tb_roles WHERE estado = '1' ");
                        $query_roles->execute();
                        $roles = $query_roles->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($roles as $rol) {
                            $id_rol = $rol['id_rol'];
                            $nombre = $rol['nombre'];
                            $contador++;
                            ?>
                            <tr>
                                <td><?php echo $contador; ?></td>
                                <td><?php echo $nombre; ?></td>
                                <td>
                                    <center>
                                        <button class="btn btn-danger borrar" data-id_rol="<?php echo $id_rol; ?>">Borrar</button>
                                    </center>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                    <hr>
            <a href="reporte_roles.php" class="btn btn-primary" target="_blank">Generar reporte
                <i class="fa fa">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-bar-graph" viewBox="0 0 16 16">
                        <path d="M10 13.5a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-6a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v6zm-2.5.5a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-1zm-3 0a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-1z"/>
                        <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                    </svg>
                </i>
            </a>
                    
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
    $(document).on('click', '.borrar', function () {
        var id_rol = $(this).data('id_rol');
        Swal.fire({
            title: '¿Estás seguro de eliminar este rol?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, borrar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.get('controller_delete_roles.php', {id_rol: id_rol}, function (datos) {
                    $('#respuesta').html(datos);
                    Swal.fire({
                        title: "ELIMINADO!",
                        text: "El Rol ha sido Eliminado",
                        icon: "success"
                    }).then(() => {
                        location.reload(); // Recargar la página después de la confirmación
                    });
                });
            }
        });
    });
</script>

