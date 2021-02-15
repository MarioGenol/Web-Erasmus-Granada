function Comentarios() {
	if (document.getElementById("espacio_comentarios").style.display == "block") {
		document.getElementById("espacio_comentarios").style.display = "none";
	} else document.getElementById("espacio_comentarios").style.display = "block";
}

$(document).ready(function() {
	//Llamamos a la función cada vez que se levanta una tecla
	$("#buscar_evento").keyup(function() {
		var evento = $('#buscar_evento').val();
		//Comprobamos que no esté vacio
		if (evento == "") {
			$("#display").html("");
		} else {
			//Llamamos a ajax
			$.ajax({
				type: "POST",
				url: "ajax.php",
				data: {buscar_evento: evento},
				//Si tiene éxito mostramos los resultados
				success: function(html) {
					$("#display").html(html).show();
				}
			});
		}
	});
	//Si el ratón se mueve fuera del display lo cerramos
	$('#display').mouseleave(function(){
		$('#display').hide();
	});
	//$(document).on("focus","#buscar_evento",-> $('#display').hide())
});

/*
function Comentar(palabrasProhibidas) {

	var nombreFormulario = document.getElementById("nombre_com").innerHTML;
	var correoFormulario = document.getElementById("email_com").innerHTML;
	var textoFormulario = document.formulario.texto_formulario.value;

	var fechaActual = new Date(); //Fecha para el comentario
	var dia = fechaActual.getDate();
	var mes = fechaActual.getMonth();
	var anio = fechaActual.getFullYear();
	var hora = fechaActual.getHours();
	var min = fechaActual.getMinutes();
	var re = /^([\da-z_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/; //variable para la comprobación del email

	if (nombreFormulario == "" || correoFormulario == "" || textoFormulario == "") { //alerta para completar todos los campos
		alert("Completar todos los campos");
	} else if (!re.exec(correoFormulario)) {
		alert('email no valido'); //alerta de email incorrecto
	} else {
		//escribimos la fecha en el formato adecuado
		var fechaComentario = dia + "/" + mes + "/" + anio;
		var horaComentario = hora + ":" + min;

		//Eliminamos las palabras prohibidas del comentario
		palabrasComentario = textoFormulario.split(" ");
		var textoLimpio = "";
		for (i in palabrasComentario)
			if (palabrasComentario[i] != "") {
				var prohibido = false;
				for (j in palabrasProhibidas) {
					if (palabrasComentario[i] == palabrasProhibidas[j]) {
						prohibido = true;
						for (k = 0; k < palabrasComentario[i].length; k++){
							textoLimpio += "*";
						}
						textoLimpio += " ";
					}
				}
				if (!prohibido)
					textoLimpio += palabrasComentario[i] + " ";
				textoFormulario = textoLimpio;
			}

		var nodoNombre = document.createTextNode(nombreFormulario);
		var nodoFecha = document.createTextNode(fechaComentario);
		var nodoHora = document.createTextNode(horaComentario);
		var nodoTexto = document.createTextNode(textoFormulario);

		//Estructura de un comentario (div)
		var divComentario = document.createElement("div");
		var divNombre = document.createElement("div");
		var divFecha = document.createElement("div");
		var divHora = document.createElement("div");
		var divTexto = document.createElement("div");

		divComentario.setAttribute("class", "comentario");
		divNombre.setAttribute("class", "nombre_comentario");
		divFecha.setAttribute("class", "fecha_comentario");
		divHora.setAttribute("class", "hora_comentario");
		divTexto.setAttribute("class", "texto_comentario");

		//Estructura de un comentario (p) 
		var nombre = document.createElement("p");
		var fecha = document.createElement("p")
		var hora = document.createElement("p");
		var texto = document.createElement("p");

		nombre.appendChild(nodoNombre);
		fecha.appendChild(nodoFecha);
		hora.appendChild(nodoHora);
		texto.appendChild(nodoTexto);

		divNombre.appendChild(nombre);
		divFecha.appendChild(fecha);
		divHora.appendChild(hora);
		divTexto.appendChild(texto);

		divComentario.appendChild(divNombre);
		divComentario.appendChild(divFecha);
		divComentario.appendChild(divHora);
		divComentario.appendChild(divTexto);
		document.getElementById("comentarios_escritos").appendChild(divComentario);

		var mysql = require('mysql');

		var con = mysql.createConnection({
			host: "localhost",
			user: "usuario",
			password: "usuario",
			database: "SIBW"
		});

		con.connect(function(err) {
			if (err) throw err;
			console.log("Connected!");
			//var sql = "INSERT INTO customers (name, address) VALUES ('Company Inc', 'Highway 37')";
			//con.query(sql, function (err, result) {
			//	if (err) throw err;
			//	console.log("1 record inserted");
			//});
		});
	}
}

function PanelControl() {
	if (document.getElementById("panel_de_control").style.display == "block") {
		document.getElementById("panel_de_control").style.display = "none";
	} else document.getElementById("panel_de_control").style.display = "block";
}

function ModificaComentario(index) {
	if (document.getElementsByClassName("modifica_comentario")[index].style.display == "block") {
		document.getElementsByClassName("modifica_comentario")[index].style.display = "none";
	} else document.getElementsByClassName("modifica_comentario")[index].style.display = "block";
}*/