
/**
 * Obtiene los albaranes de entrada abiertos
 * @returns
 */
function getCitascargaPendientes() {
	//al cargar la pagina, cargamos todas las citas de carga pendientes en el select
	$.ajax({
		url: "../ajax/get_citas_carga_pendientes.php",
		type: "POST",
		dataType: "json",
		cache: false,
		success: function (result) {
			//console.log("result get_citas_descarga_pendientes: "+JSON.stringify(result));
			var citas_carga_pendientes_combo = document.getElementById("citas_carga_pendientes_combo");
			//console.log(result.value.length);
			for (var i = 0; i < result.value.length; i++) {
				var option = document.createElement("option");
				option.innerHTML = result.value[i].num_expedicion;
				option.value = result.value[i].id_cita_carga;
				citas_carga_pendientes_combo.add(option);
			}
			citas_carga_pendientes_combo.selectedIndex = "0";
		},
		error: function (result) {
			//console.log("error get_citas_descarga_pendientes: "+JSON.stringify(result));
		}
	});
}


/**
 * Valida la salida de mercancía
 * @returns
 */
function validarsalida() {

	//var num_contenedores = parseInt(document.getElementById("num_contenedores").innerHTML);
	//console.log(num_palets);

	var id_cita_carga = document.getElementById("citas_carga_pendientes_combo").value;
	//console.log(id_cita_carga);



	var cita = document.getElementById("citas_carga_pendientes_combo");
	var num_expedicion = cita.options[cita.selectedIndex].text;
	//console.log(num_expedicion);



	if (confirm("Validar salida tren " + num_expedicion + ". Total Contenedores: " + num_contenedores) == true) {
		//"You pressed OK!";
		$.ajax({
			type: "POST",
			url: "../ajax/validar_salida_tren.php",
			dataType: "json",
			data: {
				'id_cita_carga': id_cita_carga,
				'num_expedicion': num_expedicion
			},
			cache: false,
			success: function (result) {
				console.log("result validar_salida: " + JSON.stringify(result));
				//alert("Mercancía dada de alta en el sistema correctamente");
				id_salida = result.id_salida;
				console.log(id_salida);
				status = result.status;
				console.log(status);

				// Intentar limpiar y parsear el JSON
				try {
					let cleanResponse = result.replace(/<script>.*?<\/script><br>/g, '');
					let jsonResponse = JSON.parse(cleanResponse);
					console.log(jsonResponse);
				} catch (e) {
					console.error("Error al parsear el JSON:", e);
				}

				if (status == 'success') {
					alert("Salida dada de alta en el sistema correctamente");
					document.location = '../controllers/salida_resumen_controller.php?id_salida=' + id_salida;
				} else {
					alert("ERROR: hubo algún fallo al dar la salida")//
				}
			},
			error: function (result) {
				console.log("error validar_salida: " + JSON.stringify(result));
				alert("ERROR: hubo algún fallo al dar salidaa");
			}

		});

	} else {
		//"You canceled!";
	}
}

function checkaddLineaSalida(num_vagon, pos_vagon, pos_contenedor) {
	pos_vagon_check = true;
	pos_contenedor_check = true;
	table_contenedores_salida.rows().every(function (rowIdx, tableLoop, rowLoop) {

		var d = this.data();

		if ((d.pos_vagon == pos_vagon) && (d.num_vagon == num_vagon)) {
		} else if ((d.pos_vagon != pos_vagon) && (d.num_vagon == num_vagon)) {
			//error
			pos_vagon_check = false;
			pos_vagon_ok = d.pos_vagon;
			num_vagon_ok = d.num_vagon;
		} else if ((d.pos_vagon == pos_vagon) && (d.num_vagon != num_vagon)) {
			//error
			pos_vagon_check = false;
			pos_vagon_ok = d.pos_vagon;
			num_vagon_ok = d.num_vagon;
		} else if ((d.pos_vagon != pos_vagon) && (d.num_vagon != num_vagon)) {
		}
		//Comprobacion posicion contenedor
		if ((d.pos_vagon == pos_vagon) && (d.num_vagon == num_vagon) && (d.pos_contenedor == pos_contenedor)) {
			//error
			pos_contenedor_check = false;
		}

	});
	if (pos_vagon_check == false) {
		alert("ERROR: Ya esta el vagón " + num_vagon_ok + " en la posición " + pos_vagon_ok);
	}
	if (pos_contenedor_check == false) {
		alert("ERROR: Ya hay un contenedor en el vagón " + num_vagon + " en la posición " + pos_contenedor);
	}
	if ((pos_vagon_check == false) || (pos_contenedor_check == false)) {
		return false;
	} else {
		return true;
	}
}

function addLineaSalida() {

	var num_vagon = $('#num_vagon').find(":selected").text();
	//console.log(num_vagon);
	var pos_vagon = $('#pos_vagon').val();
	//console.log(pos_vagon);
	var num_contenedor = $('#num_contenedor').find(":selected").text();
	//console.log(num_contenedor);
	var pos_contenedor = $('#pos_contenedor').val();
	//console.log(pos_contenedor);
	var id_cita_carga = document.getElementById("citas_carga_pendientes_combo").value;
	//var cita = document.getElementById("citas_carga_pendientes_combo");
	//var num_expedicion_salida = cita.options[cita.selectedIndex].text;
	//console.log(num_expedicion_salida);

	// Check todos los campos estan rellenos
	if (
		(num_contenedor != '') &&
		(pos_contenedor != '') &&
		(num_vagon != '') &&
		(pos_vagon != '')
	) {

		if (num_contenedor == 'NO-CON') {//Si el contenedor elegido es NO-CON es un huevo vacio en el vagon
			////////////////////////////////////////
			check_add_linea = checkaddLineaSalida(
				num_vagon,
				pos_vagon,
				pos_contenedor
			);
			////////////////////////////////////
			if (check_add_linea == true) {
				$.ajax({
					url: '../ajax/contenedor_hueco_salida_temp_update.php',
					type: 'POST',
					data: {
						id_cita_carga: id_cita_carga,
						num_vagon: num_vagon,
						pos_vagon: pos_vagon,
						num_contenedor: num_contenedor,
						pos_contenedor: pos_contenedor
					},
					success: function (response) {
						var obj = $.parseJSON(response);
						jQuery(obj).each(function (i, resp) {
							//id_contenedor_temp = resp.id_contenedor_temp;
							// handle response
							var item = {
								num_vagon: resp.num_vagon,
								pos_vagon: resp.pos_vagon,
								num_contenedor: resp.num_contenedor,
								pos_contenedor: resp.pos_contenedor,
								id_tipo_contenedor_iso: resp.id_tipo_contenedor_iso,
								descripcion_mercancia: resp.descripcion_mercancia,
								nombre_comercial_propietario: resp.nombre_comercial_propietario,
								operacion: "<button id='" + resp.id_linea_carga + "' class='remove btn-danger no-con'><span class='glyphicon glyphicon-trash'></span></button>"
							};

							table_contenedores_salida.row.add(item);
							table_contenedores_salida.draw(false);

							//resetar inputs
							$('#pos_contenedor').val('');
							$("#num_contenedor").val('').trigger('change');
							$('#id_tipo_contenedor_iso').val('');
							$('#descripcion_mercancia').val('');
						})

						//recargamos tabla con lista de picking
						getcontenedorespedidos();
					}
				});
			}

		} else {//en caso contrario es un nº de contenedor que habra que chequear

			//comprobamos que el contenedor elegido nos vale para el pedido
			$.ajax({
				url: '../ajax/check_contenedor_salida_pedido.php',
				type: 'POST',
				data: {
					id_cita_carga: id_cita_carga,
					num_contenedor: num_contenedor
				},
				success: function (response) {
					var obj = $.parseJSON(response);
					var linea_carga_check = obj.linea_carga_check;
					//console.log(linea_carga_check);
					var stock_check = obj.stock_check;
					//console.log(stock_check);
					//si el contenedor es valido
					if (stock_check == '1' && linea_carga_check == '1') {

						////////////////////////////////////////
						check_add_linea = checkaddLineaSalida(
							num_vagon,
							pos_vagon,
							pos_contenedor
						);
						////////////////////////////////////

						if (check_add_linea == true) {
							//Insertar contenedor en tabla salida
							/************************************/
							$.ajax({
								url: '../ajax/contenedor_salida_temp_update.php',
								type: 'POST',
								data: {
									id_cita_carga: id_cita_carga,
									num_vagon: num_vagon,
									pos_vagon: pos_vagon,
									num_contenedor: num_contenedor,
									pos_contenedor: pos_contenedor
								},
								success: function (response) {
									var obj = $.parseJSON(response);
									jQuery(obj).each(function (i, resp) {
										//id_contenedor_temp = resp.id_contenedor_temp;
										// handle response
										var item = {
											num_vagon: resp.num_vagon,
											pos_vagon: resp.pos_vagon,
											num_contenedor: resp.num_contenedor,
											pos_contenedor: resp.pos_contenedor,
											id_tipo_contenedor_iso: resp.id_tipo_contenedor_iso,
											descripcion_mercancia: resp.descripcion_mercancia,
											nombre_comercial_propietario: resp.nombre_comercial_propietario,
											operacion: "<button id='" + resp.id_linea_carga + "' class='remove btn-danger'><span class='glyphicon glyphicon-trash'></span></button>"
										};

										table_contenedores_salida.row.add(item);
										table_contenedores_salida.draw(false);

										num_contenedores = num_contenedores + 1;
										//console.log(num_contenedores);
										$("#num_contenedores").text(num_contenedores);

										//resetar inputs
										$('#pos_contenedor').val('');
										$("#num_contenedor").val('').trigger('change');
										$('#id_tipo_contenedor_iso').val('');
										$('#descripcion_mercancia').val('');
									})

									//recargamos tabla con lista de picking
									getcontenedorespedidos();
								}
							});

						}

					} else {
						alert('Contenedor actualmente no esta en Stock.');
					}
				}
			});
		}

	} else {
		alert("Faltan campos");
	}
}


/**
 *
 * @returns
 */
function getcontenedorespedidos() {
	//Borramos tabla de contenedores a cargar
	$('#table_contenedores_lineas_carga').dataTable().fnClearTable();
	//Sacamos id de la cita de carga
	var id_cita_carga = document.getElementById("citas_carga_pendientes_combo").value;
	//sacamos datos de contenedores a cargar en esa cita
	$.ajax({
		type: "POST",
		url: "../ajax/get_contenedores_salida_pedidos.php",
		data: {
			id_cita_carga: id_cita_carga,
		},
		success: function (response) {
			pedido_completado = true;
			var obj = $.parseJSON(response);
			jQuery(obj).each(function (i, resp) {
				var item = {
					num_contenedor: resp.num_contenedor,
					id_tipo_contenedor_iso: resp.id_tipo_contenedor_iso,
					longitud_tipo_contenedor: resp.longitud_tipo_contenedor,
					descripcion_tipo_contenedor: resp.descripcion_tipo_contenedor,
					nombre_comercial_propietario: resp.nombre_comercial_propietario,
					peso_bruto_actual_contenedor: resp.peso_bruto_actual_contenedor,
					descripcion_mercancia: resp.descripcion_mercancia,
					picking_check: resp.picking_check,
					stock_check: resp.stock_check,
				};

				picking_check = resp.picking_check;
				stock_check = resp.stock_check;
				if (picking_check == null || stock_check == "0") {
					pedido_completado = false;
				}

				table_contenedores_lineas_carga.row.add(item);
				table_contenedores_lineas_carga.draw(false);
			})

			total_contenedores = table_contenedores_lineas_carga.rows().count();
			$("#num_contenedores_total").text(total_contenedores);
			//habilitar o deshabilitar boton validar
			if (pedido_completado == true) {
				$("#validarSalidaButton").prop("disabled", false);
				//$("#add_linea").prop("disabled",true);
			} else if (pedido_completado == false) {
				$("#validarSalidaButton").prop("disabled", true);
				$("#add_linea").prop("disabled", false);
			}

		},
		error: function () {
			alert("failure");
		}
	});
}
