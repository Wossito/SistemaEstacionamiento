<?php

define('SERVIDOR','localhost');
define('USUARIO','root');
define('PASSWORD','30060430');
define('BD','ESTACIONAMIENTO2');

$servidor = "mysql:dbname=".BD.";host=".SERVIDOR;

try{
    $pdo = new PDO($servidor,USUARIO,PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));
    // echo "<script>alert('La conexion ha sido realizada correctamente')</script>";
} catch (PDOException $e){
    // echo "Error a la hora de conectar en la base de datos";
    echo "<script>alert('Error en la base de datos')</script>";
}

$URL="http://localhost/www.sistemaestacionamiento2.com";

$estado_del_registro = "1";

?>