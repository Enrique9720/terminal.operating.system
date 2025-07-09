<?php

session_start();

require_once("../models/railsider_model.php");
require_once("../functions/functions.php");
check_logged_user();

$search = isset($_GET['q']) ? trim($_GET['q']) : '';
$nombre_comercial_propietario = isset($_GET['nombre_comercial_propietario']) ? trim($_GET['nombre_comercial_propietario']) : '';

if (empty($search) && empty($nombre_comercial_propietario)) {
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode([['id' => '0', 'text' => 'Parámetros inválidos']]);
	exit;
}

$railsider_model = new railsider_model();
$list = $railsider_model->get_contenedores_stock_noIncidencia_vacio_ajax($search, $nombre_comercial_propietario);

$data = [];

if (is_array($list) && count($list) > 0) {
	foreach ($list as $key => $value) {
		$data[] = [
			'id' => $value['num_contenedor'],
			'text' => $value['num_contenedor']
		];
	}
} else {
	$data[] = [
		'id' => '0',
		'text' => 'No hay resultados'
	];
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);
