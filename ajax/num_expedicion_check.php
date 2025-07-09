<?php

session_start();

//cargamos el modelo con la clase que interactua con la tabla
require_once("../models/railsider_model.php");
//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");
//comprobamos que el usuario esta logeado
check_logged_user();

if(isset($_POST['num_expedicion']) && isset($_POST['tipo_cita'])){

	$num_expedicion = strip_tags(trim($_POST['num_expedicion']));
	$tipo_cita = strip_tags(trim($_POST['tipo_cita']));

	//echo $num_expedicion;
	//echo $tipo_cita;

	//instanciamos el modelo para acceso a la BBDD de usuarios
	$railsider_model = new railsider_model();

	if($tipo_cita == 'CARGA'){
		$num_expedicion_list = $railsider_model -> num_expedicion_carga_check($num_expedicion);
		$fecha = $num_expedicion_list[0]['fecha'];
		if(count($num_expedicion_list) > 0){//si existe
			$fecha = $num_expedicion_list[0]['fecha'];
			$estado = 'existe';
			$mensaje = '<span class="label label-danger" >Nº expedición carga planificado '.$fecha.'!</span>';
		}else{//si no esta en stock
			$estado = 'no existe';
			$mensaje = '';
		}
	}else if($tipo_cita == 'DESCARGA'){
		$num_expedicion_list = $railsider_model -> num_expedicion_descarga_check($num_expedicion);
		if(count($num_expedicion_list) > 0){//si existe
			$fecha = $num_expedicion_list[0]['fecha'];
			$estado = 'existe';
			$mensaje = '<span class="label label-danger" >Nº expedición descarga planificado '.$fecha.'!</span>';
		}else{//si no esta en stock
			$estado = 'no existe';
			$mensaje = '';
		}
	}else {
	}

}else{
}

$data[] = array(
	'estado' => $estado,
	'mensaje' => $mensaje
);


//Devolvemos el objeto JSON
echo json_encode($data);

?>
