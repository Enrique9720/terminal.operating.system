<?php
//////////////////////////////////////////////////////////////////
session_start();

//cargamos el codigo PHP que realiza la conexion a la BD
require_once("../models/conexion_db.php");

//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");

//comprobamos que el usuario esta logeado
check_logged_user();

/////////////////////////////////////////////////////////////////////////////////////


///////////////////////*CARGA DE MODELOS*////////////////////////////////////////////
require_once("../models/railsider_model.php");
/////////////////////////////////////////////////////////////////////////////////////

if (isset($_GET['year']) && isset($_GET['cliente'])) {

  $railsider_model = new railsider_model();

  $year = $_GET['year'];
  $nombre_comercial_cliente = $_GET['cliente'];
  //echo $nombre_comercial_cliente;

  $cliente_datos = $railsider_model->get_id_cliente_por_nombre($nombre_comercial_cliente);
  $id_cliente = $cliente_datos[0]['id_cliente'];
  //echo $id_cliente;

  $year_actual = date("Y");
  $month_actual = date("m");

  $periodo_actual = date_create($year_actual . "-" . $month_actual);
  $facturacion_array = array();
  $facturacion_anual = array();

  $facturacion_anual_list = $railsider_model->get_facturacion_by_year_by_cliente($year, $id_cliente);

  //echo "<pre>";
  //print_r($facturacion_anual_list);
  //echo "<pre>";

  for ($month = 1; $month <= 12; $month++) {

    if ($month_actual >= $month) {
      //echo "hola<br>";
      $botones = '<a target="_blank" href="../controllers/detalle_facturacion_controller.php?year=' . $year . '&amp;month=' . $month . '&amp;cliente=' . $nombre_comercial_cliente . '" type="button" class="btn btn-sm btn-default" title="Ver"><span class="glyphicon glyphicon-eye-open"></span></a>';
    } else {
      $botones = '';
    }

    if (count($facturacion_anual_list) > 0) {

      foreach ($facturacion_anual_list as $facturacion_anual_line) {
        //echo "<pre>";
        //print_r($facturacion_anual_line);
        //echo "<pre>";

        if ($facturacion_anual_line['month'] == $month) {
          $filename = '../facturas/detalle_facturacion_MS_TERMINAL_nonduermas_' . $year . '_' . get_month_name($month) . '.pdf';
          if (file_exists($filename)) {
            $botones = $botones . '<a target="_blank" href="' . $filename . '" type="button" class="btn btn-sm btn-default" title="Ver"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</a>';
          }

          $facturacion_anual[$month] = array(
            'year' => $facturacion_anual_line['year'],
            'month_name' => get_month_name($facturacion_anual_line['month']),
            'importe_manipulacion_utis' => number_format($facturacion_anual_line['importe_manipulacion_utis'], 2) . " €",
            'importe_almacenaje' => number_format($facturacion_anual_line['importe_almacenaje'], 2) . " €",
            'importe_conexionado_electrico' => number_format($facturacion_anual_line['importe_conexionado_electrico'], 2) . " €",
            'importe_control_temperatura' => number_format($facturacion_anual_line['importe_control_temperatura'], 2) . " €",
            'importe_limpieza' => number_format($facturacion_anual_line['importe_limpieza'], 2) . " €",
            'importe_horas_extras' => number_format($facturacion_anual_line['importe_horas_extras'], 2) . " €",
            'importe_maniobra_terminal' => number_format($facturacion_anual_line['importe_maniobra_terminal'], 2) . " €",
            'importe_maniobra_generadores' => number_format($facturacion_anual_line['importe_maniobra_generadores'], 2) . " €",
            'importe_servicios_especiales' => number_format($facturacion_anual_line['importe_servicios_especiales'], 2) . " €",
            'importe_total' => number_format($facturacion_anual_line['importe_total'], 2) . " €",
            'botones' => $botones
          );
        } else if (!isset($facturacion_anual[$month])) {
          $facturacion_anual[$month] = array(
            'year' => $year,
            'month_name' => get_month_name($month),
            'importe_manipulacion_utis' => '-',
            'importe_almacenaje' => '-',
            'importe_conexionado_electrico' => '-',
            'importe_control_temperatura' => '-',
            'importe_limpieza' => '-',
            'importe_horas_extras' => '-',
            'importe_maniobra_terminal' => '-',
            'importe_maniobra_generadores' => '-',
            'importe_servicios_especiales' => '-',
            'importe_total' => '-',
            'botones' => $botones
          );
        }
      }
    } else {
      $facturacion_anual[$month] = array(
        'year' => $year,
        'month_name' => get_month_name($month),
        'importe_manipulacion_utis' => '-',
        'importe_almacenaje' => '-',
        'importe_conexionado_electrico' => '-',
        'importe_control_temperatura' => '-',
        'importe_limpieza' => '-',
        'importe_horas_extras' => '-',
        'importe_maniobra_terminal' => '-',
        'importe_maniobra_generadores' => '-',
        'importe_servicios_especiales' => '-',
        'importe_total' => '-',
        'botones' => $botones
      );
    }
  }

  //echo "<pre>";
  //print_r($facturacion_anual);
  //echo "<pre>";

  //cargamos la vista
  require_once('../views/facturacion_view.php');
} else {
  echo "ERROR:  Indique Año y Cliente";
}
