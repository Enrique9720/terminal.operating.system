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



if (isset($_GET['id_parte'])) {  //estamos guardando formulario
	$id_parte_trabajo = $_GET['id_parte'];

	$num_contenedor = $_GET['num_contenedor'];

	$railsider_model = new railsider_model();
	$parte_trabajo = $railsider_model->get_parte_trabajo($id_parte_trabajo);
	//echo "<pre>";
	//print_r($parte_trabajo);
	//echo "</pre>";


	$parte_trabajo_lineas = $railsider_model->get_parte_trabajo_lineas($id_parte_trabajo);
	//echo "<pre>";
	//print_r($parte_trabajo_lineas);
	//echo "</pre>";


	$fotos_list = $railsider_model->get_fotos_parte_trabajo($id_parte_trabajo);
	//echo "<pre>";
	//print_r($fotos_list);
	//echo "</pre>";

	//cargamos informacion del envio de CODECO del nº contenedor
	$num_contenedor = $parte_trabajo[0]['num_contenedor'];

	$codeco_info_list = $railsider_model->get_codeco_parte_trabajo($num_contenedor, $id_parte_trabajo);
	//echo "<pre>";
	//print_r($codeco_info_list);
	//echo "</pre>";

	$averia_daño_incidencia_list = $railsider_model->get_incidencias_num_contenedor($num_contenedor);
	//echo "<pre>";
	//print_r($averia_daño_incidencia_list);
	//echo "</pre>";

	//cargamos la vista
	require_once('../views/parte_trabajo_view.php');
} else { //mostramos la vista con el formulario
	echo "No hay ID parte trabajo";
}
