<?php

session_start();

//cargamos el modelo con la clase que interactua con la tabla
require_once("../models/railsider_model.php");
//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");
//comprobamos que el usuario esta logeado
check_logged_user();

////////////////////////////////////////////////////////////////

	$id_evento = strtoupper(strip_tags(trim($_POST['id_evento'])));
	//echo $id_evento;

	//instanciamos el modelo para acceso a la BBDD
	$railsider_model = new railsider_model();
	//obtenemos los datos de la entrada planificada
	$evento_list = $railsider_model -> get_incidencia_evento_por_id($id_evento);
	//echo "<pre>";
	//print_r($evento_list);
	//echo "</pre>";

	//si hay datos y la entrada no esta validada
	if(count($evento_list) > 0 ){

		//obtenemos los ficheros asociados al evento
		$ficheros_list = $railsider_model -> get_ficheros_por_id_evento($id_evento);
		foreach ($ficheros_list as $ficheros_line) {
			$id_fichero = $ficheros_line['id_fichero'];
			$ruta_fichero = $ficheros_line['ruta_fichero'];
			//borramos
			$railsider_model -> delete_incidencia_evento_fichero($id_fichero);
			$railsider_model -> delete_fichero($id_fichero);
			unlink($ruta_fichero);
		}

		//por ultimo borramos la entrada de la tabla entradas
		$railsider_model -> delete_incidencia_evento($id_evento);

	}

	$evento_list = null;
	//obtenemos los doatos de un registro en concreto de la tabla desde la BBDD
  $evento_list = $railsider_model -> get_incidencia_evento_por_id($id_evento);


	if(count($evento_list) > 0){

		$data[] = array(
			'id_evento' => $id_evento,
			'text' => 'Hay resultados'
		);

	} else {
		$data[] = array(
			'id_evento' => $id_evento,
			'text' => 'No hay resultados'
		);
	}

	//Devolvemos el objeto JSON
	echo json_encode($data);

?>
