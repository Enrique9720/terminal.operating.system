<?php

session_start();

//cargamos el modelo con la clase que interactua con la tabla clientes
require_once("../models/railsider_model.php");
//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");
//comprobamos que el usuario esta logeado
check_logged_user();

////////////////////////////////////////////////////////////////

//echo "<pre>";
//print_r($_POST);
//echo "</pre>";

$id_evento = strtoupper(strip_tags(trim($_POST['id_evento'])));
//echo $id_evento;

$tipo_modal = strip_tags(trim($_POST['tipo_modal']));
//echo $tipo_modal;

//instanciamos el modelo para acceso a la BBDD de usuarios
$railsider_model = new railsider_model();
//obtenemos el listado de todos los clientes de la BBDD
$ficheros_list = $railsider_model->get_ficheros_por_id_evento($id_evento);

//echo "<pre>";
//print_r($ficheros_list);
//echo "</pre>";

if (count($ficheros_list) > 0) {

	foreach ($ficheros_list as $key => $value) {
		$id_fichero = $value['id_fichero'];
		$ruta_fichero = $value['ruta_fichero'];
		if ($tipo_modal == 'view_record' || $tipo_modal == 'delete_record') {
			$boton_fichero = "<div class='btn-group'>";
			$boton_fichero = $boton_fichero . "<a href='" . $value['ruta_fichero'] . "' target='_blank' type='button' class='btn btn-sm btn-default ver_fichero' title='Ver'><span class='fa fa-eye'></span></a>";
			$boton_fichero = $boton_fichero . "</div>";
		} else if ($tipo_modal == 'edit_record') {
			$boton_fichero = "<div class='btn-group'>";
			$boton_fichero = $boton_fichero . "<a href='" . $value['ruta_fichero'] . "' target='_blank' type='button' class='btn btn-sm btn-default ver_fichero' title='Ver'><span class='fa fa-eye'></span></a>";
			$boton_fichero = $boton_fichero . "<a href='#' type='button' id='" . $id_fichero . "' class='btn btn-sm btn-danger borrar_fichero' title='Borrar Fichero'><span class='fas fa-trash'></span></a>";
			$boton_fichero = $boton_fichero . "</div>";
		}

		$id_tipo_fichero = $value['id_tipo_fichero'];
		$tipo_fichero = $value['tipo_fichero'];
		$nombre_fichero = $value['nombre_fichero'];


		$data[] = array(
			'id' => $id_fichero,
			'ruta_fichero' => $ruta_fichero,
			'nombre_fichero' => $nombre_fichero,
			'boton_fichero' => $boton_fichero,
			'id_tipo_fichero' => $id_tipo_fichero,
			'tipo_fichero' => $tipo_fichero,
			'text' => 'Hay resultados'
		);
	}
} else {

	$data[] = array(
		'id' => '',
		'ruta_fichero' => '',
		'nombre_fichero' => '',
		'boton_fichero' => '',
		'id_tipo_fichero' => '',
		'tipo_fichero' => '',
		'text' => 'No hay resultados'
	);
}

//Devolvemos el objeto JSON
echo json_encode($data);
