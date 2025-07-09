<?php

session_start();

//cargamos el modelo con la clase que interactua con la tabla
require_once("../models/railsider_model.php");
//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");
//comprobamos que el usuario esta logeado
check_logged_user();

if (isset($_POST['dni_conductor'])) {

	$dni_conductor = strip_tags(trim($_POST['dni_conductor']));
	//echo $tipo_contenedor_iso;

	//instanciamos el modelo para acceso a la BBDD de usuarios
	$railsider_model = new railsider_model();

	$conductor_list = $railsider_model->get_conductor_por_dni($dni_conductor);

	//si hay datos
	if (count($conductor_list) > 0) {
		foreach ($conductor_list as $key => $value) {
			$dni_conductor = $value['dni_conductor'];
			$nombre_conductor = $value['nombre_conductor'];
			$apellidos_conductor = $value['apellidos_conductor'];
		}

		$data = array(
			'id' => $dni_conductor,
			'nombre_conductor' => $nombre_conductor,
			'apellidos_conductor' => $apellidos_conductor,
			'text' => 'Hay resultados'
		);
	} else {
		$data[] = array('id' => $dni_conductor, 'text' => 'No hay resultados');
	}

	//Devolvemos el objeto JSON
	echo json_encode($data);
}
