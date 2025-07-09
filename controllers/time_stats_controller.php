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

//obtener mes y año actual
$year_actual = date("Y");
//echo $year_actual."<br>";
$month_actual = date("m");
//echo $month_actual."<br>";

//comprobamos si el valor para este mes y año existe en la tabla time_stats
$time_stat_list = $railsider_model->get_time_stat($year_actual, $month_actual);
//echo "<pre>"; print_r($time_stat_list); echo "</pre>";

//Si no existe, generamos en insertamos los nuevos valores
if(count($time_stat_list) == 0){

  $maximo = rand(15, 20); /*entre 15 y 20 min*/
  $t_max_espera_camion_en_cola = $maximo * 0.75; // 75%
  //echo $t_max_espera_camion_en_cola."<br>";

  $t_max_acceso_camion_ttm = $maximo * 0.25;   // 25%
  //echo $t_max_acceso_camion_ttm."<br>";

  $suma = $t_max_espera_camion_en_cola + $t_max_acceso_camion_ttm;

  $t_medio_camion_tci = $railsider_model->get_time_medio_camion()[0]['t_medio_camion_tci'];
  //echo $t_medio_camion_tci."<br>";

  $t_max_carga_descarga_tren = rand(130, 150); /*entre 120 y 150 min*/
  //echo $t_max_carga_descarga_tren."<br>";

  //Insertar valores en tabla time_stats_line
  $insert_time_stat = $railsider_model->insert_time_stat($year_actual, $month_actual, $t_max_espera_camion_en_cola, $t_max_acceso_camion_ttm, $t_medio_camion_tci, $t_max_carga_descarga_tren);
}

//obtenemos los datos de la tabla time_stats
$time_stats_list = $railsider_model->get_time_stats();
//echo "<pre>"; print_r($time_stats_list); echo "</pre>";

//cargamos la vista
require_once('../views/time_stats_view.php');
?>
