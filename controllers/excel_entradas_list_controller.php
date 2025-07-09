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
require_once "../functions/excel_entradas_list_functions.php";



//$fecha_inicio = date('Y-m-01');
//$fecha_fin = date('Y-m-t');

if (isset($_GET['year'])) {

    $year = $_GET['year'];

    $railsider_model = new railsider_model();

    //obtenemos listado de datos
    $entradas_list = $railsider_model->get_entradas_por_year($year);
    //echo "<pre>";
    //print_r($entradas_list);
    //echo "</pre>";

    foreach ($entradas_list as $key => $entradas_line) {

        $id_entrada = $entradas_line['id_entrada'];
        //echo "id_entrada: ".$id_entrada."<br/>";
        $tipo_entrada = $entradas_line['tipo_entrada'];
        //echo "tipo_entrada: ".$tipo_entrada."<br/>";

        if ($tipo_entrada == 'CAMIÓN') { //Si es camion

            //obtenemos num_expedicion de la entrada camion
            $num_expedicion_list = $railsider_model->get_num_expedicion_entrada_camion($id_entrada);
            foreach ($num_expedicion_list as $indice => $num_expedicion_line) {
                $num_expedicion = $num_expedicion_line['num_expedicion'];
                $nombre_comercial_propietario = $num_expedicion_line['nombre_comercial_propietario'];
            }
            $entradas_list[$key]['num_expedicion'] = $num_expedicion;
            $entradas_list[$key]['nombre_comercial_propietario'] = $nombre_comercial_propietario;
            //obtenemos contenedores de la entrada camion
            $contenedores_list = $railsider_model->get_contenedores_entrada_camion_por_id_entrada($id_entrada);
            //echo "<pre>";
            //print_r($contenedores_list);
            //echo "</pre>";
            $entradas_list[$key]['contenedores'] = $contenedores_list;
            $entradas_list[$key]['total_contenedores'] = $contenedores_list;
        } else if ($tipo_entrada == 'TREN') { //Si es tren

            //obtenemos num_expedicion de la entrada camion
            $num_expedicion_list = $railsider_model->get_num_expedicion_entrada_tren($id_entrada);
            $nombre_comercial_propietario = '';
            foreach ($num_expedicion_list as $indice => $num_expedicion_line) {
                $num_expedicion = $num_expedicion_line['num_expedicion'];
                if ($indice == 0) {
                    $nombre_comercial_propietario = $num_expedicion_line['nombre_comercial_propietario'];
                } else {
                    $nombre_comercial_propietario = $nombre_comercial_propietario . "<br>" . $num_expedicion_line['nombre_comercial_propietario'];
                }
            }
            $entradas_list[$key]['num_expedicion'] = $num_expedicion;
            $entradas_list[$key]['nombre_comercial_propietario'] = $nombre_comercial_propietario;
            //obtenemos contenedores de la entrada tren
            $contenedores_list = $railsider_model->get_contenedores_entrada_tren_por_id_entrada($id_entrada);
            //echo "<pre>";
            //print_r($contenedores_list);
            //echo "</pre>";
            $entradas_list[$key]['contenedores'] = $contenedores_list;
            $entradas_list[$key]['total_contenedores'] = $contenedores_list;
        } else if ($tipo_entrada == 'TRASPASO') { //Si es traspaso

            //obtenemos num_expedicion de la entrada traspaso
            $num_expedicion_list = $railsider_model->get_num_expedicion_entrada_traspaso($id_entrada);
            foreach ($num_expedicion_list as $indice => $num_expedicion_line) {
                $num_expedicion = $num_expedicion_line['num_expedicion'];
                $nombre_comercial_propietario_anterior = $num_expedicion_line['nombre_comercial_propietario_anterior'];
                $nombre_comercial_propietario_actual = $num_expedicion_line['nombre_comercial_propietario_actual'];
                $nombre_comercial_propietario = $nombre_comercial_propietario_anterior . " -> " . $nombre_comercial_propietario_actual;
            }
            $entradas_list[$key]['num_expedicion'] = $num_expedicion;
            $entradas_list[$key]['nombre_comercial_propietario'] = $nombre_comercial_propietario;
            //obtenemos contenedores de la entrada traspaso
            $contenedores_list = $railsider_model->get_contenedores_entrada_traspaso_por_id_entrada($id_entrada);
            //echo "<pre>";
            //print_r($contenedores_list);
            //echo "</pre>";
            $entradas_list[$key]['contenedores'] = $contenedores_list;
            $entradas_list[$key]['total_contenedores'] = $contenedores_list;
        } /*else if ($tipo_entrada == 'TRANSBORDO') {
      $num_expedicion_list = $railsider_model->get_num_expedicion_entrada_transbordo($id_entrada);
      foreach ($num_expedicion_list as $indice => $num_expedicion_line) {
        $num_expedicion = $num_expedicion_line['num_expedicion'];
        $nombre_comercial_propietario = $num_expedicion_line['nombre_comercial_propietario'];
      }
      $entradas_list[$key]['num_expedicion'] = $num_expedicion;
      $entradas_list[$key]['nombre_comercial_propietario'] = $nombre_comercial_propietario;

      $contenedores_list = $railsider_model->get_contenedores_entrada_transbordo_por_id_entrada($id_entrada);
      //echo "<pre>"; print_r($contenedores_list); echo "</pre>";

      $entradas_list[$key]['contenedores'] = $contenedores_list;
      $entradas_list[$key]['total_contenedores'] = $contenedores_list;
    }*/
    }

    // echo "<pre>";
    // print_r($entradas_list);
    // echo "</pre>";

    ////////////////////////////////////////////////////////////////

    //cargamos la vista
    //require_once('../views/entradas_list_view.php');
    excel_listado_entradas($entradas_list);
} else {
    echo "Establezca año";
}
