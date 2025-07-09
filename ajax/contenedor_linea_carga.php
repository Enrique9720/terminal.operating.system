<?php

session_start();

//cargamos el modelo con la clase que interactua con la tabla
require_once("../models/railsider_model.php");
//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");
//comprobamos que el usuario esta logeado
check_logged_user();

if(
	isset($_POST['num_contenedor']) &&
	isset($_POST['cif_propietario'])
){

	$num_contenedor = strip_tags(trim($_POST['num_contenedor']));
	$cif_propietario = strip_tags(trim($_POST['cif_propietario']));
	//echo $num_contenedor;
	//echo $cif_propietario;

	//Inicializamos checks
	$mensaje_error = "";
	$contenedor_numero_correcto_check = "";
	$contenedor_existe_check = "";
	$contenedor_propietario_check = "";
	$contenedor_reservado_check = "";
	$contenedor_stock_check = "";

	//instanciamos el modelo para acceso a la BBDD de usuarios
	$railsider_model = new railsider_model();
	$list_stock_contenedor = $railsider_model->contenedor_en_stock($num_contenedor);
	$list_existe_contenedor = $railsider_model->existe_contenedor($num_contenedor);
	$list_reservado_contenedor = $railsider_model->contenedor_reservado_cita_carga($num_contenedor);

	if(preg_match("/^[a-zA-Z]{3}U\d{7}$/", $num_contenedor)){//si cumple patron
		$contenedor_numero_correcto_check = "SI";
		if(count($list_existe_contenedor) > 0){//si existe
			$contenedor_existe_check = "SI";
			$cif_propietario_actual = $list_existe_contenedor[0]['cif_propietario_actual'];
			$nombre_comercial_propietario_actual = $list_existe_contenedor[0]['nombre_comercial_propietario_actual'];
			//echo $cif_propietario_actual;
			if($cif_propietario_actual == $cif_propietario){
				$contenedor_propietario_check = "SI";
			}else{
				$contenedor_propietario_check = "NO";
				$mensaje_error = $mensaje_error."Propietario es ".$nombre_comercial_propietario_actual.". ";
			}
			if(count($list_reservado_contenedor) > 0){//si ya esta reservado en otra cita
				$contenedor_reservado_check = "SI";
				$num_expedicion_cita_reservada = $list_reservado_contenedor[0]['num_expedicion'];
				$mensaje_error = $mensaje_error."Reservado en salida ".$num_expedicion_cita_reservada.". ";
			}else{//si no esta reservado
				$contenedor_reservado_check = "NO";
			}
			if(count($list_stock_contenedor) > 0){//si esta en stock
				$contenedor_stock_check = "SI";
			}else{//si no esta en stock
				$ultima_salida_contenedor = $railsider_model->ultima_salida_contenedor($num_contenedor);
				foreach ($ultima_salida_contenedor as $key => $value) {
					$fecha_salida = $value['fecha_salida'];
					$tipo_salida = $value['tipo_salida'];
				}
				$contenedor_stock_check = "NO";
				$mensaje_error = $mensaje_error."No stock. Salida ".$fecha_salida." en ".$tipo_salida;
			}
		}else{//si no existe
			$contenedor_existe_check = "NO";
			$mensaje_error = $mensaje_error." No existe.";
		}
	}else{//si no cumple patron
		$contenedor_numero_correcto_check = "NO";
		$mensaje_error = "Número Incorrecto";
	}

	$data[] = array(
		'num_contenedor' => $num_contenedor,
		'contenedor_numero_correcto_check' => $contenedor_numero_correcto_check,
		'contenedor_duplicado_check' => "NO",
		'contenedor_existe_check' => $contenedor_existe_check,
		'contenedor_propietario_check' => $contenedor_propietario_check,
		'contenedor_reservado_check' => $contenedor_reservado_check,
		'contenedor_stock_check' => $contenedor_stock_check,
		'mensaje_error' => $mensaje_error
	);

	//Devolvemos el objeto JSON
	echo json_encode($data);

}

?>
