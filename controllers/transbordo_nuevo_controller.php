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

if (isset($_POST['submit'])) { //estamos guardando formulario
  //echo "<pre>"; print_r($_POST); echo "</pre>";

  //sacamos datos
  $fecha_form = $_POST['fecha_transbordo'];
  $hora_form = $_POST['hora_transbordo'];
  $fecha_transbordo = $fecha_form . " " . $hora_form;
  //Contenedor Origen
  $num_contenedor_origen = $_POST['num_cont_1'];
  $nombre_comercial_propietario_cont_origen = $_POST['nombre_comercial_propietario_cont_anterior'];
  //Contenedor Destino
  $num_contenedor_destino = $_POST['num_cont_2'];
  $nombre_comercial_propietario_cont_destino = $_POST['nombre_comercial_propietario_cont_destino'];

  if ($nombre_comercial_propietario_cont_origen == $nombre_comercial_propietario_cont_destino) {

    if ($num_contenedor_origen != $num_contenedor_destino) { //Insertamos Transbordos

      $contenedor_origen_data = array();
      $contenedor_list_origen = $railsider_model->get_contenedor($num_contenedor_origen);
      foreach ($contenedor_list_origen as $contenedor_line_origen) {
        $contenedor_origen_data['tara_contenedor'] = $contenedor_line_origen['tara_contenedor'];
        $contenedor_origen_data['estado_carga_contenedor'] = $contenedor_line_origen['estado_carga_contenedor'];
        $contenedor_origen_data['peso_bruto_actual_contenedor'] = $contenedor_line_origen['peso_bruto_actual_contenedor'];
        $contenedor_origen_data['peso_mercancia_actual_contenedor'] = $contenedor_line_origen['peso_mercancia_actual_contenedor'];
        $contenedor_origen_data['num_booking_actual_contenedor'] = $contenedor_line_origen['num_booking_actual_contenedor'];
        $contenedor_origen_data['num_precinto_actual_contenedor'] = $contenedor_line_origen['num_precinto_actual_contenedor'];
        $contenedor_origen_data['temperatura_actual_contenedor'] = $contenedor_line_origen['temperatura_actual_contenedor'];
        $contenedor_origen_data['id_tipo_mercancia_actual_contenedor'] = $contenedor_line_origen['id_tipo_mercancia_actual_contenedor'];
        $contenedor_origen_data['num_peligro_adr_actual_contenedor'] = $contenedor_line_origen['num_peligro_adr_actual_contenedor'];
        $contenedor_origen_data['num_onu_adr_actual_contenedor'] = $contenedor_line_origen['num_onu_adr_actual_contenedor'];
        $contenedor_origen_data['num_clase_adr_actual_contenedor'] = $contenedor_line_origen['num_clase_adr_actual_contenedor'];
        $contenedor_origen_data['cod_grupo_embalaje_adr_actual_contenedor'] = $contenedor_line_origen['cod_grupo_embalaje_adr_actual_contenedor'];
        $contenedor_origen_data['descripcion_mercancia'] = $contenedor_line_origen['descripcion_mercancia'];
        $contenedor_origen_data['id_tipo_contenedor_iso'] = $contenedor_line_origen['id_tipo_contenedor_iso'];
        $contenedor_origen_data['longitud_tipo_contenedor'] = $contenedor_line_origen['longitud_tipo_contenedor'];
        $contenedor_origen_data['descripcion_tipo_contenedor'] = $contenedor_line_origen['descripcion_tipo_contenedor'];
        $contenedor_origen_data['cif_propietario_actual'] = $contenedor_line_origen['cif_propietario_actual'];
        $contenedor_origen_data['codigo_estacion_ferrocarril_actual_contenedor'] = $contenedor_line_origen['codigo_estacion_ferrocarril_actual_contenedor'];
        $contenedor_origen_data['id_destinatario_actual'] = $contenedor_line_origen['id_destinatario_actual'];
        $contenedor_origen_data['nombre_destinatario'] = $contenedor_line_origen['nombre_destinatario'];
        $contenedor_origen_data['id_cita_carga_temp'] = $contenedor_line_origen['id_cita_carga_temp'];
      }

      //echo "<pre>";
      //print_r($contenedor_origen_data);
      //echo "</pre>";


      $contenedor_destino_data = array();
      $contenedor_list_destino = $railsider_model->get_contenedor($num_contenedor_destino);
      foreach ($contenedor_list_destino as $contenedor_line_destino) {
        $contenedor_destino_data['tara_contenedor'] = $contenedor_line_destino['tara_contenedor'];
        $contenedor_destino_data['estado_carga_contenedor'] = $contenedor_line_destino['estado_carga_contenedor'];
        $contenedor_destino_data['peso_bruto_actual_contenedor'] = $contenedor_line_destino['peso_bruto_actual_contenedor'];
        $contenedor_destino_data['peso_mercancia_actual_contenedor'] = $contenedor_line_destino['peso_mercancia_actual_contenedor'];
        $contenedor_destino_data['num_booking_actual_contenedor'] = $contenedor_line_destino['num_booking_actual_contenedor'];
        $contenedor_destino_data['num_precinto_actual_contenedor'] = $contenedor_line_destino['num_precinto_actual_contenedor'];
        $contenedor_destino_data['temperatura_actual_contenedor'] = $contenedor_line_destino['temperatura_actual_contenedor'];
        $contenedor_destino_data['id_tipo_mercancia_actual_contenedor'] = $contenedor_line_destino['id_tipo_mercancia_actual_contenedor'];
        $contenedor_destino_data['num_peligro_adr_actual_contenedor'] = $contenedor_line_destino['num_peligro_adr_actual_contenedor'];
        $contenedor_destino_data['num_onu_adr_actual_contenedor'] = $contenedor_line_destino['num_onu_adr_actual_contenedor'];
        $contenedor_destino_data['num_clase_adr_actual_contenedor'] = $contenedor_line_destino['num_clase_adr_actual_contenedor'];
        $contenedor_destino_data['cod_grupo_embalaje_adr_actual_contenedor'] = $contenedor_line_destino['cod_grupo_embalaje_adr_actual_contenedor'];
        $contenedor_destino_data['descripcion_mercancia'] = $contenedor_line_destino['descripcion_mercancia'];
        $contenedor_destino_data['id_tipo_contenedor_iso'] = $contenedor_line_destino['id_tipo_contenedor_iso'];
        $contenedor_destino_data['longitud_tipo_contenedor'] = $contenedor_line_destino['longitud_tipo_contenedor'];
        $contenedor_destino_data['descripcion_tipo_contenedor'] = $contenedor_line_destino['descripcion_tipo_contenedor'];
        $contenedor_destino_data['cif_propietario_actual'] = $contenedor_line_destino['cif_propietario_actual'];
        $contenedor_destino_data['codigo_estacion_ferrocarril_actual_contenedor'] = $contenedor_line_destino['codigo_estacion_ferrocarril_actual_contenedor'];
        $contenedor_destino_data['id_destinatario_actual'] = $contenedor_line_destino['id_destinatario_actual'];
        $contenedor_destino_data['nombre_destinatario'] = $contenedor_line_destino['nombre_destinatario'];
        $contenedor_destino_data['id_cita_carga_temp'] = $contenedor_line_destino['id_cita_carga_temp'];
      }

      //echo "<pre>";
      //print_r($contenedor_destino_data);
      //echo "</pre>";

      ///// INICIO ALGORITMO TRANSBORDO /////
      //INSERTAR TABLA TRANSBORDO
      $id_transbordo = $railsider_model->insert_transbordo(
        $fecha_transbordo,
        $num_contenedor_origen,
        $contenedor_origen_data['estado_carga_contenedor'],
        $contenedor_origen_data['peso_mercancia_actual_contenedor'],
        $contenedor_origen_data['num_booking_actual_contenedor'],
        $contenedor_origen_data['num_precinto_actual_contenedor'],
        $contenedor_origen_data['temperatura_actual_contenedor'],
        $contenedor_origen_data['id_tipo_mercancia_actual_contenedor'],
        $contenedor_origen_data['num_peligro_adr_actual_contenedor'],
        $contenedor_origen_data['num_onu_adr_actual_contenedor'],
        $contenedor_origen_data['num_clase_adr_actual_contenedor'],
        $contenedor_origen_data['cod_grupo_embalaje_adr_actual_contenedor'],
        $contenedor_origen_data['codigo_estacion_ferrocarril_actual_contenedor'],
        $contenedor_origen_data['id_destinatario_actual'],
        $num_contenedor_destino,
        $contenedor_destino_data['estado_carga_contenedor'],
        $contenedor_destino_data['peso_mercancia_actual_contenedor'],
        $contenedor_destino_data['num_booking_actual_contenedor'],
        $contenedor_destino_data['num_precinto_actual_contenedor'],
        $contenedor_destino_data['temperatura_actual_contenedor'],
        $contenedor_destino_data['id_tipo_mercancia_actual_contenedor'],
        $contenedor_destino_data['num_peligro_adr_actual_contenedor'],
        $contenedor_destino_data['num_onu_adr_actual_contenedor'],
        $contenedor_destino_data['num_clase_adr_actual_contenedor'],
        $contenedor_destino_data['cod_grupo_embalaje_adr_actual_contenedor'],
        $contenedor_destino_data['codigo_estacion_ferrocarril_actual_contenedor'],
        $contenedor_destino_data['id_destinatario_actual'],

      ); //HECHO

      //UPDATE TABLA INCIDENCIA CONTENEDOR
      $update_transbordo_incidencia_contenedor = $railsider_model->update_transbordo_incidencia_contenedor($id_transbordo, $num_contenedor_origen); //HECHO

      //UPDATE TABLA CONTENEDOR (DESTINO) CON LOS DATOS DEL CONTENEDOR (ORIGEN)
      if ($contenedor_destino_data['estado_carga_contenedor'] == 'V') {
        $railsider_model->update_datos_contenedor_destino(
          $num_contenedor_destino,
          $contenedor_origen_data['estado_carga_contenedor'],
          $contenedor_origen_data['peso_mercancia_actual_contenedor'],
          $contenedor_origen_data['num_booking_actual_contenedor'],
          $contenedor_origen_data['num_precinto_actual_contenedor'],
          $contenedor_origen_data['temperatura_actual_contenedor'],
          $contenedor_origen_data['id_tipo_mercancia_actual_contenedor'],
          $contenedor_origen_data['num_peligro_adr_actual_contenedor'],
          $contenedor_origen_data['num_onu_adr_actual_contenedor'],
          $contenedor_origen_data['num_clase_adr_actual_contenedor'],
          $contenedor_origen_data['cod_grupo_embalaje_adr_actual_contenedor'],
          $contenedor_origen_data['codigo_estacion_ferrocarril_actual_contenedor'],
          $contenedor_origen_data['id_destinatario_actual']
        );
      }

      //UPDATE TABLA CONTENEDOR (ORIGEN) CON NULL
      $railsider_model->update_datos_contenedor_origen(
        $num_contenedor_origen
      );

      ///// FIN ALGORITMO TRANSBORDO /////

      //Cargamos la vista
      header('Location: ../controllers/transbordo_controller.php?id_transbordo=' . $id_transbordo);
    } else {
      echo "Estas haciendo un transbordo de un contenedor dañado. No selecciones el mismo contenedor.";
    }
  } else {
    echo "Uno de los contenedores no es del mismo propietario";
  }
} else {
  require_once('../views/transbordo_nuevo_view.php');
}
