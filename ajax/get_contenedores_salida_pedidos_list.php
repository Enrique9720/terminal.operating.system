<?php

//////////////////////////////////////////////////////////////////
session_start();

//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");

//comprobamos que el usuario esta logeado
check_logged_user();

/////////////////////// CARGA DE MODELOS ////////////////////////////////////////////
require_once("../models/railsider_model.php");
/////////////////////////////////////////////////////////////////////////////////////


$search = strip_tags(trim($_GET['q']));
$id_cita_carga = strip_tags(trim($_GET['id_cita_carga']));
//echo $id_cita_carga;

$railsider_model = new railsider_model();
$list = $railsider_model->get_contenedores_salida_tren_pedidos_ajax($id_cita_carga, $search);

//añadimos la opcion de NO-CON (No contenedor) para las posiciones sin contenedor
if (preg_match("/{$search}/i", 'NO-CON')) {
  $data[] = array(
    'id' => 'NO-CON',
    'text' => 'NO-CON'
  );
}

// Nos aseguramos que hallan resultados
if (count($list) > 0) {
  foreach ($list as $key => $value) {
    $data[] = array(
      'id' => $value['num_contenedor'],
      'text' => $value['num_contenedor']
    );
  }
} else {
  $data[] = array(
    'id' => '0',
    'text' => 'No hay resultados'
  );
}

echo json_encode($data);
