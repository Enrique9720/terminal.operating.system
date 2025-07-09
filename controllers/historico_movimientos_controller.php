<?php
//////////////////////////////////////////////////////////////////
session_start();

//cargamos el codigo PHP que realiza la conexion a la BD
require_once("../models/conexion_db.php");

//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");

//comprobamos que el usuario esta logeado
check_logged_user();
/////////////////////////////////////////////////////////////////////////////////////

///////////////////////*CARGA DE MODELOS*////////////////////////////////////////////
require_once("../models/railsider_model.php");
/////////////////////////////////////////////////////////////////////////////////////

if (isset($_POST['submit'])) { //estamos guardando formulario
  $fecha_inicio = date('Y-m-d', strtotime($_POST['fecha_inicio']));
  $fecha_fin = date('Y-m-d', strtotime($_POST['fecha_fin']));
}else { 
  $fecha_fin = date("Y-m-d");
  $fecha_inicio = date('Y-m-d', strtotime($fecha_fin. ' - 7 days'));
}

$railsider_model = new railsider_model();

$movimientos_entrada_list = $railsider_model->get_historico_movimientos_entrada_por_fecha($fecha_inicio, $fecha_fin);
//echo "<pre>";
//print_r($movimientos_entrada_list);
//echo "</pre>";

$movimientos_salida_list = $railsider_model->get_historico_movimientos_salida_por_fecha($fecha_inicio, $fecha_fin);
//echo "<pre>";
//print_r($movimientos_salida_list);
//echo "</pre>";

$movimientos_list = array_merge($movimientos_entrada_list, $movimientos_salida_list);
//echo "<pre>";
//print_r($movimientos_list);
//echo "</pre>";

//cargamos la vista
require_once('../views/historico_movimientos_view.php');
