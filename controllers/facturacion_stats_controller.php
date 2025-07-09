<?php
/////////////////////////////////////////////////////////////////////////////////////
// Iniciar la sesión
session_start();

// Cargar funciones comunes
require_once("../functions/functions.php");

// Verificar que el usuario esté logueado
check_logged_user();

/////////////////////////////////////////////////////////////////////////////////////
// CARGA DE MODELOS
require_once("../models/railsider_model.php");

$railsider_model = new railsider_model();

// Inicializar variables
$cliente_datos = [];
$years_disponibles = [];
$datos_area_chart = [
    'manipulacion_utis'      => [],  
    'almacenaje'             => [],
    'conexionado_electrico'  => [],
    'control_temperatura'    => [],
    'limpieza'               => [],
    'horas_extras'           => [],
    'maniobra_terminal'      => [],
    'maniobra_generadores'   => [],
    'servicios_especiales'   => []   
];

// Obtener todos los clientes y años disponibles
$cliente_datos = $railsider_model->get_cliente();
$years_disponibles = $railsider_model->get_years_disponibles();

$cliente_seleccionado = '';
$year_seleccionado = '';

// Se comprueba si se recibió el formulario (recordar que se agregó name="submit" en el botón)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Recuperar datos del formulario
    $cliente_seleccionado = $_POST['nombre_comercial_cliente'] ?? '';
    $year_seleccionado = $_POST['year'] ?? '';
    
    if (!empty($cliente_seleccionado) && !empty($year_seleccionado)) {
        // Obtener ID del cliente basado en el nombre comercial
        $cliente_data = $railsider_model->get_cliente_por_nombre_comercial($cliente_seleccionado);
        if (!empty($cliente_data)) {
            $id_cliente = $cliente_data[0]['id_cliente'];
            $cif_cliente = $cliente_data[0]['cif_cliente'];            

            // Obtener la facturación del cliente para el año seleccionado
            $facturacion = $railsider_model->get_facturacion_by_year_by_cliente($year_seleccionado, $id_cliente);
            foreach ($facturacion as $facturacion_line) {
                // Se itera sobre cada clave para armar los datos para los gráficos
                foreach ($datos_area_chart as $key => &$chart_data) {
                    $importe_key = 'importe_' . $key; // Por ejemplo: 'importe_manipulacion_utis'
                    if (isset($facturacion_line[$importe_key])) {
                        $chart_data[] = [
                            'año_mes' => $facturacion_line['fecha_año_mes'],
                            'importe' => $facturacion_line[$importe_key]
                        ];
                    }
                }
            }
        }
    }    
}

// Cargar la vista
require_once('../views/facturacion_stats_view.php');
