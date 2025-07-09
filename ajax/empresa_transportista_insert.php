<?php

session_start();

//cargamos el modelo con la clase que interactua con la tabla
require_once("../models/railsider_model.php");
//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");
//comprobamos que el usuario esta logeado
check_logged_user();

if( isset($_POST['cif_empresa_transportista']) && isset($_POST['nombre_empresa_transportista'])){

	$cif_empresa_transportista = strtoupper(strip_tags(trim($_POST['cif_empresa_transportista'])));
	//echo "<br/>cif_empresa_transportista: ".$cif_empresa_transportista;
	$nombre_empresa_transportista = strtoupper(strip_tags(trim($_POST['nombre_empresa_transportista'])));
	//echo "<br/>nombre_empresa_transportista: ".$nombre_empresa_transportista;
	$direccion_empresa_transportista = strtoupper(strip_tags(trim($_POST['direccion_empresa_transportista'])));
	//echo "<br/>direccion_empresa_transportista: ".$direccion_empresa_transportista;


	//instanciamos el modelo para acceso a la tabla
	$railsider_model = new railsider_model();

	//obtener el id al insertar para comprobar que se ha insertado
	$railsider_model -> insert_empresa_transportista(
		$cif_empresa_transportista, $nombre_empresa_transportista, $direccion_empresa_transportista
	);

	$empresa_transportista_list = $railsider_model ->get_empresa_transportista_por_cif($cif_empresa_transportista);

	//echo "<pre>";
	//print_r($empresa_transportista_list);
	//echo "</pre>";

	//si hay datos
	if(count($empresa_transportista_list) > 0){

		foreach ($empresa_transportista_list as $key => $value) {
			$cif_empresa_transportista = $value['cif_empresa_transportista'];
			$nombre_empresa_transportista = $value['nombre_empresa_transportista'];
			$direccion_empresa_transportista = $value['direccion_empresa_transportista'];
		}

		$data = array(
						'id' => $cif_empresa_transportista,
						'nombre_empresa_transportista' => $nombre_empresa_transportista,
						'direccion_empresa_transportista' => $direccion_empresa_transportista,
						'text' => 'Hay resultados'
				);

	} else {
		$data[] = array('id' => $cif_empresa_transportista, 'text' => 'No hay resultados');
	}

	//Devolvemos el objeto JSON
	echo json_encode($data);
}
?>
