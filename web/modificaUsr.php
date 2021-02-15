<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  require_once 'bd.php';

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);

  $mysql = conexionBD();
  session_start();

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nick = $_SESSION['nickUsuario'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $email = $_POST['email'];
    $pass = $_POST['contraseña'];
    //Modificamos el usuario y si sale bien redirigimos a index.php
    if(!modifyUser($mysql, $nick, $nombre, $apellidos, $email, $pass)){
      echo"<script>alert('E-mail no válido')</script>";
    } else {
      header("Location: index.php");
      exit();
    }
  }  
  $user = getUser($mysql, $_SESSION['nickUsuario']);
  echo $twig->render('modificaUsr.html', ['user' => $user]);
?>