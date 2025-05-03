<?php include('../app/config.php');
include('../layout/admin/datos_usuario_sesion.php');  ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include('../layout/admin/head.php');?>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <?php include('../layout/admin/menu.php');?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <br>
        <div class="container">
            <div style="margin: 0px 0px 0px 10px ;">
                <h2>CREACION DE UN NUEVO ROL</h2>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card" style="border: 1px solid #171616">
                            <div class="card-header" style="background-color: #4686c8;color: #FFFFFF">
                                <h4>Nuevo Rol</h4>
                            </div>
                            <div class="card-body">
                                <div class="form_group">
                                    <label for="">Nombre del Rol</label>
                                    <input type="text" class="form-control" id="nombre">
                                </div>
                                <br>
                                <div class="form_group">
                                    <button class="btn btn-primary" id="btn_guardar">GUARDAR</button>
                                    <a href="<?php echo $URL;?>/roles/" class="btn btn-default">CANCELAR</button></a>
                                </div>
                                <div id="respuesta">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6"></div>
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
    $('#btn_guardar').click(function () {
        var nombre = $('#nombre').val();

        if (nombre == "") {
            Swal.fire({
                icon: 'warning',
                title: 'NOMBRE DE ROL obligatorio',
                text: 'DEBE INTRODUCIR EL ROL',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                $('#nombre').focus();
            });
        } else{
            var url='controller_create_roles.php';
            $.get(url ,{nombre:nombre}, function(datos){
                $('#respuesta').html(datos);
            });
        }
    });
</script>