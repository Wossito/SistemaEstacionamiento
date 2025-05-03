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

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <br>
        <div class="container">

            <?php
            $id_get = $_GET['id'];
            $query_usuario = $pdo->prepare("SELECT * FROM tb_usuarios WHERE id_usuario = '$id_get' AND estado = '1' ");
            $query_usuario-> execute();
            $usuarios = $query_usuario->fetchAll(PDO::FETCH_ASSOC);
            foreach($usuarios as $usuario){
                $Id = $usuario['id_usuario'];
                $Nombres = $usuario['nombres'];
                $Email = $usuario['email'];
                $password_user = $usuario['contraseña'];
            }
            ?>

            <div style="margin: 0px 0px 0px 10px ;">
                <h2>ACTUALIZACIÓN DEL USUARIO</h2>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-primary" style="border: 1px solid #000000">
                            <div class="card-header">
                                <h3 class="card-title">EDICIÓN DEL USUARIO</h3>
                            </div>

                            <div class="card-body">
                                <div class="form_group">
                                    <label for="">Nombres</label>
                                    <input type="text" class="form-control" id="nombres" value="<?php echo $Nombres;?>">
                                </div>
                                <div class="form_group">
                                    <label for="">Email</label>
                                    <input type="text" class="form-control" id="email" value="<?php echo $Email;?>">
                                </div>
                                <div class="form_group">
                                    <label for="">Contraseña</label>
                                    <input type="text" class="form-control" id="password_user" value="<?php echo $password_user;?>">
                                </div>
                                <br>
                                <div class="form_group">
                                    <button class="btn btn-success" id="btn_actualizar">ACTUALIZAR</button>
                                    <a href="<?php echo $URL;?>/usuarios/index_usuario.php" class="btn btn-default">CANCELAR</button></a>
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
    $('#btn_actualizar').click(function () {
        var nombres = $('#nombres').val();
        var email = $('#email').val();
        var password_user = $('#password_user').val();
        var id_user ='<?php echo $id_get = $_GET['id'];?>';
        if (nombres == "") {
            alert("DEBE INTRODUCIR SUS NOMBRES...")
            $('#nombres').focus();
        } else if ( email == "" ) {
            alert("DEBE INTRODUCIR SU EMAIL...")
            $('#email').focus();
        } else if ( password_user == "" ) {
            alert("DEBE INTRODUCIR SU CONTRASEÑA...")
            $('#password_user').focus();
        } else{
            var url='controller_update_usuario.php';
            $.get(url ,{nombres:nombres, email:email,password_user:password_user, id_user:id_user}, function(datos){
                $('#respuesta').html(datos);
            });
        }
    });
</script>