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

$railsider_model = new railsider_model();
//echo "<pre>";
//print_r($_POST);
//echo "</pre>";

//$get_incidencias_total = $railsider_model->get_incidencias_total();
//echo "<pre>";
//print_r($get_incidencias_total);
//echo "</pre>";

$date_incidencia = $_POST['fecha_incidencia'];
$hora_incidencia = $_POST['hora_incidencia'];
$id_tipo_incidencia = $_POST['id_tipo_incidencia'];
$observaciones = $_POST['observaciones'];

$fecha_incidencia = $date_incidencia . " " . $hora_incidencia;

$id_incidencia = $_POST['id_incidencia'];
$num_incidencia = $_POST['num_incidencia'];
$num_contenedor = $_POST['num_contenedor'];
$estado_carga_contenedor = $_POST['estado_carga_contenedor'];
$cif_propietario = $_POST['cif_propietario'];
$id_entrada = $_POST['id_entrada'];
$id_transbordo = $_POST['id_transbordo'];

$estado_incidencia = 'ABIERTA';

//obtener serie del año segun la fecha de incidencia
$fecha_serie = strtotime($date_incidencia);
$year_serie = date("y", $fecha_serie);
//echo $year_serie;

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

  if ($id_tipo_incidencia == 1) { //AVERÍA REEFER
    $id_entrada_num_contenedor = $_POST['id_entrada_num_contenedor'];
    $id_entrada = explode("-", $_POST['id_entrada_num_contenedor'])[0];
    $num_contenedor = explode("-", $_POST['id_entrada_num_contenedor'])[1];

    $entrada_list = $railsider_model->get_entrada_por_id($id_entrada);
    $tipo_entrada = $entrada_list[0]['tipo_entrada'];

    if ($tipo_entrada == 'CAMIÓN') {
      $entrada_camion_list = $railsider_model->get_entrada_tipo_camion_por_id_entrada_por_num_contenedor2($id_entrada, $num_contenedor);
      //echo "<pre>";
      //print_r($entrada_tren_list);
      //echo "</pre>";

      $estado_carga_contenedor = $entrada_camion_list[0]['estado_carga_contenedor'];
      $id_entrada = $entrada_camion_list[0]['id_entrada'];
      $fecha_entrada = $entrada_camion_list[0]['fecha_entrada'];
      $cif_propietario = $entrada_camion_list[0]['cif_propietario'];
      $id_salida = $entrada_camion_list[0]['id_salida'];
    } else if ($tipo_entrada == 'TREN') {
      $entrada_tren_list = $railsider_model->get_entrada_tipo_tren_por_id_entrada_por_num_contenedor2($id_entrada, $num_contenedor);
      //echo "<pre>";
      //print_r($entrada_tren_list);
      //echo "</pre>";

      $estado_carga_contenedor = $entrada_tren_list[0]['estado_carga_contenedor'];
      $id_entrada = $entrada_tren_list[0]['id_entrada'];
      $fecha_entrada = $entrada_tren_list[0]['fecha_entrada'];
      $cif_propietario = $entrada_tren_list[0]['cif_propietario'];
      $id_salida = $entrada_tren_list[0]['id_salida'];
    }

    //$id_salida = null;
    $id_transbordo = null;

    //TABLA INCIDENCIA CONTENEDOR
    $incidencia_contenedor = $railsider_model->insert_incidencia_contenedor(
      $id_incidencia,
      $num_contenedor,
      $estado_carga_contenedor,
      $cif_propietario,
      $id_entrada,
      $id_salida,
      $id_transbordo
    );

  } else if ($id_tipo_incidencia == 2) { //RETRASO CAMIÓN ENTRADA
    //TABLA INCIDENCIA ENTRADA
    $incidencia_entrada = $railsider_model->insert_incidencia_entrada($id_incidencia, $id_entrada);
  } else if ($id_tipo_incidencia == 3) { //DAÑO UTI
    $id_entrada_num_contenedor = $_POST['id_entrada_num_contenedor'];
    $id_entrada = explode("-", $_POST['id_entrada_num_contenedor'])[0];
    $num_contenedor = explode("-", $_POST['id_entrada_num_contenedor'])[1];

    $entrada_list = $railsider_model->get_entrada_por_id($id_entrada);
    $tipo_entrada = $entrada_list[0]['tipo_entrada'];

    if ($tipo_entrada == 'CAMIÓN') {
      $entrada_camion_list = $railsider_model->get_entrada_tipo_camion_por_id_entrada_por_num_contenedor2($id_entrada, $num_contenedor);

      $estado_carga_contenedor = $entrada_camion_list[0]['estado_carga_contenedor'];
      $id_entrada = $entrada_camion_list[0]['id_entrada'];
      $fecha_entrada = $entrada_camion_list[0]['fecha_entrada'];
      $cif_propietario = $entrada_camion_list[0]['cif_propietario'];
      $id_salida = $entrada_camion_list[0]['id_salida'];
    } else if ($tipo_entrada == 'TREN') {
      $entrada_tren_list = $railsider_model->get_entrada_tipo_tren_por_id_entrada_por_num_contenedor2($id_entrada, $num_contenedor);

      $estado_carga_contenedor = $entrada_tren_list[0]['estado_carga_contenedor'];
      $id_entrada = $entrada_tren_list[0]['id_entrada'];
      $fecha_entrada = $entrada_tren_list[0]['fecha_entrada'];
      $cif_propietario = $entrada_tren_list[0]['cif_propietario'];
      $id_salida = $entrada_tren_list[0]['id_salida'];
    }

    //$id_salida = null;
    $id_transbordo = null;

    //TABLA INCIDENCIA CONTENEDOR
    $incidencia_contenedor = $railsider_model->insert_incidencia_contenedor(
      $id_incidencia,
      $num_contenedor,
      $estado_carga_contenedor,
      $cif_propietario,
      $id_entrada,
      $id_salida,
      $id_transbordo
    );
  } else if ($id_tipo_incidencia == 4) { //FRENADO TREN
    $id_salida = $_POST['id_salida'];

    $salida_tren_list_ = $railsider_model->get_salida_tipo_tren_por_id_salida2($id_salida);
    $num_expedicion_salida = $salida_tren_list_[0]['num_expedicion'];
    $fecha_salida = $salida_tren_list_[0]['fecha_salida'];
    $tipo_salida = $salida_tren_list_[0]['tipo_salida'];
    $nombre_comercial_propietario = $salida_tren_list_[0]['nombre_comercial_propietario'];

    //TABLA INCIDENCIA SALIDA
    $incidencia_salida = $railsider_model->insert_incidencia_salida($id_incidencia, $id_salida);
  } else if ($id_tipo_incidencia == 5) { //RETRASO TREN
    //TABLA INCIDENCIA ENTRADA
    $incidencia_entrada = $railsider_model->insert_incidencia_entrada($id_incidencia, $id_entrada);

  } else if ($id_tipo_incidencia == 6) { //ESTANCIA M.M.P.P
    $id_salida_num_contenedor = $_POST['id_salida_num_contenedor'];
    $id_salida = explode("-", $_POST['id_salida_num_contenedor'])[0];
    $num_contenedor = explode("-", $_POST['id_salida_num_contenedor'])[1];

    $salida_list = $railsider_model->get_salida_por_id($id_salida);
    $tipo_salida = $salida_list[0]['tipo_salida'];

    $estado_carga_contenedor = null;

    if ($tipo_salida == 'CAMIÓN') {
      $salida_camion_list = $railsider_model->get_salida_tipo_camion_por_id_salida_por_num_contenedor2($id_salida, $num_contenedor);
      //echo "<pre>"; print_r($salida_camion_list); echo "</pre>";

      $estado_carga_contenedor = $salida_camion_list[0]['estado_carga_contenedor'];
      $cif_propietario = $salida_camion_list[0]['cif_propietario_actual'];
      $id_entrada = $salida_camion_list[0]['id_entrada'];
    } else if ($tipo_salida == 'TREN') {
      $salida_tren_list = $railsider_model->get_salida_tipo_tren_por_id_salida_por_num_contenedor2($id_salida, $num_contenedor);
      //echo "<pre>"; print_r($salida_tren_list); echo "</pre>";

      $estado_carga_contenedor = $salida_tren_list[0]['estado_carga_contenedor'];
      $cif_propietario = $salida_tren_list[0]['cif_propietario_actual'];
      $id_entrada = $salida_tren_list[0]['id_entrada'];
    }

    $id_transbordo = null;

    //TABLA INCIDENCIA CONTENEDOR
    $incidencia_contenedor = $railsider_model->insert_incidencia_contenedor(
      $id_incidencia,
      $num_contenedor,
      $estado_carga_contenedor,
      $cif_propietario,
      $id_entrada,
      $id_salida,
      $id_transbordo
    );
  } else if ($id_tipo_incidencia == 7) { //OTRO
    //TABLA INCIDENCIA SALIDA
    //$incidencia_salida = $railsider_model->insert_incidencia_salida($id_incidencia, $id_salida);
  } else {
    echo "ERROR";
  }
} else { //else count incidencia_list
  echo "ERROR SERIE";
}


//creamos JSON
$data = array(
  'id_incidencia' => $id_incidencia,
  'num_contenedor' => $num_contenedor,
  'status' => 'success',
  'text_fichero' => $text_fichero,
  'incidencia_entrada' => $incidencia_entrada,
  'incidencia_salida' => $incidencia_salida,
  'incidencia_contenedor' => $incidencia_contenedor
);

//Devolvemos el objeto JSON
echo json_encode($data);
