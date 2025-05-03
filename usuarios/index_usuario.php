<?php 
include('../app/config.php');
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
      <h2>LISTADO DE USUARIOS</h2>
      <script>
                $(document).ready(function() {
                    $('#Tabla_Usuarios').DataTable( {
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
<br> 
      <table id="Tabla_Usuarios"class="table tabla-bordered table-sm table-striped">
        <thead>
        <th><center>Nro<center></th>
        <th>Nombre de Usuarios</th>
        <th>Email</th>
        <th><center>Accion<center></th>
        </thead>

        <tbody>
        <?php 
        $contador=0;
        $query_usuario = $pdo->prepare("SELECT * FROM tb_usuarios WHERE estado = '1' ");
        $query_usuario-> execute();
        $usuarios = $query_usuario->fetchAll(PDO::FETCH_ASSOC);
        foreach($usuarios as $usuario){
            $Id = $usuario['id_usuario'];
            $Nombres = $usuario['nombres'];
            $Email = $usuario['email'];
            $contador = $contador     + 1;
        ?>
            <tr>
            <td><?php echo $contador;?></td>
            <td><?php echo $Nombres;?></td>
            <td><?php echo $Email;?></td>
            <td>
              <center>
                  <a href="update_usuario.php?id=<?php echo $Id;?>" type="button" class="btn btn-success">Editar</a>
                  <button class="btn btn-danger borrar2" data-id="<?php echo $Id; ?>">Borrar</button>
              <center>
            </td>
          </tr>
        <?php
        }
        ?>
        </tbody>
      </table>
      <hr>
            <a href="reporte_usuarios.php" class="btn btn-primary" target="_blank">Generar reporte
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
  <!-- /.content-wrapper -->
  <?php include('../layout/admin/footer.php');?>
  </div>
  <?php include('../layout/admin/footer_links.php');?>
</body>
</html>

<script>
    $(document).on('click', '.borrar2', function () {
        var id_user = $(this).data('id');
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
                $.get('controller_delete_usuario.php', {id_user: id_user}, function(datos) {
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