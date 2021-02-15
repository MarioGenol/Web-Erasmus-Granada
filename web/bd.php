<?php

	function conexionBD(){
		$db_server = "mysql";
		$db_name = "SIBW";
		$db_user = "usuario";
		$db_pass = "usuario";

		$mysqli = new mysqli($db_server, $db_user, $db_pass, $db_name);
		
		if($mysqli->connect_errno){
			die("Connection failed" . $connection->connect_error); 
		}
		
		if(!$mysqli->set_charset( "utf8" )){
			echo "error cargando el conjunto de caracteres utf8";
		}
		return $mysqli;
	}
	
	function desconexionBD(){
		mysqli_close();
	}

	//Devolvemos un evento dado el índice
	function getEvento($idEv, $mysqli) {
  		//$mysqli = conexionBD();

		settype($idEv, "integer"); //Evitamos inyección de código
		$res = $mysqli->query("SELECT indice, nombre, fecha, lugar, fecha_pub, descripcion, img1, img2, img1text, img2text, publicado FROM eventos WHERE indice=" . $idEv); //Elegimos evento según el índice que es único de cada uno
    		
		if ($res->num_rows > 0) {
			$row = $res->fetch_assoc();
      			$evento = array('indice' => $row['indice'], 'nombre' => $row['nombre'], 'fecha' => $row['fecha'], 'lugar' => $row['lugar'], 'fecha_pub' => $row['fecha_pub'], 'descripcion' => $row['descripcion'], 'img1' => $row['img1'], 'img2' => $row['img2'], 'img1text' => $row['img1text'], 'img2text' => $row['img2text'], 'publicado' => $row['publicado']);
		}
    		return $evento;
  	}

    function getEventos($mysqli) {
    $res = $mysqli->query("SELECT indice, nombre, fecha, lugar, fecha_pub, descripcion, img1, img2, img1text, img2text, publicado FROM eventos");
        
    if ($res->num_rows > 0) {
      while($row = $res->fetch_assoc()){
        $eventos[] = array('indice' => $row['indice'], 'nombre' => $row['nombre'], 'fecha' => $row['fecha'], 'lugar' => $row['lugar'], 'fecha_pub' => $row['fecha_pub'], 'descripcion' => $row['descripcion'], 'img1' => $row['img1'], 'img2' => $row['img2'], 'img1text' => $row['img1text'], 'img2text' => $row['img2text'], 'publicado' => $row['publicado']);
      }
    }
        return $eventos;
    }

    function cambiarPublicado($mysqli, $nombreEv, $bool){
      $stmt = $mysqli->prepare("UPDATE eventos SET publicado=? WHERE nombre=?");
      $stmt->bind_param('is', $boolParam, $nombreEvParam);

      if ($bool == 'visible'){
        $boolParam = '1';
      } else $boolParam = '0';
      $nombreEvParam = $nombreEv;

      if ($stmt->execute()) {
        return true;
      }else return false;
    } 

  	//Devolvemos los comentarios dado un evento
	function getComentariosEvento($idEv, $mysqli) {
		settype($idEv, "integer"); //Evitamos inyección de código
		$res = $mysqli->query("SELECT * FROM comentarios WHERE indice=" . $idEv); //Elegimos el comentario según el índice que es único de cada evento asociado a el
    		
		if ($res->num_rows > 0) {
			while($row = $res->fetch_assoc()) {
			        $comentarios[] = array('indice' => $row['indice'], 'nombre' => $row['nombre'], 'hora' => $row['hora'], 'texto' => $row['texto'], 'email' => $row['email']);
			}
		}
    		return $comentarios;
  	}

  	//Creamos un comentario
	function createComment($mysqli, $idEv, $email, $nick, $comentario) {
		$palabras=getPalabrasProhibidas($mysqli);
		//limpiamos el comentario
		for ($i = 0; $i < count($palabras); ++$i){
			$str = str_replace ( $palabras[$i] , "" , $comentario );
			$comentario = $str;
		}

		$stmt = $mysqli->query("INSERT INTO comentarios (indice, nombre, texto, email) VALUES ('$idEv', '$nick', '$comentario', '$email')");

	}

  	//Modificamos un comentario
	function modifyComment($mysqli, $idEv, $email, $fecha, $hora, $comentario) {
    	$stmt = $mysqli->prepare("UPDATE comentarios SET texto=? WHERE indice=? and email=? and hora=?");
		$stmt->bind_param('siss', $texto, $indice, $email, $hora);

		$texto = $comentario;
		$indice = $idEv;
		$email = $email;
		$hora = $hora;

		if ($stmt->execute()) {
  			return true;
  		} else {
  			return false;
  		}
  	}
  	//Borramos el comentario
  	function deleteComment($mysqli, $idEv, $email, $fecha, $hora, $comentario) {
    	$stmt = $mysqli->prepare("DELETE FROM comentarios WHERE indice=? and email=? and hora=? and texto=?");
		$stmt->bind_param('isss', $indice, $email, $hora, $texto);

		$texto = $comentario;
		$indice = $idEv;
		$email = $email;
		$hora = $hora;
		$texto = $comentario;

		if ($stmt->execute()) {
  			return true;
  		} else {
  			return false;
  		}
  	}

  	//Devolvemos un array con las palabras prohibidas en formato legible por Javascript
  	function getPalabrasProhibidas($mysqli) {
		$res = $mysqli->query("SELECT * FROM palabrasProhibidas");
		if ($res->num_rows > 0) {
			while($row = $res->fetch_assoc()) {
			        $palabras[] = $row['palabra'];
			}
		}
		//Necesitamos que el vector sea reconocido por javascript
		//$palabrasJava = json_encode($palabras);
    	return $palabras;
  	}

  	//Insertamos un nuevo usuario con los parámetros dados
  	function insertUser($mysqli, $nick, $nombre, $apellido, $email, $pass){
  		$hashPass = password_hash($pass, PASSWORD_DEFAULT);
  		
  		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			//echo '<script language="javascript">alert("e-mail no válido");</script>';
			$stmt = $mysqli->prepare("INSERT INTO usuarios (nick, nombre, apellidos, email, password) VALUES (?, ?, ?, ?, ?)");
			$stmt->bind_param('sssss', $nickAux, $nombreAux, $apellidoAux, $emailAux, $hashPassAux);

			$nickAux = $nick;
			$nombreAux = $nombre;
			$apellidoAux = $apellido;
			$emailAux = $email;
			$hashPassAux = $hashPass;

  			if ($stmt->execute()) {
  				return true;
  			} else {
  				return false;
  			}
		}else return false;
  	}

  	//Modificamos el usuario dado por $nick
  	function modifyUser($mysqli, $nick, $nombre, $apellido, $email, $pass){
  		$hashPass = password_hash($pass, PASSWORD_DEFAULT);
  		
  		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			//echo '<script language="javascript">alert("e-mail no válido");</script>';
			$stmt = $mysqli->prepare("UPDATE usuarios SET nombre=? , apellidos=?, email=?, password=? WHERE nick=?");
			$stmt->bind_param('sssss', $nombreAux, $apellidoAux, $emailAux, $hashPassAux, $nickAux);

			$nombreAux = $nombre;
			$apellidoAux = $apellido;
			$emailAux = $email;
			$hashPassAux = $hashPass;
			$nickAux = $nick;

  			if ($stmt->execute()) {
  				return true;
  			} else {
  				return false;
  			}
		} else return false;
  	}

	// Devuelve true si existe un usuario con esa contraseña
  	function checkLogin($mysqli, $nick, $pass) {
  		$usuario = $mysqli->query("SELECT * FROM usuarios WHERE nick='$nick'");
  		//echo $usuario['password'];
  		if ($usuario->num_rows > 0){
  			$row = $usuario->fetch_assoc();
  			if (password_verify($pass, $row['password'])){
  				return true;
  			}
  		}
  		return false;
  	}  	

  	function compruebaNick($mysqli, $nick){		//comprueba que el usuario no wxista
  		$usuario = $mysqli->query("SELECT * FROM usuarios WHERE nick='$nick'");
  		if ($usuario->num_rows > 0) {
  			return true;
  		}
  		else return false;
  	}

	// Devuelve la información de un usuario a partir de su nick 
  	function getUser($mysqli, $nick) {
  		$usuario = $mysqli->query("SELECT * FROM usuarios WHERE nick='$nick'");
  		if ($usuario->num_rows > 0) {
  			return $usuario->fetch_assoc();
  		}
  		else return 0;
  	}

  	function getUsers($mysqli) {
  		$resultado = $mysqli->query("SELECT * FROM usuarios");
  		if ($resultado->num_rows > 0) {
  			while($fila = $resultado->fetch_assoc()) {
			        $usuarios[] = $fila;
			}
  		}
   		return $usuarios;
  	}

  	function cambiarRango($mysqli, $nick, $rango){
  		$comprobacion = $mysqli->query("SELECT * FROM usuarios WHERE rango = 'superusuario'");
  		//echo strcmp($rango, 'superusuario');
  		//echo $rango;
  		if ($comprobacion->num_rows == 1 and $nick == $comprobacion->fetch_assoc()['nick']){
  			return false;
  		}

  		$stmt = $mysqli->prepare("UPDATE usuarios SET rango=? WHERE nick=?");
		  $stmt->bind_param('ss', $rango, $nick);

		  $rango = $rango;
		  $nick = $nick;

		  if ($stmt->execute()) {
  			return true;
  		}
  	}  
?>
