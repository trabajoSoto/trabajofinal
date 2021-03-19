<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.80.0">
    <title>SPAKARMA</title>


    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" integrity="sha512-KXkS7cFeWpYwcoXxyfOumLyRGXMp7BTMTjwrgjMg0+hls4thG2JGzRgQtRfnAuKTn2KWTDZX4UdPg+xTs8k80Q==" crossorigin="anonymous" />


<link href="/assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }


      .fondo {
        
        background-image: url('imagenes/agua-gotas.jpg');

      }

      img.transparent {
        filter:alpha(opacity=60);
        opacity:.60;
      }

    </style>

    
    <!-- Estilos para este template -->
    <link href="/assets/starter-template.css" rel="stylesheet">
  </head>
  <body class="fondo">
    

  <?php

require_once ('app.php');
$app = new App();
$app->run();
?>

<!-- Creamos la barra de inicio con un listado en horizontal en diferentes estilos-->

<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="/index.php?action=dashboard">INICIO</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav me-auto mb-2 mb-md-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href='index.php?action=calendario'>RESERVAS</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-bs-toggle="dropdown" aria-expanded="false">SOCIOS</a>
          <ul class="dropdown-menu" aria-labelledby="dropdown01">
            <li><a class="dropdown-item" href="/index.php?action=show-customer">VER SOCIOS</a></li>
            <li><a class="dropdown-item" href="/index.php?action=search-customer">BUSCA SOCIO</a></li>
            <li><a class="dropdown-item" href="index.php?action=defaulter">DEUDA</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdown02" data-bs-toggle="dropdown" aria-expanded="false">EMPLEADOS</a>
          <ul class="dropdown-menu" aria-labelledby="dropdown02">
            <li><a class="dropdown-item" href="/index.php?action=show-employee">VER EMPLEADOS</a></li>
            <li><a class="dropdown-item" href="/index.php?action=search-employee">BUSCAR EMPLEADO</a></li>
            <li class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="/index.php?action=materials">INVENTARIO</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle " href="#" id="dropdown03" data-bs-toggle="dropdown" aria-expanded="true">INFO</a>
          <ul class="dropdown-menu" aria-labelledby="dropdown03">
            <li><a class="dropdown-item" href="/index.php?action=fisioterapia">FISIOTERAPIA</a></li>
            <li><a class="dropdown-item" href="/index.php?action=gimnasio">GIMNASIO</a></li>
            <li><a class="dropdown-item" href="/index.php?action=piscina">PISCINA</a></li>
            <li><a class="dropdown-item" href="/index.php?action=salas">ACTIVIDADES</a></li>
          </ul>
        </li>
      </ul>
      <form class="d-flex">
      <li class="nav-item">
        <button class="btn btn-outline-success" href='/index.php?action=log-off' onclick="return confirm('¿Seguro que quieres salir?');">SALIR</button>
      </li>
      </form>
    </div>
  </div>
</nav>

<main class="container" >

        <div class="starter-template text-center py-5 px-3">
          <h1>SPAKARMA</h1>
          <p class="lead text-primary">Si hay magia en este planeta, está contenida en el agua</p>
        </div>
        <div class=" text-center text-md-start p-1">
          <footer class="blockquote-footer">proyecto fin de ciclo Sebastián Soto</footer>
        </div>

</main><!-- el container donde mantendremos información, como nombre de empresa -->



<!-- lista de librerías añadidas-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
            
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js" integrity="sha512-o0rWIsZigOfRAgBxl4puyd0t6YKzeAw9em/29Ag7lhCQfaaua/mDwnpE2PVzwqJ08N7/wqrgdjc2E0mwdSY2Tg==" crossorigin="anonymous"></script>
    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/es.min.js" integrity="sha512-DekU3EtZYK7QnqJh6Y+0LSL4w48zh6ZP/f52wTKiRa7uTlS8Eecw9aBVPwT4pR17B3dxiZBJwo/+XH8FPehgkQ==" crossorigin="anonymous"></script>

            <script src="/assets/dist/js/bootstrap.bundle.min.js"></script>
            <script src="/resources/js/main.js"></script>
  </body>

</html>