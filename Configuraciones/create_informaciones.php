<?php
include('../app/config.php');
include('../layout/admin/datos_usuario_sesion.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include('../layout/admin/head.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <?php include('../layout/admin/menu.php'); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <br>
        <div class="container">
            <h2>CREACION DE UNA NUEVA INFORMACION</h2>
            <br>
            <div class="row">
                <div class="col-md-8">

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">REGISTRE LOS DATOS CON MUCHA CUIDADO</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>

                        </div>
                        <div class="card-body" style="display: block;">

                            <div class="row">
                                <div class="col-md-5">
                                    <label for="">Nombre del Estacionamiento <span style="color: red"><b>*</b></span></label>
                                    <input type="text" class="form-control" id="nombre_estacionamiento">
                                </div>
                                <div class="col-md-5">
                                    <label for="">Actividad de la empresa <span style="color: red"><b>*</b></span></label>
                                    <input type="text" class="form-control" id="actividad_empresa">
                                </div>
                                <div class="col-md-2">
                                    <label for="">Sucursal <span style="color: red"><b>*</b></span></label>
                                    <input type="text" class="form-control" id="sucursal">
                                </div>
                            </div>

                            <br>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Dirección <span style="color: red"><b>*</b></span></label>
                                    <input type="text" class="form-control" id="direccion">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Zona <span style="color: red"><b>*</b></span></label>
                                    <input type="text" class="form-control" id="zona">
                                </div>
                            </div>

                            <br>

                            <div class="row">
                                <div class="col-md-4">
                                    <label for="">Teléfono <span style="color: red"><b>*</b></span></label>
                                    <input type="text" class="form-control" id="telefono">
                                </div>
                                <div class="col-md-4">
                                    <label for="">Ciudad <span style="color: red"><b>*</b></span></label>
                                    <input type="text" class="form-control" id="ciudad">
                                </div>
                                <div class="col-md-4">
                                    <label for="">País <span style="color: red"><b>*</b></span></label>
                                    <input type="text" class="form-control" id="pais">
                                </div>
                            </div>


                            <hr>

                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn btn-primary btn-block" id="btn_registrar_informacion">
                                        REGISTRAR
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <a href="informaciones.php" class="btn btn-default btn-block">CANCELAR</a>
                                </div>
                            </div>

                            <div id = "respuesta">

                            </div>

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
    $('#btn_registrar_informacion').click(function () {

        var nombre_estacionamiento = $('#nombre_estacionamiento').val();
        var actividad_empresa = $('#actividad_empresa').val();
        var sucursal = $('#sucursal').val();
        var direccion = $('#direccion').val();
        var zona = $('#zona').val();
        var telefono = $('#telefono').val();
        var ciudad = $('#ciudad').val();
        var pais = $('#pais').val();

        if(nombre_estacionamiento == ""){
            Swal.fire({
                icon: 'warning',
                title: 'NOMBRE DEL ESTACIONAMIENTO OBLIGATORIO',
                text: 'Debe llenar el campo nombre del estacionamiento',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                $('#nombre_estacionamiento').focus();
            });
        } else if(actividad_empresa == ""){
            Swal.fire({
                icon: 'warning',
                title: 'ACTIVIDAD DE LA EMPRESA OBLIGATORIA',
                text: 'Debe llenar el campo actividad de la empresa',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                $('#actividad_empresa').focus();
            });
        } else if(sucursal == ""){
            Swal.fire({
                icon: 'warning',
                title: 'SUCURSAL OBLIGATORIA',
                text: 'Debe llenar el campo sucursal',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                $('#sucursal').focus();
            });
        } else if(direccion == ""){
            Swal.fire({
                icon: 'warning',
                title: 'DIRECCIÓN OBLIGATORIA',
                text: 'Debe llenar el campo dirección',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                $('#direccion').focus();
            });
        } else if(zona == ""){
            Swal.fire({
                icon: 'warning',
                title: 'ZONA OBLIGATORIA',
                text: 'Debe llenar el campo zona',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                $('#zona').focus();
            });
        } else if(telefono == ""){
            Swal.fire({
                icon: 'warning',
                title: 'TELÉFONO OBLIGATORIO',
                text: 'Debe llenar el campo teléfono',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                $('#telefono').focus();
            });
        } else if(ciudad == ""){
            Swal.fire({
                icon: 'warning',
                title: 'CIUDAD OBLIGATORIA',
                text: 'Debe llenar el campo departamento o ciudad',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                $('#ciudad').focus();
            });
        } else if(pais == ""){
            Swal.fire({
                icon: 'warning',
                title: 'PAÍS OBLIGATORIO',
                text: 'Debe llenar el campo país',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                $('#pais').focus();
            });
        } else {
            var url = 'controller_create_informaciones.php';
            $.get(url, {
                nombre_estacionamiento: nombre_estacionamiento,
                actividad_empresa: actividad_empresa,
                sucursal: sucursal,
                direccion: direccion,
                zona: zona,
                telefono: telefono,
                ciudad: ciudad,
                pais: pais
            }, function (datos) {
                $('#respuesta').html(datos);
            });
        }
    });
</script>
