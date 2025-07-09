<?php
//////////////////////////////////////////////////////////////////
session_start();

//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");
//cargamos las funciones PHP comunes para CODECOS
require_once "../functions/codeco_functions.php";
//comprobamos que el usuario esta logeado
check_logged_user();

/////////////////////// CARGA DE MODELOS ////////////////////////////////////////////
require_once("../models/railsider_model.php");
/////////////////////////////////////////////////////////////////////////////////////

$railsider_model = new railsider_model();

if (isset($_POST['submit'])) { //estamos guardando formulario

	//echo "<pre>";
	//print_r($_POST);
	//echo "</pre>";

	//sacamos fecha y hora y hacemos datetime
	$fecha_form = $_POST['fecha_salida'];
	$hora_form = $_POST['hora_salida'];

	$id_origen = $_POST['id_origen'];
	$id_destino = $_POST['id_destino'];

	$num_contenedor = $_POST['num_cont_1'];

	$temperatura_contenedor = $_POST['temperatura_cont_1'];
	if ($temperatura_contenedor == '') {
		$temperatura_contenedor = null;
	}

	$cif_empresa_transportista = $_POST['emp_transportista'];
	$matricula_tractora = str_replace("-", "", strtoupper($_POST['matricula_tractora']));
	$matricula_remolque = str_replace("-", "", strtoupper($_POST['matricula_remolque']));
	$observaciones = $_POST['observaciones'];

	$dni_conductor = str_replace("-", "", strtoupper($_POST['dni_conductor']));
	$nombre_conductor = strtoupper($_POST['nombre_conductor']);
	$apellidos_conductor = strtoupper($_POST['apellidos_conductor']);

	$id_destinatario = $_POST['destinatario_cont_1'];

	//TABLA SALIDA
	//fecha salida en formato datetime
	$fecha_salida = $fecha_form . " " . $hora_form;
	//Sacamos ID TIPO SALIDA CAMIÓN
	$tipo_salida = 'CAMIÓN';
	$list_tipo_salida = $railsider_model->get_tipo_salida_por_tipo($tipo_salida);
	$id_tipo_salida_camion = $list_tipo_salida[0]['id_tipo_salida'];
	//En camion no hay cita de descarga
	$id_cita_carga = null;

	//Insertamos registro en tabla salida
	$id_salida = $railsider_model->insert_salida(
		$fecha_salida,
		$id_tipo_salida_camion,
		$id_cita_carga,
		$_SESSION['email']
	);

	//TABLA EMPRESA_DESTINO_ORIGEN
	if ($id_destinatario != '') {
		//Comprobamos si existe el destinatario
		$destinatario_list = $railsider_model->get_destinatario_por_id($id_destinatario);
		if (count($destinatario_list) == 0) { //Si no existe
			$nombre_destinatario = strtoupper($id_destinatario);
			//$nombre_destinatario = strtoupper('');
			//Insertamos destinatario
			$id_destinatario = $railsider_model->insert_destinatario($nombre_destinatario, NULL);
		}
	} else {
		$id_destinatario = null;
	}

	//TABLA CONDUCTOR
	//Comprobamos si existe el conductor
	$conductor_list = $railsider_model->get_conductor_por_dni($dni_conductor);
	if (count($conductor_list) == 0) { //Si no existe
		//Insertamos conductor
		$railsider_model->insert_conductor($dni_conductor, $nombre_conductor, $apellidos_conductor);
	}

	//TABLA SALIDA_TIPO_CAMION
	//calculamos ultimo numero de expedicion para camion
	$num_expedicion_list = $railsider_model->get_ultimo_num_expedicion_salida_tipo_camion();
	$num_expedicion = $num_expedicion_list[0]['num_expedicion'] + 1;

	//Insertamos registro en tabla salida_tipo_camion
	$railsider_model->insert_salida_camion(
		$id_salida,
		$num_expedicion,
		$matricula_tractora,
		$matricula_remolque,
		$dni_conductor,
		$cif_empresa_transportista,
		$id_origen,
		$id_destino,
		$observaciones
	);


	//pintamos variables

	//echo "id_salida: ".$id_salida."<br>";
	//echo "num_expedicion: ".$num_expedicion."<br>";
	//echo "matricula_tractora: ".$matricula_tractora."<br>";
	//echo "matricula_remolque: ".$matricula_remolque."<br>";
	//echo "dni_conductor: ".$dni_conductor."<br>";
	//echo "cif_empresa_transportista: ".$cif_empresa_transportista."<br>";
	//echo "observaciones: ".$observaciones."<br>";

	//TABLA SALIDA_CAMION_CONTENEDOR
	$railsider_model->insert_salida_camion_contenedor(
		$id_salida,
		$num_contenedor,
		$temperatura_contenedor,
		$id_destinatario
	);

	//TABLA CONTENEDOR
	//calculamos temperatura actual
	$temperatura_actual_contenedor = $temperatura_contenedor;
	//calcular id_destinatario_actual
	$id_destinatario_actual = $id_destinatario;

	//sacamos datos de contenedor
	$list = $railsider_model->get_contenedor($num_contenedor);
	if (count($list) > 0) { //Si existe, actualizamos
		foreach ($list as $value) { //sacamos datos del contenedor desde BBDD

			//cif_propietario para CODECO
			$cif_propietario = $value['cif_propietario_actual'];
			//estado_carga_contenedor para CODECO
			$estado_carga_contenedor = $value['estado_carga_contenedor'];
			//id_tipo_contenedor_iso para CODECO
			$id_tipo_contenedor_iso = $value['id_tipo_contenedor_iso'];
			//num_booking_actual_contenedor para CODECO
			$num_booking_actual_contenedor = $value['num_booking_actual_contenedor'];
			//num_precinto_actual_contenedor para CODECO
			$num_precinto_actual_contenedor = $value['num_precinto_actual_contenedor'];
			//peso_bruto_actual_contenedor para CODECO
			$peso_bruto_actual_contenedor = $value['peso_bruto_actual_contenedor'];


			$railsider_model->update_contenedor_salida(
				$num_contenedor,
				$temperatura_actual_contenedor,
				$id_destinatario_actual
			);
		}
	}




	////////////////////////////////////////// INCIDENCIA DEMORA ESTANCIA M.M.P.P. //////////////////////////////////////////
	if (isset($num_contenedor)) {
	//coger el numero contenedor y sus datos
	$contenedor_datos = $railsider_model->get_ultima_entrada($num_contenedor);
	//echo "<pre>";
	//print_r($contenedor_datos);
	//echo "</pre>";
	if (!empty($contenedor_datos)) {
		foreach ($contenedor_datos as $value) {
			$id_entrada = $value['id_entrada'];
			$estado_carga_contenedor = $value['estado_carga_contenedor'];
			$id_tipo_mercancia = $value['id_tipo_mercancia'];
			$fecha_entrada_time = date('Y-m-d H:i:s', strtotime($value['fecha_entrada']));
			$fecha_salida_time = date('Y-m-d H:i:s', strtotime($fecha_salida));
		}
		//calculamos diferencia de dias
		$dias_estancia_mmpp = calcular_diferencia_dias($fecha_entrada_time, $fecha_salida_time);

		if ( ($id_tipo_mercancia == 2) && ($dias_estancia_mmpp >= 3) ) {
		//Si lleva mercancia peligrosa o vacio-sucio y esta mas de tres dias
		//entonces insertamos incidencia con insert_incidencia()
		//e insertamos incidencia contenedor con insert_incidencia_contenedor()

			$id_tipo_incidencia = 6;
			$estado_incidencia = 'ABIERTA';
			$observaciones = '';
			$fecha_incidencia = $fecha_salida_time; //con hora
			$date_incidencia = date('Y-m-d', strtotime($fecha_salida)); //sin hora
			$fecha_serie = strtotime($date_incidencia);
			$year_serie = date("y", $fecha_serie);

			$ultimo_num_incidencia = $railsider_model->get_ultimo_num_incidencia_por_serie($year_serie)[0]['num_incidencia'];
			//echo "<script>console.log('Ultimo Num-Incidencia: $ultimo_num_incidencia');</script>";
			$contador_incidencia_serie = explode("/", $ultimo_num_incidencia)[1];
			//echo "<script>console.log('Contador Incidencia Serie: $contador_incidencia_serie');</script>";
			$siguiente_num_incidencia = $year_serie . "/" . sprintf('%04d', $contador_incidencia_serie + 1);
			//echo "<script>console.log('Siguiente Num-Incidencia: $siguiente_num_incidencia');</script>";
			$incidencia_list = $railsider_model->get_num_incidencia_por_num_incidencia($siguiente_num_incidencia);
			//echo "<script>console.log('Incidencia List Count: " . $incidencia_list . "');</script>";

			if (empty($incidencia_list)) {
				try {
					$id_incidencia = $railsider_model->insert_incidencia(
						$fecha_incidencia,
						$id_tipo_incidencia,
						$estado_incidencia,
						$_SESSION['email'],
						$observaciones,
						$siguiente_num_incidencia
					);
				} catch (Exception $e) {
					//echo "<pre>Id Incidencia Insertada: $id_incidencia</pre>";
					//echo "<script>console.log('Id Incidencia Insertada: " . $id_incidencia . "');</script>";
					//continue;
				}
				$incidencia_contenedor = $railsider_model->insert_incidencia_contenedor(
					$id_incidencia,
					$num_contenedor,
					$estado_carga_contenedor,
					$cif_propietario,
					$id_entrada,
					$id_salida,
					NULL
				);
			}
		}
	}
}
	////////////////////////////////////////// FIN INCIDENCIA DEMORA ESTANCIA M.M.P.P. //////////////////////////////////////////












	//TABLA CONTROL_STOCK
	$list_control_stock = $railsider_model->contenedor_en_stock($num_contenedor);
	if (count($list_control_stock) > 0) { //Si hay datos

		$id_entrada = $list_control_stock[0]['id_entrada'];
		//actualizar id_salida en tabla control_stock
		$railsider_model->update_control_stock(
			$num_contenedor,
			$id_entrada,
			$id_salida
		);
	}

	//GENERACION Y ENVIO CODECO
	if (($cif_propietario == 'A60389624') || ($cif_propietario == 'A96764097')) { //CODECOS CMA-CGM (A60389624 = CCIS-BILBAO) (A96764097 = SICSA-VALENCIA)

		$contenedores_codeco = array();
		$fecha_movimiento = $fecha_salida;

		if ($estado_carga_contenedor == 'C') { //SI SALIDA CAMION CARGADO => IMPORT => 3
			$import_export = 3; //3 for import and 2 for export
			$estado_carga = 5; //5 for full and 4 for empty
		} else if ($estado_carga_contenedor == 'V') { //SI SALIDA CAMION VACIO => EXPORT => 2
			$import_export = 2; //3 for import and 2 for export
			$estado_carga = 4; //5 for full and 4 for empty
		}
		$contenedores_codeco[] = array(
			'num_contenedor' => $num_contenedor,
			'id_tipo_contenedor_iso' => $id_tipo_contenedor_iso,
			'estado_carga' => $estado_carga,
			'import_export' => $import_export,
			'num_booking_contenedor' => $num_booking_actual_contenedor,
			'num_precinto_contenedor' => $num_precinto_actual_contenedor,
			'peso_bruto_contenedor' => $peso_bruto_actual_contenedor
		);

		//echo "<pre>";
		//print_r($contenedores_codeco);
		//echo "</pre>";

		$tipo_vehiculo = 31;  //31 for truck and 25 for rail express
		$trip_number = "";

		$empresa_transportista_list = $railsider_model->get_empresa_transportista_por_cif($cif_empresa_transportista);
		$nombre_empresa_transportista = $empresa_transportista_list[0]['nombre_empresa_transportista'];

		$id_vehiculo = $matricula_tractora;

		if ($cif_propietario == 'A60389624') { //CCIS-BILBAO
			$puerto_origen_destino = "ESBIO";
		} else if ($cif_propietario == 'A96764097') { //SICSA-VALENCIA
			$puerto_origen_destino = "ESVLC";
		}

		codeco_ccis_sicsa_gateout(
			$id_salida,
			$fecha_movimiento,
			$contenedores_codeco,
			$puerto_origen_destino,
			$tipo_vehiculo,
			$trip_number,
			$nombre_empresa_transportista,
			$id_vehiculo
		);
	}

	$mercancias_list = $railsider_model->get_mercancias();
	foreach ($mercancias_list as $value) {
		$id_tipo_mercancia = $value['id_tipo_mercancia'];
		$descripcion_mercancia = $value['descripcipcion_mercancia'];
	}


	// MODIFICO LA ID_SALIDA DE LA TABLA INCIDENCIA CONTENEDOR
	$railsider_model->update_id_salida_incidencia_contenedor($id_salida, $num_contenedor);

	$materia_peligrosa_checkbox = $_POST['materia_peligrosa_checkbox'];
	if ($cif_propietario == 'A86868114' && $estado_carga_contenedor == 'C' && $id_tipo_mercancia = 2) { //RENFE - CARGADO - MERCANCIA_PELIGROSA
		// Convertir checkbox a entero (1 si es true, 0 si es false)
		$materia_peligrosa_checkbox = isset($materia_peligrosa_checkbox) && $materia_peligrosa_checkbox ? 'Contiene Etiqueta' : 'No Contiene Etiqueta';

		// Asegurarse de que `$id_salida`, y `$num_contenedor` estén definidos/validados correctamente
		if (isset($id_salida, $num_contenedor)) {
			// INSERTAR EN TABLA CONTENEDOR_MATERIA_PELIGROSA
			$railsider_model->insert_materia_peligrosa_salida($id_salida, $num_contenedor, $materia_peligrosa_checkbox);
		} else {
			echo 'Error: Faltan datos requeridos para la inserción de materia peligrosa.';
		}
	}

	header('Location: ../controllers/salida_resumen_controller.php?id_salida=' . $id_salida);
} else { //mostramos la vista con el formulario

	//obtener origenes
	$origen_list = $railsider_model->get_origenes();
	//echo "<pre>";
	//print_r($origen_list);
	//echo "</pre>";

	//obtener destino
	$destino_list = $railsider_model->get_destinos();
	//echo "<pre>";
	//print_r($destino_list);
	//echo "</pre>";

	//obtener propietarios
	$propietarios_list = $railsider_model->get_propietarios();
	//echo "<pre>";
	//print_r($propietarios_list);
	//echo "</pre>";

	//obtener tipos de mercancias
	$mercancias_list = $railsider_model->get_mercancias();
	//echo "<pre>";
	//print_r($mercancias_list);
	//echo "</pre>";

	//obtener clases de mercancia ADR
	$adr_clase_list = $railsider_model->get_adr_clases();
	//echo "<pre>";
	//print_r($adr_clase_list);
	//echo "</pre>";

	//obtener grupos embalajes de mercancia ADR
	$adr_grupo_embalaje_list = $railsider_model->get_adr_grupos_embalajes();
	//echo "<pre>";
	//print_r($adr_grupo_embalaje_list);
	//echo "</pre>";

	//obtener estaciones ferrocarril renfeR
	$estaciones_ferrocarril_renfe_list = $railsider_model->get_estaciones_ferrocarril_renfe();
	//echo "<pre>";
	//print_r($estaciones_ferrocarril_renfe_list);
	//echo "</pre>";

	//cargamos la vista
	require_once('../views/salida_camion_view.php');
	//cargamos la vista
	require_once('../views/empresa_transportista_modal_view.php');
}
