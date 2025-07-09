<?php

session_start();

//cargamos el modelo con la clase que interactua con la tabla clientes
require_once("../models/railsider_model.php");
//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");
//comprobamos que el usuario esta logeado
check_logged_user();
/////////////////////// CARGA DE MODELOS ////////////////////////////////////////////
require_once("../models/railsider_model.php");
/////////////////////////////////////////////////////////////////////////////////////

if (isset($_POST['id_cliente'])) {

  $id_cliente = strip_tags(trim($_POST['id_cliente']));

  //declaramos objeto del modelo
  $railsider_model = new railsider_model();

  $importe_manipulacion_utis = strip_tags(trim($_POST['importe_manipulacion_utis']));
  $importe_almacenaje = strip_tags(trim($_POST['importe_almacenaje']));
  $importe_conexionado_electrico = strip_tags(trim($_POST['importe_conexionado_electrico']));
  $importe_control_temperatura = strip_tags(trim($_POST['importe_control_temperatura']));
  $importe_limpieza = strip_tags(trim($_POST['importe_limpieza']));
  $importe_horas_extras = strip_tags(trim($_POST['importe_horas_extras']));
  $importe_maniobra_terminal = strip_tags(trim($_POST['importe_maniobra_terminal']));
  $importe_maniobra_generadores = strip_tags(trim($_POST['importe_maniobra_generadores']));
  $importe_servicios_especiales = strip_tags(trim($_POST['importe_servicios_especiales']));
  $year = strip_tags(trim($_POST['year']));
  $month = strip_tags(trim($_POST['month']));

  $facturacion_list = $railsider_model->get_facturacion_by_year_by_month_by_cliente($year, $month, $id_cliente);
  //echo "<pre>";
  //print_r($facturacion_list);
  //echo "<pre>";

  if (count($facturacion_list) > 0) {
    $railsider_model->update_facturacion_mensual(
      $year,
      $month,
      $importe_manipulacion_utis,
      $importe_almacenaje,
      $importe_conexionado_electrico,
      $importe_control_temperatura,
      $importe_limpieza,
      $importe_horas_extras,
      $importe_maniobra_terminal,
      $importe_maniobra_generadores,
      $importe_servicios_especiales,
      $id_cliente
    );
  } else {
    $railsider_model->insert_facturacion_mensual(
      $year,
      $month,
      $importe_manipulacion_utis,
      $importe_almacenaje,
      $importe_conexionado_electrico,
      $importe_control_temperatura,
      $importe_limpieza,
      $importe_horas_extras,
      $importe_maniobra_terminal,
      $importe_maniobra_generadores,
      $importe_servicios_especiales,
      $id_cliente
    );
  }

  echo json_encode(array("success" => true, "message" => "Datos insertados en BBDD"));
} else {
  echo "Especifique cliente";
  echo json_encode(array("success" => false, "message" => "Error. Datos NO insertados en BBDD"));
}

//Devolvemos el objeto JSON
//echo json_encode($data);
