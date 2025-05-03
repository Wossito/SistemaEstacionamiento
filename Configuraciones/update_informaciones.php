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
    <div class="content-wrapper">
        <br>
        <div class="container">

            <h2>Actualización de la Información</h2>

            <br>
            <div class="row">
                <div class="col-md-12">

                    <div class="card card-outline card-success">
                        <div class="card-header">
                            <h3 class="card-title">Actualize los datos con mucho cuidado</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>

                        </div>

                        <?php
                        $id_informacion_get = $_GET['id'];
                        $query_informacions = $pdo->prepare("SELECT * FROM tb_informaciones WHERE estado = '1' AND id_informacion = '$id_informacion_get' ");
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
                        }
                        ?>

                        <div class="card-body" style="display: block;">

                            <div class="row">
                                <div class="col-md-5">
                                    <label for="">Nombre del Estacionamiento <span style="color: red"><b>*</b></span></label>
                                    <input type="text" class="form-control" id="nombre_estacionamiento" value="<?php echo $nombre_estacionamiento; ?>">
                                </div>
                                <div class="col-md-5">
                                    <label for="">Actividad de la empresa <span style="color: red"><b>*</b></span></label>
                                    <input type="text" class="form-control" id="actividad_empresa" value="<?php echo $actividad_empresa; ?>">
                                </div>
                                <div class="col-md-2">
                                    <label for="">Sucursal <span style="color: red"><b>*</b></span></label>
                                    <input type="text" class="form-control" id="sucursal" value="<?php echo $sucursal; ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Dirección <span style="color: red"><b>*</b></span></label>
                                    <input type="text" class="form-control" id="direccion" value="<?php echo $direccion; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Zona <span style="color: red"><b>*</b></span></label>
                                    <input type="text" class="form-control" id="zona" value="<?php echo $zona; ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <label for="">Teléfono <span style="color: red"><b>*</b></span></label>
                                    <input type="text" class="form-control" id="telefono" value="<?php echo $telefono; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="">Ciudad <span style="color: red"><b>*</b></span></label>
                                    <input type="text" class="form-control" id="ciudad" value="<?php echo $ciudad; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="">País <span style="color: red"><b>*</b></span></label>
                                    <input type="text" class="form-control" id="pais" value="<?php echo $pais; ?>">
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn btn-success btn-block" id="btn_actualizar_informacion">
                                        ACTUALIZAR
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <a href="index_informaciones.php" class="btn btn-default btn-block">CANCELAR</a>
                                </div>
                            </div>

                            <div id="respuesta">

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
<?php include('../layout/admin/footer_link.php'); ?>
</body>
</html>


<script>
    $('#btn_actualizar_informacion').click(function () {
        var nombre_estacionamiento = $('#nombre_estacionamiento').val();
        var actividad_empresa = $('#actividad_empresa').val();
        var sucursal = $('#sucursal').val();
        var direccion = $('#direccion').val();
        var zona = $('#zona').val();
        var telefono = $('#telefono').val();
        var ciudad = $('#ciudad').val();
        var pais = $('#pais').val();
        var id_informacion = '<?php echo $id_informacion_get;?>';

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
            var url = 'controller_update_informaciones.php';
            $.get(url, {
                nombre_estacionamiento: nombre_estacionamiento,
                actividad_empresa: actividad_empresa,
                sucursal: sucursal,
                direccion: direccion,
                zona: zona,

                telefono: telefono,
                ciudad: ciudad,
                pais: pais,
                id_informacion: id_informacion
            }, function (datos) {
                $('#respuesta').html(datos);
            });
        }
    });
</script>