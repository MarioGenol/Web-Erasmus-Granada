<?php
require_once "/usr/local/lib/php/vendor/autoload.php";
require_once 'bd.php';

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

$mysql = conexionBD();
$nombre ="";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$nick = $_POST['nick'];
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$email = $_POST['email'];
$pass = $_POST['contraseña'];

if (!compruebaNick($mysql, $nick)){
    if(insertUser($mysql, $nick, $nombre, $apellidos, $email, $pass)){
        session_start();
        $_SESSION['nickUsuario'] = $nick;
        header("Location: index.php");
        exit();
    } else echo "<script>alert('E-mail no válido')</script>";
} else echo "<script>alert('El nick ya está en uso')</script>";    
}
echo $twig->render('signUp.html', []);
?>