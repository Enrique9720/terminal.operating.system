<?php

/////////////////////////////////////////////////////////////////////////////////////
//Funcion para reindexar arrays
function reindex_array($array)
{
	foreach ($array as $k => $val) {
		if (is_array($val))
			$array[$k] = reindex_array($val); //recurse
	}
	return array_values($array);
}
///////////////////////////////////////////////////////////////////////////////////////////

function img2base64($url_image)
{
	$type = pathinfo($url_image, PATHINFO_EXTENSION);
	$data = file_get_contents($url_image);
	$dataUri = 'data:image/' . $type . ';base64,' . base64_encode($data);
	return $dataUri;
}
/////////////////////////////////////////////////////////////////////////////////////////
function check_logged_user()
{
	//comprobamos que el usuario esta logeado, si no lo mandamos al login
	if (!isset($_SESSION['email']) || $_SESSION['email'] == '') {
		header("Location: ../controllers/login_controller.php");
	}
}
//////////////////////////////////////////////////////////////////////////////////////
function php_alert_message($type, $message)
{

	if ($type == 'success') {
		$icon = 'fa fa-check fa-lg';
	} else if ($type == 'danger') {
		$icon = 'fa fa-exclamation-circle fa-lg';
	} else if ($type == 'warning') {
		$icon = 'fa fa-exclamation-triangle fa-lg';
	} else if ($type == 'info') {
		$icon = 'fa fa-info-circle fa-lg';
	}

	echo "<div class=\"alert alert-" . $type . " alert-dismissable fade in\">";
	echo "	<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>";
	echo "	<center>";
	echo "	<i class=\"fa " . $icon . "\" aria-hidden=\"true\"></i> " . $message . "";
	echo "	</center>";
	echo "</div>";
}

function fecha_convert($fecha_YYYY_MM_DD)
{
	$fecha_array = explode("-", $fecha_YYYY_MM_DD);
	$fecha_DD_MM_YYYY = $fecha_array[2] . "-" . $fecha_array[1] . "-" . $fecha_array[0];
	return $fecha_DD_MM_YYYY;
}


/////////////////////////////////////////////////////////////////////////////////////
function get_month_name($month_num)
{
	switch ($month_num) {
		case 1:
			return "ENERO";
		case 2:
			return "FEBRERO";
		case 3:
			return "MARZO";
		case 4:
			return "ABRIL";
		case 5:
			return "MAYO";
		case 6:
			return "JUNIO";
		case 7:
			return "JULIO";
		case 8:
			return "AGOSTO";
		case 9:
			return "SEPTIEMBRE";
		case 10:
			return "OCTUBRE";
		case 11:
			return "NOVIEMBRE";
		case 12:
			return "DICIEMBRE";
		default:
			return "";
	}
}

/////////////////////////////////////////////////////////////////////////////////////
/*function getRangeDate($date_ini, $date_end, $format) {

    $dt_ini = DateTime::createFromFormat($format, $date_ini);
    $dt_end = DateTime::createFromFormat($format, $date_end);
    $period = new DatePeriod(
        $dt_ini,
        new DateInterval('P1D'),
        $dt_end,
    );
    $range = [];
    foreach ($period as $date) {
        $range[] = $date->format($format);
    }
    $range[] = $date_end;
    return $range;
}*/

// Función para obtener el rango de fechas
function getRangeDate($fecha_inicio, $fecha_fin, $formato = 'Y-m-d')
{
	$periodo = new DatePeriod(
		new DateTime($fecha_inicio),
		new DateInterval('P1D'),
		(new DateTime($fecha_fin))->modify('+1 day') // Asegurar que la fecha de fin es inclusiva
	);

	$fechas = [];
	foreach ($periodo as $fecha) {
		$fechas[] = $fecha->format($formato);
	}
	return $fechas;
}
/////////////////////////////////////////////////////////////////////////////////////

function send_email($subject, $email, $body, $adjuntos)
{

	$mail = new PHPMailer\PHPMailer\PHPMailer;
	$mail->isSMTP();                                    // Set mailer to use SMTP
	$mail->Host = 'smtp.serviciodecorreo.es';           // Specify main and backup SMTP servers
	$mail->Port = 465;
	$mail->SMTPAuth = true;                             // Enable SMTP authentication
	$mail->Username = 'info@maritimasureste.com';                // SMTP username
	$mail->Password = 'EkZDsvZ5mp7sZ_@';                      // SMTP password
	$mail->SMTPSecure = 'ssl';                          // Enable encryption, 'ssl' or 'tls'
	$mail->From = 'info@maritimasureste.com';                    //Sender email
	$mail->FromName = 'Grupo Maritima Sureste';                          //Sender Name (optional)
	$mail->addAddress($email);

	foreach ($adjuntos as $adjunto) {
		$mail->AddAttachment($adjunto);
	}

	//$mail->addAttachment($adjunto);         // Add attachments
	//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	$mail->isHTML(true);                                  // Set email format to HTML
	$mail->Subject = $subject;
	$mail->Body    = $body;
	$mail->send();

	return $mail->ErrorInfo;
}

function send_email_office_365($subject, $email, $email_cc, $body, $adjuntos)
{

	$mail = new PHPMailer\PHPMailer\PHPMailer;
	$mail->isSMTP();                                    // Set mailer to use SMTP
	$mail->Host = 'smtp.office365.com';           // Specify main and backup SMTP servers
	$mail->Port = 587;
	$mail->SMTPAuth = true;                             // Enable SMTP authentication
	$mail->Username = 'info@maritimasureste.com';                // SMTP username
	$mail->Password = 'VGBpx58LYfO13R2E@46';                      // SMTP password
	$mail->SMTPSecure = 'tls';                          // Enable encryption, 'ssl' or 'tls'
	$mail->From = 'info@maritimasureste.com';                    //Sender email
	$mail->FromName = 'Grupo Maritima Sureste';                          //Sender Name (optional)
	$mail->addAddress($email);
	$mail->AddCC($email_cc);

	foreach ($adjuntos as $adjunto) {
		$mail->AddAttachment($adjunto);
	}

	//$mail->addAttachment($adjunto);         // Add attachments
	//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	$mail->isHTML(true);                                  // Set email format to HTML
	$mail->Subject = $subject;
	$mail->Body    = $body;
	$mail->send();

	return $mail->ErrorInfo;
}


function send_email_gmail($subject, $email, $email_cc, $body, $adjuntos)
{
	$mail = new PHPMailer\PHPMailer\PHPMailer;
	$mail->isSMTP();
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 465;
	$mail->SMTPAuth = true;
	$mail->Username = 'enriqueprogramacion97@gmail.com';
	$mail->Password = 'gygo fisi tqhj ivbq';  // https://myaccount.google.com/apppasswords
	$mail->SMTPSecure = 'ssl';
	$mail->CharSet = 'UTF-8';
	$mail->Encoding = 'base64';

	$mail->From = 'enriqueprogramacion97@gmail.com';
	$mail->FromName = 'TFG Codeco';
	$mail->addAddress($email);

	foreach ($adjuntos as $adjunto) {
		$mail->addAttachment($adjunto);
	}

	$mail->isHTML(true);
	$mail->Subject = $subject;
	$mail->Body    = $body;

	if (!$mail->send()) {
		return 'Error al enviar: ' . $mail->ErrorInfo;
	} else {
		return 'Correo enviado correctamente.';
	}
}


/////////////////////////////////////////////////////////////////////////////////////
function upload_file_incidencia($id_incidencia, $id_evento, $files_array, $railsider_model)
{

	//SUBIDA FICHERO
	//subir ficheros
	if ($files_array['fichero_upload']['error'][0] != 4) {

		//ponemos ruta relativa para el directorio donde iran las fotos de cada contenedor
		$directorio = "../uploads/incidencias_eventos/" . $id_incidencia;
		//si el directorio no existe, lo creamos
		if (!file_exists($directorio)) {
			mkdir($directorio, 0777, true);
		}

		$text_fichero = array();
		//por cada fichero
		$total_count = count($files_array['fichero_upload']['name']);
		//echo $total_count;
		for ($i = 0; $i < $total_count; $i++) {

			$allowedTypes = ['xls', 'xlsx', 'eml', 'pdf', 'txt', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'gif', 'msg'];

			$fileType = strtolower(pathinfo($files_array["fichero_upload"]["name"][$i], PATHINFO_EXTENSION)); #Get File Extension
			//Nombre con el formato establecido para el fichero a subir
			$filename = $id_evento . "-" . $files_array["fichero_upload"]["name"][$i];

			$filename_original = $files_array["fichero_upload"]["name"][$i];
			// Choose where to save the uploaded file
			$url = $directorio . "/" . $filename/* . "." . $fileType*/;
			$text_fichero[$i]['file'] = $filename_original;

			if (in_array($fileType, $allowedTypes)) {

				// Save the uploaded file to the local filesystem
				if (move_uploaded_file($files_array['fichero_upload']['tmp_name'][$i], $url)) {
					//insertamos el registro en la tabla
					$id_tipo_fichero = 6; //INCIDENCIAS
					$id_fichero = $railsider_model->insert_fichero($url, $_SESSION['email'], $id_tipo_fichero);
					//insertamos la relacion en la tabla entradas_ficheros
					$railsider_model->insert_incidencia_evento_fichero($id_evento, $id_fichero);
					$text_fichero[$i]['text'] = "<span class='label label-success'><b>$filename_original</b> Upload Successfully</span><br/>";
					$text_fichero[$i]['status'] = "success";
				} else {
					$text_fichero[$i]['text'] = "<span class='label label-danger'><b>$filename_original</b> Upload Failed. Try Again.</span><br/>";
					$text_fichero[$i]['status'] = "error";
				}
			} else {
				$text_fichero[$i]['text'] = "<span class='label label-danger'>Upload Failed. <b>$fileType</b> Not allowed.</span><br/>";
				$text_fichero[$i]['status'] = "error";
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
	//FIN SUBIDA FICHERO


	return $text_fichero;
}
/////////////////////////////////////////////////////////////////////////////////////
// Validar fechas y calcular diferencia en días (sin cambios significativos aquí)
function calcular_diferencia_dias($fecha_entrada, $fecha_salida)
{
	if ($fecha_salida === null) {
		return null;
	}
	$fecha_entrada_obj = new DateTime($fecha_entrada);
	$fecha_salida_obj = new DateTime($fecha_salida);
	$intervalo = $fecha_salida_obj->diff($fecha_entrada_obj);
	return $intervalo->days;
}

/////////////////////////////////////////////////////////////////////////////////////