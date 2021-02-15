<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  
  if (isset($_GET['ev'])) {
    $idEv = $_GET['ev'];
  } else {
    $idEv = -1;
  }
  
  $mysql = conexionBD();
  $evento = getEvento($idEv, $mysql);
  $comentarios = getComentariosEvento($idEv, $mysql);
  $palabrasProhibidas = getPalabrasProhibidas($mysql);

  session_start();
  if (isset($_SESSION['nickUsuario'])) {
    $user = getUser($mysql, $_SESSION['nickUsuario']);
  }
  
  echo $twig->render('evento.html', ['evento' => $evento, 'comentarios' => $comentarios, 'palabrasProhibidas' => $palabrasProhibidas, 'user' => $user]);
?>
