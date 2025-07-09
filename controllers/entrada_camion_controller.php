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
	echo "<pre>";
	print_r($_POST);
	echo "</pre>";

	//sacamos fecha y hora y hacemos datetime
	$fecha_form = $_POST['fecha_entrada'];
	$hora_form = $_POST['hora_entrada'];
	$id_origen = $_POST['id_origen'];
	$id_destino = $_POST['id_destino'];
	$num_contenedor = $_POST['num_cont_1'];
	$id_tipo_contenedor_iso = $_POST['id_tipo_cont_1'];
	$id_tipo_mercancia = $_POST['mercancia_cont_1'];
	$tara_contenedor = $_POST['tara_cont_1'];

	$retraso_camion_checkbox = $_POST['retraso_camion_checkbox'];

	//variables en caso de mercancia peligrosa
	$num_peligro_adr = $_POST['mercancia_num_peligro_adr_cont_1'];
	if ($num_peligro_adr == '') {
		$num_peligro_adr = null;
	}
	$num_onu_adr = $_POST['mercancia_onu_adr_cont_1'];
	if ($num_onu_adr == '') {
		$num_onu_adr = null;
	}
	$num_clase_adr = $_POST['mercancia_clase_adr_cont_1'];
	if ($num_clase_adr == '') {
		$num_clase_adr = null;
	}
	$cod_grupo_embalaje_adr = $_POST['mercancia_grupo_embalaje_adr_cont_1'];
	if ($cod_grupo_embalaje_adr == '') {
		$cod_grupo_embalaje_adr = null;
	}

	$peso_mercancia_contenedor = $_POST['peso_mercancia_cont_1'];
	if (($peso_mercancia_contenedor > 0) && ($id_tipo_mercancia != 3 || $id_tipo_mercancia != 4)) { //si hay peso y tipo de mercancia no es "VACÍO" o "VACÍO-SUCIO"
		$estado_carga_contenedor = 'C';
	} else { //el contenedor esta vacio y su peso mercancia debe ser 0
		$estado_carga_contenedor = 'V';
		$peso_mercancia_contenedor = 0;
	}

	$temperatura_contenedor = $_POST['temperatura_cont_1'];
	if ($temperatura_contenedor == '') {
		$temperatura_contenedor = null;
	}

	$num_booking_contenedor = str_replace("-", "", strtoupper($_POST['num_booking_cont_1']));
	if ($num_booking_contenedor == '') {
		$num_booking_contenedor = null;
	}

	$num_precinto_contenedor = str_replace("-", "", strtoupper($_POST['num_precinto_cont_1']));
	if ($num_precinto_contenedor == '') {
		$num_precinto_contenedor = null;
	}

	$cif_empresa_transportista = $_POST['emp_transportista'];
	$matricula_tractora = str_replace("-", "", strtoupper($_POST['matricula_tractora']));
	$matricula_remolque = str_replace("-", "", strtoupper($_POST['matricula_remolque']));
	$observaciones = $_POST['observaciones'];
	$dni_conductor = str_replace("-", "", strtoupper($_POST['dni_conductor']));
	$nombre_conductor = strtoupper($_POST['nombre_conductor']);
	$apellidos_conductor = strtoupper($_POST['apellidos_conductor']);
	$cif_propietario = $_POST['propietario_cont_1'];
	$id_destinatario = $_POST['destinatario_cont_1'];

	$codigo_estacion_ferrocarril = $_POST['num_estacion_destino'];
	if ($codigo_estacion_ferrocarril == '') {
		$codigo_estacion_ferrocarril = null;
	}

	//TABLA ENTRADA
	//fecha entrada en formato datetime
	$fecha_entrada = $fecha_form . " " . $hora_form;
	//Sacamos ID TIPO ENTRADA CAMIÓN
	$tipo_entrada = 'CAMIÓN';
	$list_tipo_entrada = $railsider_model->get_tipo_entrada_por_tipo($tipo_entrada);
	$id_tipo_entrada_camion = $list_tipo_entrada[0]['id_tipo_entrada'];
	//En camion no hay cita de descarga
	$id_cita_descarga = null;

	//Insertamos registro en tabla entrada
	$id_entrada = $railsider_model->insert_entrada(
		$fecha_entrada,
		$id_tipo_entrada_camion,
		$id_cita_descarga,
		$_SESSION['email']
	);

	//TABLA EMPRESA_DESTINO_ORIGEN
	if ($id_destinatario != '') {
		//Comprobamos si existe el destinatario
		$destinatario_list = $railsider_model->get_destinatario_por_id($id_destinatario);
		if (count($destinatario_list) == 0) { //Si no existe
			$nombre_destinatario = strtoupper($id_destinatario);
			//Insertamos destinatario
			$id_destinatario = $railsider_model->insert_destinatario($nombre_destinatario, NULL);
		}
	} else {
		$id_destinatario = null;
	}

	/*if ($cif_propietario == 'A86868114'){
		$id_destinatario = $id_destinatario_actual = '';
		$nombre_destinatario = '';
	}*/

	//TABLA CONDUCTOR
	//Comprobamos si existe el conductor
	$conductor_list = $railsider_model->get_conductor_por_dni($dni_conductor);
	if (count($conductor_list) == 0) { //Si no existe
		//Insertamos conductor
		$railsider_model->insert_conductor($dni_conductor, $nombre_conductor, $apellidos_conductor);
	}

	//TABLA ENTRADA_TIPO_CAMION
	//calculamos ultimo numero de expedicion para camion
	$num_expedicion_list = $railsider_model->get_ultimo_num_expedicion_entrada_tipo_camion();
	$num_expedicion = $num_expedicion_list[0]['num_expedicion'] + 1;
	//Insertamos registro en tabla entrada_tipo_camion
	$railsider_model->insert_entrada_camion(
		$id_entrada,
		$num_expedicion,
		$matricula_tractora,
		$matricula_remolque,
		$dni_conductor,
		$cif_empresa_transportista,
		$id_origen,
		$id_destino,
		$observaciones
	);

	//TABLA CONTENEDOR
	//calculamos mercancia actual
	$id_tipo_mercancia_actual_contenedor = $id_tipo_mercancia;
	//calculamos temperatura actual
	$temperatura_actual_contenedor = $temperatura_contenedor;
	//calcular cif_propietario_actual
	$cif_propietario_actual = $cif_propietario;
	//calcular id_destinatario_actual
	$id_destinatario_actual = $id_destinatario;
	//calculamos el peso mercancia actual del contenedor
	$peso_mercancia_actual_contenedor = $peso_mercancia_contenedor;
	//calculamos el booking actual del contenedor
	$num_booking_actual_contenedor = $num_booking_contenedor;
	//calculamos el precinto actual del contenedor
	$num_precinto_actual_contenedor = $num_precinto_contenedor;
	//calculamos el codigo estacion ferrocarril actual del contenedor
	$codigo_estacion_ferrocarril_actual_contenedor = $codigo_estacion_ferrocarril;
	//calculamos el num_peligro_adr actual del contenedor
	$num_peligro_adr_actual_contenedor = $num_peligro_adr;
	//calculamos el num_onu_adr actual del contenedor
	$num_onu_adr_actual_contenedor = $num_onu_adr;
	//calculamos el num_clase_adr actual del contenedor
	$num_clase_adr_actual_contenedor = $num_clase_adr;
	//calculamos el cod_grupo_embalaje_adr actual del contenedor
	$cod_grupo_embalaje_adr_actual_contenedor = $cod_grupo_embalaje_adr;

	//sacamos datos de contenedor
	$list = $railsider_model->get_contenedor($num_contenedor);
	if (count($list) > 0) { //Si existe, actualizamos
		foreach ($list as $value) { //sacamos datos del contenedor desde BBDD
			//al contenedor dado de alta, no podemos cambiarle el tipo
			$id_tipo_contenedor_iso = $value['id_tipo_contenedor_iso'];
			//calculamos peso bruto actual
			$peso_bruto_actual_contenedor = $peso_mercancia_contenedor + $tara_contenedor;

			$railsider_model->update_contenedor(
				$num_contenedor,
				$tara_contenedor,
				$estado_carga_contenedor,
				$peso_bruto_actual_contenedor,
				$peso_mercancia_actual_contenedor,
				$num_booking_actual_contenedor,
				$num_precinto_actual_contenedor,
				$temperatura_actual_contenedor,
				$id_tipo_mercancia_actual_contenedor,
				$num_peligro_adr_actual_contenedor,
				$num_onu_adr_actual_contenedor,
				$num_clase_adr_actual_contenedor,
				$cod_grupo_embalaje_adr_actual_contenedor,
				$id_tipo_contenedor_iso,
				$cif_propietario_actual,
				$codigo_estacion_ferrocarril_actual_contenedor,
				$id_destinatario_actual
			);
		}
	} else { //Si no existe, insertamos
		$tipo_contenedor_list = $railsider_model->get_tipo_contenedor_iso_por_id($id_tipo_contenedor_iso);
		$peso_bruto_actual_contenedor = $peso_mercancia_contenedor + $tara_contenedor;

		$railsider_model->insert_contenedor(
			$num_contenedor,
			$tara_contenedor,
			$estado_carga_contenedor,
			$peso_bruto_actual_contenedor,
			$peso_mercancia_actual_contenedor,
			$num_booking_actual_contenedor,
			$num_precinto_actual_contenedor,
			$temperatura_actual_contenedor,
			$id_tipo_mercancia_actual_contenedor,
			$num_peligro_adr_actual_contenedor,
			$num_onu_adr_actual_contenedor,
			$num_clase_adr_actual_contenedor,
			$cod_grupo_embalaje_adr_actual_contenedor,
			$id_tipo_contenedor_iso,
			$cif_propietario_actual,
			$codigo_estacion_ferrocarril_actual_contenedor,
			$id_destinatario_actual
		);
	}

	//pintamos variables
	/*
		echo "num_contenedor: ".$num_contenedor."<br>";
		echo "tara_contenedor: ".$tara_contenedor."<br>";
		echo "estado_carga_contenedor: ".$estado_carga_contenedor."<br>";
		echo "peso_bruto_actual_contenedor: ".$peso_bruto_actual_contenedor."<br>";
		echo "temperatura_actual_contenedor: ".$temperatura_actual_contenedor."<br>";
		echo "id_tipo_mercancia_actual_contenedor: ".$id_tipo_mercancia_actual_contenedor."<br>";
		echo "id_tipo_contenedor_iso: ".$id_tipo_contenedor_iso."<br>";
*/

	//TABLA ENTRADA_CAMION_CONTENEDOR
	$railsider_model->insert_entrada_camion_contenedor(
		$id_entrada,
		$num_contenedor,
		$estado_carga_contenedor,
		$id_tipo_mercancia,
		$num_peligro_adr,
		$num_onu_adr,
		$num_clase_adr,
		$cod_grupo_embalaje_adr,
		$peso_mercancia_contenedor,
		$num_booking_contenedor,
		$num_precinto_contenedor,
		$temperatura_contenedor,
		$cif_propietario,
		$codigo_estacion_ferrocarril,
		$id_destinatario
	);

	//pintamos variables
	/*
			echo "id_entrada: ".$id_entrada."<br>";
			echo "num_contenedor: ".$num_contenedor."<br>";
			echo "id_tipo_mercancia: ".$id_tipo_mercancia."<br>";
			echo "num_onu_adr: ".$num_onu_adr."<br>";
			echo "num_clase_adr: ".$num_clase_adr."<br>";
			echo "cod_grupo_embalaje_adr: ".$cod_grupo_embalaje_adr."<br>";
			echo "peso_mercancia_contenedor: ".$peso_mercancia_contenedor."<br>";
			echo "temperatura_contenedor: ".$temperatura_contenedor."<br>";
			echo "cif_propietario: ".$cif_propietario."<br>";
			echo "codigo_estacion_ferrocarril: ".$codigo_estacion_ferrocarril."<br>";
			echo "id_destinatario: ".$id_destinatario."<br>";
			*/

	//TABLA CONTROL_STOCK
	$list_control_stock = $railsider_model->contenedor_en_stock($num_contenedor);
	if (count($list_control_stock) == 0) { //Si no hay datos
		//insertar id_entrada y contenedor en tabla control_stock
		$id_control_stock = $railsider_model->insert_control_stock(
			$num_contenedor,
			$id_entrada
		);
	}

	//GENERACION Y ENVIO CODECO
	if (($cif_propietario == 'A60389624') || ($cif_propietario == 'A96764097')) { //CODECOS CMA-CGM (A60389624 = CCIS-BILBAO) (A96764097 = SICSA-VALENCIA)

		$contenedores_codeco = array();
		$fecha_movimiento = $fecha_entrada;

		if ($estado_carga_contenedor == 'C') { //SI ENTRADA CAMION CARGADO => EXPORT => 2
			$import_export = 2; //3 for import and 2 for export
			$estado_carga = 5; //5 for full and 4 for empty
		} else if ($estado_carga_contenedor == 'V') { //SI ENTRADA CAMION VACIO => IMPORT => 3
			$import_export = 3; //3 for import and 2 for export
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
		//marcamos que el CODECO no presenta averia o daño del contenedor
		$daño_averia = 0;

		codeco_ccis_sicsa_gatein(
			$id_entrada,
			$fecha_movimiento,
			$contenedores_codeco,
			$tipo_vehiculo,
			$trip_number,
			$nombre_empresa_transportista,
			$id_vehiculo,
			$daño_averia
		);
	}

	//GENERACION DE INCIDENCIA
	//Si esta marcado la casilla de retraso, insertamos incidencia
	if (isset($retraso_camion_checkbox)) {

		$id_tipo_incidencia = 2; //la incidencia es de tipo retraso camion
		$estado_incidencia = 'ABIERTA';
		$observaciones = '';
		$fecha_incidencia = $fecha_entrada; //con hora
		$date_incidencia = $fecha_form; //sin hora

		//obtener serie del año segun la fecha de incidencia
		$fecha_serie = strtotime($date_incidencia);
		$year_serie = date("y", $fecha_serie);

		//obtener ultimo num_incidencia del año
		$ultimo_num_incidencia = $railsider_model->get_ultimo_num_incidencia_por_serie($year_serie)[0]['num_incidencia'];
		$contador_incidencia_serie = explode("/", $ultimo_num_incidencia)[1];
		//sumarle 1
		$siguiente_num_incidencia = $year_serie . "/" . sprintf('%04d', $contador_incidencia_serie + 1);
		//echo $siguiente_num_incidencia;

		//comprobar que no exista
		$incidencia_list = $railsider_model->get_num_incidencia_por_num_incidencia($siguiente_num_incidencia);

		if (count($incidencia_list) == 0) { //si no existe el numero
			//TABLA INCIDENCIA
			$id_incidencia = $railsider_model->insert_incidencia(
				$fecha_incidencia,
				$id_tipo_incidencia,
				$estado_incidencia,
				$_SESSION['email'],
				$observaciones,
				$siguiente_num_incidencia
			);

			$incidencia_entrada = $railsider_model->insert_incidencia_entrada($id_incidencia, $id_entrada);
		}
	}

	$materia_peligrosa_checkbox = $_POST['materia_peligrosa_checkbox'];

	if ($cif_propietario == 'A86868114' && $estado_carga_contenedor == 'C' && $id_tipo_mercancia = 2) { //RENFE - CARGADO - MERCANCIA_PELIGROSA
		// Convertir checkbox a entero (1 si es true, 0 si es false)
		$materia_peligrosa_checkbox = isset($materia_peligrosa_checkbox) && $materia_peligrosa_checkbox ? 'Contiene Etiqueta' : 'No Contiene Etiqueta';

		// Asegurarse de que `$id_entrada`, `$id_salida`, y `$num_contenedor` estén definidos/validados correctamente
		if (isset($id_entrada, $num_contenedor)) {
			// INSERTAR EN TABLA CONTENEDOR_MATERIA_PELIGROSA
			$railsider_model->insert_materia_peligrosa_entrada($id_entrada, $num_contenedor, $materia_peligrosa_checkbox);
		} else {
			echo 'Error: Faltan datos requeridos para la inserción de materia peligrosa.';
		}
	}

	header('Location: ../controllers/entrada_resumen_controller.php?id_entrada=' . $id_entrada);
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

	//obtener estaciones ferrocarril renfe
	$estaciones_ferrocarril_renfe_list = $railsider_model->get_estaciones_ferrocarril_renfe();
	//echo "<pre>";
	//print_r($estaciones_ferrocarril_renfe_list);
	//echo "</pre>";


	//cargamos la vista
	require_once('../views/entrada_camion_view.php');
	//cargamos la vista
	require_once('../views/empresa_transportista_modal_view.php');
}
