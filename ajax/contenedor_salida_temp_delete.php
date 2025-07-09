<?php

session_start();

//cargamos el modelo con la clase que interactua con la tabla
require_once("../models/railsider_model.php");
//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");
//comprobamos que el usuario esta logeado
check_logged_user();

if (
	isset($_POST['id_linea_carga']) &&
	isset($_POST['id_cita_carga'])
) {

	$id_linea_carga = strip_tags(trim($_POST['id_linea_carga']));
	//echo $num_contenedor."<br>";
	$id_cita_carga = strip_tags(trim($_POST['id_cita_carga']));
	//echo $id_cita_carga."<br>";

	//declaramos objeto del modelo
	$railsider_model = new railsider_model();

	$linea_carga = $railsider_model->get_linea_carga_por_id($id_linea_carga);
	foreach ($linea_carga as $key => $value) {
		$num_contenedor = $value['num_contenedor'];
	}

	if ($num_contenedor != null) { //si es un contenedor

		//marcamos los palets con la cita_carga_temporal
		$railsider_model->delete_contenedor_id_cita_carga_temp($num_contenedor);
		$railsider_model->delete_contenedor_linea_carga_temp($num_contenedor, $id_cita_carga);

		//comprobamos que se halla actualizado correctamente esea palet con la cita de carga temporal
		$contenedor_list = $railsider_model->get_contenedor($num_contenedor);
		if (count($contenedor_list) > 0) { //Contenedor en stock
			foreach ($contenedor_list as $key => $value) {
				$id_tipo_contenedor_iso = $value['id_tipo_contenedor_iso'];
				$descripcion_mercancia = $value['descripcion_mercancia'];
				$nombre_comercial_propietario = $value['nombre_comercial_propietario'];
				$id_cita_carga_temp = $value['id_cita_carga_temp'];
			}
		}

		//comprobamos que se halla actualizado correctamente esea palet con la cita de carga temporal
		$linea_carga_list = $railsider_model->get_contenedor_salida_tren_pedido($id_cita_carga, $num_contenedor);
		if (count($linea_carga_list) > 0) { //Contenedor en stock
			foreach ($linea_carga_list as $key => $value) {
				$pos_contenedor_temp = $value['pos_contenedor_temp'];
				$num_vagon_temp = $value['num_vagon_temp'];
				$pos_vagon_temp = $value['pos_vagon_temp'];
			}
		}

		if (
			($id_cita_carga_temp == null) &&
			($num_vagon_temp == null) &&
			($pos_vagon_temp == null) &&
			($pos_contenedor_temp == null)
		) {
			$data = array(
				'num_contenedor' => $num_contenedor,
				'pos_contenedor' => $pos_contenedor_temp,
				'id_tipo_contenedor_iso' => $id_tipo_contenedor_iso,
				'descripcion_mercancia' => $descripcion_mercancia,
				'nombre_comercial_propietario' => $nombre_comercial_propietario,
				'num_vagon' => $num_vagon_temp,
				'pos_vagon' => $pos_vagon_temp,
				'id_contenedor_temp' => $contenedor_list
			);
		} else {
			$data = array(
				'num_contenedor' => $num_contenedor,
				'id_contenedor_temp' => 'error'
			);
		}
	} else { //si es un hueco NO-CON
		$railsider_model->delete_no_contenedor_linea_carga_temp($id_linea_carga);

		$linea_carga_no_con = $railsider_model->get_linea_carga_por_id($id_linea_carga);
		if (count($linea_carga_no_con) == 0) {
			$data = array(
				'num_contenedor' => $num_contenedor,
				'id_contenedor_temp' => 'success'
			);
		} else {
			$data = array(
				'num_contenedor' => $num_contenedor,
				'id_contenedor_temp' => 'error'
			);
		}
	}

	//Devolvemos el objeto JSON
	echo json_encode($data);
}
?>