<?php
session_start();

// Cargamos funciones comunes y comprobamos que el usuario esté logueado
require_once("../functions/functions.php");
check_logged_user();

// Cargamos el modelo
require_once("../models/railsider_model.php");
$railsider_model = new railsider_model();

// Obtenemos los años disponibles (esto asume que ya tienes un método para ello)
$years_disponibles = $railsider_model->get_years_disponibles_incidencias();
$year_seleccionado = '';
$datos_donut_chart = array();

// Se comprueba si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $year_seleccionado = $_POST['year'] ?? '';
    if (!empty($year_seleccionado)) {
        // Obtenemos el número de incidencias agrupadas por tipo para el año seleccionado
        $incidencias_por_tipo = $railsider_model->get_incidencias_por_tipo($year_seleccionado);
        
        // Armamos el arreglo para el gráfico Donut
        foreach ($incidencias_por_tipo as $tipo) {
            $datos_donut_chart[] = array(
                'label' => $tipo['tipo_incidencia'],
                'value' => (int)$tipo['total']
            );
        }
    }
}

// Cargamos la vista
require_once('../views/incidencias_stats_view.php');