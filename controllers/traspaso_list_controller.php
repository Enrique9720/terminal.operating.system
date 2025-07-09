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

if(isset($_GET['year'])){
    $year = $_GET['year'];

    $railsider_model = new railsider_model();
    //obtenemos listado de datos
    $traspasos_list = $railsider_model->get_traspasos_por_year($year);
    //echo "<pre>";
    //print_r($traspasos_list);
    //echo "</pre>";

    ////////////////////////////////////////////////////////////////

    //cargamos la vista
    require_once('../views/traspaso_list_view.php');

  }else{
    echo "Establezca año";
  }
