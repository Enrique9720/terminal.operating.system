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

if(isset($_GET['propietario'])){

  if (isset($_POST['submit'])) { //estamos guardando formulario
    $fecha_stock = date('Y-m-d', strtotime($_POST['fecha_stock']));
  }else {
    $fecha_stock = date("Y-m-d"); //fecha del dia actual
  }

  $railsider_model = new railsider_model();

  $nombre_comercial_propietario = $_GET['propietario'];
  $propietario_list = $railsider_model->get_propietario_por_nombre_comercial($nombre_comercial_propietario);
  $cif_propietario = $propietario_list[0]['cif_propietario'];

  if($fecha_stock == date("Y-m-d")){
    $contenedores_stock_list = $railsider_model->get_contenedores_stock_por_propietario($cif_propietario);
  }else{
    $contenedores_stock_list = $railsider_model->get_control_stock_por_fecha_por_propietario(
      $fecha_stock,
      $nombre_comercial_propietario
    );
  }

  //echo "<pre>";
  //print_r($contenedores_stock_list);
  //echo "</pre>";

  ////////////////////////////////////////////////////////////////

  //cargamos la vista
  require_once('../views/stock_contenedores_propietario_view.php');


}else{
  echo "Establezca propietario";
}
