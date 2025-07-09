<?php

session_start();

//cargamos el modelo con la clase que interactua con la tabla
require_once("../models/railsider_model.php");
//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");
//comprobamos que el usuario esta logeado
check_logged_user();

if(isset($_POST['num_clase_adr'])){

	$num_clase_adr = strip_tags(trim($_POST['num_clase_adr']));
	//echo $num_onu_adr;

	//instanciamos el modelo para acceso a la BBDD de usuarios
	$railsider_model = new railsider_model();

	$adr_clase_list = $railsider_model->get_adr_clase_por_codigo($num_clase_adr);

	//si hay datos
	if(count($adr_clase_list) > 0){
		foreach ($adr_clase_list as $key => $value) {
			$num_clase_adr = $value['num_clase_adr'];
		}

		$data = array(
          	'id' => $num_clase_adr,
            'text' => 'Hay resultados'
        );

	} else {
		$data[] = array('id' => $num_clase_adr, 'text' => 'No hay resultados');
	}

	//Devolvemos el objeto JSON
	echo json_encode($data);

}

?>
