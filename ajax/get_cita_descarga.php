<?php

session_start();

//cargamos el modelo con la clase que interactua con la tabla
require_once("../models/railsider_model.php");
//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");
//comprobamos que el usuario esta logeado
check_logged_user();

if (isset($_POST['num_expedicion'])) {

	$num_expedicion = strip_tags(trim($_POST['num_expedicion']));
	//echo $num_expedicion;

	//instanciamos el modelo para acceso a la BBDD de usuarios
	$railsider_model = new railsider_model();

	$list = $railsider_model->get_citas_descarga_por_num_expedicion($num_expedicion);

	//si hay datos
	if (count($list) > 0) {
		foreach ($list as $key => $value) {
			$id_cita_descarga = $value['id_cita_descarga'];
			$num_expedicion = $value['num_expedicion'];
			$fecha = $value['fecha'];
			$hora = $value['hora'];
			$observaciones = $value['observaciones'];
			$cif_propietario = $value['cif_propietario'];
			$nombre_propietario = $value['nombre_propietario'];
			$nombre_comercial_propietario = $value['nombre_comercial_propietario'];
			$nombre_origen  = $value['nombre_origen '];
		}

		$data = array(
			'id' => $id_cita_descarga,
			'num_expedicion' => $num_expedicion,
			'fecha' => $fecha,
			'hora' => $hora,
			'observaciones' => $observaciones,
			'cif_propietario' => $cif_propietario,
			'nombre_propietario' => $nombre_propietario,
			'nombre_comercial_propietario' => $nombre_comercial_propietario,
			'text' => 'Hay resultados'
		);
	} else {
		$data[] = array(
			'id' => $num_expedicion,
			'text' => 'No hay resultados'
		);
	}

	//Devolvemos el objeto JSON
	echo json_encode($data);
}
