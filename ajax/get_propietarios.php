<?php

//////////////////////////////////////////////////////////////////
session_start();

/////////////////////// CARGA DE MODELOS ////////////////////////////////////////////
require_once("../models/railsider_model.php");
/////////////////////////////////////////////////////////////////////////////////////

$railsider_model = new railsider_model();

$result = $railsider_model->get_propietarios();

$response_array['status'] = 'success';  
$response_array['value'] = $result;

echo json_encode($response_array);

?>
