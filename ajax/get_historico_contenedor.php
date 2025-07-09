<?php

session_start();
///////////////////////*CARGA DE MODELOS*////////////////////////////////////////////
require_once("../models/railsider_model.php");
/////////////////////////////////////////////////////////////////////////////////////
//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");
//comprobamos que el usuario esta logeado
check_logged_user();
////////////////////////////////////////////////////////////////

$num_contenedor = strtoupper(strip_tags(trim($_POST['num_contenedor'])));
//echo $matricula;

//instanciamos el modelo para acceso a la BBDD de usuarios
$railsider_model = new railsider_model();
//obtenemos el listado de todos los clientes de la BBDD
$contenedor_historico_list = $railsider_model->get_historico_contenedor($num_contenedor); //STOCK CONTENEDORES

//echo "<pre>";
//print_r($contenedor_historico_list);
//echo "</pre>";

if (count($contenedor_historico_list) > 0) {

	foreach ($contenedor_historico_list as $key => $value) {

		$id_control_stock = "";
		$id_ubicacion = "";

		$num_expedicion_entrada = "";
		$id_entrada = "";
		$tipo_entrada = "";
		$fecha_entrada = "";
		$descripcion_mercancia_entrada = "";
		$nombre_comercial_propietario_entrada = "";
		$num_expedicion_salida = "";
		$id_salida = "";
		$tipo_salida = "";
		$fecha_salida = "";
		$nombre_comercial_propietario_salida = "";

		$num_contenedor = $value['num_contenedor'];
		$id_control_stock = $value['id_control_stock'];
		$id_ubicacion = $value['id_ubicacion'];
		$id_entrada = $value['id_entrada'];
		$tipo_entrada = $value['tipo_entrada'];
		$fecha_entrada = $value['fecha_entrada'];
		$id_salida = $value['id_salida'];
		$tipo_salida = $value['tipo_salida'];
		$fecha_salida = $value['fecha_salida'];

		if($tipo_entrada == 'TREN'){ //ENTRADA
			$entrada_tren_list = $railsider_model->get_entrada_tipo_tren_por_id_entrada_por_num_contenedor($id_entrada, $num_contenedor);
			$num_expedicion_entrada = $entrada_tren_list[0]['num_expedicion'];
			$descripcion_mercancia_entrada = $entrada_tren_list[0]['descripcion_mercancia'];
			$nombre_comercial_propietario_entrada = $entrada_tren_list[0]['nombre_comercial_propietario'];

		}else if($tipo_entrada == 'CAMIÓN'){
			$entrada_camion_list = $railsider_model->get_entrada_tipo_camion_por_id_entrada_por_num_contenedor($id_entrada, $num_contenedor);
			$num_expedicion_entrada = $entrada_camion_list[0]['num_expedicion'];
			$descripcion_mercancia_entrada = $entrada_camion_list[0]['descripcion_mercancia'];
			$nombre_comercial_propietario_entrada = $entrada_camion_list[0]['nombre_comercial_propietario'];
		}else if($tipo_entrada == 'TRASPASO'){
			$entrada_traspaso_list = $railsider_model->get_entrada_tipo_traspaso_por_id_entrada_por_num_contenedor($id_entrada, $num_contenedor);
			$num_expedicion_entrada = $entrada_traspaso_list[0]['num_expedicion'];
			$descripcion_mercancia_entrada = $entrada_traspaso_list[0]['descripcion_mercancia'];
			$nombre_comercial_propietario_entrada = $entrada_traspaso_list[0]['nombre_comercial_propietario'];
		}




		if($tipo_salida == 'TREN'){ //SALIDA
			//$salida_tren_list = $railsider_model->get_salida_tipo_tren_por_id_salida_por_num_contenedor($id_salida, $num_contenedor);
			//$num_expedicion_salida = $salida_tren_list[0]['num_expedicion'];
			//$descripcion_mercancia_salida = $salida_tren_list[0]['descripcion_mercancia'];
			//$nombre_comercial_propietario_salida = $salida_tren_list[0]['nombre_comercial_propietario'];
		}else if($tipo_salida == 'CAMIÓN'){
			$salida_camion_list = $railsider_model->get_salida_tipo_camion_por_id_salida_por_num_contenedor($id_salida, $num_contenedor);
			$num_expedicion_salida = $salida_camion_list[0]['num_expedicion'];
			$nombre_comercial_propietario_salida = $salida_camion_list[0]['nombre_comercial_propietario'];
		}

		$data[] = array(
			'id' => $num_contenedor,
			'id_control_stock' => $id_control_stock,
			'id_ubicacion' => "",
			'id_entrada' => $id_entrada,
			'num_expedicion_entrada' => $num_expedicion_entrada,
			'tipo_entrada' => $tipo_entrada,
			'fecha_entrada' => $fecha_entrada,
			'descripcion_mercancia_entrada' => $descripcion_mercancia_entrada,
			'nombre_comercial_propietario_entrada' => $nombre_comercial_propietario_entrada,
			'id_salida' => $id_salida,
			'num_expedicion_salida' => $num_expedicion_salida,
			'tipo_salida' => $tipo_salida,
			'fecha_salida' => $fecha_salida,
			'nombre_comercial_propietario_salida' => $nombre_comercial_propietario_salida,
			'text' => 'Hay resultados'
		);

	}


} else {
	$data[] = array('id' => $num_contenedor, 'text' => 'No hay resultados');
}

//Devolvemos el objeto JSON
echo json_encode($data);
