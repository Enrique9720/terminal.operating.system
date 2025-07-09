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
//print_r($_GET);
//echo "</pre>";

//INCIDENCIAS AUTOMÁTICAS DE AVERÍA REEFER(1) Y DAÑO UTI(3)
function incidencia_averia($num_contenedor, $estado_carga_contenedor, $cif_propietario, $fecha_parte_trabajo, $hora_parte_trabajo, $railsider_model)
{
  $fecha_incidencia = $fecha_parte_trabajo . " " . $hora_parte_trabajo;
  $id_tipo_incidencia = 1; //la incidencia es de tipo AVERIA REEFER
  $estado_incidencia = 'ABIERTA';
  $observaciones = '';

  //obtener serie del año segun la fecha de incidencia
  $fecha_serie = strtotime($fecha_parte_trabajo);
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

    $control_stock_list = $railsider_model->get_contenedor_historico($num_contenedor);
    foreach ($control_stock_list as $control_stock_line) {
      if ($control_stock_line['id_salida'] == NULL) {
        $id_entrada = $control_stock_line['id_entrada'];
        $id_salida = $control_stock_line['id_salida'];
      }
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
  }
}

function incidencia_daño_uti($num_contenedor, $estado_carga_contenedor, $cif_propietario, $fecha_parte_trabajo, $hora_parte_trabajo, $railsider_model)
{

  $fecha_incidencia = $fecha_parte_trabajo . " " . $hora_parte_trabajo;
  $id_tipo_incidencia = 3; //la incidencia es de tipo DAÑO UTI
  $estado_incidencia = 'ABIERTA';
  $observaciones = '';

  //obtener serie del año segun la fecha de incidencia
  $fecha_serie = strtotime($fecha_parte_trabajo);
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

    $control_stock_list = $railsider_model->get_contenedor_historico($num_contenedor);
    foreach ($control_stock_list as $control_stock_line) {
      if ($control_stock_line['id_salida'] == NULL) {
        $id_entrada = $control_stock_line['id_entrada'];
        $id_salida = $control_stock_line['id_salida'];
      }
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
  }
}
/////////////////////////////////////////////////////////////////////////////////////

$railsider_model = new railsider_model();

//obtener tipos de trabajos desde BBDD
$tipos_trabajos_list = $railsider_model->get_tipos_trabajos();
//echo "<pre>";
//print_r($tipos_trabajos_list);
//echo "</pre>";

//obtener tipos de trabajos desde BBDD
$tipos_incidencias_list = $railsider_model->get_tipos_incidencias();
//echo "<pre>";
//print_r($tipos_incidencias_list);
//echo "</pre>";

//sacamos fecha y hora y hacemos datetime
$num_contenedor = $_POST['num_cont_1'];
$fecha_parte_trabajo = $_POST['fecha_parte_trabajo'];
$hora_parte_trabajo = $_POST['hora_parte_trabajo'];
$fecha_parte_trabajo = $fecha_parte_trabajo . " " . $hora_parte_trabajo;
$observaciones = $_POST['observaciones'];

$contenedor_list = $railsider_model->get_contenedor($num_contenedor);
$cif_propietario = $contenedor_list[0]['cif_propietario_actual'];
$estado_carga_contenedor = $contenedor_list[0]['estado_carga_contenedor'];

//TABLA PARTE_TABAJO
$id_parte_trabajo = $railsider_model->insert_parte_trabajo(
  $fecha_parte_trabajo,
  $num_contenedor,
  $cif_propietario,
  $_SESSION['email'],
  $observaciones
);

//TABLA LINEA_PARTE_TRABAJO
foreach ($tipos_trabajos_list as $tipos_trabajos_line) {
  if (isset($_POST[$tipos_trabajos_line['tipo_trabajo']])) {
    $id_tipo_trabajo = $_POST[$tipos_trabajos_line['tipo_trabajo']];
    //echo $id_tipo_trabajo."<br>";
    $railsider_model->insert_linea_parte_trabajo(
      $id_parte_trabajo,
      $id_tipo_trabajo
    );
  }
}

//TABLA LINEA_PARTE_TRABAJO INCIDENCIAS
foreach ($tipos_incidencias_list as $tipos_incidencias_line) {
  if (isset($_POST[$tipos_incidencias_line['tipo_trabajo']])) {
    $id_tipo_trabajo = $_POST[$tipos_incidencias_line['tipo_trabajo']];
    if ($id_tipo_trabajo == 3 || $id_tipo_trabajo == 4) { //si la incidencia es averia o dañado
      $railsider_model->contenedor_incidencia(
        $num_contenedor,
        $id_parte_trabajo
      );
    }
    $railsider_model->insert_linea_parte_trabajo(
      $id_parte_trabajo,
      $id_tipo_trabajo
    );
  }
}

/////////INCIENCIA
try {
  if (isset($_POST['AVERÍA'])) {
    incidencia_averia($num_contenedor, $estado_carga_contenedor, $cif_propietario, $fecha_parte_trabajo, $hora_parte_trabajo, $railsider_model);
  }

  if (isset($_POST['DAÑADO'])) {
    incidencia_daño_uti($num_contenedor, $estado_carga_contenedor, $cif_propietario, $fecha_parte_trabajo, $hora_parte_trabajo, $railsider_model);
  }
} catch (Exception $e) {
  //echo 'Excepción capturada: ' . $e->getMessage() . "\n";
}
/////////INCIENCIA



//Envio de CODECO si el contenedor esta dañado o averiado
if (isset($_POST['AVERÍA']) || isset($_POST['DAÑADO'])) {
  //marcamos que este CODECO va a tener averia o daño
  $daño_averia = 1;
  $control_stock_list = $railsider_model->contenedor_en_stock($num_contenedor);
  //Sacamos datos del contenedor
  $id_tipo_contenedor_iso = $control_stock_list[0]['id_tipo_contenedor_iso'];
  //sacar datos del propietario del contenedor
  $cif_propietario_actual = $control_stock_list[0]['cif_propietario_actual'];
  //sacar datos de la ultima entrada
  $id_entrada = $control_stock_list[0]['id_entrada'];
  $entrada_list = $railsider_model->get_entrada_por_id($id_entrada);
  $tipo_entrada = $entrada_list[0]['tipo_entrada'];
  $fecha_movimiento = $fecha_parte_trabajo;

  if ($tipo_entrada == 'CAMIÓN') {

    $tipo_vehiculo = 31; //31 for truck and 25 for rail express
    $entrada_camion_list = $railsider_model->get_entrada_tipo_camion_por_id_entrada_por_num_contenedor($id_entrada, $num_contenedor);

    $estado_carga_contenedor = $entrada_camion_list[0]['estado_carga_contenedor'];
    $num_booking_contenedor = $entrada_camion_list[0]['num_booking_contenedor'];
    $num_precinto_contenedor = $entrada_camion_list[0]['num_precinto_contenedor'];
    $peso_bruto_contenedor = $entrada_camion_list[0]['peso_bruto_contenedor'];
    $cif_empresa_transportista = $entrada_camion_list[0]['cif_empresa_transportista'];
    $empresa_transportista_list = $railsider_model->get_empresa_transportista_por_cif($cif_empresa_transportista);
    $empresa_transportista = $empresa_transportista_list[0]['nombre_empresa_transportista'];
    $trip_number = "";
    $id_vehiculo = $entrada_camion_list[0]['matricula_tractora'];
    if ($estado_carga_contenedor == 'C') { //SI ENTRADA CAMION CARGADO => EXPORT => 2
      $import_export = 2; //3 for import and 2 for export
      $estado_carga = 5; //5 for full and 4 for empty
    } else if ($estado_carga_contenedor == 'V') { //SI ENTRADA CAMION VACIO => IMPORT => 3
      $import_export = 3; //3 for import and 2 for export
      $estado_carga = 4; //5 for full and 4 for empty
    }
  } else if ($tipo_entrada == 'TREN') {
    $tipo_vehiculo = 25; //31 for truck and 25 for rail express
    $entrada_tren_list = $railsider_model->get_entrada_tipo_tren_por_id_entrada_por_num_contenedor($id_entrada, $num_contenedor);

    $estado_carga_contenedor = $entrada_tren_list[0]['estado_carga_contenedor'];
    $num_booking_contenedor = null;
    $num_precinto_contenedor = null;
    $peso_bruto_contenedor = $entrada_tren_list[0]['peso_bruto_contenedor'];
    $empresa_transportista = 'RENFE MERCANCIAS SME SA';
    $trip_number = $entrada_tren_list[0]['num_expedicion'];;
    $id_vehiculo = explode('-', $trip_number)[0];
    if ($estado_carga_contenedor == 'C') { //SI ENTRADA TREN CARGADO => IMPORT => 3
      $import_export = 3; //3 for import and 2 for export
      $estado_carga = 5; //5 for full and 4 for empty
    } else if ($estado_carga_contenedor == 'V') { //SI ENTRADA TREN VACIO => EXPORT => 2
      $import_export = 2; //3 for import and 2 for export
      $estado_carga = 4; //5 for full and 4 for empty
    }
  } else if ($tipo_entrada == 'TRASPASO') {
    //$tipo_vehiculo = ;
    //$entrada_traspaso_list = $railsider_model->get_entrada_tipo_traspaso_por_id_entrada_por_num_contenedor($id_entrada, $num_contenedor);

    //a partir del id_entrada, sacamos su id_traspaso
    //a partir del id_traspaso, sacamos su id_salida
    //a partir del id_salida sacamos el id_entrada anterior al traspaso
  }

  $contenedores_codeco[] = array(
    'num_contenedor' => $num_contenedor,
    'id_tipo_contenedor_iso' => $id_tipo_contenedor_iso,
    'estado_carga' => $estado_carga,
    'import_export' => $import_export,
    'num_booking_contenedor' => $num_booking_contenedor,
    'num_precinto_contenedor' => $num_precinto_contenedor,
    'peso_bruto_contenedor' => $peso_bruto_contenedor
  );


  //Si el propietario es CCIS-BILBAO o SICSA-VALENCIA
  if (($cif_propietario_actual == 'A60389624') || ($cif_propietario_actual == 'A96764097')) {
    //Rehacer y enviar nuevo CODECO indicando daño y nueva fecha
    $id_codeco = codeco_ccis_sicsa_gatein(
      $id_entrada,
      $fecha_movimiento,
      $contenedores_codeco,
      $tipo_vehiculo,
      $trip_number,
      $empresa_transportista,
      $id_vehiculo,
      $daño_averia
    );
    //El Codeco que acabamos de insertar es un Codeco con averia o daño
    //Por lo que marcamos ese codeco con su parte de trabajo con dicho daño o averia
    codeco_failure_damage($id_codeco, $id_parte_trabajo);
  }
}

//subir ficheros
if ($_FILES['files']['error'][0] != 4) {

  //echo "<pre>";
  //print_r($_FILES);
  //echo "</pre>";

  //ponemos ruta relativa para el directorio donde iran las fotos de cada contenedor
  $directorio = "../uploads/fotos/" . $num_contenedor;
  //si el directorio no existe, lo creamos
  if (!file_exists($directorio)) {
    mkdir($directorio, 0777, true);
  }

  $text_fichero = array();
  //por cada fichero
  $total_count = count($_FILES['files']['name']);
  for ($i = 0; $i < $total_count; $i++) {
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
    $fileType = strtolower(pathinfo($_FILES["files"]["name"][$i], PATHINFO_EXTENSION)); #Get File Extension

    //Nombre con el formato establecido para el fichero a subir
    $filename = $num_contenedor . "-parte-" . $id_parte_trabajo . "-" . $i;

    $filename_original = $_FILES["files"]["name"][$i];
    // Choose where to save the uploaded file
    $url = $directorio . "/" . $filename . "." . $fileType;
    $text_fichero[$i]['file'] = $filename_original;

    if (in_array($fileType, $allowTypes)) {

      // Save the uploaded file to the local filesystem
      if (move_uploaded_file($_FILES['files']['tmp_name'][$i], $url)) {
        //insertamos el registro en la tabla
        $id_tipo_fichero = 1; //FOTOS
        $id_fichero = $railsider_model->insert_fichero($url, $_SESSION['email'], $id_tipo_fichero);
        //insertamos la relacion en la tabla entradas_ficheros
        $railsider_model->insert_fichero_parte_trabajo($id_parte_trabajo, $id_fichero);
        $text_fichero[$i]['text'] = "<span class='label label-success'><b>$filename_original</b> Upload Successfully</span><br/>";
      } else {
        $text_fichero[$i]['text'] = "<span class='label label-danger'><b>$filename_original</b> Upload Failed. Try Again.</span><br/>";
      }
    } else {
      $text_fichero[$i]['text'] = "<span class='label label-danger'>Upload Failed. <b>$fileType</b> Not allowed.</span><br/>";
    }

    //obtener los datos del fichero por su id, para comprobar que se ha insertado correctamente
    $ficheros_list = $railsider_model->get_fichero($id_fichero);

    if ((count($ficheros_list) > 0) && file_exists($url)) { //si existe el registro del fichero y se encuentra en fichero en su ruta
      foreach ($ficheros_list as $key => $value) {
        $id_fichero = $value['id_fichero'];
        $ruta_fichero = $value['ruta_fichero'];
      }
    }

    $text_fichero[$i]['id_fichero'] = $id_fichero;
    $text_fichero[$i]['ruta_fichero'] = $ruta_fichero;
  }
}

//creamos JSON
$data = array(
  'num_contenedor' => $num_contenedor,
  'id_parte_trabajo' => $id_parte_trabajo,
  'status' => 'success',
  'text_fichero' => $text_fichero
);

//Devolvemos el objeto JSON
echo json_encode($data);
