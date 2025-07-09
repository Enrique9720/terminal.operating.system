<?php

session_start();

//cargamos el modelo con la clase que interactua con la tabla
require_once("../models/railsider_model.php");
//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");
//comprobamos que el usuario esta logeado
check_logged_user();

if(isset($_POST['num_contenedor'])){

	$num_contenedor = strip_tags(trim($_POST['num_contenedor']));
	//echo $num_contenedor;

	//instanciamos el modelo para acceso a la BBDD de usuarios
	$railsider_model = new railsider_model();

	$list_control_stock = $railsider_model->contenedor_en_stock($num_contenedor);

	if(count($list_control_stock) > 0){
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
