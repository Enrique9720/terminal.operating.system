<?php
//////////////////////////////////////////////////////////////////
session_start();

//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");

//comprobamos que el usuario esta logeado
check_logged_user();

/////////////////////////////////////////////////////////////////////////////////////

//echo "<pre>";
//print_r($_SESSION);
//echo "</pre>";

///////////////////////*CARGA DE MODELOS*////////////////////////////////////////////
require_once("../models/railsider_model.php");
/////////////////////////////////////////////////////////////////////////////////////
//$fecha_inicio = date('Y-m-01');
//$fecha_fin = date('Y-m-t');

if(isset($_GET['year'])){

  $year = $_GET['year'];

  $railsider_model = new railsider_model();

  //obtenemos listado de datos
  $partes_trabajo_list = $railsider_model->get_partes_trabajo($year);

  foreach ($partes_trabajo_list as $key => $partes_trabajo_line) {
    $id_parte_trabajo = $partes_trabajo_line['id_parte_trabajo'];
    //obtenemos contenedores de la salida camion
    $lineas_parte = $railsider_model->get_parte_trabajo_lineas($id_parte_trabajo);
    //echo "<pre>";
    //print_r($lineas_parte);
    //echo "</pre>";
    $partes_trabajo_list[$key]['lineas_parte'] = $lineas_parte;
  }

  //echo "<pre>";
  //print_r($partes_trabajo_list);
  //echo "</pre>";

  ////////////////////////////////////////////////////////////////

  //cargamos la vista
  require_once('../views/partes_trabajo_list_view.php');

}else{
  echo "Establezca año";
}
