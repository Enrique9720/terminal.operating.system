<?php
//////////////////////////////////////////////////////////////////
session_start();

//cargamos el codigo PHP que realiza la conexion a la BD de Wordpress
require_once "../models/conexion_db.php";

//cargamos las funciones PHP comunes para todas las apps
require_once "../functions/functions.php";

//cargamos el modelo con la clase que interactua con la tabla clientes
require_once("../models/railsider_model.php");

//comprobamos que el usuario esta logeado
check_logged_user();

/////////////////////////////////////////////////////////////////////////////////////

require '../vendor/autoload.php';

//cargamos las funciones que generan los excel por propietario
require_once "../functions/excel_stock_propietario_functions.php";


if (isset($_GET["propietario"]) && isset($_GET["fecha_stock"])){

  //instanciamos el modelo de la BBDD
  $railsider_model = new railsider_model();
  //recogemos desde metodo GET
  $nombre_comercial_propietario = $_GET["propietario"];
  $fecha_stock = $_GET["fecha_stock"];

  $propietario_list = array();
  if($nombre_comercial_propietario == 'CCIS-BILBAO_SICSA-VALENCIA'){
    $propietario_list[] = array(
			'cif_propietario' => 'A60389624',
			'nombre_comercial_propietario' => 'CCIS-BILBAO'
		);
    $propietario_list[] = array(
			'cif_propietario' => 'A96764097',
			'nombre_comercial_propietario' => 'SICSA-VALENCIA'
		);
  }else{
    //datos desde BBDD
    $propietario_list = $railsider_model->get_propietario_por_nombre_comercial($nombre_comercial_propietario);
  }
  //echo "<pre>";
  //print_r($propietario_list);
  //echo "</pre>";

  $contendores_stock_list = array();
  foreach ($propietario_list as $key => $propietario_line) {
    $cif_propietario_ = $propietario_line['cif_propietario'];
    $nombre_comercial_propietario_ = $propietario_line['nombre_comercial_propietario'];
    if($fecha_stock == date("Y-m-d")){
      $contendores_stock_list = array_merge($contendores_stock_list, $railsider_model->get_contenedores_stock_por_propietario($cif_propietario_));
    }else{
      $contendores_stock_list = array_merge($contendores_stock_list, $railsider_model->get_control_stock_por_fecha_por_propietario($fecha_stock, $nombre_comercial_propietario_));
    }
  }
  //echo "<pre>";
  //print_r($contendores_stock_list);
  //echo "</pre>";

  //echo $nombre_comercial_propietario;


  if($nombre_comercial_propietario == 'CCIS-BILBAO_SICSA-VALENCIA'){
    excel_stock_ccis_sicsa($contendores_stock_list, $fecha_stock);
  }else if($nombre_comercial_propietario == 'RENFE'){
    excel_stock_renfe($contendores_stock_list, $fecha_stock);
  }else if($nombre_comercial_propietario == 'SICSA-VALENCIA'){
    excel_stock_sicsa($contendores_stock_list, $fecha_stock);
  }else if($nombre_comercial_propietario == 'CCIS-BILBAO'){
    excel_stock_ccis($contendores_stock_list, $fecha_stock);
  }

}else{
    echo "Error. No hay propietario o fecha stock";
}
