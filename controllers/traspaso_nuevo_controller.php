<?php
/////////////////////////////////////////////////////////////////////////////////////
session_start();

//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");

//comprobamos que el usuario esta logeado
check_logged_user();

/////////////////////// CARGA DE MODELOS ////////////////////////////////////////////
require_once("../models/railsider_model.php");
/////////////////////////////////////////////////////////////////////////////////////
$railsider_model = new railsider_model();

//obtener propietarios desde BBDD
$propietarios_list = $railsider_model->get_propietarios();
//echo "<pre>";
//print_r($propietarios_list);
//echo "</pre>";

if (isset($_POST['submit'])) { //estamos guardando formulario
  //echo "<pre>";
  //print_r($_POST);
  //echo "</pre>";

  //sacamos datos
  $fecha_form = $_POST['fecha_traspaso'];
  $hora_form = $_POST['hora_traspaso'];
  $fecha_traspaso = $fecha_form . " " . $hora_form;
  $num_contenedor = $_POST['num_cont_1'];
  $cif_propietario_anterior = $_POST['propietario_cont_anterior'];
  $cif_propietario_actual = $_POST['propietario_cont_nuevo'];

  if ($cif_propietario_anterior != $cif_propietario_nuevo) { //insertamos traspaso

    $contenedor_list2 = $railsider_model->get_contenedor($num_contenedor);
    foreach ($contenedor_list2 as $contenedor_line2) {
      $estado_carga_contenedor = $contenedor_line2['estado_carga_contenedor'];
      $id_tipo_mercancia = $contenedor_line2['id_tipo_mercancia_actual_contenedor'];
      $num_peligro_adr = $contenedor_line2['num_peligro_adr_actual_contenedor'];
      $num_onu_adr = $contenedor_line2['num_onu_adr_actual_contenedor'];
      $num_clase_adr = $contenedor_line2['num_clase_adr_actual_contenedor'];
      $cod_grupo_embalaje_adr = $contenedor_line2['cod_grupo_embalaje_adr_actual_contenedor'];
      $peso_mercancia_contenedor = $contenedor_line2['peso_mercancia_actual_contenedor'];
      $peso_bruto_contenedor = $contenedor_line2['peso_bruto_actual_contenedor'];
      $num_booking_contenedor = $contenedor_line2['num_booking_actual_contenedor'];
      $num_precinto_contenedor = $contenedor_line2['num_precinto_actual_contenedor'];
      $temperatura_contenedor = $contenedor_line2['temperatura_actual_contenedor'];
      $codigo_estacion_ferrocarril = $contenedor_lin2['codigo_estacion_ferrocarril_actual_contenedor'];
      $id_destinatario = $contenedor_line2['id_destinatario_actual'];
    }
///// INICIO ALGORITMO TRASPASO /////
    //INSERTAR TABLA TRASPASO
    $id_traspaso = $railsider_model->insert_traspaso(
      $fecha_traspaso,
      $num_contenedor,
      $cif_propietario_anterior,
      $cif_propietario_actual,
      $estado_carga_contenedor,
      $id_tipo_mercancia,
      $num_peligro_adr,
      $num_onu_adr,
      $num_clase_adr,
      $cod_grupo_embalaje_adr,
      $peso_mercancia_contenedor,
      $peso_bruto_contenedor,
      $num_booking_contenedor,
      $num_precinto_contenedor,
      $temperatura_contenedor,
      $codigo_estacion_ferrocarril,
      $id_destinatario
    ); //HECHO

    //INSERT TABLA SALIDA
    $id_tipo_salida = 3; //TRASPASO
    $id_cita_carga = null;
    $user_insert = $_SESSION['email'];

    $id_salida = $railsider_model->insert_salida(
      $fecha_traspaso,
      $id_tipo_salida,
      $id_cita_carga,
      $user_insert
    ); //HECHO

    //INSERT TABLA SALIDA TIPO TRASPASO
    $railsider_model->insert_salida_tipo_traspaso($id_salida, $id_traspaso); //HECHO

    //GET TABLA SALIDA TIPO TRASPASO
    //$salida_tipo_traspaso = $railsider_model->get_salida_tipo_traspaso($id_salida, $id_traspaso);//HECHO
    //echo "<pre>";
    //print_r($salida_tipo_traspaso);
    //echo "</pre>";

    //UPDATE CONTROL STOCK
    $update_control_stock_list = $railsider_model->update_salida_control_stock($num_contenedor, $id_salida); //HECHO

    //GET CONTROL STOCK
    //$get_control_stock_id_salida = $railsider_model->get_control_stock_por_id_salida($id_salida); //HECHO
    //echo "<pre>";
    //print_r($get_control_stock_id_salida);
    //echo "</pre>";

    //UPDATE CONTENEDOR
    $update_contenedor_list = $railsider_model->update_contenedor_traspaso(
      $num_contenedor,
      $cif_propietario_actual
    );

    //INSERT TABLA ENTRADA
    $id_tipo_entrada = 3; //TRASPASO
    $id_cita_descarga = null;
    $user_insert = $_SESSION['email'];

    $id_entrada = $railsider_model->insert_entrada(
      $fecha_traspaso,
      $id_tipo_entrada,
      $id_cita_descarga,
      $user_insert
    ); //HECHO

    //INSERT TABLA ENTRADA TIPO TRASPASO
    $entrada_tipo_traspaso_list = $railsider_model->insert_entrada_tipo_traspaso($id_entrada, $id_traspaso); //REVISAR

    //GET TABLA ENTRADA TIPO TRASPASO
    //$get_entrada_tipo_traspaso = $railsider_model->get_entrada_tipo_traspaso($id_entrada); //REVISAR

    //INSERT CONTROL STOCK
    $insert_control_stock_list = $railsider_model->insert_control_stock($num_contenedor, $id_entrada); //HECHO

    ///// FIN ALGORITMO TRASPASO /////

    //Cargamos la vista
    header('Location: ../controllers/traspaso_controller.php?id_traspaso=' . $id_traspaso);

  } else {
    echo "Estas haciendo un traspaso de propietario. No selecciones el mismo propietario";
  }
} else {
  require_once('../views/traspaso_nuevo_view.php');
}
