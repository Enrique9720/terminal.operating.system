<?php

session_start();

//cargamos el modelo con la clase que interactua con la tabla clientes
require_once("../models/railsider_model.php");
//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");
//comprobamos que el usuario esta logeado
check_logged_user();

$num_contenedor = strip_tags(trim($_POST['num_contenedor']));

//instanciamos el modelo para acceso a la BBDD
$railsider_model = new railsider_model();

//obtener propietarios
$contenedor_list = $railsider_model-> existe_contenedor($num_contenedor);

// Nos aseguramos que hallan resultados
if(count($contenedor_list) > 0){
	foreach ($contenedor_list as $key => $value) {

		//sacar fecha ultima entrada y ultima salida
		$control_stock_list = $railsider_model-> get_ultima_entrada_salida_control_stock_por_num_contenedor($num_contenedor);
		foreach ($control_stock_list as $key => $value2) {
			$fecha_entrada_ultima = $value2['fecha_entrada'];
			$fecha_salida_ultima = $value2['fecha_salida'];

			$id_salida = $value2['id_salida'];
			$tipo_salida = $value2['tipo_salida'];

			//TIPO SALIDA CAMION
			if($tipo_salida == 'CAMIÓN'){
				$salida_camion_ultima_list = $railsider_model->get_salida_camion_por_id_salida($id_salida);
				$id_destinatario = $salida_camion_ultima_list[0]['id_destinatario'];
				$nombre_destinatario = $salida_camion_ultima_list[0]['nombre_destinatario'];
			}
			//TIPO ENTRADA CAMION
			if($tipo_entrada == 'CAMIÓN'){
				$entrada_camion_ultima_list = $railsider_model->get_entrada_camion_por_id_entrada($id_entrada);
				$id_destinatario = $entrada_camion_ultima_list[0]['id_destinatario'];
				$nombre_destinatario = $entrada_camion_ultima_list[0]['nombre_destinatario'];
			}

			if($tipo_salida == 'TREN'){
				$id_destinatario = '';
				$nombre_destinatario = '';
			}



		}

		$data[] = array(
			'id' => $value['num_contenedor'],
			'id_tipo_contenedor_iso' => $value['id_tipo_contenedor_iso'],
			'longitud_tipo_contenedor' => $value['longitud_tipo_contenedor'],
			'descripcion_tipo_contenedor' => $value['descripcion_tipo_contenedor'],
			'tara_contenedor' => $value['tara_contenedor'],
			'id_destinatario' => $id_destinatario,
			'nombre_destinatario' => $nombre_destinatario,
			'id_entrada_ultimo' => $value['id_entrada_ultimo'],
			'tipo_entrada_ultimo' => $value['tipo_entrada_ultimo'],
			'cif_propietario_actual' => $value['cif_propietario_actual'],
			'nombre_comercial_propietario_actual' => $value['nombre_comercial_propietario_actual'],
			'fecha_entrada_ultima' => $fecha_entrada_ultima,
			'fecha_salida_ultima' => $fecha_salida_ultima,
			'text' => 'Hay resultados'
		);
	}
} else {
	$data[] = array(
		'id' => '0',
		'fecha_entrada_ultima' => '',
		'fecha_salida_ultima' => '',
		'text' => 'No hay resultados'
	);
}

//Devolvemos el objeto JSON
echo json_encode($data);

?>
