<?php
session_start();

// Cargar modelos y funciones
require_once("../models/railsider_model.php");
require_once("../functions/functions.php");

// Comprobar si el usuario está logueado
check_logged_user();

// Verificar si el parámetro está presente
if (isset($_POST['num_cont_1'])) {
    $num_contenedor = htmlspecialchars(trim($_POST['num_cont_1']));

    try {
        // Instanciar el modelo
        $railsider_model = new railsider_model();
        $contenedor_list = $railsider_model->get_contenedor($num_contenedor);

        if (!empty($contenedor_list)) {
            // Crear la respuesta JSON
            $data = array_map(function ($value) {
                return [
                    'id' => $value['num_contenedor'],
                    'id_tipo_contenedor_iso' => $value['id_tipo_contenedor_iso'],
                    'longitud_tipo_contenedor' => $value['longitud_tipo_contenedor'],
                    'descripcion_tipo_contenedor' => $value['descripcion_tipo_contenedor'],
                    'tara_contenedor' => $value['tara_contenedor'],
                    'cif_propietario_actual' => $value['cif_propietario_actual'],
                    'nombre_comercial_propietario' => $value['nombre_comercial_propietario'],
                    'id_tipo_mercancia_actual_contenedor' => $value['id_tipo_mercancia_actual_contenedor'],
                    'descripcion_mercancia' => $value['descripcion_mercancia'],
                    'id_destinatario_actual' => $value['id_destinatario_actual'],
                    'nombre_destinatario' => $value['nombre_destinatario'],
                    'peso_bruto_actual_contenedor' => $value['peso_bruto_actual_contenedor'],
                    'peso_mercancia_actual_contenedor' => $value['peso_mercancia_actual_contenedor'],
                    'num_booking_actual_contenedor' => $value['num_booking_actual_contenedor'],
                    'num_precinto_actual_contenedor' => $value['num_precinto_actual_contenedor'],
                    'temperatura_actual_contenedor' => $value['temperatura_actual_contenedor'],
                    'codigo_estacion_ferrocarril_actual_contenedor' => $value['codigo_estacion_ferrocarril_actual_contenedor'],
                    'num_peligro_adr_actual_contenedor' => $value['num_peligro_adr_actual_contenedor'],
                    'num_onu_adr_actual_contenedor' => $value['num_onu_adr_actual_contenedor'],
                    'num_clase_adr_actual_contenedor' => $value['num_clase_adr_actual_contenedor'],
                    'cod_grupo_embalaje_adr_actual_contenedor' => $value['cod_grupo_embalaje_adr_actual_contenedor'],
                    'estado_carga_contenedor' => $value['estado_carga_contenedor'],
                    'text' => 'Hay resultados'
                ];
            }, $contenedor_list);
        } else {
            // No hay resultados
            $data = [['id' => $num_contenedor, 'text' => 'No hay resultados']];
        }

        // Responder con JSON
        echo json_encode($data);
    } catch (Exception $e) {
        echo json_encode(['error' => 'Ocurrió un error: ' . $e->getMessage()]);
    }
} else {
    // Parámetro no recibido
    echo json_encode(['error' => 'Parámetro num_cont_1 faltante']);
}
