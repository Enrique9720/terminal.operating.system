<?php

session_start();

//cargamos el modelo con la clase que interactua con la tabla
require_once("../models/railsider_model.php");
//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");
//comprobamos que el usuario esta logeado
check_logged_user();

if (isset($_POST['num_peligro_adr'])) {

	$num_peligro_adr = strip_tags(trim($_POST['num_peligro_adr']));
	//echo $num_onu_adr;

	//instanciamos el modelo para acceso a la BBDD de usuarios
	$railsider_model = new railsider_model();

	$num_peligro_adr_list = $railsider_model->get_adr_num_peligro_por_codigo($num_peligro_adr);

	//si hay datos
	if (count($num_peligro_adr_list) > 0) {
		foreach ($num_peligro_adr_list as $key => $value) {
			$num_peligro_adr = $value['num_peligro_adr'];
			$descripcion_peligro_adr = $value['descripcion_peligro_adr'];
		}

		$data = array(
			'id' => $num_peligro_adr,
			'descripcion_peligro_adr' => $descripcion_peligro_adr,
			'text' => 'Hay resultados'
		);
	} else {
		$data[] = array('id' => $num_peligro_adr, 'text' => 'No hay resultados');
	}

	//Devolvemos el objeto JSON
	echo json_encode($data);
}
