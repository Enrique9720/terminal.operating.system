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

//cargamos las funciones que generan los excel por cliente
require_once "../functions/excel_detalle_facturacion_cliente_functions.php";

//cargamos las funciones que generan los excel por cliente
//require_once "../controllers/detalle_facturacion_controller.php";

if (isset($_GET["cliente"]) && isset($_GET["fecha_inicio"]) && isset($_GET["fecha_fin"]) && isset($_GET["tipo_facturacion"])) {
  //if (isset($_GET['year'])) {
    //$year = intval($_GET['year']);
    //instanciamos el modelo de la BBDD
    $railsider_model = new railsider_model();

    //recogemos desde metodo GET
    $nombre_comercial_cliente = $_GET["cliente"];
    $fecha_inicio = $_GET["fecha_inicio"];
    $fecha_fin = $_GET["fecha_fin"];
    $tipo_facturacion = $_GET["tipo_facturacion"];
    $year = date("Y", strtotime($fecha_inicio));

    $tarifas = $railsider_model->get_tarifas_by_year($year, $nombre_comercial_cliente);

    foreach ($tarifas as $tarifa) {
      // Accedemos a cada atributo por su clave
      $id_tarifa = $tarifa['id_tarifa'];
      $year = $tarifa['year'];
      $cif_cliente = $tarifa['cif_cliente'];
      $tarifa_manipulacion_uti = $tarifa['tarifa_manipulacion_uti'];
      $tarifa_manipulacion_uti_traspaso = $tarifa['tarifa_manipulacion_uti_traspaso'];
      $tarifa_almacenaje_20 = $tarifa['tarifa_almacenaje_20'];
      $unidades_libres_20 = $tarifa['unidades_libres_20'];
      $tarifa_almacenaje_40 = $tarifa['tarifa_almacenaje_40'];
      $unidades_libres_40 = $tarifa['unidades_libres_40'];
      $tarifa_almacenaje_45 = $tarifa['tarifa_almacenaje_45'];
      $unidades_libres_45 = $tarifa['unidades_libres_45'];
      $tarifa_temperatura = $tarifa['tarifa_temperatura'];
      $tarifa_conexion = $tarifa['tarifa_conexion'];
      $tarifa_limpieza = $tarifa['tarifa_limpieza'];
      $tarifa_hora_extraordinaria = $tarifa['tarifa_hora_extraordinaria'];
      $tarifa_reducida = $tarifa['tarifa_reducida'];
      $tarifa_maxima = $tarifa['tarifa_maxima'];
      $tarifa_adicional = $tarifa['tarifa_adicional'];
      $tarifa_exceso_7_dias = $tarifa['tarifa_exceso_7_dias'];
      $tarifa_maniobra_terminal = $tarifa['tarifa_maniobra_terminal'];
      $tarifa_maniobra_cambio_generadores = $tarifa['tarifa_maniobra_cambio_generadores'];
      $id_cliente = $tarifa['id_cliente'];
      $nombre_cliente = $tarifa['nombre_cliente'];
      $nombre_comercial_cliente = $tarifa['nombre_comercial_cliente'];
      $direccion_cliente = $tarifa['direccion_cliente'];
      $persona_contacto = $tarifa['persona_contacto'];
      $email_contacto = $tarifa['email_contacto'];
    }
    //echo "<pre>";
    //print_r($tarifas);
    //echo "</pre>";

    if ($nombre_comercial_cliente == 'CCIS-BILBAO') {
      if ($tipo_facturacion == 'manipulacion_uti') {
        //$tarifa_manipulacion_uti = 32;
        //$tarifa_manipulacion_uti_traspaso = 16;
        $total_importe_manipulacion_utis = 0;
        $manipulacion_uti_list = $railsider_model->manipulacion_uti_por_fecha_por_cliente($fecha_inicio, $fecha_fin, $nombre_comercial_cliente);
        $total_importe_manipulacion_utis = 0;
        foreach ($manipulacion_uti_list as $key => $manipulacion_uti_line) {
          if (($manipulacion_uti_line['tipo_entrada'] == 'TRASPASO') || ($manipulacion_uti_line['tipo_salida'] == 'TRASPASO')) {
            $importe_manipulacion_uti = $tarifa_manipulacion_uti_traspaso;
          } else {
            $importe_manipulacion_uti = $tarifa_manipulacion_uti;
          }
          $manipulacion_uti_list[$key]['importe_manipulacion_utis'] = $importe_manipulacion_uti;
          $total_importe_manipulacion_utis += $importe_manipulacion_uti;
        }
        $manipulacion_uti_list[$key]['total_importe_manipulacion_utis'] = $total_importe_manipulacion_utis;
        //echo "<pre>";
        //print_r($manipulacion_uti_list);
        //echo "</pre>";
        excel_detalle_facturacion_manipulacion_uti_ccis_bilbao($manipulacion_uti_list, $fecha_inicio, $fecha_fin, $tarifas);
      } else if ($tipo_facturacion == 'almacenaje') {
        //Tarifas que vendran desde BBDD
        //$tarifa_almacenaje_20 = 0.5;
        //$unidades_libres_20 = 80;
        //$tarifa_almacenaje_40 = 1;
        //$unidades_libres_40 = 40;
        //$tarifa_almacenaje_45 = 1;
        //$unidades_libres_45 = 30;

        $total_importe_almacenaje_20 = 0;
        $total_importe_almacenaje_40 = 0;
        $total_importe_almacenaje_45 = 0;
        $total_importe_almacenaje = 0;

        $almacenaje_list_20 = array();
        $almacenaje_list_40 = array();
        $almacenaje_list_45 = array();

        $fechas_mes = getRangeDate($fecha_inicio, $fecha_fin, 'Y-m-d');

        foreach ($fechas_mes as $key => $fecha_dia) {
          //Sacamos los datos de contenedores de entrada en ese dia
          $num_contenedores_entrada_list = $railsider_model->get_contenedores_total_entrada_por_fecha_por_propietario($fecha_dia, $nombre_comercial_cliente);
          //echo "<pre>";
          //print_r($num_contenedores_entrada_list);
          //echo "</pre>";
          //Sacamos los datos de contenedores de salida en ese dia
          $num_contenedores_salida_list = $railsider_model->get_contenedores_total_salida_por_fecha_por_propietario($fecha_dia, $nombre_comercial_cliente);
          //echo "<pre>";
          //print_r($num_contenedores_salida_list);
          //echo "</pre>";
          $almacenaje_agrupado_list = $railsider_model->get_control_stock_por_fecha_por_propietario_agrupado($fecha_dia, $nombre_comercial_cliente);
          //echo "<pre>";
          //print_r($almacenaje_agrupado_list);
          //echo "</pre>";

          //ALMACENAJE 20'
          $num_contenedores_entrada_20 = $num_contenedores_entrada_list[0]['num_contenedores_entrada_20'];
          $num_contenedores_salida_20 = $num_contenedores_salida_list[0]['num_contenedores_salida_20'];;
          $num_contenedores_20_total = $almacenaje_agrupado_list[0]['num_contenedores_20_total'];
          if ($num_contenedores_20_total > $unidades_libres_20) {
            $num_contenedores_20_cobrar = $num_contenedores_20_total - $unidades_libres_20;
          } else {
            $num_contenedores_20_cobrar = 0;
          }
          $importe_almacenaje_20 = $num_contenedores_20_cobrar * $tarifa_almacenaje_20;
          $almacenaje_list_20[] = array(
            'fecha_dia' => $fecha_dia,
            'num_contenedores_entrada_20' => $num_contenedores_entrada_20,
            'num_contenedores_salida_20' => $num_contenedores_salida_20,
            'num_contenedores_20_total' => $num_contenedores_20_total,
            'num_contenedores_20_cobrar' => $num_contenedores_20_cobrar,
            'importe_almacenaje_20' => $importe_almacenaje_20
          );

          //ALMACENAJE 40'
          $num_contenedores_entrada_40 = $num_contenedores_entrada_list[0]['num_contenedores_entrada_40'];
          $num_contenedores_salida_40 = $num_contenedores_salida_list[0]['num_contenedores_salida_40'];;
          $num_contenedores_40_total = $almacenaje_agrupado_list[0]['num_contenedores_40_total'];
          if ($num_contenedores_40_total > $unidades_libres_40) {
            $num_contenedores_40_cobrar = $num_contenedores_40_total - $unidades_libres_40;
          } else {
            $num_contenedores_40_cobrar = 0;
          }
          $importe_almacenaje_40 = $num_contenedores_40_cobrar * $tarifa_almacenaje_40;
          $almacenaje_list_40[] = array(
            'fecha_dia' => $fecha_dia,
            'num_contenedores_entrada_40' => $num_contenedores_entrada_40,
            'num_contenedores_salida_40' => $num_contenedores_salida_40,
            'num_contenedores_40_total' => $num_contenedores_40_total,
            'num_contenedores_40_cobrar' => $num_contenedores_40_cobrar,
            'importe_almacenaje_40' => $importe_almacenaje_40
          );

          //ALMACENAJE 45'
          $num_contenedores_entrada_45 = $num_contenedores_entrada_list[0]['num_contenedores_entrada_45'];
          $num_contenedores_salida_45 = $num_contenedores_salida_list[0]['num_contenedores_salida_45'];;
          $num_contenedores_45_total = $almacenaje_agrupado_list[0]['num_contenedores_45_total'];
          if ($num_contenedores_45_total > $unidades_libres_45) {
            $num_contenedores_45_cobrar = $num_contenedores_45_total - $unidades_libres_45;
          } else {
            $num_contenedores_45_cobrar = 0;
          }
          $importe_almacenaje_45 = $num_contenedores_45_cobrar * $tarifa_almacenaje_45;
          $almacenaje_list_45[] = array(
            'fecha_dia' => $fecha_dia,
            'num_contenedores_entrada_45' => $num_contenedores_entrada_45,
            'num_contenedores_salida_45' => $num_contenedores_salida_45,
            'num_contenedores_45_total' => $num_contenedores_45_total,
            'num_contenedores_45_cobrar' => $num_contenedores_45_cobrar,
            'importe_almacenaje_45' => $importe_almacenaje_45
          );

          $total_importe_almacenaje_20 += $importe_almacenaje_20;
          $total_importe_almacenaje_40 += $importe_almacenaje_40;
          $total_importe_almacenaje_45 += $importe_almacenaje_45;
          $total_importe_almacenaje += $importe_almacenaje_20 += $importe_almacenaje_40 += $importe_almacenaje_45;
        }
        $almacenaje_agrupado_list[$key]['total_importe_almacenaje_20'] = $total_importe_almacenaje_20;
        $almacenaje_agrupado_list[$key]['total_importe_almacenaje_40'] = $total_importe_almacenaje_40;
        $almacenaje_agrupado_list[$key]['total_importe_almacenaje_45'] = $total_importe_almacenaje_45;
        $almacenaje_agrupado_list[$key]['total_importe_almacenaje'] = $total_importe_almacenaje;

        excel_detalle_facturacion_almacenaje_ccis_bilbao($almacenaje_list_20, $almacenaje_list_40, $almacenaje_list_45, $almacenaje_agrupado_list, $fecha_inicio, $fecha_fin, $tarifas);
      } else if ($tipo_facturacion == 'conexionado_temperatura_limpieza') {
        //$tarifa_temperatura = 20;
        //$tarifa_conexion = 30;
        //$tarifa_limpieza = 20;

        $total_importe_control_temperatura = 0;
        $total_importe_conexion = 0;
        $total_importe_limpieza = 0;

        $conexionado_control_temperatura_list = $railsider_model->conexionado_control_temperatura_limpieza_cliente($fecha_inicio, $fecha_fin, $nombre_comercial_cliente);

        foreach ($conexionado_control_temperatura_list as $key => $conexionado_control_temperatura_line) {
          $importe_temperatura = $tarifa_temperatura;
          $importe_conexion = $tarifa_conexion;

          if (($conexionado_control_temperatura_line['limpieza_bool'] != '')) {
            $importe_limpieza = $tarifa_limpieza;
          } else {
            $importe_limpieza = 0;
          }

          $conexionado_control_temperatura_list[$key]['importe_control_temperatura'] = $importe_temperatura;
          $conexionado_control_temperatura_list[$key]['importe_conexion'] = $importe_conexion;
          $conexionado_control_temperatura_list[$key]['importe_limpieza'] = $importe_limpieza;

          $total_importe_control_temperatura += $importe_temperatura;
          $total_importe_conexion += $importe_conexion;
          $total_importe_limpieza += $importe_limpieza;
          $total = $total_importe_control_temperatura + $total_importe_conexion + $total_importe_limpieza;
        }
        $conexionado_control_temperatura_list[$key]['total_importe_control_temperatura'] = $total_importe_control_temperatura;
        $conexionado_control_temperatura_list[$key]['total_importe_conexion'] = $total_importe_conexion;
        $conexionado_control_temperatura_list[$key]['total_importe_limpieza'] = $total_importe_limpieza;
        $conexionado_control_temperatura_list[$key]['total'] = $total;

        //echo "<pre>";
        //print_r($conexionado_control_temperatura_list);
        //echo "</pre>";

        excel_detalle_facturacion_temperatura_conexionado_limpieza_ccis_bilbao($conexionado_control_temperatura_list, $fecha_inicio, $fecha_fin, $tarifas);
      } else if ($tipo_facturacion == 'horas_extras') {
        //excel_detalle_facturacion_horas_extras_ccis_bilbao($horas_extras, $fecha_inicio, $fecha_fin);
      }
    } else if ($nombre_comercial_cliente == 'SICSA-VALENCIA') {
      if ($tipo_facturacion == 'manipulacion_uti') {
        //$tarifa_manipulacion_uti = 32;
        //$tarifa_manipulacion_uti_traspaso = 16;
        $total_importe_manipulacion_utis = 0;
        $manipulacion_uti_list = $railsider_model->manipulacion_uti_por_fecha_por_cliente($fecha_inicio, $fecha_fin, $nombre_comercial_cliente);
        $total_importe_manipulacion_utis = 0;
        foreach ($manipulacion_uti_list as $key => $manipulacion_uti_line) {
          if (($manipulacion_uti_line['tipo_entrada'] == 'TRASPASO') || ($manipulacion_uti_line['tipo_salida'] == 'TRASPASO')) {
            $importe_manipulacion_uti = $tarifa_manipulacion_uti_traspaso;
          } else {
            $importe_manipulacion_uti = $tarifa_manipulacion_uti;
          }
          $manipulacion_uti_list[$key]['importe_manipulacion_utis'] = $importe_manipulacion_uti;
          $total_importe_manipulacion_utis += $importe_manipulacion_uti;
        }
        $manipulacion_uti_list[$key]['total_importe_manipulacion_utis'] = $total_importe_manipulacion_utis;
        //echo "<pre>";
        //print_r($manipulacion_uti_list);
        //echo "</pre>";
        excel_detalle_facturacion_manipulacion_uti_sicsa_valencia($manipulacion_uti_list, $fecha_inicio, $fecha_fin, $tarifas);
      } else if ($tipo_facturacion == 'almacenaje') {
        //Tarifas que vendran desde BBDD
        //$tarifa_almacenaje_20 = 0.5;
        //$unidades_libres_20 = 80;
        //$tarifa_almacenaje_40 = 1;
        //$unidades_libres_40 = 40;
        //$tarifa_almacenaje_45 = 1;
        //$unidades_libres_45 = 30;

        $total_importe_almacenaje_20 = 0;
        $total_importe_almacenaje_40 = 0;
        $total_importe_almacenaje_45 = 0;
        $total_importe_almacenaje = 0;

        $almacenaje_list_20 = array();
        $almacenaje_list_40 = array();
        $almacenaje_list_45 = array();

        $fechas_mes = getRangeDate($fecha_inicio, $fecha_fin, 'Y-m-d');

        foreach ($fechas_mes as $key => $fecha_dia) {
          //Sacamos los datos de contenedores de entrada en ese dia
          $num_contenedores_entrada_list = $railsider_model->get_contenedores_total_entrada_por_fecha_por_propietario($fecha_dia, $nombre_comercial_cliente);
          //Sacamos los datos de contenedores de salida en ese dia
          $num_contenedores_salida_list = $railsider_model->get_contenedores_total_salida_por_fecha_por_propietario($fecha_dia, $nombre_comercial_cliente);
          $almacenaje_agrupado_list = $railsider_model->get_control_stock_por_fecha_por_propietario_agrupado($fecha_dia, $nombre_comercial_cliente);

          //ALMACENAJE 20'
          $num_contenedores_entrada_20 = $num_contenedores_entrada_list[0]['num_contenedores_entrada_20'];
          $num_contenedores_salida_20 = $num_contenedores_salida_list[0]['num_contenedores_salida_20'];;
          $num_contenedores_20_total = $almacenaje_agrupado_list[0]['num_contenedores_20_total'];
          if ($num_contenedores_20_total > $unidades_libres_20) {
            $num_contenedores_20_cobrar = $num_contenedores_20_total - $unidades_libres_20;
          } else {
            $num_contenedores_20_cobrar = 0;
          }
          $importe_almacenaje_20 = $num_contenedores_20_cobrar * $tarifa_almacenaje_20;
          $almacenaje_list_20[] = array(
            'fecha_dia' => $fecha_dia,
            'num_contenedores_entrada_20' => $num_contenedores_entrada_20,
            'num_contenedores_salida_20' => $num_contenedores_salida_20,
            'num_contenedores_20_total' => $num_contenedores_20_total,
            'num_contenedores_20_cobrar' => $num_contenedores_20_cobrar,
            'importe_almacenaje_20' => $importe_almacenaje_20
          );

          //ALMACENAJE 40'
          $num_contenedores_entrada_40 = $num_contenedores_entrada_list[0]['num_contenedores_entrada_40'];
          $num_contenedores_salida_40 = $num_contenedores_salida_list[0]['num_contenedores_salida_40'];;
          $num_contenedores_40_total = $almacenaje_agrupado_list[0]['num_contenedores_40_total'];
          if ($num_contenedores_40_total > $unidades_libres_40) {
            $num_contenedores_40_cobrar = $num_contenedores_40_total - $unidades_libres_40;
          } else {
            $num_contenedores_40_cobrar = 0;
          }
          $importe_almacenaje_40 = $num_contenedores_40_cobrar * $tarifa_almacenaje_40;
          $almacenaje_list_40[] = array(
            'fecha_dia' => $fecha_dia,
            'num_contenedores_entrada_40' => $num_contenedores_entrada_40,
            'num_contenedores_salida_40' => $num_contenedores_salida_40,
            'num_contenedores_40_total' => $num_contenedores_40_total,
            'num_contenedores_40_cobrar' => $num_contenedores_40_cobrar,
            'importe_almacenaje_40' => $importe_almacenaje_40
          );

          //ALMACENAJE 45'
          $num_contenedores_entrada_45 = $num_contenedores_entrada_list[0]['num_contenedores_entrada_45'];
          $num_contenedores_salida_45 = $num_contenedores_salida_list[0]['num_contenedores_salida_45'];;
          $num_contenedores_45_total = $almacenaje_agrupado_list[0]['num_contenedores_45_total'];
          if ($num_contenedores_45_total > $unidades_libres_45) {
            $num_contenedores_45_cobrar = $num_contenedores_45_total - $unidades_libres_45;
          } else {
            $num_contenedores_45_cobrar = 0;
          }
          $importe_almacenaje_45 = $num_contenedores_45_cobrar * $tarifa_almacenaje_45;
          $almacenaje_list_45[] = array(
            'fecha_dia' => $fecha_dia,
            'num_contenedores_entrada_45' => $num_contenedores_entrada_45,
            'num_contenedores_salida_45' => $num_contenedores_salida_45,
            'num_contenedores_45_total' => $num_contenedores_45_total,
            'num_contenedores_45_cobrar' => $num_contenedores_45_cobrar,
            'importe_almacenaje_45' => $importe_almacenaje_45
          );

          $total_importe_almacenaje_20 += $importe_almacenaje_20;
          $total_importe_almacenaje_40 += $importe_almacenaje_40;
          $total_importe_almacenaje_45 += $importe_almacenaje_45;
          $total_importe_almacenaje += $importe_almacenaje_20 += $importe_almacenaje_40 += $importe_almacenaje_45;
        }
        $almacenaje_agrupado_list[$key]['total_importe_almacenaje_20'] = $total_importe_almacenaje_20;
        $almacenaje_agrupado_list[$key]['total_importe_almacenaje_40'] = $total_importe_almacenaje_40;
        $almacenaje_agrupado_list[$key]['total_importe_almacenaje_45'] = $total_importe_almacenaje_45;
        $almacenaje_agrupado_list[$key]['total_importe_almacenaje'] = $total_importe_almacenaje;
        excel_detalle_facturacion_almacenaje_sicsa_valencia($almacenaje_list_20, $almacenaje_list_40, $almacenaje_list_45, $almacenaje_agrupado_list, $fecha_inicio, $fecha_fin, $tarifas);
      } else if ($tipo_facturacion == 'horas_extras') {
        //excel_detalle_facturacion_horas_extras_sicsa_valencia($horas_extras, $fecha_inicio, $fecha_fin);
      }
    } else if ($nombre_comercial_cliente == 'RENFE') {
      if ($tipo_facturacion == 'manipulacion_uti_renfe') {
        //$tarifa_reducida = 40;
        //$tarifa_maxima = 48;
        //$tarifa_adicional = 32;
        //$tarifa_exceso_7_dias = 9.50;

        $total_importe_reducida = 0;
        $total_importe_maxima = 0;
        $total_importe_adicional = 0;
        $total_importe_exceso_7_dias = 0;

        $manipulacion_uti_list = $railsider_model->manipulacion_uti_por_fecha_por_cliente_renfe($fecha_inicio, $fecha_fin, $nombre_comercial_cliente);
        //echo "<pre>";
        //print_r($manipulacion_uti_list);
        //echo "</pre>";

        $fecha_inicio_dt = new DateTime($fecha_inicio);
        $fecha_fin_dt = new DateTime($fecha_fin);


        foreach ($manipulacion_uti_list as $key => $manipulacion_uti_line) {
          //Inicializamos los importes
          $importe_reducida = 0;
          $importe_maxima = 0;
          $importe_adicional = 0;
          $importe_exceso_7_dias = 0;


          $fecha_entrada = $manipulacion_uti_line['fecha_entrada'];
          $fecha_salida = $manipulacion_uti_line['fecha_salida'];
          //calculamos fecha inicio facturacion
          $fecha_inicio_facturacion = $fecha_entrada;
          $manipulacion_uti_list[$key]['fecha_inicio_facturacion'] = $fecha_inicio_facturacion;
          //calculamos fecha fin facturacion
          if ($fecha_salida != '') {
            $fecha_fin_facturacion = $fecha_salida;
          } else {
            $fecha_fin_facturacion = $fecha_fin;
          }
          $manipulacion_uti_list[$key]['fecha_fin_facturacion'] = $fecha_fin_facturacion;

          ///// PROCESO DE CALCULAR TOTAL DIAS /////
          // Convertir las fechas a objetos DateTime
          $fecha_inicio_facturacion_dt = new DateTime($fecha_inicio_facturacion);
          $fecha_fin_facturacion_dt = new DateTime($fecha_fin_facturacion);
          // Calcular la diferencia en días
          $interval = $fecha_fin_facturacion_dt->diff($fecha_inicio_facturacion_dt);
          $dias_estancia_total = $interval->days + 1;
          $manipulacion_uti_list[$key]['total_dias'] = $dias_estancia_total;

          //Caso de movimiento que entra en el mes de facturacion
          if (($fecha_entrada >= $fecha_inicio) && ($fecha_entrada <= $fecha_fin)) {
            // CALCULOS DE TARIFAS
            //intervalo dias
            if ($dias_estancia_total >= 0 && $dias_estancia_total <= 2) { // (>=0 && <=2)
              $importe_reducida = $tarifa_reducida;
            } else if ($dias_estancia_total > 2) { // (>2 )
              $importe_maxima = $tarifa_maxima;
            }
            //importe adicional
            if ($dias_estancia_total > 7) { // (>7)
              $importe_adicional = $tarifa_adicional;
              $importe_exceso_7_dias = ($dias_estancia_total - 7) * $tarifa_exceso_7_dias;
            }
          } else if ($fecha_entrada < $fecha_inicio) { //Caso de movimiento que entra antes del mes de facturacion

            $dias_estancia_total_mes = $fecha_fin_facturacion_dt->diff($fecha_inicio_dt)->days + 1;
            $dias_estancia_total_meses_anteriores = $fecha_inicio_facturacion_dt->diff($fecha_inicio_dt)->days;

            //intervalo dias
            if ($dias_estancia_total_meses_anteriores >= 0 && $dias_estancia_total_meses_anteriores <= 2) { // (>=0 && <=2)
              $importe_reducida = 0;
              if ($dias_estancia_total > 2) {
                $importe_maxima = $tarifa_maxima - $tarifa_reducida;
              } else {
                $importe_maxima = 0;
              }
            }

            //importe adicional
            if ($dias_estancia_total > 7) { // (>7)

              if ($dias_estancia_total_meses_anteriores <= 7) {
                $importe_adicional = $tarifa_adicional;
                $importe_exceso_7_dias = ($dias_estancia_total_mes + $dias_estancia_total_meses_anteriores - 7) * $tarifa_exceso_7_dias;
              } else {
                $importe_adicional = 0;
                $importe_exceso_7_dias = ($dias_estancia_total_mes) * $tarifa_exceso_7_dias;
              }
            } else {
              $importe_exceso_7_dias = 0;
            }
          }

          $manipulacion_uti_list[$key]['importe_reducida'] = $importe_reducida;
          $manipulacion_uti_list[$key]['importe_maxima'] = $importe_maxima;
          $manipulacion_uti_list[$key]['importe_adicional'] = $importe_adicional;
          $manipulacion_uti_list[$key]['importe_exceso_7_dias'] = $importe_exceso_7_dias;

          $total_importe_reducida += $importe_reducida;
          $total_importe_maxima += $importe_maxima;
          $total_importe_adicional += $importe_adicional;
          $total_importe_exceso_7_dias += $importe_exceso_7_dias;
          $total = $total_importe_reducida + $total_importe_maxima + $total_importe_adicional + $total_importe_exceso_7_dias;
        }
        $manipulacion_uti_list[$key]['total_importe_reducida'] = $total_importe_reducida;
        $manipulacion_uti_list[$key]['total_importe_maxima'] = $total_importe_maxima;
        $manipulacion_uti_list[$key]['total_importe_adicional'] = $total_importe_adicional;
        $manipulacion_uti_list[$key]['total_importe_exceso_7_dias'] = $total_importe_exceso_7_dias;
        $manipulacion_uti_list[$key]['total'] = $total;
        //echo "<pre>";
        //print_r($manipulacion_uti_list);
        //echo "</pre>";

        excel_detalle_facturacion_manipulacion_uti_renfe($manipulacion_uti_list, $fecha_inicio, $fecha_fin, $tarifas);
      }
    } else if ($nombre_comercial_cliente == 'CONTINENTAL-RAIL') {
      if ($tipo_facturacion == 'maniobra_terminal') {
        //$maniobra_continental_list = $railsider_model->maniobras_continental_rail($fecha_inicio, $fecha_fin);
        //excel_detalle_facturacion_maniobras_terminal_continental_rail($maniobra_continental_list, $fecha_inicio, $fecha_fin);
      }
    } else if ($nombre_comercial_cliente == 'GMF-RAILWAY') {
      if ($tipo_facturacion == 'maniobra_generadores') {
        //$maniobra_gmf_railway_list = $railsider_model->maniobras_gmf_railway($fecha_inicio, $fecha_fin);
        //excel_detalle_facturacion_maniobras_generadores_gmf_railway($maniobra_gmf_railway_list, $fecha_inicio, $fecha_fin);
      }
    } else {
      echo "Error.";
    }
  /*} else {
    echo "Error. Indique año";
  }*/
} else {
  echo "Error. Indique cliente, fecha inicio, fecha fin y/o tipo de facturacion";
}
