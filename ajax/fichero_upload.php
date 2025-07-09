<?php

session_start();

// cargamos el modelo con la clase que interactúa con la tabla clientes
require_once("../models/railsider_model.php");
// cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");
// comprobamos que el usuario está logeado
check_logged_user();

if (isset($_FILES["fichero_upload"])) {

  $fileName = basename($_FILES["fichero_upload"]["name"]); // Obtener el nombre del archivo
  $fileType = pathinfo($_FILES["fichero_upload"]["name"], PATHINFO_EXTENSION); // Obtener la extensión del archivo
  $fileType = strtolower($fileType); // Convertir a minúsculas
  $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf', 'xls', 'xlsx');
  $id_tipo_fichero = $_POST['id_tipo_fichero_upload'];
  $railsider_model = new railsider_model();

  if ($_POST['id_entrada_upload'] != '') {

    $uploadFolder = "../uploads/entradas/";
    $id_entrada = $_POST['id_entrada_upload'];
    $tipo_movimiento = 'entrada';
    $ruta_fichero = $uploadFolder . $id_entrada . "-" . $fileName;

    $tipo_fichero_entrada_list = $railsider_model->existe_tipo_fichero_entrada($id_entrada, $id_tipo_fichero);

    if (count($tipo_fichero_entrada_list) == 0) { // tipo fichero no existe en entrada
      if (in_array($fileType, $allowTypes)) {
        if (move_uploaded_file($_FILES["fichero_upload"]["tmp_name"], $ruta_fichero)) {
          $id_fichero = $railsider_model->insert_fichero($ruta_fichero, $_SESSION['email'], $id_tipo_fichero);
          $entradas_list = $railsider_model->insert_entrada_fichero($id_entrada, $id_fichero);
          $text = "<span class='label label-success'><b>$fileName</b> Upload Successfully</span>";
          $status = "success";
        } else {
          $text = "<span class='label label-danger'><b>$fileName</b> Upload Failed. Try Again.</span>";
          $status = "error";
        }
      } else {
        $text = "<span class='label label-danger'>Upload Failed. <b>$fileType</b> Not allowed.</span>";
        $status = "error";
      }
    } else {
      $text = "<span class='label label-danger'>Upload Failed. <b>$fileType</b> Ya existe el tipo fichero en esta entrada.</span>";
      $status = "error";
    }
  } else if ($_POST['id_salida_upload'] != '') {

    $uploadFolder = "../uploads/salidas/";
    $id_salida = $_POST['id_salida_upload'];
    $tipo_movimiento = 'salida';
    $ruta_fichero = $uploadFolder . $id_salida . "-" . $fileName;

    $tipo_fichero_salida_list = $railsider_model->existe_tipo_fichero_salida($id_salida, $id_tipo_fichero);

    if (count($tipo_fichero_salida_list) == 0) {
      if (in_array($fileType, $allowTypes)) {
        if (move_uploaded_file($_FILES["fichero_upload"]["tmp_name"], $ruta_fichero)) {
          $id_fichero = $railsider_model->insert_fichero($ruta_fichero, $_SESSION['email'], $id_tipo_fichero);
          $salidas_list = $railsider_model->insert_salida_fichero($id_salida, $id_fichero);
          $text = "<span class='label label-success'><b>$fileName</b> Upload Successfully</span>";
          $status = "success";
        } else {
          $text = "<span class='label label-danger'><b>$fileName</b> Upload Failed. Try Again.</span>";
          $status = "error";
        }
      } else {
        $text = "<span class='label label-danger'>Upload Failed. <b>$fileType</b> Not allowed.</span>";
        $status = "error";
      }
    } else {
      $text = "<span class='label label-danger'>Upload Failed. <b>$fileType</b> Ya existe el tipo fichero en esta salida.</span>";
      $status = "error";
    }
  } 
}

// obtener los datos del fichero por su id, para comprobar que se ha insertado correctamente
if (isset($id_fichero) && $id_fichero !== null) {
  $ficheros_list = $railsider_model->get_fichero($id_fichero);

  if ((count($ficheros_list) > 0) && file_exists($ruta_fichero)) { // si existe el registro del fichero y se encuentra el fichero en su ruta
    foreach ($ficheros_list as $key => $value) {
      $id_fichero = $value['id_fichero'];
      $ruta_fichero = $value['ruta_fichero'];
      $extension = $value['extension'];
      $id_tipo_fichero = $value['id_tipo_fichero'];
      $tipo_fichero = $value['tipo_fichero'];
    }
  }
} else {
  $ficheros_list = array();
  error_log("Error: id_fichero es null o no está definido");
}

$data = array(
  'id' => $id_fichero,
  'ruta_fichero' => $ruta_fichero,
  'extension' => $extension,
  'id_tipo_fichero' => $id_tipo_fichero,
  'tipo_fichero' => $tipo_fichero,
  'tipo_movimiento' => $tipo_movimiento,
  'status' => $status,
  'text' => $text
);
// Devolvemos el objeto JSON
echo json_encode($data);
