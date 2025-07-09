<?php

session_start();

//cargamos el modelo con la clase que interactua con la tabla
require_once("../models/railsider_model.php");
//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");
//comprobamos que el usuario esta logeado
check_logged_user();

if (isset($_POST['id_tipo_contenedor_iso'])) {

	$id_tipo_contenedor_iso = strip_tags(trim($_POST['id_tipo_contenedor_iso']));
	//echo $tipo_contenedor_iso;

	//instanciamos el modelo para acceso a la BBDD de usuarios
	$railsider_model = new railsider_model();

	$tipo_contenedor_iso_list = $railsider_model->get_tipo_contenedor_iso_por_id($id_tipo_contenedor_iso);

	//si hay datos
	if (count($tipo_contenedor_iso_list) > 0) {
		foreach ($tipo_contenedor_iso_list as $key => $value) {
			$id_tipo_contenedor_iso = $value['id_tipo_contenedor_iso'];
			$longitud_tipo_contenedor = $value['longitud_tipo_contenedor'];
			$descripcion_tipo_contenedor = $value['descripcion_tipo_contenedor'];
		}

		$data = array(
			'id' => $id_tipo_contenedor_iso,
			'longitud_tipo_contenedor' => $longitud_tipo_contenedor,
			'descripcion_tipo_contenedor' => $descripcion_tipo_contenedor,
			'text' => 'Hay resultados'
		);
	} else {
		$data[] = array('id' => $id_tipo_contenedor_iso, 'text' => 'No hay resultados');
	}

	//Devolvemos el objeto JSON
	echo json_encode($data);
}
