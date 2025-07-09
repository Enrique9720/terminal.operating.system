<?php
/////////////////////////////////////////////////////////////////////////////////////
session_start();

//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");

//comprobamos que el usuario esta logeado
check_logged_user();

/////////////////////////////////////////////////////////////////////////////////////
///////////////////////*CARGA DE MODELOS*////////////////////////////////////////////
require_once("../models/railsider_model.php");

//Instaciamos el objeto para el modelo
$railsider_model = new railsider_model();

//Obtenemos el numero de contenedores total por entradas y por fechas
//$num_contenedores_entrada = $railsider_model->get_contenedores_total_entrada($year, $month);
$num_contenedores_entrada = $railsider_model->get_contenedores_total_entrada2();

//Obtenemos el numero de contenedores total por salidas y por fechas
//$num_contenedores_salida = $railsider_model->get_contenedores_total_salida($year, $month);
$num_contenedores_salida = $railsider_model->get_contenedores_total_salida2();

//Obtenemos el numero total de contenedores de todas las entradas
$num_total_contenedores_entrada = $railsider_model->get_num_contenedores_total_entrada();
foreach ($num_total_contenedores_entrada as $value) {
  $datos_donut_chart_entrada[] = array(
    'label' => 'Nº Cont. Tren',
    'value' => $value['contenedor_tren'],
  );
  $datos_donut_chart_entrada[] = array(
    'label' => 'Nº Cont. Camion',
    'value' => $value['contenedor_camion'],
  );
}

//Obtenemos el numero total de contenedores de todas las salidas
$num_total_contenedores_salida = $railsider_model->get_num_contenedores_total_salida();
foreach ($num_total_contenedores_salida as $value) {
  $datos_donut_chart_salida[] = array(
    'label' => 'Nº Cont. Tren',
    'value' => $value['contenedor_tren'],
  );
  $datos_donut_chart_salida[] = array(
    'label' => 'Nº Cont. Camion',
    'value' => $value['contenedor_camion'],
  );
}

//cargamos la vista
require_once('../views/general_stats_view.php');
?>
