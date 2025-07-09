<?php

//////////////////////////////////////////////////////////////////
session_start();

/////////////////////// CARGA DE MODELOS ////////////////////////////////////////////
require_once("../models/railsider_model.php");
/////////////////////////////////////////////////////////////////////////////////////

$num_contenedor = strip_tags(trim($_POST['num_contenedor']));

$railsider_model = new railsider_model();

if ($num_contenedor != '') {
  $result = $railsider_model->get_entradas_by_num_contenedor($id_producto);
} else {
  $result = $railsider_model->get_entradas_validadas();
}

$response_array['status'] = 'success';
$response_array['value'] = $result;

echo json_encode($response_array);
