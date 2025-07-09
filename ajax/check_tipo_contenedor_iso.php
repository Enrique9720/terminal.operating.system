<?php

session_start();

//cargamos el modelo con la clase que interactua con la tabla
require_once("../models/railsider_model.php");
//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");
//comprobamos que el usuario esta logeado
check_logged_user();

if(isset($_POST['id_tipo_contenedor_iso'])){

	$id_tipo_contenedor_iso = strip_tags(trim($_POST['id_tipo_contenedor_iso']));
	//echo $tipo_contenedor_iso;

	//instanciamos el modelo para acceso a la BBDD de usuarios
	$railsider_model = new railsider_model();

	$list_tipo_contenedor_iso = $railsider_model->get_tipo_contenedor_iso_por_id($id_tipo_contenedor_iso);

	if(count($list_tipo_contenedor_iso) > 0){
	  $data = array(
			'text' => 'existe'
		);

	}else{
	  $data = array(
			'text' => 'no existe'
		);
	}

	//Devolvemos el objeto JSON
	echo json_encode($data);

}

?>
