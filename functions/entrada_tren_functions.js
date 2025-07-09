/**
 * Valida la entrada de mercancía
 * @returns
 */
function validarEntrada() {
	console.log("validarEntrada()");

	$('#validarEntradaButton').prop('disabled', true);

	num_expedicion = $('#citas_descarga_pendientes_combo').find(":selected").text().split("(")[0].trim();
	console.log(num_expedicion);

	//console.log($('#retraso_tren_checkbox').prop("checked"));
	var retraso_tren_checkbox = "";
	if($('#retraso_tren_checkbox').prop("checked")){
		retraso_tren_checkbox = $('#retraso_tren_checkbox').val();
	}

	if ((num_expedicion === "Seleccione nº de expedición")) {
		alert("Debe seleccionar un número de expedición");
		$('#validarEntradaButton').prop('disabled', false);
		return;
	}

	var entrada_tren = [];
	//console.log(table_entrada_tren);

	//recorremos la tabla de entrada tren fila a fila
	for (var i = 0; i < table_entrada_tren.rows().data().length; i++) {

		var data = table_entrada_tren.rows().data()[i];
		//console.log(data);

		var linea_entrada_tren = {
			num_vagon: data['num_vagon'],
			pos_vagon: data['pos_vagon'],
			pos_contenedor: data['pos_contenedor'],
			num_contenedor: data['num_contenedor'],
			tipo_contenedor_iso: data['tipo_contenedor_iso'],
			tara_contenedor: data['tara_contenedor'],
			vacio_cargado_contenedor: data['vacio_cargado_contenedor'],
			peso_bruto_contenedor: data['peso_bruto_contenedor'],
			temperatura_contenedor: data['temperatura_contenedor'],
			nombre_comercial_propietario: data['nombre_comercial_propietario'],
			num_peligro_adr: data['num_peligro_adr'],
			num_onu_adr: data['num_onu_adr'],
			num_clase_adr: data['num_clase_adr'],
			cod_grupo_embalaje_adr: data['cod_grupo_embalaje_adr'],
			destinatario: data['destinatario']
		}

		entrada_tren.push(linea_entrada_tren);
	}

	if (entrada_tren.length == 0) {
		alert("Debe haber al menos un vagón");
		$('#validarEntradaButton').prop('disabled', false);
		return;
	}

	console.log(entrada_tren);

	$.ajax({
		type: "POST",
		url: "../ajax/validar_entrada_tren.php",
		dataType: "json",
		async: false,
		data: {
			num_expedicion: num_expedicion,
			retraso_tren_checkbox: retraso_tren_checkbox,
			entrada_tren: entrada_tren
		},
		cache: false,
		success: function (result) {
			console.log("result validar_entrada_mercancia: " + JSON.stringify(result));
			//alert("Mercancía dada de alta en el sistema correctamente");
			id_entrada = result.id_entrada;
			//console.log($id_entrada);
			status = result.status;
			//console.log(status);

			if (status == 'success') {
				alert("Entrada dada de alta en el sistema correctamente");
				document.location = '../controllers/entrada_resumen_controller.php?id_entrada=' + id_entrada;
			} else {
				alert("ERROR: hubo algún fallo al dar la entrada")
			}
		},
		error: function (result) {
			console.log("error validar_entrada_mercancia: " + JSON.stringify(result));
			alert("ERROR: hubo algún fallo al dar de entrada la mercancía");
		}
	});
}

/**
 * Obtiene los albaranes de entrada abiertos
 * @returns
 */
function getCitasDescargaPendientes() {

	$.ajax({
		url: "../ajax/get_citas_descarga_pendientes.php",
		type: "POST",
		dataType: "json",
		cache: false,
		success: function (result) {
			//console.log("result get_citas_descarga_pendientes: "+JSON.stringify(result));

			var citas_descarga_pendientes_combo = document.getElementById("citas_descarga_pendientes_combo");
			//console.log(result.value.length);
			for (var i = 0; i < result.value.length; i++) {
				var option = document.createElement("option");
				option.innerHTML = '' + result.value[i].num_expedicion + ' (' + result.value[i].fecha + ') (' + result.value[i].nombre_comercial_propietario + ')';
				option.value = result.value[i].id;
				citas_descarga_pendientes_combo.add(option);
			}

			citas_descarga_pendientes_combo.selectedIndex = "0";

		},
		error: function (result) {
			console.log("error get_citas_descarga_pendientes: " + JSON.stringify(result));
		}
	});
}
