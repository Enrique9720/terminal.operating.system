<?php

session_start();

//cargamos el modelo con la clase que interactua con la tabla clientes
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

	//si hay datos
	if(count($evento_list) > 0){

		foreach ($evento_list as $key => $evento_line) {
			$id_evento = $evento_line['id_evento'];
			$fecha_evento = $evento_line['fecha_evento'];
			$nombre_evento = $evento_line['nombre_evento'];
			$id_incidencia = $evento_line['id_incidencia'];
		}

		$data = array(
          	'id_evento' => $id_evento,
            'fecha_evento' => $fecha_evento,
            'nombre_evento' => $nombre_evento,
            'id_incidencia' => $id_incidencia,
            'text' => 'Hay resultados'
      );

	} else {
		$data[] = array('id_evento' => $id_evento, 'text' => 'No hay resultados');
	}

	//Devolvemos el objeto JSON
	echo json_encode($data);

?>
