<?php
//////////////////////////////////////////////////////////////////
session_start();

//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");

//comprobamos que el usuario esta logeado
check_logged_user();

/////////////////////////////////////////////////////////////////////////////////////

///////////////////////*CARGA DE MODELOS*////////////////////////////////////////////
require_once("../models/railsider_model.php");
/////////////////////////////////////////////////////////////////////////////////////

if (isset($_POST['submit'])) { //estamos guardando formulario
  $fecha_stock = date('Y-m-d', strtotime($_POST['fecha_stock']));
}else {
  $fecha_stock = date("Y-m-d"); //fecha del dia actual
}

$railsider_model = new railsider_model();

if($fecha_stock == date("Y-m-d")){
  $contenedores_stock_list = $railsider_model->get_contenedores_stock();
}else{
  $contenedores_stock_list = $railsider_model->get_control_stock_por_fecha($fecha_stock);
}


//echo "<pre>";
//print_r($contenedores_stock_list);
//echo "</pre>";

////////////////////////////////////////////////////////////////

//cargamos la vista
require_once('../views/stock_contenedores_view.php');
