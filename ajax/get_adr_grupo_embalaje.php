<?php

session_start();

//cargamos el modelo con la clase que interactua con la tabla
require_once("../models/railsider_model.php");
//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");
//comprobamos que el usuario esta logeado
check_logged_user();

if (isset($_POST['cod_grupo_embalaje_adr'])) {

	$cod_grupo_embalaje_adr = strip_tags(trim($_POST['cod_grupo_embalaje_adr']));
	//echo $num_onu_adr;

	//instanciamos el modelo para acceso a la BBDD de usuarios
	$railsider_model = new railsider_model();

	$adr_grupo_embalaje_list = $railsider_model->get_adr_grupo_embalaje_por_codigo($cod_grupo_embalaje_adr);

	//si hay datos
	if (count($adr_grupo_embalaje_list) > 0) {
		foreach ($adr_grupo_embalaje_list as $key => $value) {
			$cod_grupo_embalaje_adr = $value['cod_grupo_embalaje_adr'];
		}

		$data = array(
			'id' => $cod_grupo_embalaje_adr,
			'text' => 'Hay resultados'
		);
	} else {
		$data[] = array('id' => $cod_grupo_embalaje_adr, 'text' => 'No hay resultados');
	}

	//Devolvemos el objeto JSON
	echo json_encode($data);
}
