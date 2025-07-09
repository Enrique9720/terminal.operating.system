<?php
//////////////////////////////////////////////////////////////////
session_start();

//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");

//comprobamos que el usuario esta logeado
check_logged_user();

/////////////////////// CARGA DE MODELOS ////////////////////////////////////////////
require_once("../models/railsider_model.php");
/////////////////////////////////////////////////////////////////////////////////////

if (isset($_GET['id_traspaso'])) {
    //echo "<pre>";
    //print_r($_GET);
    //echo "</pre>";

    $id_traspaso = $_GET['id_traspaso'];
    $railsider_model = new railsider_model();

    //TRASPASOS
    $traspasos_list = $railsider_model->get_traspasos($id_traspaso);
    //echo "<pre>";
    //print_r($traspasos_list);
    //echo "</pre>";

    foreach ($traspasos_get_list as $traspasos_get_line) {
        $fecha_traspaso = $traspasos_get_line['fecha_traspaso'];
        $num_contenedor = $traspasos_get_line['num_contenedor'];
        $cif_propietario_anterior = $traspasos_get_line['cif_propietario_anterior'];
        $cif_propietario_actual = $traspasos_get_line['cif_propietario_actual'];
        $nombre_comercial_propietario_anterior = $traspasos_get_line['nombre_comercial_propietario_anterior'];
        $nombre_comercial_propietario_actual = $traspasos_get_line['nombre_comercial_propietario_actual'];
        $estado_carga_contenedor = $traspasos_get_line['estado_carga_contenedor'];
        $id_tipo_mercancia = $traspasos_get_line['id_tipo_mercancia_actual_contenedor'];
        $num_peligro_adr = $traspasos_get_line['num_peligro_adr_actual_contenedor'];
        $num_onu_adr = $traspasos_get_line['num_onu_adr_actual_contenedor'];
        $num_clase_adr = $traspasos_get_line['num_clase_adr_actual_contenedor'];
        $cod_grupo_embalaje_adr = $traspasos_get_line['cod_grupo_embalaje_adr_actual_contenedor'];
        $peso_mercancia_contenedor = $traspasos_get_line['peso_mercancia_actual_contenedor'];
        $peso_bruto_contenedor = $traspasos_get_line['peso_bruto_actual_contenedor'];
        $num_booking_contenedor = $traspasos_get_line['num_booking_actual_contenedor'];
        $num_precinto_contenedor = $traspasos_get_line['num_precinto_actual_contenedor'];
        $temperatura_contenedor = $traspasos_get_line['temperatura_contenedor'];
        $codigo_estacion_ferrocarril = $traspasos_get_line['codigo_estacion_ferrocarril_actual_contenedor'];
        $id_destinatario = $traspasos_get_line['id_destinatario_actual'];
    }

/*
    if (count($traspasos_list) > 0) {

        foreach ($traspasos_get_list as $key => $value){
            $nombre_comercial_propietario_anterior = "";
            $nombre_comercial_propietario_actual = "";

            $nombre_comercial_propietario = $value['nombre_comercial_propietario'];

            switch($traspaso_list) {
                case 1:
                    $nombre_comercial_propietario_anterior = $tipo_entrada[0]['nombre_comercial_propietario'];
                    $nombre_comercial_propietario_actual = $tipo_entrada[0]['nombre_comercial_propietario'];
                    break;
                case 2:
                    $nombre_comercial_propietario_anterior = $tipo_entrada[0]['nombre_comercial_propietario'];
                    $nombre_comercial_propietario_actual = $tipo_entrada[0]['nombre_comercial_propietario'];
                    break;
            }

            $traspaso_list[] = array(
                'nombre_comercial_propietario' => $nombre_comercial_propietario,
                'nombre_comercial_propietario_anterior' => $nombre_comercial_propietario_anterior,
                'nombre_comercial_propietario_actual' => $nombre_comercial_propietario_actual
            );

            /*if ($tipo_entrada == 'TRASPASO'){
                $nombre_comercial_propietario_anterior = $tipo_entrada[0]['nombre_comercial_propietario'];
                $nombre_comercial_propietario_actual = $tipo_entrada[0]['nombre_comercial_propietario'];
            }

            if ($tipo_salida == 'TRASPASO'){
                $nombre_comercial_propietario_anterior = $tipo_entrada[0]['nombre_comercial_propietario'];
                $nombre_comercial_propietario_actual = $tipo_entrada[0]['nombre_comercial_propietario'];
            }

            $traspaso_list[] = array(
                'nombre_comercial_propietario' => $nombre_comercial_propietario,
                'nombre_comercial_propietario_anterior' => $nombre_comercial_propietario_anterior,
                'nombre_comercial_propietario_actual' => $nombre_comercial_propietario_actual
            );*/
        //}
    //}
    //echo "<pre>";
    //print_r($traspasos_list);
    //echo "</pre>";    

    //Cargamos la vista
    require_once('../views/traspaso_view.php');

} else {
    echo "No hay ID traspaso";
}
