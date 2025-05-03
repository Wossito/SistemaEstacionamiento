<?php include('app/config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISTEMA DE ESTACIONAMIENTO</title>

    <!-- Bootstrap CSS local -->
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
</head>
<body style="background-image: url('public/imagenes/piso3.jpg');
            background-repeat: no-repeat;
            z-index: -3;
            background-size: 100vw 100vh">
  
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<a class="navbar-brand" href="#">
    <img src="<?php echo $URL;?>/public/imagenes/carro2-removebg-preview.png" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">
    SISTEMA ESTACIONAMIENTO
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">INICIO <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="#">INFORMACION</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="#">INTERFAZ</a>
      </li>
      <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
          OPCIONES
        </a>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="#">1</a>
          <a class="dropdown-item" href="#">2</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">3</a>
        </div>
      </li> 
      <li class="nav-item active">
        <a class="nav-link" href="#">SOBRE NOSOTROS</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="#">CONTACTANOS</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
    </form>
    <a href="login/index_login.php" class="btn btn-primary">
    INGRESAR
</a>
  </div>
</nav>
<br>
<div class="container">
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
                        <h2 class="text-white"><?php echo $nro_espacio;?></h2>
                        <button class="btn btn-success" style="width: 100%; height: 114px">
                            <p class="text-white"><?php echo $estado_espacio;?></p>
                        </button>
                    </center>
                </div>

                <?php
            }
            if ($estado_espacio == "OCUPADO") {
                ?>
                <div class="col">
                    <center>
                        <h2 class="text-white"><?php echo $nro_espacio;?></h2>
                        <button class="btn btn-primary">
                            <img src="<?php echo $URL;?>/public/imagenes/auto1.png" width="65px" alt="">
                        </button>
                        <p class="text-white"><?php echo $estado_espacio;?></p>
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

<!-- jQuery, Popper.js y Bootstrap JS locales -->
<script src="public/js/jquery-3.7.1.min.js"></script>
<script src="public/js/popper.min.js"></script>
<script src="public/js/bootstrap.min.js"></script>

</body>
</html>

          