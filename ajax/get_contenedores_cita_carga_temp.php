<?php

session_start();

//cargamos el modelo con la clase que interactua con la tabla
require_once("../models/railsider_model.php");
//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");
//comprobamos que el usuario esta logeado
check_logged_user();

if (isset($_POST['id_cita_carga'])) {

	$id_cita_carga = strip_tags(trim($_POST['id_cita_carga']));
	//echo $id_cita_carga."<br>";

	//declaramos objeto del modelo proveedores
	$railsider_model = new railsider_model();
	//Comprobamos si existe previamente el CIF de dicho proveedor
	$contenedores_list = $railsider_model->get_contenedores_cita_carga_temp($id_cita_carga);
	//print_r($contenedores_list);

	if (count($contenedores_list) > 0) {
		$data = $contenedores_list;
	} else {
		$data = array(
			'num_contenedor' => 'No hay'
		);
	}

	//Devolvemos el objeto JSON
	echo json_encode($data);
}
