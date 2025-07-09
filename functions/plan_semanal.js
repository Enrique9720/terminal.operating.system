var propietarios_array;
var citas_carga_array;
var citas_descarga_array;
var destinos_array;
var origenes_array;

/**
 * Muestra lso campos del formulario específicos según la cita sea de carga o de descarga
 * @returns
 */
function num_expedicion_check() {

	$.ajax({
		type: "POST",
		url: "../ajax/num_expedicion_check.php",
		data: {
			'num_expedicion': $('#num_expedicion').val(),
			'tipo_cita': document.forms["citaForm"]["tipo_cita"].value
		},
		success: function (returned) {
			var obj = $.parseJSON(returned);
			jQuery(obj).each(function (i, item) {
				estado = item.estado;
				mensaje = item.mensaje;

				if (estado == 'existe') {
					$("#error_num_expedicion").html(mensaje);
					$("#validarCitaButton").prop("disabled", true);
				} else if (estado == 'no existe') {
					//vaciamos el div de error
					$("#error_num_expedicion").empty();
					$("#validarCitaButton").prop("disabled", false);
				}
			})
		},
		error: function () {
			alert("failure");
		}
	});

}

/**
 * Muestra lso campos del formulario específicos según la cita sea de carga o de descarga
 * @returns
 */
function propietariochange() {
	var cif_propietario = document.forms["citaForm"]["propietarios_combo"].value;
	//console.log(cif_propietario);
	if (cif_propietario != "") {
		$('#lineas_carga_button').prop('disabled', false);
		//pulsamos el boton de editar lineas de carga, para poner textarea y borrar tabla
		$('#editar_contenedores').trigger('click');
		//evitamos el envio del formulario hasta que esten los contenedores correctos
		$("#num_contenedores_check").val("");
	} else {
		$('#lineas_carga_button').prop('disabled', true);
	}
}

/**
 * Muestra lso campos del formulario específicos según la cita sea de carga o de descarga
 * @returns
 */
function tipoCitaChange() {
	var tipo_cita = document.forms["citaForm"]["tipo_cita"].value;
	switch (tipo_cita) {
		case "CARGA":
			//$("#num_expedicion").hide();
			//$("#orden_suministro").show();
			//EL ORIGEN DE LA CARGA SIEMPRE ES NONDUERMAS (ID=1)
			origen_combo.selectedIndex = "1";
			destino_combo.selectedIndex = "0";
			$('#origen_combo').prop('disabled', true);
			$('#destino_combo').prop('disabled', false);
			$("#citaForm").css("border", "1px solid #21b6b6");//more efficient
			$('#lineas_carga_button').show();//mostramos boton añadir lineas carga
			//$('#validarCitaButton').prop('disabled', true);//deshabilitamos el boton de validar cita
			break;
		case "DESCARGA":
			//$("#num_expedicion").show();
			//$("#orden_suministro").hide();
			//EL DESTINO DE LA CARGA SIEMPRE ES NONDUERMAS (ID=1)
			destino_combo.selectedIndex = "1";
			origen_combo.selectedIndex = "0";
			$('#origen_combo').prop('disabled', false);
			$('#destino_combo').prop('disabled', true);
			$("#citaForm").css("border", "1px solid #ff8d00");//more efficient
			$('#lineas_carga_button').hide();
			break;
	}
}

/**
 * Rellena el Dropdown de los diferentes almacenes
 * @returns
 */
function fillpropietariosDropdown() {

	var propietarios_combo = document.getElementById("propietarios_combo");
	for (i = 0; i < propietarios_array.length; i++) {
		var option = document.createElement("option");
		option.value = propietarios_array[i].cif_propietario;
		option.text = propietarios_array[i].nombre_comercial_propietario;
		propietarios_combo.add(option);
	}
	propietarios_combo.selectedIndex = "0";

}
/**
 * Rellena el Dropdown de los diferentes almacenes
 * @returns
 */
function fillOrigenesDropdown() {
	var origen_combo = document.getElementById("origen_combo");
	for (i = 0; i < origenes_array.length; i++) {
		var option = document.createElement("option");
		option.value = origenes_array[i].id_origen;
		option.text = origenes_array[i].nombre_origen;
		origen_combo.add(option);
	}
	origen_combo.selectedIndex = "0";
}

/**
 * Rellena el Dropdown de los diferentes almacenes
 * @returns
 */
function fillDestinosDropdown() {
	var destino_combo = document.getElementById("destino_combo");
	for (i = 0; i < destinos_array.length; i++) {
		var option = document.createElement("option");
		option.value = destinos_array[i].id_destino;
		option.text = destinos_array[i].nombre_destino;
		destino_combo.add(option);
	}
	destino_combo.selectedIndex = "0";
}

/**
 * Recupera todos los almacenes de la base de datos
 * @returns
 */
function getpropietarios() {
	$.ajax({
		url: "../ajax/get_propietarios.php",
		type: "POST",
		dataType: "json",
		async: false,
		data: {
		},
		cache: false,
		success: function (result) {
			//console.log("result get_almacenes: "+JSON.stringify(result));
			propietarios_array = result.value;
			fillpropietariosDropdown();
		},
		error: function () {
		}
	});
}

/**
 * Recupera todos los almacenes de la base de datos
 * @returns
 */
function getorigenes() {
	$.ajax({
		url: "../ajax/get_origenes.php",
		type: "POST",
		dataType: "json",
		async: false,
		data: {
		},
		cache: false,
		success: function (result) {
			//console.log("result get_origenes: "+JSON.stringify(result));
			origenes_array = result.value;
			fillOrigenesDropdown();
		},
		error: function () {
		}
	});
}

/**
 * Recupera todos los almacenes de la base de datos
 * @returns
 */
function getdestinos() {
	$.ajax({
		url: "../ajax/get_destinos.php",
		type: "POST",
		dataType: "json",
		async: false,
		data: {
		},
		cache: false,
		success: function (result) {
			//console.log("result get_destinos: "+JSON.stringify(result));
			destinos_array = result.value;
			fillDestinosDropdown();
		},
		error: function () {
		}
	});
}


function validarCita() {

	console.log("Validando cita!");

	var tipo_cita = document.forms["citaForm"]["tipo_cita"].value;
	var date = $("#fecha").jqxDateTimeInput('getDate');
	if (date != null) {
		var fecha = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
	}
	var hora = document.forms["citaForm"]["hora"].value;
	var cif_propietario = document.forms["citaForm"]["propietarios_combo"].value;
	var id_origen = document.forms["citaForm"]["origen_combo"].value;
	var id_destino = document.forms["citaForm"]["destino_combo"].value;
	var observaciones = document.forms["citaForm"]["observaciones"].value;
	var num_expedicion = document.forms["citaForm"]["num_expedicion"].value;
	var num_contenedores_check = document.forms["citaForm"]["num_contenedores_check"].value;

	console.log(tipo_cita);
	console.log(fecha);
	console.log(hora);
	console.log(cif_propietario);
	console.log(num_expedicion);
	console.log(id_origen);
	console.log(id_destino);
	console.log(observaciones);
	console.log("num_contenedores_check: " + num_contenedores_check);

	var params_cita_carga_ok = (tipo_cita == "CARGA") && (fecha != "") && (hora != "") && (cif_propietario != "") && (num_expedicion != "") && (id_origen != "") && (id_destino != "") && (num_contenedores_check == "true");
	var params_cita_descarga_ok = (tipo_cita == "DESCARGA") && (fecha != "") && (hora != "") && (cif_propietario != "") && (num_expedicion != "") && (id_origen != "") && (id_destino != "");

	//comprobar todos los campos obligatorios
	if (params_cita_carga_ok) {

		$("#validarCitaButton").prop("disabled", true); // Disable submit button until AJAX call is complete to prevent duplicate messages

		//sacamos Nºs de contenedor para la carga
		var num_contenedores = [];
		//recorremos la tabla de contenedores fila a fila
		for (var i = 0; i < table.rows().data().length; i++) {
			var data = table.rows().data()[i];
			//console.log(data);
			var linea_num_contenedor = {
				num_contenedor: data['num_contenedor']
			}
			num_contenedores.push(linea_num_contenedor);
		}

		$.ajax({
			url: "../ajax/crear_cita_carga.php",
			type: "POST",
			dataType: "json",
			async: false,
			data: {
				fecha: fecha,
				hora: hora,
				cif_propietario: cif_propietario,
				num_expedicion: num_expedicion,
				id_origen: id_origen,
				id_destino: id_destino,
				observaciones: observaciones,
				num_contenedores: num_contenedores
			},
			cache: false,
			success: function (result) {
				console.log(result);
				if (result.status == 'success') {
					console.log("OK RESULT: " + JSON.stringify(result));
					mostrarMensaje("SUCCESS", "Su solicitud ha sido registrada correctamente.");
					//clear all fields
					$('#citaForm').trigger("reset");
					window.location.reload();
					//Reload calendario de citas
					//loadCalendarioCitas();
					calendar.render();
				}
				else {
					console.log("ERROR RESULT: " + JSON.stringify(result));
					// Fail message
					mostrarMensaje("ERROR", "Ha habido un error al procesar su solicitud.");
				}
			},
			error: function (result) {
				console.log("ERROR RESULT: " + JSON.stringify(result));
				mostrarMensaje("ERROR", "Ha habido un error al procesar su solicitud.");
			},
			complete: function () {
				setTimeout(function () {
					$("#validarCitaButton").prop("disabled", false); // Re-enable submit button when AJAX call is complete
				}, 1000);
			}
		});

	}
	else if (params_cita_descarga_ok) {

		$("#validarCitaButton").prop("disabled", true); // Disable submit button until AJAX call is complete to prevent duplicate messages

		$.ajax({
			url: "../ajax/crear_cita_descarga.php",
			type: "POST",
			dataType: "json",
			async: false,
			data: {
				fecha: fecha,
				hora: hora,
				cif_propietario: cif_propietario,
				num_expedicion: num_expedicion,
				id_origen: id_origen,
				id_destino: id_destino,
				observaciones: observaciones
			},
			cache: false,
			success: function (result) {
				console.log(result);
				if (result.status == 'success') {
					console.log("OK RESULT: " + JSON.stringify(result));
					mostrarMensaje("SUCCESS", "Su solicitud ha sido registrada correctamente.");
					//clear all fields
					$('#citaForm').trigger("reset");
					window.location.reload();
					//Reload calendario de citas
					//loadCalendarioCitas();
					calendar.render();
				}
				else {
					console.log("ERROR RESULT: " + JSON.stringify(result));
					// Fail message
					mostrarMensaje("ERROR", "Ha habido un error al procesar su solicitud.");
				}
			},
			error: function (result) {
				console.log("ERROR RESULT: " + JSON.stringify(result));
				mostrarMensaje("ERROR", "Ha habido un error al procesar su solicitud.");
			},
			complete: function () {
				setTimeout(function () {
					$("#validarCitaButton").prop("disabled", false); // Re-enable submit button when AJAX call is complete
				}, 1000);
			}
		});

	}
	else {
		mostrarMensaje("ERROR", "Le rogamos que rellene todos los campos obligatorios.");
	}

}

function mostrarMensaje(tipo_mensaje, mensaje) {
	if (tipo_mensaje == "SUCCESS") {
		// Success message
		$('#success').html("<div class='alert alert-success'>");
		$('#success > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;").append("</button>");
		$('#success > .alert-success').append("<strong>" + mensaje + "</strong>");
		$('#success > .alert-success').append('</div>');
	}
	else {
		// Fail message
		$('#success').html("<div class='alert alert-danger'>");
		$('#success').html("<div class='alert alert-danger'>");
		$('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;").append("</button>");
		$('#success > .alert-danger').append($("<strong>").text(mensaje));
		$('#success > .alert-danger').append('</div>');
	}
}

/**
 * Recarga el calendario de citas
 * @returns
 */
function loadCalendarioCitas(fecha_min, fecha_max) {

	//reset events
	var events = calendar.getEvents();
	for (var i = 0; i < events.length; i++) {
		//console.log(events[i]);
		events[i].remove();
	}

	fecha_min_sql = fecha_min.getFullYear() + "-" + (fecha_min.getMonth() + 1) + "-" + fecha_min.getDate();
	fecha_max_sql = fecha_max.getFullYear() + "-" + (fecha_max.getMonth() + 1) + "-" + fecha_max.getDate();

	console.log(fecha_min_sql, " ", fecha_max_sql);

	$.ajax({
		url: "../ajax/get_citas_carga.php",
		type: "POST",
		dataType: "json",
		async: false,
		data: {
			fecha_min: fecha_min_sql,
			fecha_max: fecha_max_sql
		},
		cache: false,
		success: function (result) {
			//console.log("result get_citas_carga: "+JSON.stringify(result));
			citas_carga_array = result.value;
		},
		error: function (result) {
			console.log("ERROR RESULT: " + JSON.stringify(result));
		}
	});

	$.ajax({
		url: "../ajax/get_citas_descarga.php",
		type: "POST",
		dataType: "json",
		async: false,
		data: {
			fecha_min: fecha_min_sql,
			fecha_max: fecha_max_sql
		},
		cache: false,
		success: function (result) {
			//console.log("result get_citas_descarga: "+JSON.stringify(result));
			citas_descarga_array = result.value;
		},
		error: function (result) {
			console.log("ERROR RESULT: " + JSON.stringify(result));
		}
	});

	for (i = 0; i < citas_carga_array.length; i++) {
		var id = citas_carga_array[i].id_cita_carga;
		var fecha = citas_carga_array[i].fecha;
		var hora = citas_carga_array[i].hora;
		var num_expedicion = citas_carga_array[i].num_expedicion;
		var nombre_comercial_propietario = citas_carga_array[i].nombre_comercial_propietario;
		var observaciones = citas_carga_array[i].observaciones;
		var nombre_destino = citas_carga_array[i].nombre_destino;

		var event = {
			title: num_expedicion,
			extendedProps: {
				id: id,
				tipo_cita: "carga",
				num_expedicion: num_expedicion,
				nombre_comercial_propietario: nombre_comercial_propietario,
				nombre_destino: nombre_destino,
				observaciones: observaciones
			},
			start: fecha + "T" + hora,
			color: "#21b6b6",
			//textColor: (estado == 'ABIERTA')?'#000000': '#ffffff',
			editable: true,

		};
		calendar.addEvent(event);

		//console.log("CITA_CARGA",fecha+"T"+hora);
	}

	for (i = 0; i < citas_descarga_array.length; i++) {
		var id = citas_descarga_array[i].id_cita_descarga;
		var fecha = citas_descarga_array[i].fecha;
		var hora = citas_descarga_array[i].hora;
		var num_expedicion = citas_descarga_array[i].num_expedicion;
		var observaciones = citas_descarga_array[i].observaciones;
		var nombre_comercial_propietario = citas_descarga_array[i].nombre_comercial_propietario;
		var nombre_origen = citas_descarga_array[i].nombre_origen;

		var event = {
			title: num_expedicion,
			extendedProps: {
				id: id,
				tipo_cita: "descarga",
				num_expedicion: num_expedicion,
				nombre_comercial_propietario: nombre_comercial_propietario,
				nombre_origen: nombre_origen,
				observaciones: observaciones
			},
			start: fecha + "T" + hora,
			color: "#ff8d00",
			//textColor: (id_entrada_mercancia == null)?'#000000': '#ffffff',
			editable: true,

		};
		calendar.addEvent(event);

		//console.log("CITA_DESCARGA",fecha+"T"+hora);
	}
}

/**
 * Modifica la fecha y hora de una cita
 * @param id
 * @param operacion
 * @param hora
 * @param fecha
 * @returns
 */
function modificarHorarioCita(tipo_cita, id_cita, fecha, hora) {

	$.ajax({
		url: "../ajax/modificar_horario_cita.php",
		type: "POST",
		dataType: "json",
		async: false,
		data: {
			tipo_cita: tipo_cita,
			id_cita: id_cita,
			fecha: fecha,
			hora: hora
		},
		cache: false,
		success: function (result) {
			//console.log(tipo_cita, id_cita, fecha, hora);
			console.log("Cita modificada con éxito: " + JSON.stringify(result));
		},
		error: function (result) {
			console.log("ERROR: " + JSON.stringify(result));
		}
	});

}

function getValueById(input_array, id, property_name) {
	//console.log(" getValueById: ",input_array, id, property_name);

	for (var i = 0; i < input_array.length; i++) {
		if (input_array[i].id == "" + id) {
			return "" + input_array[i][property_name];
		}
	}
	return "?";
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function getEntradas() {
	$.ajax({
		url: "../functions/get_entradas_validadas.php",
		type: "POST",
		dataType: "json",
		async: false,
		data: {
		},
		cache: false,
		success: function (result) {
			//console.log("result get_productos: "+JSON.stringify(result));
			var productos_array = result.value;
			p = [];
			productos_array.forEach(producto => p.push(producto.id_entrada));
			//console.log(p);
			$("#num_packing_entrada").jqxInput({ placeHolder: "Entrada", height: 35, width: '100%', minLength: 1, source: p });
		},
		error: function () {
		}
	});
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////