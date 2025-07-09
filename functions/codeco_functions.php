<?php
//////////////////////////////CCIS-BILBAO_SICSA-VALENCIA (CMA) ///////////////////////////////////////
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
////////////////////////////////////INICIO GATE IN /////////////////////////////////////////////
function codeco_ccis_sicsa_gatein(
  $id_entrada,
  $fecha_movimiento,
  $contenedores_codeco,
  $tipo_vehiculo,
  $trip_number,
  $empresa_transportista,
  $id_vehiculo,
  $daño_averia
) {
  $railsider_model = new railsider_model();

  foreach ($contenedores_codeco as $contenedor_codeco) {
    $num_contenedor = $contenedor_codeco['num_contenedor'];
    $id_tipo_contenedor_iso = $contenedor_codeco['id_tipo_contenedor_iso'];
    $estado_carga = $contenedor_codeco['estado_carga'];
    $import_export = $contenedor_codeco['import_export'];
    $num_booking = $contenedor_codeco['num_booking_contenedor'];
    $num_precinto = $contenedor_codeco['num_precinto_contenedor'];
    $peso_bruto = $contenedor_codeco['peso_bruto_contenedor'];

    if ($num_contenedor != 'CTXU3374480' && $num_contenedor != 'CTXU3374541') {
      //Insertar CODECO en BBDD
      $id_codeco = $railsider_model->insert_codeco_entrada($id_entrada, $num_contenedor, $_SESSION['email']);

      $sender_id = 'ESMJVRRAI';
      $receiver_id = 'CMA';
      $locode_murcia = 'ESMJV';
      $date = date_create($fecha_movimiento);
      $fecha_codeco = date_format($date, "Ymd:Hi");
      $fecha_codeco2 = date_format($date, "YmdHi");
      $numero_contenedores = 1; //1 contenedor por CODECO

      //tipo_vehiculo: 31 for truck and 25 for rail express
      if ($tipo_vehiculo == 31) { //CAMIÓN
        $tipo_movimiento_codeco = 34; //Transport Truck Equipment Gate In Report
        //[34] Transport Truck Equipment Gate In Report
        //[36] Transport Truck Equipment Gate Out Report
        //[44] Transport Rail Equipment Gate In Report
        //[46] Transport Rail Equipment Gate Out Report
        $modo_transporte = 3; //3 for road and 2 for rail
        $transport_stage = 1; //1 Inland transport (camion) and 20 main-carriage transport (tren)
      } else if ($tipo_vehiculo == 25) { //TREN
        $tipo_movimiento_codeco = 44; //Transport rail Equipment Gate In Report
        //[34] Transport Truck Equipment Gate In Report
        //[36] Transport Truck Equipment Gate Out Report
        //[44] Transport Rail Equipment Gate In Report
        //[46] Transport Rail Equipment Gate Out Report
        $modo_transporte = 2; //3 for road and 2 for rail
        $transport_stage = 20; //1 Inland transport (camion) and 20 main-carriage transport (tren)
      }

      $codeco_array = array();

      ///////UNB/////////
      //Metemos variable sender_id, receiver_id, fecha_codeco y id_codeco
      $codeco_array[] = "UNB+UNOA:2+" . $sender_id . "+" . $receiver_id . "+" . $fecha_codeco . "+" . $id_codeco . "'";

      ///////UNH/////////
      //Metemos variable id_codeco
      $codeco_array[] = "UNH+" . $id_codeco . "+CODECO:D:95B:UN'";

      ///////BGM/////////
      //Cambiamos variable tipo_movimiento_codeco e id_codeco
      $codeco_array[] = "BGM+" . $tipo_movimiento_codeco . "+" . $id_codeco . "+9'";

      ///////NAD/////////
      $codeco_array[] = "NAD+MS+" . $sender_id . "'";
      //$codeco_array[] = "NAD+CF+CHIW'"; //Revisar o quitar
      $codeco_array[] = "NAD+MR+" . $receiver_id . "'";

      ///////EQD/////////
      //Cambiamos variable num_contenedor, id_tipo_contenedor_iso, import_export y estado_carga
      $codeco_array[] = "EQD+CN+" . $num_contenedor . "+" . $id_tipo_contenedor_iso . ":102:5++" . $import_export . "+" . $estado_carga . "'";

      ///////RFF/////////
      if (($estado_carga == 5) && $num_booking != '') { //Contenedor LLeno
        $codeco_array[] = "RFF+BN:" . $num_booking . "'";
        //$codeco_array[] = "SEL+".$num_precinto."+CA'";
      }

      ///////DTM/////////
      //Cambiamos variable fecha_codeco2
      $codeco_array[] = "DTM+7:" . $fecha_codeco2 . ":203'";

      ///////LOC/////////
      $codeco_array[] = "LOC+165+" . $locode_murcia . ":139:6+ESMJVRRAI'";

      ///////MEA/////////
      //Cambiamos variable peso_bruto en KG
      $codeco_array[] = "MEA+AAE+G+KGM:" . $peso_bruto . "'";

      ///////SEL/////////
      if (($estado_carga == 5) && $num_booking != '') { ////Contenedor LLeno
        $codeco_array[] = "SEL+" . $num_precinto . "+CA'";
      }

      ///////DAM///////// Contenedor dañado
      if ($daño_averia == 1) {
        $codeco_array[] = "DAM+1'";
        //When a hole appears:
        //	DAM+1+HO:ZZZ::holed+IN:ZZZ::floor panel'
        //When the Reefer container experiences damage in the refrigerator equipment:
        //	DAM+1+SH:ZZZ::reefer pti failure+MN:ZZZ::refrigerator equipment'
        //When the container has a dent:
        //	DAM+1+DT:ZZZ::dent+EN:ZZZ::right panel'
      }

      ///////TDT/////////
      //$codeco_array[] = "TDT+".$transport_stage."+".$trip_number."+".$modo_transporte."+".$tipo_vehiculo."+".$empresa_transportista."+++".$id_vehiculo.":172'";
      $empresa_transportista_sin_caracteres = substr(str_replace(array(',', '.', '-', 'Á', 'É', 'Í', 'Ó', 'Ú', ' ', 'Ñ'), array('', '', '', 'A', 'E', 'I', 'O', 'U', '', 'N'), $empresa_transportista), 0, 16);
      $codeco_array[] = "TDT+" . $transport_stage . "+" . $trip_number . "+" . $modo_transporte . "+" . $tipo_vehiculo . "+" . $empresa_transportista_sin_caracteres . "+++" . $id_vehiculo . ":172'";


      ///////CNT/////////
      $codeco_array[] = "CNT+16:" . $numero_contenedores . "'";

      ///////UNT/////////
      $num_lineas_codeco = count($codeco_array);
      $codeco_array[] = "UNT+" . $num_lineas_codeco . "+" . $id_codeco . "'";

      ///////UNZ/////////
      $codeco_array[] = "UNZ+1+" . $id_codeco . "'";

      //Guardamos fichero de CODECO
      $fecha_insert = date_format($date, "Y-m-d_H:i");
      //$codeco_file_name = "../tmp/codeco_".$id_codeco."_".$fecha_insert.".txt";
      $codeco_file_name = '../tmp/CODECO_' . $id_codeco . '_' . $num_contenedor . '_' . date_format(date_create($fecha_movimiento), "Y-m-d") . '.txt';
      //Convertimos array a cadena texto con saltos de linea
      $txt_codeco = "";
      $txt_codeco = implode("\n", $codeco_array);
      file_put_contents($codeco_file_name, $txt_codeco);

      //UPDATE TXT CODECO en BBDD
      $railsider_model->update_codeco_txt($id_codeco, $txt_codeco);

      $contenedores_codeco_email[] = array(
        'num_contenedor' => $num_contenedor,
        'codeco_file_name' => $codeco_file_name,
        'id_codeco' => $id_codeco
      );
    } //fin if generadores


  } //fin foreach

  //funcion envio CODECOs
  codeco_envio_ccis_sicsa($contenedores_codeco_email, $fecha_movimiento);

  return $id_codeco;
}
//////////////////////////////////// FIN GATE IN /////////////////////////////////////////////

////////////////////////////////////INICIO GATE OUT /////////////////////////////////////////////
function codeco_ccis_sicsa_gateout(
  $id_salida,
  $fecha_movimiento,
  $contenedores_codeco,
  $puerto_origen_destino,
  $tipo_vehiculo,
  $trip_number,
  $empresa_transportista,
  $id_vehiculo
) {
  $railsider_model = new railsider_model();

  foreach ($contenedores_codeco as $contenedor_codeco) {
    $num_contenedor = $contenedor_codeco['num_contenedor'];
    $id_tipo_contenedor_iso = $contenedor_codeco['id_tipo_contenedor_iso'];
    $estado_carga = $contenedor_codeco['estado_carga'];
    $import_export = $contenedor_codeco['import_export'];
    $num_booking = $contenedor_codeco['num_booking_contenedor'];
    $num_precinto = $contenedor_codeco['num_precinto_contenedor'];
    $peso_bruto = $contenedor_codeco['peso_bruto_contenedor'];

    if ($num_contenedor != 'CTXU3374480' && $num_contenedor != 'CTXU3374541') {
      //Insertar CODECO en BBDD
      $id_codeco = $railsider_model->insert_codeco_salida($id_salida, $num_contenedor, $_SESSION['email']);

      $sender_id = 'ESMJVRRAI';
      $receiver_id = 'CMA';
      $locode_murcia = 'ESMJV';
      $date = date_create($fecha_movimiento);
      $fecha_codeco = date_format($date, "Ymd:Hi");
      $fecha_codeco2 = date_format($date, "YmdHi");
      $numero_contenedores = 1; //1 contenedor por CODECO

      //tipo_vehiculo: 31 for truck and 25 for rail express
      if ($tipo_vehiculo == 31) { //CAMIÓN
        $tipo_movimiento_codeco = 36; //Transport Truck Equipment Gate In Report
        //[34] Transport Truck Equipment Gate In Report
        //[36] Transport Truck Equipment Gate Out Report
        //[44] Transport Rail Equipment Gate In Report
        //[46] Transport Rail Equipment Gate Out Report
        $modo_transporte = 3; //3 for road and 2 for rail
        $transport_stage = 1; //1 Inland transport (camion) and 20 main-carriage transport (tren)
      } else if ($tipo_vehiculo == 25) { //TREN
        $tipo_movimiento_codeco = 46; //Transport Truck Equipment Gate In Report
        //[34] Transport Truck Equipment Gate In Report
        //[36] Transport Truck Equipment Gate Out Report
        //[44] Transport Rail Equipment Gate In Report
        //[46] Transport Rail Equipment Gate Out Report
        $modo_transporte = 2; //3 for road and 2 for rail
        $transport_stage = 20; //1 Inland transport (camion) and 20 main-carriage transport (tren)
      }

      $codeco_array = array();

      ///////UNB/////////
      //Metemos variable sender_id, receiver_id, fecha_codeco y id_codeco
      $codeco_array[] = "UNB+UNOA:2+" . $sender_id . "+" . $receiver_id . "+" . $fecha_codeco . "+" . $id_codeco . "'";

      ///////UNH/////////
      //Metemos variable id_codeco
      $codeco_array[] = "UNH+" . $id_codeco . "+CODECO:D:95B:UN'";

      ///////BGM/////////
      //Cambiamos variable tipo_movimiento_codeco e id_codeco
      $codeco_array[] = "BGM+" . $tipo_movimiento_codeco . "+" . $id_codeco . "+9'";

      ///////NAD/////////
      $codeco_array[] = "NAD+MS+" . $sender_id . "'";
      //$codeco_array[] = "NAD+CF+CHIW'"; //Revisar o quitar
      $codeco_array[] = "NAD+MR+" . $receiver_id . "'";

      ///////EQD/////////
      //Cambiamos variable num_contenedor, id_tipo_contenedor_iso, import_export y estado_carga
      $codeco_array[] = "EQD+CN+" . $num_contenedor . "+" . $id_tipo_contenedor_iso . ":102:5++" . $import_export . "+" . $estado_carga . "'";

      ///////RFF/////////
      if (($estado_carga == 5) && $num_booking != '') { //Contenedor LLeno
        $codeco_array[] = "RFF+BN:" . $num_booking . "'";
      }

      ///////DTM/////////
      //Cambiamos variable fecha_codeco2
      $codeco_array[] = "DTM+7:" . $fecha_codeco2 . ":203'";

      ///////LOC/////////
      $codeco_array[] = "LOC+165+" . $locode_murcia . ":139:6+ESMJVRRAI'";

      ///////LOC/////////
      if ($import_export == 3) { //Import
        $codeco_array[] = "LOC+11+" . $puerto_origen_destino . ":139:6'"; //Port of discharge BILBAO (ESBIO) o VALENCIA (ESVLC)
      } else if ($import_export == 2) { //Export
        $codeco_array[] = "LOC+9+" . $puerto_origen_destino . ":139:6'"; //Port of discharge BILBAO (ESBIO) o VALENCIA (ESVLC)
      }

      ///////MEA/////////
      //Cambiamos variable peso_bruto en KG
      $codeco_array[] = "MEA+AAE+G+KGM:" . $peso_bruto . "'";

      ///////SEL/////////
      if (($estado_carga == 5) && $num_booking != '') { //Contenedor LLeno
        $codeco_array[] = "SEL+" . $num_precinto . "+CA'";
      }

      ///////DAM///////// Contenedor dañado
      //When a hole appears:
      //	DAM+1+HO:ZZZ::holed+IN:ZZZ::floor panel'
      //When the Reefer container experiences damage in the refrigerator equipment:
      //	DAM+1+SH:ZZZ::reefer pti failure+MN:ZZZ::refrigerator equipment'
      //When the container has a dent:
      //	DAM+1+DT:ZZZ::dent+EN:ZZZ::right panel'

      ///////TDT/////////
      //$codeco_array[] = "TDT+".$transport_stage."+".$trip_number."+".$modo_transporte."+".$tipo_vehiculo."+".$empresa_transportista."+++".$id_vehiculo.":172'";
      $empresa_transportista_sin_caracteres = substr(str_replace(array(',', '.', '-', 'Á', 'É', 'Í', 'Ó', 'Ú', ' ', 'Ñ'), array('', '', '', 'A', 'E', 'I', 'O', 'U', '', 'N'), $empresa_transportista), 0, 16);
      $codeco_array[] = "TDT+" . $transport_stage . "+" . $trip_number . "+" . $modo_transporte . "+" . $tipo_vehiculo . "+" . $empresa_transportista_sin_caracteres . "+++" . $id_vehiculo . ":172'";

      ///////CNT/////////
      $codeco_array[] = "CNT+16:" . $numero_contenedores . "'";

      ///////UNT/////////
      $num_lineas_codeco = count($codeco_array);
      $codeco_array[] = "UNT+" . $num_lineas_codeco . "+" . $id_codeco . "'";

      ///////UNZ/////////
      $codeco_array[] = "UNZ+1+" . $id_codeco . "'";

      //Guardamos fichero de CODECO
      $fecha_insert = date_format($date, "Y-m-d_H:i");
      $codeco_file_name = '../tmp/CODECO_' . $id_codeco . '_' . $num_contenedor . '_' . date_format(date_create($fecha_movimiento), "Y-m-d") . '.txt';
      //Convertimos array a cadena texto con saltos de linea
      $txt_codeco = "";
      $txt_codeco = implode("\n", $codeco_array);
      file_put_contents($codeco_file_name, $txt_codeco);

      //UPDATE TXT CODECO en BBDD
      $railsider_model->update_codeco_txt($id_codeco, $txt_codeco);

      $contenedores_codeco_email[] = array(
        'num_contenedor' => $num_contenedor,
        'codeco_file_name' => $codeco_file_name,
        'id_codeco' => $id_codeco
      );
    } //fin if generadores
  } //Fin foreach

  //funcion envio CODECOs
  codeco_envio_ccis_sicsa($contenedores_codeco_email, $fecha_movimiento);

  return $id_codeco;
}
////////////////////////////////////FIN GATE OUT /////////////////////////////////////////////

////////////////////////////// ENVIAR CORREO ///////////////////////////////////////
function codeco_envio_ccis_sicsa($contenedores_codeco_email, $fecha_movimiento)
{
  $railsider_model = new railsider_model();
  ////////////// ENVIO DE EMAIL //////////////
  //$email = 'j.ferrer@maritimasureste.com';
  $email = 'enriqueandresvaleroguillen@gmail.com'; //e.valero@maritimasureste.com
  $email_cc = 'enriqueandres1997@hotmail.com'; //j.ferrer@maritimasureste.com

  ////////////// TEST //////////////
  //$email = 'app.esbuat@edi.cma-cgm.com';
  //$email_cc = 'SSC.Spainequip@cma-cgm.com';

  ////////////// PRODUCTION //////////////
  //$email = 'app.editr@edi.cma-cgm.com';
  //$email_cc = 'SSC.Spainequip@cma-cgm.com';
  //receiver_id => email_envio@edi.cma-cgm.com
  //CMA => app.editr@edi.cma-cgm.com
  //CNC	=> app.cnc@edi.cma-cgm.com
  //ANL	=> app.anl@edi.cma-cgm.com
  //APL	=> app.apl@edi.cma-cgm.com

  $body = '';
  $subject = 'CODECO ';
  $codeco_files = array();
  $ids_codecos = array();

  foreach ($contenedores_codeco_email as $contenedor_codeco_email) {
    $num_contenedor = $contenedor_codeco_email['num_contenedor'];
    $codeco_files[] = $contenedor_codeco_email['codeco_file_name'];
    $id_codeco = $contenedor_codeco_email['id_codeco'];
    $ids_codecos[] = $id_codeco;
    $body = $body . 'CODECO ' . $id_codeco . ' ' . $num_contenedor . ' ' . date_format(date_create($fecha_movimiento), "Y-m-d") . '<br/>';
    $subject = $subject . ' ' . $id_codeco . ', ';
  }

  $subject = $subject . ' ' . date_format(date_create($fecha_movimiento), "Y-m-d");
  $adjuntos = $codeco_files;

  //$error_email = send_email_office_365($subject, $email, $email_cc, $body, $adjuntos);
  $error_email = send_email_gmail($subject, $email, $email_cc, $body, $adjuntos);
  if ($error_email != '') {
    //echo 'Message could not be sent.<br>';
    //echo 'Mailer Error: ' . $error_email;
    $check_envio = 0;
    $error_envio = $error_email;
    foreach ($ids_codecos as $id_codeco) {
      $railsider_model->update_codeco_envio($id_codeco, $check_envio, $error_envio);
    }
  } else {
    //echo 'Message has been sent';
    $check_envio = 1;
    $error_envio = null;
    foreach ($ids_codecos as $id_codeco) {
      $railsider_model->update_codeco_envio($id_codeco, $check_envio, $error_envio);
    }
  }

  foreach ($adjuntos as $adjunto) {
    unlink($adjunto);
  }
}
////////////////////////////// FIN ENVIAR CORREO ///////////////////////////////////////

////////////////////////////// REENVIAR CODECO ///////////////////////////////////////
function reenvio_codeco($id_codeco)
{
  $railsider_model = new railsider_model();
  $codeco_list = $railsider_model->get_codeco_por_id_codeco($id_codeco);
  //echo "<pre>";
  //print_r($codeco_line);
  //echo "</pre>";

  //obtener txt_codeco
  foreach ($codeco_list as $codeco_line) {
    $txt_codeco = $codeco_line['txt_codeco'];
    $fecha_insert = $codeco_line['fecha_insert'];
    $num_contenedor = $codeco_line['num_contenedor'];
  }

  //guardar txt_codeco en fichero texto
  $codeco_file_name = '../tmp/CODECO_' . $id_codeco . '_' . $num_contenedor . '_' . date_format(date_create($fecha_insert), "Y-m-d") . '.txt';
  file_put_contents($codeco_file_name, $txt_codeco);

  ////////////// REENVIO DE EMAIL //////////////
  $email = 'enriqueandresvaleroguillen@gmail.com';
  $email_cc = 'enriqueandres1997@hotmail.com';
  ////////////// PRODUCTION //////////////
  //$email = 'app.editr@edi.cma-cgm.com';
  //$email_cc = 'SSC.Spainequip@cma-cgm.com';

  $subject = 'REENVIO CODECO ' . $id_codeco . ', ' . date_format(date_create($fecha_insert), "Y-m-d");
  $adjunto[] = $codeco_file_name;
  $body = 'REENVIO CODECO ' . $id_codeco . ' ' . $num_contenedor . ' ' . date_format(date_create($fecha_insert), "Y-m-d") . '<br/>';

  //$error_email = send_email_office_365($subject, $email, $email_cc, $body, $adjunto);
  $error_email = send_email_gmail($subject, $email, $email_cc, $body, $adjunto);
  if ($error_email != '') {
    //echo 'Message could not be sent.<br>';
    //echo 'Mailer Error: ' . $error_email;
    $check_envio = 0;
    $error_envio = $error_email;
    $railsider_model->update_codeco_envio($id_codeco, $check_envio, $error_envio);
  } else {
    //echo 'Message has been sent';
    $check_envio = 1;
    $error_envio = null;
    $railsider_model->update_codeco_envio($id_codeco, $check_envio, $error_envio);
  }

  foreach ($adjunto as $adjunto) {
    unlink($adjunto);
  }
  return $check_envio;
}
////////////////////////////// FIN REENVIAR CODECO ///////////////////////////////////////



////////////////////////////// INICIO MARCAR CODECO CON INCIDENCIA ///////////////////////////////////////
function codeco_failure_damage($id_codeco, $id_parte_trabajo)
{
  $railsider_model = new railsider_model();
  $codeco_list = $railsider_model->update_codeco_incidencia($id_codeco, $id_parte_trabajo);
}
////////////////////////////// FIN MARCAR CODECO CON INCIDENCIA ///////////////////////////////////////

////////////////////////////// FIN CCIS-BILBAO_SICSA-VALENCIA (CMA) ///////////////////////////////////////
