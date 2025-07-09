<?php

session_start();

//cargamos el modelo con la clase que interactua con la tabla
require_once("../models/railsider_model.php");
//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");
//comprobamos que el usuario esta logeado
check_logged_user();

if(isset($_POST['id_destinatario'])){

	$id_destinatario = strip_tags(trim($_POST['id_destinatario']));
	//echo $id_destinatario;

	//instanciamos el modelo para acceso a la BBDD de usuarios
	$railsider_model = new railsider_model();

	$num_tarjeta_teco_list = $railsider_model->get_num_teco($id_destinatario);

	//si hay datos
	if(count($num_tarjeta_teco_list) > 0){
		foreach ($num_tarjeta_teco_list as $key => $value) {
			$id_empresa_destino_origen = $value['id_empresa_destino_origen'];
			$nombre_empresa_destino_origen = $value['nombre_empresa_destino_origen'];
			$num_tarjeta_teco = $value['num_tarjeta_teco'];
			//echo $num_tarjeta_teco;
		}

		$data = array(
          	'id' => $id_empresa_destino_origen,
            'nombre_empresa_destino_origen' => $nombre_empresa_destino_origen,
            'num_tarjeta_teco' => $num_tarjeta_teco,
            'text' => 'Hay resultados'
        );

	} else {
		$data[] = array(
			'id' => $id_empresa_destino_origen,
			'text' => 'No hay resultados'
		);
	}

	//Devolvemos el objeto JSON
	echo json_encode($data);

}

?>
