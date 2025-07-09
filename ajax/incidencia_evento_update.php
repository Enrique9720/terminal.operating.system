<?php

session_start();

//cargamos el modelo con la clase que interactua con la tabla
require_once("../models/railsider_model.php");
//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");
//comprobamos que el usuario esta logeado
check_logged_user();

//echo "<pre>";
//print_r($_POST);
//echo "</pre>";

//echo "<pre>";
//print_r($_FILES);
//echo "</pre>";

$id_evento = strtoupper(strip_tags(trim($_POST['id_evento'])));
$id_incidencia = strtoupper(strip_tags(trim($_POST['id_incidencia'])));

$fecha_evento = strtoupper(strip_tags(trim($_POST['fecha_evento'])));
//echo "<br/>fecha_evento: ".$fecha_evento;
$nombre_evento = strtoupper(strip_tags(trim($_POST['nombre_evento'])));
//echo "<br/>nombre_evento: ".$nombre_evento;

//instanciamos el modelo para acceso a la tabla
$railsider_model = new railsider_model();

//obtener el id al insertar para comprobar que se ha insertado
$railsider_model->update_incidencia_evento($id_evento, $fecha_evento, $nombre_evento);

$text_fichero = upload_file_incidencia($id_incidencia, $id_evento, $_FILES, $railsider_model);
//print_r($text_fichero);

//comprobamos insercion
$evento_list = $railsider_model->get_incidencia_evento_por_id($id_evento);
//echo "<pre>";
//print_r($evento_list);
//echo "</pre>";

//si hay datos
if (count($evento_list) > 0) {

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
		'text_fichero' => $text_fichero,
		'text' => 'Hay resultados'
	);
} else {
	$data[] = array('id_evento' => $id_entrada, 'text' => 'No hay resultados');
}

//Devolvemos el objeto JSON
echo json_encode($data);
