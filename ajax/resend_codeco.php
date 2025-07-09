<?php

session_start();
///////////////////////*CARGA DE MODELOS*////////////////////////////////////////////
require_once("../models/railsider_model.php");
/////////////////////////////////////////////////////////////////////////////////////
//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");
//cargamos las funciones de CODECO
require_once("../functions/codeco_functions.php");
//comprobamos que el usuario esta logeado
check_logged_user();
////////////////////////////////////////////////////////////////

$id_codeco = strtoupper(strip_tags(trim($_POST['id_codeco'])));
//echo $id_codeco;

//instanciamos el modelo para acceso a la BBDD de usuarios
$railsider_model = new railsider_model();

$check_envio = reenvio_codeco($id_codeco);

if ($check_envio == 1) {
	$data[] = array('id_codeco' => $id_codeco, 'text' => 'success');
}else if($check_envio == 0){
	$data[] = array('id_codeco' => $id_codeco, 'text' => 'error');
}

//Devolvemos el objeto JSON
echo json_encode($data);
