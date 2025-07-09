<?php

session_start();

//cargamos el modelo con la clase que interactua con la tabla clientes
require_once("../models/railsider_model.php");
//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");
//comprobamos que el usuario esta logeado
check_logged_user();

$id_fichero = strip_tags(trim($_POST['id_fichero']));
//echo $id_cita_descarga."<br>";

//declaramos objeto del modelo proveedores
$railsider_model = new railsider_model();

$fichero_list = $railsider_model -> get_fichero($id_fichero);
$ruta_fichero = $fichero_list[0]['ruta_fichero'];

$railsider_model -> delete_entrada_fichero($id_fichero);
$railsider_model -> delete_salida_fichero($id_fichero);
$railsider_model -> delete_parte_trabajo_fichero($id_fichero);

$railsider_model -> delete_fichero($id_fichero);
unlink($ruta_fichero);

$fichero_list = $railsider_model -> get_fichero($id_fichero);

if(count($fichero_list) == 0){

  $data = array(
		'text' => 'Fichero Borrado'
	);

}else{
  $data = array(
		'text' => 'Error al borrar fichero'
	);
}
//Devolvemos el objeto JSON
echo json_encode($data);

?>
