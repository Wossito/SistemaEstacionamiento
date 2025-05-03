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
            <h2>LISTADO DE CLIENTES</h2>
            <br>
            <script>
                $(document).ready(function() {
                    $('#Tabla_Clientes').DataTable( {
                        "pageLength": 5,
                        "language": {
                            "emptyTable": "No hay información",
                            "info": "Mostrando _START_ a _END_ de _TOTAL_ Clientes",
                            "infoEmpty": "Mostrando 0 a 0 de 0 Clientes",
                            "infoFiltered": "(Filtrado de _MAX_ total Clientes)",
                            "infoPostFix": "",
                            "thousands": ",",
                            "lengthMenu": "Mostrar _MENU_ Clientes",
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
                            <h3 class="card-title">CLIENTES REGISTRADOS</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>

                        </div>

                        <div class="card-body">

                            <table id="Tabla_Clientes" class="table table-bordered table-sm table-striped">
                                <thead>
                                <th><center>Nro<center></th>
                                <th>DNI/CARNET</th>
                                <th>Nombre del Cliente</th>
                                <th>Placa_Auto</th>
                                <th>Cargo_Cliente</th>
                                <th>Marca_Auto</th>
                                <th><center>Accion<center></th>
                                </thead>
                                <tbody>
                                <?php
                                // Consulta con JOIN para obtener los datos de cliente y auto relacionados
                                $contador_cliente = 0;
                                $checkQuery = $pdo->prepare("SELECT c.id_cliente, c.dni_cliente, c.nombre_cliente, a.placa_auto, c.cargo_cliente, a.marca_auto 
                                                                FROM tb_clientes c
                                                                LEFT JOIN tb_autos a ON c.id_auto = a.id_auto
                                                                WHERE c.estado = '1'");
                                $checkQuery->execute();
                                $datos_cliente = $checkQuery->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($datos_cliente as $dato_cliente) {
                                    $contador_cliente = $contador_cliente + 1;
                                    $id_cliente = $dato_cliente['id_cliente'];
                                    $dni_cliente = $dato_cliente['dni_cliente'];
                                    $nombre_cliente = $dato_cliente['nombre_cliente'];
                                    $placa_auto = $dato_cliente['placa_auto']; 
                                    $cargo_cliente = $dato_cliente['cargo_cliente'];
                                    $marca_auto = $dato_cliente['marca_auto'];  
                                    ?>
                                    <tr>
                                        <td><center><?php echo $contador_cliente; ?></center></td>
                                        <td><?php echo $dni_cliente; ?></td>
                                        <td><?php echo $nombre_cliente; ?></td>
                                        <td><?php echo $placa_auto; ?></td>
                                        <td><?php echo $cargo_cliente; ?></td>
                                        <td><?php echo $marca_auto; ?></td>
                                        <td>
                                            
                                        <?php
                            if($rol_sesion == "ADMINISTRADOR"){ ?>
                            <center>
                                                <a href="update_clientes.php?id=<?php echo $id_cliente; ?>" class="btn btn-success">Editar</a>
                                                <button class="btn btn-danger borrar-cliente" data-id="<?php echo $id_cliente; ?>">Borrar</button>
                                            </center>
                            <?php 
                            }
                            ?>

                            <?php
                            if($rol_sesion == "OPERADOR"){ ?>
                            <center>
                            <a href="update_clientes.php?id=<?php echo $id_cliente; ?>" class="btn btn-success disabled" tabindex="-1" aria-disabled="true">Editar</a>
                            <button class="btn btn-danger borrar-cliente" data-id="<?php echo $id_cliente; ?>" disabled>Borrar</button>
                                            </center>
                            <?php 
                            }
?>                                        
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            
                            </table>

                            <hr>
            <a href="reporte_clientes.php" class="btn btn-primary" target="_blank">Generar reporte
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

<script>
    $(document).on('click', '.borrar-cliente', function () {
        var id_cliente = $(this).data('id');
        Swal.fire({
            title: '¿Estás seguro de eliminar este cliente?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, borrar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.get('controller_delete_clientes.php', {id_cliente: id_cliente}, function(datos) {
                    $('#respuesta').html(datos);
                    Swal.fire({
                        title: "¡ELIMINADO!",
                        text: "El cliente ha sido eliminado",
                        icon: "success"
                    }).then(() => {
                        location.reload();
                    });
                });
            }
        });
    });
</script>

