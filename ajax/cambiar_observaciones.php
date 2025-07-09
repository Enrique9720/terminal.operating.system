<?php
session_start();

// Cargamos el modelo
require_once("../models/railsider_model.php");

// Cargamos las funciones PHP
require_once("../functions/functions.php");

// Comprobamos que el usuario está logeado
check_logged_user();

// Establecer la respuesta por defecto
$response = array('success' => false, 'message' => '');

// Comprobar si la solicitud es POST y contiene los datos necesarios
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Instanciamos el objeto para el modelo
    $railsider_model = new railsider_model();

    // Obtener los datos de la solicitud
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['id']) && isset($data['type'])) {
        // Sanitizar los datos recibidos
        $id = intval($data['id']);
        $type = htmlspecialchars($data['type'], ENT_QUOTES, 'UTF-8');

        $success = false;

        // Llamar a la función del modelo según el tipo recibido
        if ($type == 'entrada' && isset($data['observaciones'])) {
            $observaciones = htmlspecialchars($data['observaciones'], ENT_QUOTES, 'UTF-8');
            $success = $railsider_model->update_campo_observaciones_entrada_camion($id, $observaciones);
        } elseif ($type == 'salida' && isset($data['observaciones'])) {
            $observaciones = htmlspecialchars($data['observaciones'], ENT_QUOTES, 'UTF-8');
            $success = $railsider_model->update_campo_observaciones_salida_camion($id, $observaciones);
        } elseif ($type == 'incidencia' && isset($data['observaciones'])) {
            $observaciones = htmlspecialchars($data['observaciones'], ENT_QUOTES, 'UTF-8');
            $success = $railsider_model->update_campo_observaciones_incidencia($id, $observaciones);
        } elseif ($type == 'incidencia' && isset($data['estado'])) {
            $estado_incidencia = htmlspecialchars($data['estado'], ENT_QUOTES, 'UTF-8');
            $success = $railsider_model->update_campo_estado_incidencia($id, $estado_incidencia);
        }
        
        if ($success) {
            // Si la actualización es exitosa, establecer la respuesta como exitosa
            $response['success'] = true;
            $response['message'] = 'Actualización realizada correctamente';
        } else {
            // Si la actualización falla, establecer un mensaje de error
            $response['message'] = 'Error al realizar la actualización';
        }
    } else {
        // Si los datos están incompletos, establecer un mensaje de error
        $response['message'] = 'Datos incompletos';
    }
} else {
    // Si la solicitud no es POST, establecer un mensaje de error
    $response['message'] = 'Solicitud inválida';
}

// Devolver la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);
?>