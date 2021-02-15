<?php

include ("bd.php");

session_start();
$bd = conexionBD();

if (isset($_POST['buscar_evento'])) {
  	$user = getUser($bd, $_SESSION['nickUsuario']);

	$nombre = $_POST['buscar_evento'];
	//Dependiendo del tipo de usuario, buscamos todos los eventos o solo los publicados
	if ($user['rango'] == 'gestor' || $user['rango'] == 'superusuario'){
		$query = "SELECT nombre, indice FROM eventos WHERE nombre LIKE '%$nombre%' LIMIT 5";
	} else $query = "SELECT nombre, indice FROM eventos WHERE nombre LIKE '%$nombre%' and publicado='false' LIMIT 5";
	
	$resultado = MySQLi_query($bd, $query);

	//Creamos una lista para mostrar el contenido
	echo '<ul>';

	while ($fila = MySQLi_fetch_array($resultado)) {
		?>
		<!-- Creamos la lista fuera del php -->
		<li>
			<!--Aquí redireccionamos al evento -->
			<a href="../evento.php?ev=<?php echo $fila['indice']; ?>">
				<?php echo $fila['nombre']; ?>
			</a>
		</li>

		<?php
	}
}
?>
<!-- Cerramos la lista -->
</ul>
