<?php

session_start();

//cargamos el modelo con la clase que interactua con la tabla
require_once("../models/railsider_model.php");
//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");
//comprobamos que el usuario esta logeado
check_logged_user();

if(
	isset($_POST['id_cita_carga']) &&
	isset($_POST['num_vagon']) &&
	isset($_POST['pos_vagon']) &&
	isset($_POST['num_contenedor']) &&
	isset($_POST['pos_contenedor'])
){

	$id_cita_carga = strip_tags(trim($_POST['id_cita_carga']));
	$num_vagon = strip_tags(trim($_POST['num_vagon']));
	$pos_vagon = strip_tags(trim($_POST['pos_vagon']));
	$num_contenedor = strip_tags(trim($_POST['num_contenedor']));
	$pos_contenedor = strip_tags(trim($_POST['pos_contenedor']));
	//echo $id_cita_carga."<br>";
	//echo $num_vagon."<br>";
	//echo $pos_vagon."<br>";
	//echo $num_contenedor."<br>";
	//echo $pos_contenedor."<br>";

	//declaramos objeto del modelo
	$railsider_model = new railsider_model();
	//marcamos los contenedores con la cita_carga_temporal
	$railsider_model -> update_contenedor_id_cita_carga_temp(
		$num_contenedor,
		$id_cita_carga
	);

	$railsider_model -> update_contenedor_linea_carga_temp(
		$id_cita_carga,
		$num_vagon,
		$pos_vagon,
		$num_contenedor,
		$pos_contenedor
	);

	//comprobamos que se halla actualizado correctamente ese contenedor con la cita de carga temporal
	$contenedor_list = $railsider_model -> get_contenedor($num_contenedor);
	if(count($contenedor_list) > 0){//Contenedor en stock
		foreach ($contenedor_list as $key => $value) {
			$id_tipo_contenedor_iso = $value['id_tipo_contenedor_iso'];
			$descripcion_mercancia = $value['descripcion_mercancia'];
			$nombre_comercial_propietario = $value['nombre_comercial_propietario'];
			$id_cita_carga_temp = $value['id_cita_carga_temp'];
		}
	}

	//comprobamos que se halla actualizado correctamente esea palet con la cita de carga temporal
	$linea_carga_list = $railsider_model -> get_contenedor_salida_tren_pedido($id_cita_carga, $num_contenedor);
	if(count($linea_carga_list) > 0){//Contenedor en stock
		foreach ($linea_carga_list as $key => $value) {
			$id_linea_carga = $value['id_linea_carga'];
			$pos_contenedor_temp = $value['pos_contenedor_temp'];
			$num_vagon_temp = $value['num_vagon_temp'];
			$pos_vagon_temp = $value['pos_vagon_temp'];
		}
	}

	if(
		($id_cita_carga_temp == $id_cita_carga) &&
		($num_vagon_temp == $num_vagon) &&
		($pos_vagon_temp == $pos_vagon) &&
		($pos_contenedor_temp == $pos_contenedor)
	){
	  $data = array(
			'num_contenedor' => $num_contenedor,
			'id_linea_carga' => $id_linea_carga,
			'pos_contenedor' => $pos_contenedor_temp,
			'id_tipo_contenedor_iso' => $id_tipo_contenedor_iso,
			'descripcion_mercancia' => $descripcion_mercancia,
			'nombre_comercial_propietario' => $nombre_comercial_propietario,
			'num_vagon' => $num_vagon_temp,
			'pos_vagon' => $pos_vagon_temp,
			'id_contenedor_temp' => $contenedor_list
		);
	}else{
	  $data = array(
			'num_contenedor' => $num_contenedor,
			'id_contenedor_temp' => 'error'
		);
	}


	//Devolvemos el objeto JSON
	echo json_encode($data);

}

?>
