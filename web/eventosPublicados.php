<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  require_once 'bd.php';

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);

  $mysql = conexionBD();
  $users = getUsers($mysql);

  //session_start();
  session_start();
  $eventos = getEventos($mysql);
  
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bool = $_POST['publicado'];
    $nombreEv = $_POST['nombreEv'];
  
    if (cambiarPublicado($mysql, $nombreEv, $bool)) {   //Si el superusuario cambia su rol, se vuelve a la página de inicio
      header("Location: eventosPublicados.php");      
    }
  }
  echo $twig->render('eventosPublicados.html', ['eventos' => $eventos]);
?>