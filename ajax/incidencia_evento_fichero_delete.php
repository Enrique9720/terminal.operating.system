<?php

session_start();

//cargamos el modelo con la clase que interactua con la tabla
require_once("../models/railsider_model.php");
//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");
//comprobamos que el usuario esta logeado
check_logged_user();

////////////////////////////////////////////////////////////////

	$id_fichero = strtoupper(strip_tags(trim($_POST['id_fichero'])));
	//echo $id_fichero;

	//instanciamos el modelo para acceso a la BBDD
	$railsider_model = new railsider_model();

	//obtenemos los datos
	$fichero_list = $railsider_model -> get_fichero($id_fichero);
	//echo "<pre>";
	//print_r($fichero_list);
	//echo "</pre>";

	//si hay datos
	if(count($fichero_list) > 0 ){
		//borramos incidencias_fichero
		$railsider_model -> delete_incidencia_evento_fichero($id_fichero);
		//borramos fichero
		$railsider_model -> delete_fichero($id_fichero);

	}

	$fichero_list = null;
	//obtenemos los doatos de un registro en concreto de la tabla desde la BBDD
  $fichero_list = $railsider_model -> get_fichero($id_fichero);


	if(count($evento_list) > 0){

		$data[] = array(
			'id_fichero' => $id_fichero,
			'text' => 'Hay resultados'
		);

	} else {
		$data[] = array(
			'id_fichero' => $id_fichero,
			'text' => 'No hay resultados'
		);
	}

	//Devolvemos el objeto JSON
	echo json_encode($data);

?>
