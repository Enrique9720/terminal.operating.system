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

	$id_linea_carga = $railsider_model -> insert_no_contenedor_linea_carga_temp(
		$id_cita_carga,
		$num_vagon,
		$pos_vagon,
		$pos_contenedor
	);


	$linea_carga_list = $railsider_model -> get_no_contenedor_salida_tren_pedido(
		$id_cita_carga,
		$pos_contenedor,
		$num_vagon,
		$pos_vagon
	);

	if(count($linea_carga_list) > 0){//Contenedor en stock
		foreach ($linea_carga_list as $key => $value) {
			$id_linea_carga_temp = $value['id_linea_carga'];
			$id_cita_carga_temp = $value['id_cita_carga'];
			$pos_contenedor_temp = $value['pos_contenedor_temp'];
			$num_vagon_temp = $value['num_vagon_temp'];
			$pos_vagon_temp = $value['pos_vagon_temp'];
		}
	}

	if(
		($id_linea_carga_temp == $id_linea_carga) &&
		($id_cita_carga_temp == $id_cita_carga) &&
		($num_vagon_temp == $num_vagon) &&
		($pos_vagon_temp == $pos_vagon) &&
		($pos_contenedor_temp == $pos_contenedor)
	){
	  $data = array(
			'id_linea_carga' => $id_linea_carga,
			'num_contenedor' => 'NO-CON',
			'pos_contenedor' => $pos_contenedor_temp,
			'id_tipo_contenedor_iso' => '',
			'descripcion_mercancia' => '',
			'nombre_comercial_propietario' => '',
			'num_vagon' => $num_vagon_temp,
			'pos_vagon' => $pos_vagon_temp,
			'id_contenedor_temp' => 'success'
		);
	}else{
	  $data = array(
			'num_contenedor' => 'NO-CON',
			'id_contenedor_temp' => 'error'
		);
	}


	//Devolvemos el objeto JSON
	echo json_encode($data);

}

?>
