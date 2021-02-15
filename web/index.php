<?php
require_once "/usr/local/lib/php/vendor/autoload.php";
include ("bd.php");

$mysql = conexionBD();

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

$variablesParaTwig = [];
session_start();

if (isset($_SESSION['nickUsuario'])) {
	$variablesParaTwig['user'] = getUser($mysql, $_SESSION['nickUsuario']);
}

echo $twig->render('portada.html', $variablesParaTwig);
?>
