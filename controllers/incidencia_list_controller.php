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
//$fecha_inicio = date('Y-m-01');
//$fecha_fin = date('Y-m-t');

if (isset($_GET['year'])) {

  $year = $_GET['year'];

  $railsider_model = new railsider_model();

  //obtenemos listado de datos
  $incidencia_list = $railsider_model->get_incidencias($year);
  //echo "<pre>";
  //print_r($incidencia_list);
  //echo "</pre>";

  foreach ($incidencia_list as $key => $incidencia_line) {
    $id_incidencia = $incidencia_line['id_incidencia'];
  }

  //echo "<pre>";
  //print_r($incidencia_list);
  //echo "</pre>";

  ////////////////////////////////////////////////////////////////

  //cargamos la vista
  require_once('../views/incidencia_list_view.php');
} else {
  echo "Establezca año";
}
