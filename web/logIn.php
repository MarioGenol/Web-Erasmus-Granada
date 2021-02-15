<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  require_once 'bd.php';

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);

  $mysql = conexionBD();
  
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nick = $_POST['nick'];
    $pass = $_POST['contraseña'];
  
    if (checkLogin($mysql, $nick, $pass)) {
      session_start();
      $_SESSION['nickUsuario'] = $nick;  // guardo en la sesión el nick del usuario que se ha logueado
      header("Location: index.php");
      exit();

    } else {
      echo "<script>alert('El usuario o la contraseña son incorrectos')</script>";
    }
  }
  
  echo $twig->render('logIn.html', []);
?>
