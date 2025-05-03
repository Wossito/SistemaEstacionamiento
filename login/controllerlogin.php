<?php

include('../app/config.php');


session_start();

$usuario_user = $_POST['usuario'];
$contraseña_user = $_POST['contraseña'];


//echo $usuario. " - ".$contraseña;
$email_tabla =       ''; $contraseña_tabla = '';

$query_login = $pdo->prepare("SELECT * FROM tb_usuarios WHERE email = '$usuario_user' AND contraseña = '$contraseña_user' AND estado = '1' ");
$query_login-> execute();
$usuarios = $query_login->fetchAll(PDO::FETCH_ASSOC);
foreach($usuarios as $usuario){
    $email_tabla = $usuario['email'];
    $contraseña_tabla = $usuario['contraseña'];
}

if(($usuario_user == $email_tabla) && ($contraseña_user == $contraseña_tabla)){
 ?>
        <script>
            Swal.fire({
                icon: "success",
                title: "USUARIO CORRECTO",
                text: "Sesion iniciada",
                confirmButtonText: "Aceptar"
            }).then(() => {
                window.location.href = "<?php echo $URL;?>/principal.php";
            });
          </script>
        <?php

    $_SESSION['usuario_sesion'] = $email_tabla;
}else{
    ?>
    <script>
            Swal.fire({
                icon: "error",
                title: "USUARIO O CONTRASEÑA INCORRECTA",
                text: "Ingrese correctamente sus datos",
                confirmButtonText: "Aceptar"
            })
          </script>
    <?php
}
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

