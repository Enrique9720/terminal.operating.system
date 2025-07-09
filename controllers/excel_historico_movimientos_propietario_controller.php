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
require_once "../functions/excel_historico_movimientos_propietario_functions.php";


if (isset($_GET["propietario"]) && isset($_GET["fecha_inicio"]) && isset($_GET["fecha_fin"])){

  //instanciamos el modelo de la BBDD
  $railsider_model = new railsider_model();
  //recogemos desde metodo GET
  $nombre_comercial_propietario = $_GET["propietario"];
  //echo $nombre_comercial_propietario;
  $fecha_inicio = date('Y-m-d', strtotime($_GET['fecha_inicio']));
  $fecha_fin = date('Y-m-d', strtotime($_GET['fecha_fin']));

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

  $movimientos_entrada_list = array();
  $movimientos_salida_list = array();

  foreach ($propietario_list as $key => $propietario_line) {

    $cif_propietario = $propietario_line['cif_propietario'];

    $movimientos_entrada_list = array_merge($movimientos_entrada_list, $railsider_model->get_historico_movimientos_entrada_por_fecha_propietario($fecha_inicio, $fecha_fin, $cif_propietario));
    //echo "<pre>";
    //print_r($movimientos_entrada_list);
    //echo "</pre>";

    $movimientos_salida_list = array_merge($movimientos_salida_list, $railsider_model->get_historico_movimientos_salida_por_fecha_propietario($fecha_inicio, $fecha_fin, $cif_propietario));
    //echo "<pre>";
    //print_r($movimientos_salida_list);
    //echo "</pre>";



  }

  //echo "<pre>";
  //print_r($movimientos_entrada_list);
  //echo "</pre>";

  //echo "<pre>";
  //print_r($movimientos_salida_list);
  //echo "</pre>";

  if($nombre_comercial_propietario == 'CCIS-BILBAO_SICSA-VALENCIA'){
    excel_historico_movimientos_ccis_sicsa($movimientos_entrada_list, $movimientos_salida_list, $fecha_inicio, $fecha_fin);
  }else if($nombre_comercial_propietario == 'RENFE'){
    if(isset($_GET["entrada_camion"])){
      excel_historico_movimientos_renfe_entrada_camion($movimientos_entrada_list, $fecha_inicio, $fecha_fin);
    }else if(isset($_GET["salida_camion"])){
      excel_historico_movimientos_renfe_salida_camion($movimientos_salida_list, $fecha_inicio, $fecha_fin);
    }
  }else if($nombre_comercial_propietario == 'SICSA-VALENCIA'){
    //excel_historico_movimientos_sicsa($historico_movimientos);
  }else if($nombre_comercial_propietario == 'CCIS-BILBAO'){
    //excel_historico_movimientos_ccis($historico_movimientos);
  }


}else{
    echo "Error. No hay propietario";
}
