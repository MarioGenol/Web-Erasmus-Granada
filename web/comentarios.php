<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  require_once 'bd.php';

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);

  $mysql = conexionBD();
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Aquí creamos el comentario
    if ($_POST['operacion']==0){
      $idEv = $_POST['indice'];
      $email = $_POST['email'];
      $nick = $_POST['nick'];
      $comentario = $_POST['comentario'];

      createComment($mysql, $idEv, $email, $nick, $comentario);
    } else if ($_POST['operacion']==1) {   //Aqui modificamos
      $idEv = $_POST['indice'];
      $email = $_POST['email'];
      $fecha = $_POST['fecha'];
      $hora = $_POST['hora'];
      $comentario = $_POST['editado'];

      modifyComment($mysql, $idEv, $email, $fecha, $hora, $comentario);
    }else { //Aqui borramos
      $idEv = $_POST['indice'];
      $email = $_POST['email'];
      $fecha = $_POST['fecha'];
      $hora = $_POST['hora'];
      $comentario = $_POST['comentario'];

      deleteComment($mysql, $idEv, $email, $fecha, $hora, $comentario);
    }
    header("Location: evento.php?ev=".$idEv);
    exit();
  }
?>