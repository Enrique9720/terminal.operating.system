<?php

session_start();

//cargamos el modelo con la clase que interactua con la tabla
require_once("../models/railsider_model.php");
//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");
//comprobamos que el usuario esta logeado
check_logged_user();
//echo "<pre>";
//print_r($_FILES);
//echo "</pre>";

// Compruebe si se envió el formulario y si se cargó un archivo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fichero_upload'])) {
	// Establecer encabezados de respuesta
	header('Content-Type: application/json');

	// Inicializar variables
	$uploadFolder = "../uploads/incidencias_eventos/"; // Directorio donde se guardarán los archivos
	$id_tipo_fichero = 6;
	$railsider_model = new railsider_model();
	$tipo_movimiento = 'evento';

	// Comprueba si se proporciona el ID del evento
	if (isset($_POST['id_evento_upload']) && $_POST['id_evento_upload'] != '') {
		$id_evento = $_POST['id_evento_upload'];

		// Obtener la información del archivo cargado
		$file = $_FILES['fichero_upload'];
		$fileName = basename($file['name']);
		$fileTmpName = $file['tmp_name'];
		$fileSize = $file['size'];
		$fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
		$fileError = $file['error'];

		// Tipos de archivo permitidos
		$allowedTypes = ['jpg', 'png', 'jpeg', 'svg', 'gif', 'pdf', 'xls', 'xlsx', 'doc', 'docx', 'txt', 'rtf'];

		// Compruebe si el tipo de archivo ya existe para el evento
		$tipo_fichero_evento_list = $railsider_model->existe_tipo_fichero_incidencia_evento($id_evento, $id_tipo_fichero);

		if (count($tipo_fichero_evento_list) == 0) { // El tipo de archivo no existe para el evento.

			// Validar el tipo de archivo
			if (in_array($fileType, $allowedTypes)) {

				// Comprobar errores de carga de archivos
				if ($fileError !== UPLOAD_ERR_OK) {
					echo json_encode(['status' => 'error', 'text' => 'Error uploading the file.']);
					exit;
				}

				// Limite el tamaño del archivo a 5 MB
				if ($fileSize > 5 * 1024 * 1024) {
					echo json_encode(['status' => 'error', 'text' => 'File size exceeds the 5MB limit.']);
					exit;
				}

				// Genere una ruta de archivo única para el almacenamiento
				$ruta_fichero = $uploadFolder . uniqid($id_evento . '-', true) . '.' . $fileType;

				// Mover el archivo al directorio de destino
				if (move_uploaded_file($fileTmpName, $ruta_fichero)) {
					// Insertar información del archivo en la base de datos.
					$id_fichero = $railsider_model->insert_fichero($ruta_fichero, $_SESSION['email'], $id_tipo_fichero);
					$incidencia_evento_list = $railsider_model->insert_incidencia_evento_fichero($id_evento, $id_fichero);

					// Preparar respuesta de éxito
					$text = "<span class='label label-success'><b>$fileName</b> uploaded successfully.</span>";
					$status = "success";
				} else {
					// Preparar la respuesta de error para el error de movimiento
					$text = "<span class='label label-danger'><b>$fileName</b> upload failed. Try again.</span>";
					$status = "error";
				}
			} else {
				// Preparar respuesta de error para tipo de archivo no válido
				$text = "<span class='label label-danger'>Upload failed. <b>$fileType</b> not allowed.</span>";
				$status = "error";
			}
		} else {
			// Preparar respuesta de error para el tipo de archivo existente
			$text = "<span class='label label-danger'>Upload failed. <b>$fileType</b> already exists for this event.</span>";
			$status = "error";
		}

		// Compruebe si el archivo se insertó correctamente
		if (isset($id_fichero) && $id_fichero != null) {
			$ficheros_list = $railsider_model->get_fichero($id_fichero);

			// Validar la existencia del archivo y registrarlo en la base de datos.
			if ((count($ficheros_list) > 0) && file_exists($ruta_fichero)) {
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
			error_log("Error: id_fichero is null or not defined");
		}

		// Prepare response data
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

		// Return JSON response
		echo json_encode($data);
	} else {
		// Prepare error response for missing event ID
		echo json_encode(['status' => 'error', 'text' => 'Event ID is missing.']);
	}
} else {
	// Prepare error response for no file uploaded
	echo json_encode(['status' => 'error', 'text' => 'No file uploaded or invalid request.']);
}










/*
////////////////////////////////////////////////////////////////
//echo "<pre>";
//print_r($_POST);
//echo "</pre>";

if (isset($_FILES["fichero_upload"])) {

	$fileName = basename($_FILES["fichero_upload"]["name"]); // Obtener el nombre del archivo
	$fileType = pathinfo($_FILES["fichero_upload"]["name"], PATHINFO_EXTENSION); // Obtener la extensión del archivo
	$fileType = strtolower($fileType); // Convertir a minúsculas
	$allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf', 'xls', 'xlsx');
	//$id_tipo_fichero = $_POST['id_tipo_fichero_upload'];
	$id_tipo_fichero = 6;
	$railsider_model = new railsider_model();

	if ($_POST['id_evento_upload'] != '') {

		$uploadFolder = "../uploads/incidencias_eventos/";
		$id_evento = $_POST['id_evento_upload'];
		$tipo_movimiento = 'evento';
		$ruta_fichero = $uploadFolder . $id_evento . "-" . $fileName;
		$tipo_fichero_evento_list = $railsider_model->existe_tipo_fichero_incidencia_evento($id_evento, $id_tipo_fichero);

		if (count($tipo_fichero_evento_list) == 0) { // tipo fichero no existe en entrada
			if (in_array($fileType, $allowTypes)) {
				if (move_uploaded_file($_FILES["fichero_upload"]["tmp_name"], $ruta_fichero)) {
					$id_fichero = $railsider_model->insert_fichero($ruta_fichero, $_SESSION['email'], $id_tipo_fichero);
					echo $id_fichero . 'asdf';
					$incidencia_evento_list = $railsider_model->insert_incidencia_evento_fichero($id_evento, $id_fichero);
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
	}
}

// obtener los datos del fichero por su id, para comprobar que se ha insertado correctamente
if (isset($id_fichero) && $id_fichero != null) {
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
*/




















/*
$id_fichero = strtoupper(strip_tags(trim($_POST['id_fichero'])));
//echo $id_fichero;

//instanciamos el modelo para acceso a la BBDD
$railsider_model = new railsider_model();

$id_tipo_fichero = 6; //6 = INCIDENCIA

//obtenemos los datos
$fichero_list = $railsider_model->get_fichero($id_fichero);
//echo "
//<pre>";
//print_r($fichero_list);
//echo "</pre>";

//si hay datos
if (count($fichero_list) > 0) {
	//add incidencias_fichero
	$railsider_model->insert_incidencia_evento_fichero($id_fichero, $id_evento);
	//add fichero
	$railsider_model->insert_fichero($ruta_fichero, $user_insert, $id_tipo_fichero);
}

///$fichero_list = null;
//obtenemos los doatos de un registro en concreto de la tabla desde la BBDD
$fichero_list = $railsider_model->get_fichero($id_fichero);


if (count($evento_list) > 0) {

	$data[] = array(
		'id_fichero' => $id_fichero,
		'text' => 'Hay resultados'
	);
} else {
	$data[] = array(
		'id_fichero' => $id_fichero,
		'text' => 'No hay resultados'
	);
}

//Devolvemos el objeto JSON
echo json_encode($data); */
