<?php
    include('../app/config.php');
include('../layout/admin/datos_usuario_sesion.php');  ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include('../layout/admin/head.php');?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <?php include('../layout/admin/menu.php');?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <br>
        <div class="container">
            <h2>LISTADO DE INFORMACIONES</h2>
            <br>
            <script>
                $(document).ready(function() {
                    $('#Tabla_Informaciones').DataTable( {
                        "pageLength": 5,
                        "language": {
                            "emptyTable": "No hay información",
                            "info": "Mostrando _START_ a _END_ de _TOTAL_ Informaciones",
                            "infoEmpty": "Mostrando 0 a 0 de 0 Usuarios",
                            "infoFiltered": "(Filtrado de _MAX_ total Informaciones)",
                            "infoPostFix": "",
                            "thousands": ",",
                            "lengthMenu": "Mostrar _MENU_ Informaciones",
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

            <a href="create_informaciones.php" class="btn btn-primary">REGISTRAR NUEVO</a> <br> <br>

            <table id="Tabla_Informaciones" class="table tabla-bordered table-sm table-striped">
                <thead>
                <th><center>Nro<center></th>
                <th>Nombre del Estacionamiento</th>
                <th>Actividad de la Empresa</th>
                <th>Sucursal</th>
                <th>Dirección</th>
                <th>Zona</th>
                <th>Teléfono</th>
                <th>Ciudad</th>
                <th>Pais</th>
                <th><center>Accion<center></th>
                </thead>

                <tbody>
                <?php
                $contador = 0;
                $query_informacions = $pdo->prepare("SELECT * FROM tb_informaciones WHERE estado = '1' ");
                $query_informacions->execute();
                $informacions = $query_informacions->fetchAll(PDO::FETCH_ASSOC);
                foreach($informacions as $informacion){
                    $id_informacion = $informacion['id_informacion'];
                    $nombre_estacionamiento = $informacion['nombre_estacionamiento'];
                    $actividad_empresa = $informacion['actividad_empresa'];
                    $sucursal = $informacion['sucursal'];
                    $direccion = $informacion['direccion'];
                    $zona = $informacion['zona'];
                    $telefono = $informacion['telefono'];
                    $ciudad = $informacion['ciudad'];
                    $pais = $informacion['pais'];
                    $contador = $contador + 1;
                    ?>
                    <tr>
                        <td><center><?php echo $contador;?></center></td>
                        <td><?php echo $nombre_estacionamiento;?></td>
                        <td><?php echo $actividad_empresa;?></td>
                        <td><?php echo $sucursal;?></td>
                        <td><?php echo $direccion;?></td>
                        <td><?php echo $zona;?></td>
                        <td><?php echo $telefono;?></td>
                        <td><?php echo $ciudad;?></td>
                        <td><?php echo $pais;?></td>
                        <td>
                            <center>
                                <a href="update_informaciones.php?id=<?php echo $id_informacion; ?>" class="btn btn-success">EDITAR</a>
                                <button class="btn btn-danger borrar2" data-id="<?php echo $id_informacion; ?>">BORRAR</button>
                                <center>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>

            <hr>
            <a href="reporte_informaciones.php" class="btn btn-primary" target="_blank">Generar reporte
                <i class="fa fa">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-bar-graph" viewBox="0 0 16 16">
                        <path d="M10 13.5a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-6a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v6zm-2.5.5a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-1zm-3 0a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-1z"/>
                        <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                    </svg>
                </i>
            </a>

        </div>
    </div>
    <!-- /.content-wrapper -->

    <?php include('../layout/admin/footer.php');?>
    <?php include('../layout/admin/footer_links.php');?>
</body>
</html>

<script>
    $(document).on('click', '.borrar2', function () {
        var id_informacion = $(this).data('id');
        Swal.fire({
            title: '¿Estás seguro de eliminar el usuario?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, borrar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.get('controller_delete_informaciones.php', {id_informacion: id_informacion}, function(datos) {
                    $('#respuesta').html(datos);
                    Swal.fire({
                        title: "ELIMINADO!",
                        text: "El Usuario ha sido Eliminado",
                        icon: "success"
                    }).then(() => {
                        location.reload();
                    });
                });
            }
        });
    });

</script>