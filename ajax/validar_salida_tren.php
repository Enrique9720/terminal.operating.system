<?php

session_start();

//cargamos el modelo con la clase que interactua con la tabla clientes
require_once("../models/railsider_model.php");
//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");
//cargamos las funciones PHP comunes para CODECOS
require_once "../functions/codeco_functions.php";
//comprobamos que el usuario esta logeado
check_logged_user();

if (isset($_POST['id_cita_carga']) && isset($_POST['num_expedicion'])) {

  $id_cita_carga = strip_tags(trim($_POST['id_cita_carga']));
  //echo $id_cita_carga."<br>";

  $num_expedicion = strip_tags(trim($_POST['num_expedicion']));
  //echo $num_expedicion."<br>";

  $contenedores_codeco = array();

  $railsider_model = new railsider_model();

  //Sacamos ID TIPO ENTRADA TREN
  $tipo_salida = 'TREN';
  $list_tipo_salida = $railsider_model->get_tipo_salida_por_tipo($tipo_salida);
  $id_tipo_salida_tren = $list_tipo_salida[0]['id_tipo_salida'];
  //echo $id_tipo_salida_tren."<br>";

  //TABLA SALIDA Y SALIDA_TREN
  //obtenemos datos de cita carga a partir de num_packing
  $list_cita_carga = $railsider_model->num_expedicion_carga_check($num_expedicion);
  //print_r($list_cita_carga);
  if (count($list_cita_carga) > 0) { //Si hay datos

    foreach ($list_cita_carga as $value) { //sacamos datos
      $id_cita_carga = $value['id_cita_carga'];
      $fecha_salida = $value['fecha']; //fecha de la cita
      $hora_salida = $value['hora']; //fecha de la cita
      $fecha_expedicion = $fecha_salida . " " . $hora_salida;
      $cif_propietario = $value['cif_propietario'];
    }

    //insertamos en tabla salida
    $id_salida = $railsider_model->insert_salida(
      $fecha_expedicion,
      $id_tipo_salida_tren,
      $id_cita_carga,
      $_SESSION['email']
    );
    //echo $id_salida;
    if (isset($id_salida)) {
      //insertamos en tabla salida_tipo_tren
      $railsider_model->insert_salida_tren($id_salida, $num_expedicion);
      //incializamos el mensaje de error
      $mensaje_error_array = array();
      //inicializamos el contador de errores
      $contador_error = 0;

      //Cargamos datos de la salida tren desde BBDD
      $salida_tren = $railsider_model->get_datos_salida_tipo_tren($id_cita_carga);
      //echo "<pre>";
      //print_r($salida_tren);
      //echo "</pre>";

      foreach ($salida_tren as $indice => $salida_tren_linea) {

        //sacamos las variables de la linea
        $num_vagon = $salida_tren_linea['num_vagon_temp'];
        $pos_vagon = $salida_tren_linea['pos_vagon_temp'];
        $pos_contenedor = $salida_tren_linea['pos_contenedor_temp'];
        $num_contenedor = $salida_tren_linea['num_contenedor'];

        //TABLA SALIDA_VAGON_CONTENEDOR
        //insertar en tabla entrada_vagon_contenedor
        $railsider_model->insert_salida_vagon_contenedor(
          $id_salida,
          $num_vagon,
          $pos_vagon,
          $pos_contenedor,
          $num_contenedor
        );

        ////////////////////////////////////////// INCIDENCIA DEMORA ESTANCIA M.M.P.P. //////////////////////////////////////////
        if (isset($num_contenedor)) {
        //coger el numero contenedor y sus datos
        $contenedor_datos = $railsider_model->get_ultima_entrada($num_contenedor);
        //echo "<pre>";
        //print_r($contenedor_datos);
        //echo "</pre>";
        if (!empty($contenedor_datos)) {
          foreach ($contenedor_datos as $value) {
            $id_entrada = $value['id_entrada'];
            $estado_carga_contenedor = $value['estado_carga_contenedor'];
            $id_tipo_mercancia = $value['id_tipo_mercancia'];
            $fecha_entrada_time = date('Y-m-d H:i:s', strtotime($value['fecha_entrada']));
            $fecha_salida_time = date('Y-m-d H:i:s', strtotime($fecha_salida));
          }
          //calculamos diferencia de dias
          $dias_estancia_mmpp = calcular_diferencia_dias($fecha_entrada_time, $fecha_salida_time);

          if ( ($id_tipo_mercancia == 2) && ($dias_estancia_mmpp >= 3) ) {
          //Si lleva mercancia peligrosa o vacio-sucio y esta mas de tres dias
          //entonces insertamos incidencia con insert_incidencia()
          //e insertamos incidencia contenedor con insert_incidencia_contenedor()

            $id_tipo_incidencia = 6;
            $estado_incidencia = 'ABIERTA';
            $observaciones = '';
            $fecha_incidencia = $fecha_salida_time; //con hora
            $date_incidencia = date('Y-m-d', strtotime($fecha_salida)); //sin hora
      			$fecha_serie = strtotime($date_incidencia);
      			$year_serie = date("y", $fecha_serie);

            $ultimo_num_incidencia = $railsider_model->get_ultimo_num_incidencia_por_serie($year_serie)[0]['num_incidencia'];
            //echo "<script>console.log('Ultimo Num-Incidencia: $ultimo_num_incidencia');</script>";
            $contador_incidencia_serie = explode("/", $ultimo_num_incidencia)[1];
            //echo "<script>console.log('Contador Incidencia Serie: $contador_incidencia_serie');</script>";
            $siguiente_num_incidencia = $year_serie . "/" . sprintf('%04d', $contador_incidencia_serie + 1);
            //echo "<script>console.log('Siguiente Num-Incidencia: $siguiente_num_incidencia');</script>";
            $incidencia_list = $railsider_model->get_num_incidencia_por_num_incidencia($siguiente_num_incidencia);
            //echo "<script>console.log('Incidencia List Count: " . $incidencia_list . "');</script>";

            if (empty($incidencia_list)) {
              try {
                $id_incidencia = $railsider_model->insert_incidencia(
                  $fecha_incidencia,
                  $id_tipo_incidencia,
                  $estado_incidencia,
                  $_SESSION['email'],
                  $observaciones,
                  $siguiente_num_incidencia
                );
              } catch (Exception $e) {
                //echo "<pre>Id Incidencia Insertada: $id_incidencia</pre>";
                //echo "<script>console.log('Id Incidencia Insertada: " . $id_incidencia . "');</script>";
                //continue;
              }
              $incidencia_contenedor = $railsider_model->insert_incidencia_contenedor(
                $id_incidencia,
                $num_contenedor,
                $estado_carga_contenedor,
                $cif_propietario,
                $id_entrada,
                $id_salida,
                NULL
              );
            }
          }
        }
      }
        ////////////////////////////////////////// FIN INCIDENCIA DEMORA ESTANCIA M.M.P.P. //////////////////////////////////////////

        //TABLA CONTROL_STOCK
        if ($num_contenedor != null) {
          $list_control_stock = $railsider_model->contenedor_en_stock($num_contenedor);
          if (count($list_control_stock) > 0) { //Si hay datos
            //actualizamos id_salida y contenedor en tabla control_stock
            $id_control_stock = $railsider_model->update_salida_control_stock(
              $num_contenedor,
              $id_salida
            );
            //Borrar id_cita_carga_temp en tabla contenedor y demas datos
            $railsider_model->update_contenedor_salida_tren(
              $num_contenedor
            );
          }
        }





        //sacamos datos de contenedor
        $list = $railsider_model->get_contenedor($num_contenedor);
        if (count($list) > 0) { //Si existe, actualizamos
          foreach ($list as $value) { //sacamos datos del contenedor desde BBDD
            //cif_propietario para CODECO
            $cif_propietario = $value['cif_propietario_actual'];
            //estado_carga_contenedor para CODECO
            $estado_carga_contenedor = $value['estado_carga_contenedor'];
            //id_tipo_contenedor_iso para CODECO
            $id_tipo_contenedor_iso = $value['id_tipo_contenedor_iso'];
            //num_booking_actual_contenedor para CODECO
            $num_booking_actual_contenedor = $value['num_booking_actual_contenedor'];
            //num_precinto_actual_contenedor para CODECO
            $num_precinto_actual_contenedor = $value['num_precinto_actual_contenedor'];
            //peso_bruto_actual_contenedor para CODECO
            $peso_bruto_actual_contenedor = $value['peso_bruto_actual_contenedor'];
          }
        }

        //Variable con los datos de los contenedores para generar CODECOS
        if ($estado_carga_contenedor == 'C') { //SI SALIDA TREN CARGADO => EXPORT => 2
          $import_export = 2; //3 for import and 2 for export
          $estado_carga = 5; //5 for full and 4 for empty
        } else if ($estado_carga_contenedor == 'V') { //SI SALIDA TREN VACIO => IMPORT => 3
          $import_export = 3; //3 for import and 2 for export
          $estado_carga = 4; //5 for full and 4 for empty
        }
        $contenedores_codeco[] = array(
          'num_contenedor' => $num_contenedor,
          'id_tipo_contenedor_iso' => $id_tipo_contenedor_iso,
          'estado_carga' => $estado_carga,
          'import_export' => $import_export,
          'num_booking_contenedor' => $num_booking_actual_contenedor,
          'num_precinto_contenedor' => $num_precinto_actual_contenedor,
          'peso_bruto_contenedor' => $peso_bruto_actual_contenedor
        );

        //COMPROBACION SALIDA CORRECTA
        //inicializamos mensaje de error
        $mensaje_error = '';

        //TABLA SALIDA
        $list_salida = $railsider_model->get_salida_por_id($id_salida);
        if (count($list_salida) > 0) {

          //TABLA SALIDA_TIPO_TREN
          $list_salida_tipo_tren = $railsider_model->get_salida_tipo_tren_por_id_salida($id_salida);
          if (count($list_salida_tipo_tren) > 0) {

            //SALIDA_VAGON_CONTENEDOR
            $list_salida_vagon_contenedor = $railsider_model->get_salida_vagon_contenedor_por_id_salida($id_salida);
            if (count($list_salida_vagon_contenedor) > 0) {

              //CONTROL_STOCK
              $list_control_stock = $railsider_model->get_control_stock_por_id_salida($id_salida);
              if (count($list_control_stock) > 0) {
                $mensaje_error = "";
              } else {
                $mensaje_error = "Error al dar alta salida tren (control_stock)";
                $contador_error++;
              }
            } else {
              $mensaje_error = "Error al dar alta salida tren (salida_vagon_contenedor)";
              $contador_error++;
            }
          } else {
            $mensaje_error = "Error al dar alta salida tren (salida_tipo_tren)";
            $contador_error++;
          }
        } else {
          $mensaje_error = "Error al dar alta salida tren (salida)";
          $contador_error++;
        }

        $mensaje_error_array[$indice]['num_contenedor'] = $num_contenedor;
        $mensaje_error_array[$indice]['mensaje_error'] = $mensaje_error;
      } //fin foreach

    } //fin if isset($id_salida)
  } // fin if (count($list_cita_descarga) > 0)


  //echo "<pre>";
  //print_r($mensaje_error_array);
  //echo "</pre>";

  if ($contador_error > 0) {
    $response_array['id_salida'] = $id_salida;
    $response_array['status'] = 'error';
    $response_array['message'] = $mensaje_error_array;
  } else {
    $response_array['id_salida'] = $id_salida;
    $response_array['status'] = 'success';
    $response_array['message'] = $mensaje_error_array;

    //GENERACION Y ENVIO CODECO
    if (($cif_propietario == 'A60389624') || ($cif_propietario == 'A96764097')) { //CODECOS CMA-CGM (A60389624 = CCIS-BILBAO) (A96764097 = SICSA-VALENCIA)
      $fecha_movimiento = $fecha_expedicion;
      $tipo_vehiculo = 25;  //31 for truck and 25 for rail express
      $trip_number = $num_expedicion;
      //$empresa_transportista_list = $railsider_model->get_empresa_transportista_por_cif($cif_empresa_transportista);
      $nombre_empresa_transportista = 'RENFE MERCANCIAS SME SA'; //poner nombre correcto
      $id_vehiculo = explode('-', $trip_number)[0]; //

      //echo "<pre>";
      //print_r($contenedores_codeco);
      //echo "</pre>";
      //echo "id_salida: ".$id_salida."<br/>";
      //echo "fecha_movimiento: ".$fecha_movimiento."<br/>";
      //echo "puerto_origen_destino: ".$puerto_origen_destino."<br/>";
      //echo "tipo_vehiculo: ".$tipo_vehiculo."<br/>";
      //echo "trip_number: ".$trip_number."<br/>";
      //echo "nombre_empresa_transportista: ".$nombre_empresa_transportista."<br/>";
      //echo "id_vehiculo: ".$id_vehiculo."<br/>";

      if ($cif_propietario == 'A60389624') { //CCIS-BILBAO
        $puerto_origen_destino = "ESBIO";
      } else if ($cif_propietario == 'A96764097') { //SICSA-VALENCIA
        $puerto_origen_destino = "ESVLC";
      }

      codeco_ccis_sicsa_gateout(
        $id_salida,
        $fecha_movimiento,
        $contenedores_codeco,
        $puerto_origen_destino,
        $tipo_vehiculo,
        $trip_number,
        $empresa_transportista,
        $id_vehiculo
      );
    } //FIN check cif propietario
  }
} else {
  $response_array['id_salida'] = "";
  $response_array['status'] = 'error';
  $response_array['message'] = "Faltan campos: " . json_encode($_POST);
}

//echo json_encode($response_array);
if (empty($response_array)) {
  error_log("Respuesta vacía al finalizar");
} else {
  echo json_encode($response_array);
}
