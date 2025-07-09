<?php

session_start();

//cargamos el modelo con la clase que interactua con la tabla clientes
require_once("../models/railsider_model.php");
//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");
//comprobamos que el usuario esta logeado
check_logged_user();

$cif_empresa_transportista = strip_tags(trim($_POST['cif_empresa_transportista']));

//instanciamos el modelo para acceso a la BBDD
$railsider_model = new railsider_model();

//obtener propietarios
$empresa_transportista_list = $railsider_model-> get_empresa_transportista_por_cif($cif_empresa_transportista);

// Nos aseguramos que hallan resultados
if(count($empresa_transportista_list) > 0){
	foreach ($empresa_transportista_list as $key => $value) {
		$data[] = array(
			'id' => $value['cif_empresa_transportista'],
			'nombre_empresa_transportista' => $value['nombre_empresa_transportista'],
			'direccion_empresa_transportista' => $value['direccion_empresa_transportista'],
			'text' => 'Hay resultados'
		);
	}
} else {
	$data[] = array(
		'id' => '0',
		'text' => 'No hay resultados'
	);
}

//Devolvemos el objeto JSON
echo json_encode($data);

?>
