<?php

session_start();

//cargamos el modelo con la clase que interactua con la tabla clientes
require_once("../models/velilla_model.php");
//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");
//comprobamos que el usuario esta logeado
check_logged_user();

//declaramos objeto del modelo proveedores 
$railsider_model = new railsider_model();
//Comprobamos si existe previamente el CIF de dicho proveedor
$entradas_list = $velilla_model->get_entradas_validadas();
//print_r($entradas_list);

if (count($entradas_list) > 0) {

	$data = $entradas_list;
} else {
	$data = array(
		'id_entrada' => 'No hay'
        //'num_packing' => 'No hay'
	);
}
//Devolvemos el objeto JSON
echo json_encode($data);
