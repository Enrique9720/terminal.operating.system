<?php

//////////////////////////////////////////////////////////////////
session_start();

//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");
//cargamos las funciones PHP comunes para CODECOS
require_once "../functions/codeco_functions.php";
//comprobamos que el usuario esta logeado
check_logged_user();

/////////////////////// CARGA DE MODELOS ////////////////////////////////////////////
require_once("../models/railsider_model.php");
/////////////////////////////////////////////////////////////////////////////////////
//echo "<pre>";
//print_r($_POST);
//echo "</pre>";


if (isset($_POST['num_expedicion']) && isset($_POST['entrada_tren'])) {

  $num_expedicion = strip_tags(trim($_POST['num_expedicion']));
  $retraso_tren_checkbox = strip_tags(trim($_POST['retraso_tren_checkbox']));
  $entrada_tren = $_POST['entrada_tren'];
  //echo "<pre>";
  //print_r($entrada_tren);
  //echo "</pre>";
  $contenedores_codeco = array();

  //echo "num_expedicion: ".$num_expedicion."<br/>";
  //print_r($entrada_tren);
  //echo "$fecha_expedicion<br/>";

  $railsider_model = new railsider_model();

  //Añadir generadores CCIS BILBAO
  $cita_carga_list = $railsider_model->get_cita_descarga($num_expedicion);
  //print_r($cita_carga_list);
  $cif_propietario = $cita_carga_list[0]['cif_propietario'];

  //echo $cif_propietario;
  if ($cif_propietario == 'A60389624') { //Si es BILBAO añadimos generadores
    $generadores_list = $railsider_model->get_generadores_por_propietario($cif_propietario);
    foreach ($generadores_list as $generadores_line) {
      $entrada_tren[] = array(
        'num_vagon' => $generadores_line['num_vagon'],
        'pos_vagon' => $generadores_line['pos_vagon'],
        'pos_contenedor' => $generadores_line['pos_contenedor'],
        'num_contenedor' => $generadores_line['num_contenedor'],
        'tipo_contenedor_iso' => $generadores_line['tipo_contenedor_iso'],
        'tara_contenedor' => $generadores_line['tara_contenedor'],
        'vacio_cargado_contenedor' => $generadores_line['vacio_cargado_contenedor'],
        'peso_bruto_contenedor' => $generadores_line['peso_bruto_contenedor'],
        'temperatura_contenedor' => $generadores_line['temperatura_contenedor'],
        'nombre_comercial_propietario' => $generadores_line['nombre_comercial_propietario'],
        'num_peligro_adr' => $generadores_line['num_peligro_adr'],
        'num_onu_adr' => $generadores_line['num_onu_adr'],
        'num_clase_adr' => $generadores_line['num_clase_adr'],
        'cod_grupo_embalaje_adr' => $generadores_line['cod_grupo_embalaje_adr'],
        'destinatario' => $generadores_line['destinatario']
      );
    }
  }

  //echo "<pre>";
  //print_r($entrada_tren);
  //echo "</pre>";


  //Sacamos ID TIPO ENTRADA TREN
  $tipo_entrada = 'TREN';
  $list_tipo_entrada = $railsider_model->get_tipo_entrada_por_tipo($tipo_entrada);
  $id_tipo_entrada_tren = $list_tipo_entrada[0]['id_tipo_entrada'];
  //Sacamos ID MERCANCIA PELIGROSA
  $descripcion_mercancia_peligrosa = 'MERCANCÍA PELIGROSA';
  $list_mercancia = $railsider_model->get_mercancia_por_descripcion($descripcion_mercancia_peligrosa);
  $id_tipo_mercancia_peligrosa = $list_mercancia[0]['id_tipo_mercancia'];

  //Sacamos ID CARGA GENERAL
  $descripcion_mercancia_general = 'CARGA GENERAL';
  $list_mercancia = $railsider_model->get_mercancia_por_descripcion($descripcion_mercancia_general);
  $id_tipo_mercancia_general = $list_mercancia[0]['id_tipo_mercancia'];

  //Sacamos ID para VACÍO-SUCIO
  $descripcion_mercancia_vacio_sucio = 'VACÍO-SUCIO';
  $list_mercancia = $railsider_model->get_mercancia_por_descripcion($descripcion_mercancia_vacio_sucio);
  $id_tipo_mercancia_vacio_sucio = $list_mercancia[0]['id_tipo_mercancia'];

  //Sacamos ID para VACÍO
  $descripcion_mercancia_vacio = 'VACÍO';
  $list_mercancia = $railsider_model->get_mercancia_por_descripcion($descripcion_mercancia_vacio);
  $id_tipo_mercancia_vacio = $list_mercancia[0]['id_tipo_mercancia'];

  //TABLA ENTRADA Y ENTRADA_TREN
  //obtenemos datos de cita descarga a partir de num_packing
  $list_cita_descarga = $railsider_model->num_expedicion_descarga_check($num_expedicion);
  if (count($list_cita_descarga) > 0) { //Si hay datos
    foreach ($list_cita_descarga as $value) { //sacamos datos
      $id_cita_descarga = $value['id_cita_descarga'];
      $fecha_entrada = $value['fecha']; //fecha de la cita
      $hora_entrada = $value['hora']; //fecha de la cita
      $fecha_expedicion = $fecha_entrada . " " . $hora_entrada;
      $cif_propietario = $value['cif_propietario'];
    }
    //insertamos en tabla entrada
    $id_entrada = $railsider_model->insert_entrada(
      $fecha_expedicion,
      $id_tipo_entrada_tren,
      $id_cita_descarga,
      $_SESSION['email']
    );

    if (isset($id_entrada)) {
      //insertamos en tabla entrada_tipo_tren
      $railsider_model->insert_entrada_tren($id_entrada, $num_expedicion);
      //incializamos el mensaje de error
      $mensaje_error_array = array();
      //inicializamos el contador de errores
      $contador_error = 0;

      foreach ($entrada_tren as $indice => $entrada_tren_linea) {

        //sacamos las variables de la linea
        $num_vagon = $entrada_tren_linea['num_vagon'];
        $pos_vagon = $entrada_tren_linea['pos_vagon'];
        //si la pos_contenedor esta vacia, establecemos null
        $pos_contenedor = $entrada_tren_linea['pos_contenedor'];
        if ($pos_contenedor == '') {
          $pos_contenedor = null;
        }
        $num_contenedor = $entrada_tren_linea['num_contenedor'];
        //Si el numero de contenedor es vacío, establezca null
        if ($num_contenedor == '') {
          $num_contenedor = null;
        }
        $tipo_contenedor_iso = $entrada_tren_linea['tipo_contenedor_iso'];
        $vacio_cargado_contenedor = $entrada_tren_linea['vacio_cargado_contenedor'];

        $tara_contenedor = $entrada_tren_linea['tara_contenedor'];
        //si la tara esta vacia, establecemos null
        if ($tara_contenedor == '') {
          $tara_contenedor = null;
        }
        //echo $num_contenedor." tara_contenedor".$tara_contenedor."<br/>";

        $peso_bruto_contenedor = $entrada_tren_linea['peso_bruto_contenedor'];
        //si la peso_bruto_contenedor esta vacia, establecemos null
        if ($peso_bruto_contenedor == '') {
          $peso_bruto_contenedor = null;
        }
        $temperatura_contenedor = $entrada_tren_linea['temperatura_contenedor'];
        //si la temperatura esta vacia, establecemos null
        if ($temperatura_contenedor == '') {
          $temperatura_contenedor = null;
        }
        $nombre_comercial_propietario = $entrada_tren_linea['nombre_comercial_propietario'];
        $num_peligro_adr = $entrada_tren_linea['num_peligro_adr'];
        //si la num_peligro_adr esta vacia, establecemos null
        if ($num_peligro_adr == '') {
          $num_peligro_adr = null;
        }
        $num_onu_adr = $entrada_tren_linea['num_onu_adr'];
        //si la num_onu_adr esta vacia, establecemos null
        if ($num_onu_adr == '') {
          $num_onu_adr = null;
        }
        $num_clase_adr = $entrada_tren_linea['num_clase_adr'];
        //si la num_clase_adr esta vacia, establecemos null
        if ($num_clase_adr == '') {
          $num_clase_adr = null;
        }
        $cod_grupo_embalaje_adr = $entrada_tren_linea['cod_grupo_embalaje_adr'];
        //si la cod_grupo_embalaje_adr esta vacia, establecemos null
        if ($cod_grupo_embalaje_adr == '') {
          $cod_grupo_embalaje_adr = null;
        }

        //calculamos tipos de mercancia
        if ($vacio_cargado_contenedor == 'C') {
          if (($num_peligro_adr != '') || ($num_onu_adr != '')) {
            $id_tipo_mercancia = $id_tipo_mercancia_peligrosa;
          } else {
            $id_tipo_mercancia = $id_tipo_mercancia_general;
          }
        } else if ($vacio_cargado_contenedor == 'V') {
          if (($num_peligro_adr != '') || ($num_onu_adr != '')) {
            $id_tipo_mercancia = $id_tipo_mercancia_vacio_sucio; //vacio sucio
          } else {
            $id_tipo_mercancia = $id_tipo_mercancia_vacio; //vacio de verdad
          }
        } else {
          $id_tipo_mercancia = null;
        }

        if ($nombre_comercial_propietario != '') {
          $nombre_comercial_propietario = $entrada_tren_linea['nombre_comercial_propietario'];
          $propietario_list = $railsider_model->get_propietario_por_nombre_comercial($nombre_comercial_propietario);
          $cif_propietario = $propietario_list[0]['cif_propietario'];
        } else {
          $cif_propietario = null;
        }

        //TABLA EMPRESA_DESTINO_ORIGEN
        $destinatario_contenedor = $entrada_tren_linea['destinatario'];
        if ($destinatario_contenedor != '') {
          //Comprobamos si existe el nombre destinatario
          $destinatario_list = $railsider_model->get_destinatario_por_nombre($destinatario_contenedor);
          if (count($destinatario_list) == 0) { //Si no existe
            //Insertamos conductor
            $id_destinatario = $railsider_model->insert_destinatario($destinatario_contenedor, null);
          } else {
            $id_destinatario = $destinatario_list[0]['id_empresa_destino_origen'];
          }
        } else {
          $id_destinatario = null;
        }

        //TABLA CONTENEDOR
        if ($num_contenedor != null) {
          //calculamos id_tipo_mercancia_actual_contenedor
          $id_tipo_mercancia_actual_contenedor = $id_tipo_mercancia;
          //calculamos temperatura_actual_contenedor
          $temperatura_actual_contenedor = $temperatura_contenedor;
          //calcular cif_propietario_actual
          $cif_propietario_actual = $cif_propietario;
          //calcular id_destinatario_actual
          $id_destinatario_actual = $id_destinatario;
          //calculamos el peso bruto actual del contenedor
          $peso_bruto_actual_contenedor = $peso_bruto_contenedor;
          //calculamos el booking actual del contenedor
          $num_booking_actual_contenedor = null;
          //calculamos el precinto actual del contenedor
          $num_precinto_actual_contenedor = null;
          //calculamos el codigo estacion ferrocarril actual del contenedor
          $codigo_estacion_ferrocarril_actual_contenedor = null;
          //calculamos el num_peligro_adr actual del contenedor
          $num_peligro_adr_actual_contenedor = $num_peligro_adr;
          //calculamos el num_onu_adr actual del contenedor
          $num_onu_adr_actual_contenedor = $num_onu_adr;
          //calculamos el num_clase_adr actual del contenedor
          $num_clase_adr_actual_contenedor = $num_clase_adr;
          //calculamos el cod_grupo_embalaje_adr actual del contenedor
          $cod_grupo_embalaje_adr_actual_contenedor = $cod_grupo_embalaje_adr;
          $estado_carga_contenedor = $vacio_cargado_contenedor;
          $id_tipo_contenedor_iso = $tipo_contenedor_iso;

          //sacamos datos de contenedor
          $list = $railsider_model->get_contenedor($num_contenedor);
          if (count($list) > 0) { //Si existe, actualizamos
            foreach ($list as $value) { //sacamos datos del contenedor desde BBDD
              //al contenedor dado de alta, no podemos cambiarle el tipo
              //$id_tipo_contenedor_iso = $value['id_tipo_contenedor_iso'];

              //calculamos pesos
              if ($estado_carga_contenedor == 'V') {
                $peso_mercancia_actual_contenedor = 0;
                if ($tara_contenedor == null) { //Si la tara del contenedor en el excel esta vacia, la tara del contenedor sera la del peso bruto
                  //actualizamos tara si el contenedor esta vacio
                  $tara_contenedor = $peso_bruto_actual_contenedor;
                }
              } else if ($estado_carga_contenedor == 'C') {
                if ($tara_contenedor == null) { //Si la tara del contenedor en el excel esta vacia, la tara del contenedor sera la que hay en la BBDD
                  $tara_contenedor = $value['tara_contenedor'];
                }
                $peso_mercancia_actual_contenedor = $peso_bruto_actual_contenedor - $tara_contenedor;
              }

              $railsider_model->update_contenedor(
                $num_contenedor,
                $tara_contenedor,
                $estado_carga_contenedor,
                $peso_bruto_actual_contenedor,
                $peso_mercancia_actual_contenedor,
                $num_booking_actual_contenedor,
                $num_precinto_actual_contenedor,
                $temperatura_actual_contenedor,
                $id_tipo_mercancia_actual_contenedor,
                $num_peligro_adr_actual_contenedor,
                $num_onu_adr_actual_contenedor,
                $num_clase_adr_actual_contenedor,
                $cod_grupo_embalaje_adr_actual_contenedor,
                $id_tipo_contenedor_iso,
                $cif_propietario_actual,
                $codigo_estacion_ferrocarril_actual_contenedor,
                $id_destinatario_actual
              );
            }
          } else { //Si no existe, insertamos

            $tipo_contenedor_list = $railsider_model->get_tipo_contenedor_iso_por_id($id_tipo_contenedor_iso);

            //calculamos pesos
            if ($estado_carga_contenedor == 'V') {

              if ($tara_contenedor == null) { //Si la tara del contenedor en el excel esta vacia, la tara del contenedor sera la del peso bruto
                //actualizamos tara si el contenedor esta vacio
                $tara_contenedor = $peso_bruto_actual_contenedor;
              }
              $peso_mercancia_actual_contenedor = 0;
            } else if ($estado_carga_contenedor == 'C') {
              if ($tara_contenedor == null) { //Si la tara del contenedor en el excel esta vacia, la tara del contenedor sera la que hay en la BBDD
                //Al no estar el contenedor dado de alta, su tara_contenedor es la que tenga segun su tipo_contenedor
                $tara_contenedor = $tipo_contenedor_list[0]['tara_contenedor'];
              }
              $peso_mercancia_actual_contenedor = $peso_bruto_actual_contenedor - $tara_contenedor;
            }

            $railsider_model->insert_contenedor(
              $num_contenedor,
              $tara_contenedor,
              $estado_carga_contenedor,
              $peso_bruto_actual_contenedor,
              $peso_mercancia_actual_contenedor,
              $num_booking_actual_contenedor,
              $num_precinto_actual_contenedor,
              $temperatura_actual_contenedor,
              $id_tipo_mercancia_actual_contenedor,
              $num_peligro_adr_actual_contenedor,
              $num_onu_adr_actual_contenedor,
              $num_clase_adr_actual_contenedor,
              $cod_grupo_embalaje_adr_actual_contenedor,
              $id_tipo_contenedor_iso,
              $cif_propietario_actual,
              $codigo_estacion_ferrocarril_actual_contenedor,
              $id_destinatario_actual
            );

            //echo "num_contenedor: ".$num_contenedor."<br>";
            //echo "tara_contenedor: ".$tara_contenedor."<br>";
            //echo "estado_carga_contenedor: ".$estado_carga_contenedor."<br>";
            //echo "peso_bruto_actual_contenedor: ".$peso_bruto_actual_contenedor."<br>";
            //echo "peso_mercancia_actual_contenedor: ".$peso_mercancia_actual_contenedor."<br>";
            //echo "num_booking_actual_contenedor: ".$num_booking_actual_contenedor."<br>";
            //echo "num_precinto_actual_contenedor: ".$num_precinto_actual_contenedor."<br>";
            //echo "temperatura_actual_contenedor: ".$temperatura_actual_contenedor."<br>";
            //echo "id_tipo_mercancia_actual_contenedor: ".$id_tipo_mercancia_actual_contenedor."<br>";
            //echo "num_peligro_adr_actual_contenedor: ".$num_peligro_adr_actual_contenedor."<br>";
            //echo "num_onu_adr_actual_contenedor: ".$num_onu_adr_actual_contenedor."<br>";
            //echo "num_clase_adr_actual_contenedor: ".$num_clase_adr_actual_contenedor."<br>";
            //echo "cod_grupo_embalaje_adr_actual_contenedor: ".$cod_grupo_embalaje_adr_actual_contenedor."<br>";
            //echo "id_tipo_contenedor_iso: ".$id_tipo_contenedor_iso."<br>";
            //echo "cif_propietario_actual: ".$cif_propietario_actual."<br>";
            //echo "codigo_estacion_ferrocarril_actual_contenedor: ".$codigo_estacion_ferrocarril_actual_contenedor."<br>";
            //echo "id_destinatario_actual: ".$id_destinatario_actual."<br>";

          }
        } //fin if num_contenedor != null


        //TABLA ENTRADA_VAGON_CONTENEDOR
        //insertar en tabla entrada_vagon_contenedor
        $railsider_model->insert_entrada_vagon_contenedor(
          $id_entrada,
          $num_vagon,
          $pos_vagon,
          $pos_contenedor,
          $num_contenedor,
          $estado_carga_contenedor,
          $id_tipo_mercancia,
          $num_peligro_adr,
          $num_onu_adr,
          $num_clase_adr,
          $cod_grupo_embalaje_adr,
          $tara_contenedor,
          $peso_bruto_contenedor,
          $temperatura_contenedor,
          $cif_propietario,
          $id_destinatario
        );

        //TABLA CONTROL_STOCK
        if ($num_contenedor != null) {
          $list_control_stock = $railsider_model->contenedor_en_stock($num_contenedor);
          if (count($list_control_stock) == 0) { //Si no hay datos
            //insertar id_entrada y contenedor en tabla control_stock
            $id_control_stock = $railsider_model->insert_control_stock(
              $num_contenedor,
              $id_entrada
            );
          }
        }



        //Variable con los datos de los contenedores para generar CODECOS
        if ($estado_carga_contenedor == 'C') { //SI ENTRADA TREN CARGADO => IMPORT => 3
          $import_export = 3; //3 for import and 2 for export
          $estado_carga = 5; //5 for full and 4 for empty
        } else if ($estado_carga_contenedor == 'V') { //SI ENTRADA TREN VACIO => EXPORT => 2
          $import_export = 2; //3 for import and 2 for export
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



        //COMPROBACION ENTRADA CORRECTA
        //inicializamos mensaje de error
        $mensaje_error = '';

        //TABLA ENTRADA
        $list_entrada = $railsider_model->get_entrada_por_id($id_entrada);
        if (count($list_entrada) > 0) {

          //TABLA ENTRADA_TIPO_TREN
          $list_entrada_tipo_tren = $railsider_model->get_entrada_tipo_tren_por_id_entrada($id_entrada);
          if (count($list_entrada_tipo_tren) > 0) {

            //ENTRADA_VAGON_CONTENEDOR
            $list_entrada_vagon_contenedor = $railsider_model->get_entrada_vagon_contenedor_por_id_entrada($id_entrada);
            if (count($list_entrada_vagon_contenedor) > 0) {

              if ($num_contenedor != null) {

                //CONTENEDOR
                $list_contenedor = $railsider_model->get_contenedor($num_contenedor);
                if (count($list_contenedor) > 0) {

                  //CONTROL_STOCK
                  $list_control_stock = $railsider_model->get_control_stock_por_id_entrada($id_entrada);
                  if (count($list_control_stock) > 0) {
                    $mensaje_error = "";
                  } else {
                    $mensaje_error = "Error al dar alta entrada tren (control_stock)";
                    $contador_error++;
                  }
                } else {
                  $mensaje_error = "Error al dar alta entrada tren (contenedor)";
                  $contador_error++;
                }
              }
            } else {
              $mensaje_error = "Error al dar alta entrada tren (entrada_vagon_contenedor)";
              $contador_error++;
            }
          } else {
            $mensaje_error = "Error al dar alta entrada tren (entrada_tipo_tren)";
            $contador_error++;
          }
        } else {
          $mensaje_error = "Error al dar alta entrada tren (entrada)";
          $contador_error++;
        }

        $mensaje_error_array[$indice]['num_contenedor'] = $num_contenedor;
        $mensaje_error_array[$indice]['mensaje_error'] = $mensaje_error;
      } //fin foreach

    } //fin if isset($id_entrada)
  } // fin if (count($list_cita_descarga) > 0)

  //echo "<pre>";
  //print_r($mensaje_error_array);
  //echo "</pre>";

  if ($contador_error > 0) {
    $response_array['id_entrada'] = $id_entrada;
    $response_array['status'] = 'error';
    $response_array['message'] = $mensaje_error_array;
  } else {
    $response_array['id_entrada'] = $id_entrada;
    $response_array['status'] = 'success';
    $response_array['message'] = $mensaje_error_array;

    //GENERACION Y ENVIO CODECO
    if (($cif_propietario == 'A60389624') || ($cif_propietario == 'A96764097')) { //CODECOS CMA-CGM (A60389624 = CCIS-BILBAO) (A96764097 = SICSA-VALENCIA)
      $fecha_movimiento = $fecha_expedicion;
      $tipo_vehiculo = 25;  //31 for truck and 25 for rail express
      $trip_number = $num_expedicion;
      //$empresa_transportista_list = $railsider_model->get_empresa_transportista_por_cif($cif_empresa_transportista);
      $nombre_empresa_transportista = 'RENFE MERCANCIAS SME SA';
      $id_vehiculo = explode('-', $trip_number)[0]; //
      //marcamos que el CODECO no presenta averia o daño del contenedor
      $daño_averia = 0;
      //echo "<pre>";
      //print_r($contenedores_codeco);
      //echo "</pre>";
      //echo "id_entrada: ".$id_entrada."<br/>";
      //echo "fecha_movimiento: ".$fecha_movimiento."<br/>";
      //echo "tipo_vehiculo: ".$tipo_vehiculo."<br/>";
      //echo "trip_number: ".$trip_number."<br/>";
      //echo "nombre_empresa_transportista: ".$nombre_empresa_transportista."<br/>";
      //echo "id_vehiculo: ".$id_vehiculo."<br/>";

      codeco_ccis_sicsa_gatein(
        $id_entrada,
        $fecha_movimiento,
        $contenedores_codeco,
        $tipo_vehiculo,
        $trip_number,
        $nombre_empresa_transportista,
        $id_vehiculo,
        $daño_averia
      );
    } //FIN check cif propietario
  }

  //GENERACION DE INCIDENCIA
  //Si esta marcado la casilla de retraso, insertamos incidencia
  if ($retraso_tren_checkbox == true) {

    $id_tipo_incidencia = 5; //la incidencia es de tipo retraso tren
    $estado_incidencia = 'ABIERTA';
    $observaciones = '';
    $fecha_incidencia = $fecha_expedicion; //con hora
    $date_incidencia = $fecha_entrada; //sin hora

    //obtener serie del año segun la fecha de incidencia
    $fecha_serie = strtotime($date_incidencia);
    $year_serie = date("y", $fecha_serie);

    //obtener ultimo num_incidencia del año
    $ultimo_num_incidencia = $railsider_model->get_ultimo_num_incidencia_por_serie($year_serie)[0]['num_incidencia'];
    $contador_incidencia_serie = explode("/", $ultimo_num_incidencia)[1];
    //sumarle 1
    $siguiente_num_incidencia = $year_serie . "/" . sprintf('%04d', $contador_incidencia_serie + 1);
    //echo $siguiente_num_incidencia;

    //comprobar que no exista
    $incidencia_list = $railsider_model->get_num_incidencia_por_num_incidencia($siguiente_num_incidencia);

    if (count($incidencia_list) == 0) { //si no existe el numero
      //TABLA INCIDENCIA
      $id_incidencia = $railsider_model->insert_incidencia(
        $fecha_incidencia,
        $id_tipo_incidencia,
        $estado_incidencia,
        $_SESSION['email'],
        $observaciones,
        $siguiente_num_incidencia
      );

      $incidencia_entrada = $railsider_model->insert_incidencia_entrada($id_incidencia, $id_entrada);
    }
  }
} else {
  $response_array['id_entrada'] = "";
  $response_array['status'] = 'error';
  $response_array['message'] = "Faltan campos: " . json_encode($_POST);
}
echo json_encode($response_array);
