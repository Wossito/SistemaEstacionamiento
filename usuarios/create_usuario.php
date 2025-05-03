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
           <h2>CREACION DE UN USUARIO</h2>
       </div>
       <div class="container">
           <div class="row">
               <div class="col-md-6">
                   <div class="card" style="border: 1px solid #171616">
                       <div class="card-header" style="background-color: #4686c8;color: #FFFFFF">
                           <h4>Nuevo Usuario</h4>
                       </div>
                       <div class="card-body">
                           <div class="form_group">
                               <label for="">Nombres</label>
                               <input type="text" class="form-control" id="nombres">
                           </div>
                           <div class="form_group">
                               <label for="">Email</label>
                               <input type="text" class="form-control" id="email">
                           </div>
                           <div class="form_group">
                               <label for="">Contraseña</label>
                               <input type="text" class="form-control" id="password_user">
                           </div>
                           <br>
                           <div class="form_group">
                               <button class="btn btn-primary" id="btn_guardar">GUARDAR</button>
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
    $('#btn_guardar').click(function () {
        var nombres = $('#nombres').val();
        var email = $('#email').val();
        var password_user = $('#password_user').val();
        if (nombres == "") {
            Swal.fire({
                icon: 'warning',
                title: 'NOMBRE OBLIGATORIO',
                text: 'Debe introducir el nombre.',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                $('#nombres').focus();
            });
        } else if (email == "") {
            Swal.fire({
                icon: 'warning',
                title: 'EMAIL OBLIGATORIO',
                text: 'Debe introducir su email.',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                $('#email').focus();
            });
        } else if (password_user == "") {
            Swal.fire({
                icon: 'warning',
                title: 'CONTRASEÑA OBLIGATORIA',
                text: 'Debe introducir su contraseña.',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                $('#password_user').focus();
            });
        }
        else{
            var url='controller_create_usuario.php';
            $.get(url ,{nombres:nombres, email:email,password_user:password_user}, function(datos){
                $('#respuesta').html(datos);
            });
        }
    });
</script>