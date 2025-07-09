<?php
//////////////////////////////////////////////////////////////////
session_start();

//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");

//comprobamos que el usuario esta logeado
check_logged_user();

/////////////////////// CARGA DE MODELOS ////////////////////////////////////////////
require_once("../models/railsider_model.php");
/////////////////////////////////////////////////////////////////////////////////////

//echo "<pre>"; print_r($_GET); echo "</pre>";

if (isset($_GET['id_incidencia'])) { //estamos guardando formulario

	$id_incidencia = $_GET['id_incidencia'];

	$railsider_model = new railsider_model();
	$incidencia = $railsider_model->get_incidencia($id_incidencia);
	//echo "<pre>";
	//print_r($incidencia);
	//echo "</pre>";
	$num_incidencia = $incidencia[0]['num_incidencia'];
	$id_tipo_incidencia = $incidencia[0]['id_tipo_incidencia'];

	$incidencia_eventos = $railsider_model->get_incidencia_eventos($id_incidencia);
	//echo "<pre>";
	//print_r($incidencia_eventos);
	//echo "</pre>";

	if ($incidencia[0]['tipo_incidencia'] == 'AVERIA REEFER') {

		$incidencia_contenedor = $railsider_model->get_incidencia_contenedor($id_incidencia);
		//echo "<pre>";
		//print_r($incidencia_contenedor);
		//echo "</pre>";

	} else if ($incidencia[0]['tipo_incidencia'] == 'DAÑO UTI') {

		$incidencia_contenedor = $railsider_model->get_incidencia_contenedor($id_incidencia);
		//echo "<pre>";
		//print_r($incidencia_contenedor);
		//echo "</pre>";

	} else if ($incidencia[0]['tipo_incidencia'] == 'RETRASO CAMIÓN') {

		$incidencia_retraso_camion = $railsider_model->get_incidencia_retraso_camion($id_incidencia);
		//echo "<pre>";
		//print_r($incidencia_retraso_camion);
		//echo "</pre>";

	} else if ($incidencia[0]['tipo_incidencia'] == 'FRENADO TREN') {

		$incidencia_frenado_tren = $railsider_model->get_incidencia_frenado($id_incidencia);
		//echo "<pre>";
		//print_r($incidencia_frenado_tren);
		//echo "</pre>";

	} else if ($incidencia[0]['tipo_incidencia'] == 'RETRASO TREN') {

		$incidencia_retraso_tren = $railsider_model->get_incidencia_retraso_tren($id_incidencia);
		//echo "<pre>";
		//print_r($incidencia_retraso_tren);
		//echo "</pre>";
		$incidencia_retraso_tren = $railsider_model->get_incidencia_retraso_tren_entrada($id_incidencia);
		//echo "<pre>";
		//print_r($incidencia_retraso_tren);
		//echo "</pre>";

	} else if ($incidencia[0]['tipo_incidencia'] == 'ESTANCIA M.M.P.P.') {
		$incidencia_contenedor = $railsider_model->get_incidencia_contenedor($id_incidencia);
		//echo "<pre>";
		//print_r($incidencia_contenedor);
		//echo "</pre>";
		$num_contenedor = $incidencia_contenedor[0]['num_contenedor'];
		$incidencia_demora_mmpp = $railsider_model->get_incidencia_demora_mmpp($id_incidencia, $num_contenedor);
		//echo "<pre>"; print_r($incidencia_demora_mmpp); echo "</pre>";
	}



	$tipos_ficheros_list = $railsider_model->get_tipos_ficheros();
	foreach ($tipos_ficheros_list as $tipos_ficheros_line) {
		$id_tipo_fichero = $tipos_ficheros_line['id_tipo_fichero'];
		$tipo_fichero = $tipos_ficheros_line['tipo_fichero'];
	}

	//cargamos la vista
	require_once('../views/incidencia_view.php');

	//cargamos la vista modal para eventos
	require_once('../views/incidencia_modal_view.php');
} else { //mostramos la vista con el formulario
	echo "No hay ID incidencia";
}
