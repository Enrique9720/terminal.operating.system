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

if (isset($_GET['id_transbordo'])) {
    //echo "<pre>";
    //print_r($_GET);
    //echo "</pre>";

    $id_transbordo = $_GET['id_transbordo'];
    $railsider_model = new railsider_model();

    //TRASPASOS
    $transbordos_list = $railsider_model->get_transbordos($id_transbordo);
    //echo "<pre>";
    //print_r($transbordos_list);
    //echo "</pre>";

    foreach ($transbordos_list as $transbordos_line) {
        $fecha_transbordo = $transbordos_line['fecha_transbordo'];
        $num_contenedor_origen = $transbordos_line['num_contenedor_origen'];
        $estado_carga_contenedor_origen = $transbordos_line['estado_carga_contenedor_origen'];
        $peso_mercancia_actual_contenedor_origen = $transbordos_line['peso_mercancia_actual_contenedor_origen'];
        $num_booking_actual_contenedor_origen = $transbordos_line['num_booking_actual_contenedor_origen'];
        $num_precinto_actual_contenedor_origen = $transbordos_line['num_precinto_actual_contenedor_origen'];
        $temperatura_actual_contenedor_origen = $transbordos_line['temperatura_actual_contenedor_origen'];
        $id_tipo_mercancia_actual_contenedor_origen = $transbordos_line['id_tipo_mercancia_actual_contenedor_origen'];
        $num_peligro_adr_actual_contenedor_origen = $transbordos_line['num_peligro_adr_actual_contenedor_origen'];
        $num_onu_adr_actual_contenedor_origen = $transbordos_line['num_onu_adr_actual_contenedor_origen'];
        $num_clase_adr_actual_contenedor_origen = $transbordos_line['num_clase_adr_actual_contenedor_origen'];
        $cod_grupo_embalaje_adr_actual_contenedor_origen = $transbordos_line['cod_grupo_embalaje_adr_actual_contenedor_origen'];
        $codigo_estacion_ferrocarril_actual_contenedor_origen = $transbordos_line['codigo_estacion_ferrocarril_actual_contenedor_origen'];
        $id_destinatario_actual_origen = $transbordos_line['id_destinatario_actual_origen'];
        $descripcion_mercancia_origen = $transbordos_line['descripcion_mercancia_origen'];
        $num_contenedor_destino = $transbordos_line['num_contenedor_destino'];
        $estado_carga_contenedor_destino = $transbordos_line['estado_carga_contenedor_destino'];
        $peso_mercancia_actual_contenedor_destino = $transbordos_line['peso_mercancia_actual_contenedor_destino'];
        $num_booking_actual_contenedor_destino = $transbordos_line['num_booking_actual_contenedor_destino'];
        $num_precinto_actual_contenedor_destino = $transbordos_line['num_precinto_actual_contenedor_destino'];
        $temperatura_actual_contenedor_destino = $transbordos_line['temperatura_actual_contenedor_destino'];
        $id_tipo_mercancia_actual_contenedor_destino = $transbordos_line['id_tipo_mercancia_actual_contenedor_destino'];        
        $num_peligro_adr_actual_contenedor_destino = $transbordos_line['num_peligro_adr_actual_contenedor_destino'];
        $num_onu_adr_actual_contenedor_destino = $transbordos_line['num_onu_adr_actual_contenedor_destino'];
        $num_clase_adr_actual_contenedor_destino = $transbordos_line['num_clase_adr_actual_contenedor_destino'];
        $cod_grupo_embalaje_adr_actual_contenedor_destino = $transbordos_line['cod_grupo_embalaje_adr_actual_contenedor_destino'];
        $codigo_estacion_ferrocarril_actual_contenedor_destino = $transbordos_line['codigo_estacion_ferrocarril_actual_contenedor_destino'];
        $id_destinatario_actual_destino = $transbordos_line['id_destinatario_actual_destino'];
        $descripcion_mercancia_destino = $transbordos_line['descripcion_mercancia_destino'];
    }

    /*if ($estado_carga_contenedor_origen === 'C' || $estado_carga_contenedor_destino === 'C'){
        $estado_carga_contenedor_origen = 'Cargado';
        $estado_carga_contenedor_destino = 'Cargado';
    } else {
        $estado_carga_contenedor_origen = 'Vacío';
        $estado_carga_contenedor_destino = 'Vacío';
    }*/

/*
    if (count($transbordos_list) > 0) {

        foreach ($transbordos_get_list as $key => $value){
            $nombre_comercial_propietario_anterior = "";
            $nombre_comercial_propietario_actual = "";

            $nombre_comercial_propietario = $value['nombre_comercial_propietario'];

            switch($transbordo_list) {
                case 1:
                    $nombre_comercial_propietario_anterior = $tipo_entrada[0]['nombre_comercial_propietario'];
                    $nombre_comercial_propietario_actual = $tipo_entrada[0]['nombre_comercial_propietario'];
                    break;
                case 2:
                    $nombre_comercial_propietario_anterior = $tipo_entrada[0]['nombre_comercial_propietario'];
                    $nombre_comercial_propietario_actual = $tipo_entrada[0]['nombre_comercial_propietario'];
                    break;
            }

            $transbordo_list[] = array(
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

            $transbordo_list[] = array(
                'nombre_comercial_propietario' => $nombre_comercial_propietario,
                'nombre_comercial_propietario_anterior' => $nombre_comercial_propietario_anterior,
                'nombre_comercial_propietario_actual' => $nombre_comercial_propietario_actual
            );*/
        //}
    //}
    //echo "<pre>";
    //print_r($transbordos_list);
    //echo "</pre>";    

    //Cargamos la vista
    require_once('../views/transbordo_view.php');

} else {
    echo "No hay ID transbordo";
}
