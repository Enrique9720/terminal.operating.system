<?php
//////////////////////////////////////////////////////////////////
session_start();
require_once "../models/conexion_db.php";
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
require '../vendor/autoload.php';

//cargamos las funciones que generan los excel por propietario
require_once "../functions/excel_salidas_list_functions.php";


//$fecha_inicio = date('Y-m-01');
//$fecha_fin = date('Y-m-t');

if (isset($_GET['year'])) {

    $year = $_GET['year'];

    $railsider_model = new railsider_model();

    //obtenemos listado de datos
    $salidas_list = $railsider_model->get_salidas_por_year($year);

    foreach ($salidas_list as $key => $salidas_line) {

        $id_salida = $salidas_line['id_salida'];
        //echo "id_salida: ".$id_salida."<br/>";
        $tipo_salida = $salidas_line['tipo_salida'];
        //echo "tipo_salida: ".$tipo_salida."<br/>";

        if ($tipo_salida == 'CAMIÓN') { //Si es camion

            //obtenemos num_expedicion de la salida camion
            $num_expedicion_list = $railsider_model->get_num_expedicion_salida_camion($id_salida);
            foreach ($num_expedicion_list as $indice => $num_expedicion_line) {
                $num_expedicion = $num_expedicion_line['num_expedicion'];
                $nombre_comercial_propietario = $num_expedicion_line['nombre_comercial_propietario'];
            }
            $salidas_list[$key]['num_expedicion'] = $num_expedicion;
            $salidas_list[$key]['nombre_comercial_propietario'] = $nombre_comercial_propietario;
            //obtenemos contenedores de la salida camion
            $contenedores_list = $railsider_model->get_contenedores_salida_camion_por_id_salida($id_salida);
            //echo "<pre>";
            //print_r($contenedores_list);
            //echo "</pre>";
            $salidas_list[$key]['contenedores'] = $contenedores_list;
            $salidas_list[$key]['total_contenedores'] = $contenedores_list;
        } else if ($tipo_salida == 'TREN') { //Si es tren

            //obtenemos num_expedicion de la salida camion
            $num_expedicion_list = $railsider_model->get_num_expedicion_salida_tren($id_salida);

            $nombre_comercial_propietario = '';
            foreach ($num_expedicion_list as $indice => $num_expedicion_line) {
                $num_expedicion = $num_expedicion_line['num_expedicion'];
                if ($indice == 0) {
                    $nombre_comercial_propietario = $num_expedicion_line['nombre_comercial_propietario'];
                } else {
                    $nombre_comercial_propietario = $nombre_comercial_propietario . "<br>" . $num_expedicion_line['nombre_comercial_propietario'];
                }
            }
            $salidas_list[$key]['num_expedicion'] = $num_expedicion;
            $salidas_list[$key]['nombre_comercial_propietario'] = $nombre_comercial_propietario;
            //obtenemos contenedores de la salida tren
            $contenedores_list = $railsider_model->get_contenedores_salida_tren_por_id_salida($id_salida);
            //echo "<pre>";
            //print_r($contenedores_list);
            //echo "</pre>";
            $salidas_list[$key]['contenedores'] = $contenedores_list;
            $salidas_list[$key]['total_contenedores'] = $contenedores_list;
        } else if ($tipo_salida == 'TRASPASO') { //Si es traspaso

            //obtenemos num_expedicion de la salida traspaso
            $num_expedicion_list = $railsider_model->get_num_expedicion_salida_traspaso($id_salida);
            foreach ($num_expedicion_list as $indice => $num_expedicion_line) {
                $num_expedicion = $num_expedicion_line['num_expedicion'];
                $nombre_comercial_propietario_anterior = $num_expedicion_line['nombre_comercial_propietario_anterior'];
                $nombre_comercial_propietario_actual = $num_expedicion_line['nombre_comercial_propietario_actual'];
                $nombre_comercial_propietario = $nombre_comercial_propietario_anterior . " -> " . $nombre_comercial_propietario_actual;
            }
            $salidas_list[$key]['num_expedicion'] = $num_expedicion;
            $salidas_list[$key]['nombre_comercial_propietario'] = $nombre_comercial_propietario;
            //obtenemos contenedores de la salida traspaso
            $contenedores_list = $railsider_model->get_contenedores_salida_traspaso_por_id_salida($id_salida);
            //echo "<pre>";
            //print_r($contenedores_list);
            //echo "</pre>";
            $salidas_list[$key]['contenedores'] = $contenedores_list;
            $salidas_list[$key]['total_contenedores'] = $contenedores_list;
        } /*else if ($tipo_salida == 'TRANSBORDO') {
        $num_expedicion_list = $railsider_model->get_num_expedicion_salida_transbordo($id_salida);
        foreach ($num_expedicion_list as $indice => $num_expedicion_line) {
          $num_expedicion = $num_expedicion_line['num_expedicion'];
          $nombre_comercial_propietario = $num_expedicion_line['nombre_comercial_propietario'];
        }
        $salidas_list[$key]['num_expedicion'] = $num_expedicion;
        $salidas_list[$key]['nombre_comercial_propietario'] = $nombre_comercial_propietario;
  
        $contenedores_list = $railsider_model->get_contenedores_salida_transbordo_por_id_salida($id_salida);
        //echo "<pre>"; print_r($contenedores_list); echo "</pre>";
  
        $salidas_list[$key]['contenedores'] = $contenedores_list;
        $salidas_list[$key]['total_contenedores'] = $contenedores_list;
      }*/
    }

    //echo "<pre>";
    //print_r($salidas_list);
    //echo "</pre>";

    ////////////////////////////////////////////////////////////////

    //cargamos la vista
    //require_once('../views/salidas_list_view.php');
    excel_listado_salidas($salidas_list);
} else {
    echo "Establezca año";
}
