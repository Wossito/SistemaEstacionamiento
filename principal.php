<?php
include('app/config.php');
include('layout/admin/datos_usuario_sesion.php');

//recuperar el id de la informacion
$query_informacions = $pdo->prepare("SELECT * FROM tb_informaciones WHERE estado = '1' ");
$query_informacions->execute();
$informacions = $query_informacions->fetchAll(PDO::FETCH_ASSOC);
foreach($informacions as $informacion){
    $id_informacion = $informacion['id_informacion'];
}
/////////////////////////////////////////////



//recuperar el el numero de la factura
$contador_del_nro_de_factura = 0;
$query_facturaciones = $pdo->prepare("SELECT * FROM tb_facturaciones WHERE estado = '1' ");
$query_facturaciones->execute();
$facturaciones = $query_facturaciones->fetchAll(PDO::FETCH_ASSOC);
foreach($facturaciones as $facturacione){
    $contador_del_nro_de_factura = $contador_del_nro_de_factura +1;
}
$contador_del_nro_de_factura = $contador_del_nro_de_factura +1;
/////////////////////////////////////////////
    ?>
    <!DOCTYPE html>

<html lang="es">
<head>
    <?php include('layout/admin/head.php');?>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <?php include('layout/admin/menu.php');?>

  <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <br>
        <div class="container">
            <h2>Bienvenido AL SISTEMA DE ESTACIONAMIENTO - JF</h2>
            <br>
            <div class="row">
                <div class="col-md-12">

                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">MAPEO ACTUAL DEL PARQUEO</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>

                        </div>

                        <div class="card-body" style="display: ">
                            <div class="row">
                                <?php
                                $query_mapeos = $pdo->prepare("SELECT * FROM tb_mapeos WHERE estado = '1' ");
                                $query_mapeos->execute();
                                $mapeos = $query_mapeos->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($mapeos as $mapeo) {
                                    $id_map = $mapeo['id_map'];
                                    $nro_espacio = $mapeo['nro_espacio'];
                                    $estado_espacio = $mapeo['estado_espacio'];

                                    if ($estado_espacio == "LIBRE") {
                                        ?>
                                        <div class="col">
                                            <center>
                                                <h2><?php echo $nro_espacio;?></h2>
                                                <button class="btn btn-success" style="width: 102%; height: 125px"
                                                        data-toggle="modal"  data-target="#modal<?php echo $id_map;?>">
                                                    <p><?php echo $estado_espacio;?></p>
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="modal<?php echo $id_map;?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">INGRESO DEL VEHICULO</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">

                                                                <div class="form-group row">
                                                                    <label for="staticEmail" class="col-sm-3 col-form-label">DNI/CARNET: <span><b style="color: red">*</b></span></label>
                                                                    <div class="col-sm-6">
                                                                        <input type="text" class="form-control" id="dni_buscar<?php echo $id_map;?>">
                                                                    </div>
                                                                    <div class="col-sm-3">
                                                                        <button class="btn btn-primary" id="btn_buscar_cliente<?php echo $id_map;?>" type="button">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                                                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                                                                            </svg>
                                                                            BUSCAR
                                                                        </button>
                                                                        <script>
                                                                            $('#btn_buscar_cliente<?php echo $id_map;?>').click(function(){
                                                                                var dni = $('#dni_buscar<?php echo $id_map;?>').val();
                                                                                var id_map = "<?php echo $id_map;?>";
                                                                                if (dni == "") {
                                                                                    Swal.fire({
                                                                                        icon: 'warning',
                                                                                        title: 'DNI requerido',
                                                                                        text: 'DEBE INTRODUCIR EL DNI',
                                                                                        confirmButtonText: 'Aceptar'
                                                                                    }).then(() => {
                                                                                        $('#dni_buscar<?php echo $id_map;?>').focus();
                                                                                    });
                                                                                } else{
                                                                                    var url='clientes/controller_buscar_clientes.php';
                                                                                    $.get(url ,{dni:dni,id_map:id_map}, function(datos){
                                                                                        $('#respuesta_buscar_cliente<?php echo $id_map;?>').html(datos);
                                                                                    });
                                                                                }
                                                                            });

                                                                        </script>
                                                                    </div>
                                                                </div>

                                                                <div id="respuesta_buscar_cliente<?php echo $id_map;?>">

                                                                </div>

                                                                <div class="form-group row">
                                                                    <label for="staticEmail" class="col-sm-5 col-form-label">FECHA DE INGRESO:</label>
                                                                    <div class="col-sm-7">
                                                                        <?php
                                                                        date_default_timezone_set("America/Lima");
                                                                        $fecha_hora = date("Y-m-d H:i:s");
                                                                        $dia = date("d");
                                                                        $mes = date("m");
                                                                        $anio = date("Y");
                                                                        ?>
                                                                        <input type="date" class="form-control" id="fecha_ingreso<?php echo $id_map;?>" value="<?php echo $anio."-".$mes."-".$dia;?>" disabled>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label for="staticEmail" class="col-sm-5 col-form-label">HORA DE INGRESO:</label>
                                                                    <div class="col-sm-7">
                                                                        <?php
                                                                        date_default_timezone_set("America/Lima");
                                                                        $fecha_hora = date("Y-m-d H:i:s");
                                                                        $hora = date("H");
                                                                        $minutos = date("i");
                                                                        ?>
                                                                        <input type="time" class="form-control" id="hora_ingreso<?php echo $id_map;?>" value="<?php echo $hora.":".$minutos;?>" disabled>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label for="staticEmail" class="col-sm-5 col-form-label">CUBÍCULO:</label>
                                                                    <div class="col-sm-7">
                                                                        <input type="text" class="form-control" id="cubiculo<?php echo $id_map;?>"value="<?php echo $nro_espacio;?>" disabled>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-success" id="btn_registrar_ticket<?php echo $id_map;?>" disabled>REGISTRAR E IMPRIMIR TICKET</button>
                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">CERRAR</button>

                                                                <script>

                                                                    $('#btn_registrar_ticket<?php echo $id_map;?>').click(function () {

                                                                        var dni_cliente = $('#dni_buscar<?php echo $id_map;?>').val();
                                                                        var nombre_cliente = $('#nombre_cliente<?php echo $id_map;?>').val();
                                                                        var placa_auto = $('#placa_auto<?php echo $id_map;?>').val();
                                                                        var cargo_cliente = $('#cargo_cliente<?php echo $id_map;?>').val();
                                                                        var marca_auto= $('#marca_auto<?php echo $id_map;?>').val();
                                                                        var fecha_ingreso = $('#fecha_ingreso<?php echo $id_map;?>').val();
                                                                        var hora_ingreso = $('#hora_ingreso<?php echo $id_map;?>').val();
                                                                        var cubiculo = $('#cubiculo<?php echo $id_map;?>').val();
                                                                        var user_session = "<?php echo $usuario_sesion; ?>";
                                                                        var id_informacion = "<?php echo $id_informacion; ?>";


                                                                        if(dni_cliente == ""){
                                                                            Swal.fire({
                                                                                icon: 'warning',
                                                                                title: 'DNI DEL CLIENTE OBLIGATORIO',
                                                                                text: 'Debe llenar el campo DNI del cliente',
                                                                                confirmButtonText: 'Aceptar'
                                                                            }).then(() => {
                                                                                $('#dni_buscar<?php echo $id_map;?>').focus();
                                                                            });
                                                                        } else if(nombre_cliente == ""){
                                                                            Swal.fire({
                                                                                icon: 'warning',
                                                                                title: 'NOMBRE DEL CLIENTE OBLIGATORIO',
                                                                                text: 'Debe llenar el campo nombre del cliente',
                                                                                confirmButtonText: 'Aceptar'
                                                                            }).then(() => {
                                                                                $('#nombre_cliente<?php echo $id_map;?>').focus();
                                                                            });
                                                                        } else if(placa_auto == ""){
                                                                            Swal.fire({
                                                                                icon: 'warning',
                                                                                title: 'PLACA DEL CLIENTE OBLIGATORIA',
                                                                                text: 'Debe llenar el campo placa del cliente',
                                                                                confirmButtonText: 'Aceptar'
                                                                            }).then(() => {
                                                                                $('#placa_auto<?php echo $id_map;?>').focus();
                                                                            });
                                                                        } else if(cargo_cliente == ""){
                                                                            Swal.fire({
                                                                                icon: 'warning',
                                                                                title: 'CARGO DEL CLIENTE OBLIGATORIO',
                                                                                text: 'Debe llenar el campo cargo del cliente',
                                                                                confirmButtonText: 'Aceptar'
                                                                            }).then(() => {
                                                                                $('#cargo_cliente<?php echo $id_map;?>').focus();
                                                                            });
                                                                        } else if(cubiculo == ""){
                                                                            Swal.fire({
                                                                                icon: 'warning',
                                                                                title: 'MARCA DEL CARRO CLIENTE OBLIGATORIA',
                                                                                text: 'Debe llenar el campo marca del cliente',
                                                                                confirmButtonText: 'Aceptar'
                                                                            }).then(() => {
                                                                                $('#cubiculo<?php echo $id_map;?>').focus();
                                                                            });
                                                                        } else{

                                                                            var url_1 = 'parqueo/controller_cambiar_estado_ocupado.php';
                                                                            $.get(url_1, {
                                                                                cubiculo: cubiculo
                                                                            }, function (datos) {
                                                                                $('#respuesta_ticket').html(datos);

                                                                            });

                                                                            var url_2 = 'clientes/controller_registrar_clientes.php';
                                                                            $.get(url_2,{dni_cliente:dni_cliente,
                                                                                nombre_cliente:nombre_cliente,
                                                                                placa_auto:placa_auto,
                                                                                cargo_cliente:cargo_cliente,
                                                                                marca_auto:marca_auto},function (datos) {
                                                                                $('#respuesta_ticket').html(datos);
                                                                            });

                                                                            var url_3 = 'tickets/controller_registrar_ticket.php';
                                                                            $.get(url_3, {
                                                                                id_informacion: id_informacion,
                                                                                dni_cliente: dni_cliente,
                                                                                nombre_cliente: nombre_cliente,
                                                                                placa_auto: placa_auto,
                                                                                cargo_cliente: cargo_cliente,
                                                                                marca_auto: marca_auto,
                                                                                fecha_ingreso: fecha_ingreso,
                                                                                hora_ingreso: hora_ingreso,
                                                                                cubiculo: cubiculo,
                                                                                user_session: user_session
                                                                            }, function (datos) {
                                                                                $('#respuesta_ticket').html(datos);
                                                                            });

                                                                        }
                                                                    });
                                                                </script>
                                                                <div id="respuesta_ticket">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </center>
                                        </div>

                                        <?php
                                    }
                                    if ($estado_espacio == "OCUPADO") {
                                        ?>
                                        <div class="col">
                                            <center>
                                                <h2><?php echo $nro_espacio;?></h2>
                                                <button class="btn btn-primary" id="btn_ocupado<?php echo $id_map;?>" 
                                                data-toggle="modal" data-target="#exampleModal<?php echo $id_map;?>">
                                                    <img src="<?php echo $URL;?>/public/imagenes/auto1.png" width="60px" alt="">
                                                </button>

                                                <?php
                                          
// Consulta para obtener todos los detalles relacionados con ese ticket específico
$query_datos_cliente = $pdo->prepare("
    SELECT 
        t.id_ticket, t.fecha_ingreso, t.hora_ingreso,
        cl.dni_cliente, cl.nombre_cliente, cl.cargo_cliente,
        au.placa_auto, au.marca_auto,
        m.nro_espacio
    FROM tb_tickets t
    INNER JOIN tb_mapeos m ON m.id_map = t.id_map
    INNER JOIN tb_clientes cl ON t.id_cliente = cl.id_cliente
    INNER JOIN tb_autos au ON cl.id_auto = au.id_auto
    WHERE m.nro_espacio = '$nro_espacio' and m.estado = '1'
    ORDER BY t.hora_ingreso DESC
    LIMIT 1;

");

// Ejecutar la consulta
$query_datos_cliente->execute();

// Recuperar los datos
$datos = $query_datos_cliente->fetchAll(PDO::FETCH_ASSOC);

// Iterar sobre los resultados para procesarlos
foreach($datos as $dato) {
    $id_ticket = $dato['id_ticket'];
    $fecha_ingreso = $dato['fecha_ingreso'];
    $hora_ingreso = $dato['hora_ingreso'];

    // Datos del cliente
    $nombre_cliente = $dato['nombre_cliente'];
    $dni_cliente = $dato['dni_cliente'];
    $cargo_cliente = $dato['cargo_cliente'];

    // Datos del auto
    $placa_auto = $dato['placa_auto'];
    $marca_auto = $dato['marca_auto'];

    // Datos del espacio
    $cubiculo = $dato['nro_espacio'];

    // También puedes procesar estos datos o mostrarlos según sea necesario
}
$fecha_ingreso = date("Y-m-d");

                                            
                                             ?>
                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal<?php echo $id_map;?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">DATOS DEL CLIENTE</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                                
                                                            </div>
                                                            <div class="modal-body">

                                                                <div class="form-group row">
                                                                    <label for="staticEmail" class="col-sm-4 col-form-label">DNI/CARNET: </label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control" value="<?php echo $dni_cliente;?>   "id="dni_buscar<?php echo $id_map;?>" disabled>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label for="staticEmail" class="col-sm-4 col-form-label">NOMBRE: </label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control" value="<?php echo $nombre_cliente;?>"id="nombre_cliente<?php echo $id_map;?>" disabled>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label for="staticEmail" class="col-sm-4 col-form-label">PLACA: </label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control" value="<?php echo $placa_auto; ?>" id="placa_auto<?php echo $id_map;?>" disabled>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label for="staticEmail" class="col-sm-4 col-form-label">CARGO: </label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control" value="<?php echo $cargo_cliente ;?>" id="cargo_cliente<?php echo $id_map;?>" disabled>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label for="staticEmail" class="col-sm-4 col-form-label">MARCA: </label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control" value="<?php echo $marca_auto; ?>" id="marca_auto<?php echo $id_map;?>" disabled>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label for="staticEmail" class="col-sm-5 col-form-label">FECHA DE INGRESO:</label>
                                                                    <div class="col-sm-7">
                                                                    <script>$fecha_ingreso = date("Y-m-d");
                                                                    </script>
                                                                    <input type="text" class="form-control" value="<?php echo $fecha_ingreso;?>" id="fecha_ingreso<?php echo $id_map;?>" disabled>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label for="staticEmail" class="col-sm-5 col-form-label">HORA DE INGRESO:</label>
                                                                    <div class="col-sm-7">

                                                                        <input type="time" class="form-control" value="<?php echo $hora_ingreso;?>" id="hora_ingreso<?php echo $id_map;?>" disabled>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label for="staticEmail" class="col-sm-5 col-form-label">CUBICULO:</label>
                                                                    <div class="col-sm-7">
                                                                        <input type="text" class="form-control" value="<?php echo $cubiculo;?>" id="cubiculo<?php echo $id_map;?>" disabled>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <a href="tickets/re-imprimir_ticket.php?id=<?php echo $id_ticket;?>" class="btn btn-primary" target="_blank">Volver a Imprimir</a>
                                                                <a href="tickets/controller_cancelar_ticket.php?id=<?php echo $id_ticket;?>&&cubiculo=<?php echo $cubiculo;?>" class="btn btn-danger">Cancelar ticket</a>
                                                                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                                                                <button type="button" class="btn btn-success" id="btn_facturar<?php echo $id_map;?>">Facturar</button>

                                                                <?php
                                                                ///////////////////// recupera el id del cliente
                                                                $query_datos_cliente_factura = $pdo->prepare("SELECT * FROM tb_clientes WHERE dni_cliente = '$dni_cliente' AND estado = '1' ");
                                                                $query_datos_cliente_factura->execute();
                                                                $datos_clientes_facturas = $query_datos_cliente_factura->fetchAll(PDO::FETCH_ASSOC);
                                                                foreach($datos_clientes_facturas as $datos_clientes_factura){
                                                                    $id_cliente_facturacion = $datos_clientes_factura['id_cliente'];
                                                                }
                                                                /////////////////////////////////////////////////////////////////
                                                                ?>
                                                                <script>
                                                                    $('#btn_facturar<?php echo $id_map;?>').click(function () {
                                                                        var id_informacion = "<?php echo $id_informacion; ?>";
                                                                        var nro_factura = "<?php echo $contador_del_nro_de_factura; ?>";
                                                                        var id_cliente = "<?php echo $id_cliente_facturacion;?>";
                                                                        var fecha_ingreso = "<?php echo $fecha_ingreso; ?>";
                                                                        var hora_ingreso = "<?php echo $hora_ingreso; ?>";
                                                                        var cubiculo = "<?php echo $cubiculo; ?>";
                                                                        var user_sesion = "<?php echo $usuario_sesion; ?>";
                                                                       

                                                                        var url_4 = 'Facturacion/controller_registrar_factura.php';
                                                                        $.get(url_4,{id_informacion:id_informacion,nro_factura:nro_factura,id_cliente:id_cliente,
                                                                            fecha_ingreso:fecha_ingreso,hora_ingreso:hora_ingreso,cubiculo:cubiculo,
                                                                            user_sesion:user_sesion},function (datos) {
                                                                            $('#respuesta_factura<?php echo $id_map;?>').html(datos);
                                                                        });
                                                                    });
                                                                </script>
                                                            </div>
                                                            <div id="respuesta_factura<?php echo $id_map;?>">
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <p><?php echo $estado_espacio;?></p>
                                            </center>
                                        </div>

                                        <?php
                                    }
                                ?>

                                <?php
                                }
                                ?>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>
  <!-- /.content-wrapper -->

  <?php include('layout/admin/footer.php');?>
  <?php include('layout/admin/footer_links.php');?>
</body>
</html>


<script>
    // Obtener los botones por su ID
    const botonDeshabilitado = document.getElementById("btn_registrar_ticket");
    const botonHabilitar = document.getElementById("btn_buscar_cliente");

    // Agregar un evento de clic al botón de habilitación
    botonHabilitar.addEventListener("click", function() {
        // Habilitar el botón deshabilitado
        botonDeshabilitado.disabled = false;
    });
</script>