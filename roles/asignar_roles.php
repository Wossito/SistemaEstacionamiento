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
            <h2>ASIGNACIÓN DE ROLES A USUARIOS</h2>
            <br>
            <div class="row">
                <div class="col-md-12">

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">LISTADO DE USUARIOS CON ROLES</h3>
                                <script>
                $(document).ready(function() {
                    $('#Tabla_Usuario_Rol').DataTable( {
                        "pageLength": 5,
                        "language": {
                            "emptyTable": "No hay información",
                            "info": "Mostrando _START_ a _END_ de _TOTAL_ Usuarios",
                            "infoEmpty": "Mostrando 0 a 0 de 0 Usuarios",
                            "infoFiltered": "(Filtrado de _MAX_ total Usuarios)",
                            "infoPostFix": "",
                            "thousands": ",",
                            "lengthMenu": "Mostrar _MENU_ Usuarios",
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
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>

                            </div>

                            <div class="card-body">
                                <table id="Tabla_Usuario_Rol"class="table tabla-bordered table-sm table-striped">
                                    <thead>
                                    <th><center>Nro<center></th>
                                    <th>Nombre de Usuarios</th>
                                    <th>Email</th>
                                    <th><center>Asignar Rol<center></th>
                                    <th><center>ACCION<center></th>
                                    </thead>

                                    <tbody>
                                    <?php
                                    $contador=0;
                                    $query_usuario = $pdo->prepare("
                                        SELECT u.id_usuario, u.nombres, u.email, r.nombre AS rol
                                                    FROM tb_usuarios u
                                                LEFT JOIN tb_roles r ON u.id_rol = r.id_rol
                                        WHERE u.estado = '1'
");
                                    $query_usuario->execute();
                                    $usuarios = $query_usuario->fetchAll(PDO::FETCH_ASSOC);

                                    foreach($usuarios as $usuario) {
                                        $Id = $usuario['id_usuario'];
                                        $Nombres = $usuario['nombres'];
                                        $Email = $usuario['email'];
                                        $rol = $usuario['rol']; // Nombre del rol obtenido
                                        $contador++;
                                        ?>
                                        <tr>
                                            <td><?php echo $contador;?></td>
                                            <td><?php echo $Nombres;?></td>
                                            <td><?php echo $Email;?></td>

                                            <td>
                                                <center>
                                                    <?php
                                                    if ($rol == ""){ ?>
                                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal<?php echo $Id;?>">
                                                            Asignar
                                                        </button>

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="exampleModal<?php echo $Id;?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Asignar Rol</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form action="controller_asignar_roles.php" method="post">
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label for="">NOMBRE DEL USUARIO</label>
                                                                                        <input type="text" name="nombre" class="form-control" value="<?php echo $Nombres;?>" >
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label for="">EMAIL DEL USUARIO</label>
                                                                                        <input type="text" name="email" class="form-control" value="<?php echo $Email;?>" >
                                                                                        <input type="text" name="id_user" value="<?php echo $Id;?>" hidden>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label for="">ROL</label>
                                                                                        <select name="rol" id="" class="form-control">
                                                                                            <?php
                                                                                            $query_roles = $pdo->prepare("SELECT * FROM tb_roles WHERE estado = '1' ");
                                                                                            $query_roles->execute();
                                                                                            $roles = $query_roles->fetchAll(PDO::FETCH_ASSOC);
                                                                                            foreach ($roles as $rol) {
                                                                                                $id_rol = $rol['id_rol'];
                                                                                                $nombre = $rol['nombre'];
                                                                                                ?>
                                                                                                <option value="<?php echo $id_rol;?>"><?php echo $nombre;?></option>
                                                                                                <?php
                                                                                            }
                                                                                            ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button  type="submit" class="btn btn-primary">ASIGNAR ROL</button>
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                                                                    </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <?php
                                                    } else {
                                                        echo $rol;
                                                    }
                                                    ?>
                                                    <center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?php
                                                    ?>
                                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal<?php echo $Id;?>">
                                                            EDITAR
                                                        </button>

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="exampleModal<?php echo $Id;?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Asignar Rol</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form action="controller_asignar_roles.php" method="post">
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label for="">NOMBRE DEL USUARIO</label>
                                                                                        <input type="text" name="nombre" class="form-control" value="<?php echo $Nombres;?>" >
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label for="">EMAIL DEL USUARIO</label>
                                                                                        <input type="text" name="email" class="form-control" value="<?php echo $Email;?>" >
                                                                                        <input type="text" name="id_user" value="<?php echo $Id;?>" hidden>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label for="">ROL</label>
                                                                                        <select name="rol" id="" class="form-control">
                                                                                            <?php
                                                                                            $query_roles = $pdo->prepare("SELECT * FROM tb_roles WHERE estado = '1' ");
                                                                                            $query_roles->execute();
                                                                                            $roles = $query_roles->fetchAll(PDO::FETCH_ASSOC);
                                                                                            foreach ($roles as $rol) {
                                                                                                $id_rol = $rol['id_rol'];
                                                                                                $nombre = $rol['nombre'];
                                                                                                ?>
                                                                                                <option value="<?php echo $id_rol; ?>"><?php echo $nombre; ?></option>
                                                                                                <?php
                                                                                            }
                                                                                            ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button  type="submit" class="btn btn-primary">EDITAR</button>
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                                                                    </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <?php

                                                    ?>
                                                    <center>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>    
                                </table>
                            </div>

                        </div>


                </div>
            </div>
        </div>
    </div>
    <!-- /.content-wrapper -->

    <?php include('../layout/admin/footer.php'); ?>
    <?php include('../layout/admin/footer_links.php'); ?>
</body>
</html>

