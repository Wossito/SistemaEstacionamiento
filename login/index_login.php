<?php 
include('../app/config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>LOGIN</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $URL;?>/app/templeates/AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo $URL;?>/app/templeates/AdminLTE-3.2.0/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $URL;?>/app/templeates/AdminLTE-3.2.0/dist/css/adminlte.min.css">
  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>SISTEMA DE ESTACIONAMIENTO</b>JF</a>
  </div>
  <!-- /.login-logo -->
   <br>
  <center>
        <img src="<?php echo $URL;?>/public/imagenes/carro2.png" width="250px" alt="">
    </center>
    <br>
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Inicio de Sesion</p>
      
      <div id="respuesta"></div>
      
      <form id="loginForm">
        <div class="input-group mb-3">
          <input type="email" id="usuario" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" id="contraseña" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button type="button" class="btn btn-success btn-block" id="btn_ingresar">INGRESAR</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?php echo $URL;?>/app/templeates/AdminLTE-3.2.0/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo $URL;?>/app/templeates/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $URL;?>/app/templeates/AdminLTE-3.2.0/dist/js/adminlte.min.js"></script>

<script>
$('#btn_ingresar').click(function() {
    login();
});

$('#contraseña').keypress(function(e) {
    if (e.which == 13) {
        login();
    }
});

function login() {
    var usuario = $('#usuario').val();
    var contraseña = $('#contraseña').val();

    if (usuario === "") {
        Swal.fire({
            icon: 'warning',
            title: 'Usuario OBLIGATORIO',
            text: 'Debe introducir el Usuario.',
            confirmButtonText: 'Aceptar'
        }).then(() => {
            $('#usuario').focus();
        });
    } else if (contraseña === "") {
        Swal.fire({
            icon: 'warning',
            title: 'CONTRASEÑA OBLIGATORIA',
            text: 'Debe introducir la contraseña.',
            confirmButtonText: 'Aceptar'
        }).then(() => {
            $('#contraseña').focus();
        });
    } else {
        var url = 'controllerlogin.php';
        $.post(url, {usuario: usuario, contraseña: contraseña}, function(datos) {
            $('#respuesta').html(datos);
        });
    }
}
</script>
</body>
</html>
