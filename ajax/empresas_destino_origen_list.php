<?php

session_start();

//cargamos el modelo con la clase que interactua con la tabla clientes
require_once("../models/railsider_model.php");
//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");
//comprobamos que el usuario esta logeado
check_logged_user();

$search = strip_tags(trim($_GET['q']));
//declaramos objeto del modelo proveedores
$railsider_model = new railsider_model();
//Comprobamos si existe previamente el CIF de dicho proveedor
$list = $railsider_model -> get_empresas_destino_origen($search);

// Nos aseguramos que hallan resultados
if(count($list) > 0){
	foreach ($list as $key => $value) {
		$data[] = array(
			'id' => $value['id_empresa_destino_origen'],
			'text' => $value['nombre_empresa_destino_origen']
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
