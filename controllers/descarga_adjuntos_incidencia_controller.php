<?php
//////////////////////////////////////////////////////////////////
session_start();

// Load the code to connect to the WordPress database
require_once("../models/conexion_db.php");

// Load common PHP functions for all apps
require_once("../functions/functions.php");

// Load the model that interacts with the 'clientes' table
require_once("../models/railsider_model.php");

// Check if the user is logged in
check_logged_user();

/////////////////////////////////////////////////////////////////////////////////////

if (isset($_GET['id_incidencia'])) {

  $id_incidencia = $_GET['id_incidencia'];

  $railsider_model = new railsider_model();

  // Fetch the incident details
  $incidencia_list = $railsider_model->get_incidencia($id_incidencia);
  $num_incidencia = $incidencia_list[0]['num_incidencia'];
  $num_incidencia = str_replace("/", "_", $num_incidencia);

  // Fetch the files associated with the incident
  $ficheros_list = $railsider_model->get_ficheros_por_id_fichero_por_id_evento($id_incidencia);

  // Check if there are any files to download
  if (!empty($ficheros_list)) {
    $zipArchive = new ZipArchive();
    $zipFileName = "ADJUNTOS_INCIDENCIA_" . $num_incidencia . ".zip";
    $zipFile = "../uploads/incidencias_eventos/" . $id_incidencia . "/" . $zipFileName;

    // Open the ZIP file for creation
    if ($zipArchive->open($zipFile, ZipArchive::CREATE) === TRUE) {
      // Add each file to the ZIP archive
      foreach ($ficheros_list as $ficheros_line) {
        $zipArchive->addFile($ficheros_line['ruta_fichero'], $ficheros_line['nombre_fichero']);
      }

      // Close the ZIP archive
      $zipArchive->close();

      // Set the headers to force the download of the ZIP file
      header("Content-type: application/zip");
      header("Content-Disposition: attachment; filename=$zipFileName");
      header("Content-length: " . filesize($zipFile));
      header("Pragma: no-cache");
      header("Expires: 0");

      // Output the ZIP file to the browser
      readfile($zipFile);

      // Delete the ZIP file after download
      unlink($zipFile);
    } else {
      echo "<script>alert('Error: No se pudo crear el archivo ZIP.');</script>";
    }
  } else {
    echo "<script>alert('Error: No hay archivos disponibles para descargar.');</script>";
  }
} else {
  echo "<script>alert('Error: No se ha proporcionado un ID de incidencia válido.');</script>";
}
