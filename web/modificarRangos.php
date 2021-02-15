<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  require_once 'bd.php';

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);

  $mysql = conexionBD();
  $users = getUsers($mysql);

  //session_start();
  session_start();
  $user = getUser($mysql, $_SESSION['nickUsuario']);
  

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rango = $_POST['rango'];
    $nick = $_POST['nick'];
  
    if (cambiarRango($mysql, $nick, $rango) and $user['nick'] != $nick) {   //Si el superusuario cambia su rol, se vuelve a la página de inicio
      header("Location: modificarRangos.php");      
    } else {
      header("Location: index.php");      
      exit();
    }
  }
  echo $twig->render('modificarRangos.html', ['users' => $users]);
?>
