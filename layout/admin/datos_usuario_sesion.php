<?php

session_start();
if(isset($_SESSION['usuario_sesion'])){
    $usuario_sesion = $_SESSION['usuario_sesion'];

    $query_usuario_sesion = $pdo->prepare(" SELECT
                                            us.id_usuario, us.nombres, us.email,
                                            ro.nombre 
                                            FROM tb_usuarios us
                                            INNER JOIN tb_roles ro on us.id_rol = ro.id_rol 
                                            WHERE us.email = '$usuario_sesion' AND us.estado = '1' ");
    $query_usuario_sesion->execute();
    $usuarios_sesions = $query_usuario_sesion->fetchAll(PDO::FETCH_ASSOC);
    foreach ($usuarios_sesions as $usuarios_sesion) {
        $id_user_sesion = $usuarios_sesion['id_usuario'];
        $nombres_sesion = $usuarios_sesion['nombres'];
        $email_sesion = $usuarios_sesion['email'];
        $rol_sesion = $usuarios_sesion['nombre'];
    }

} else {
    header('Location: '.$URL.'/login/index_login.php');
}

?>
