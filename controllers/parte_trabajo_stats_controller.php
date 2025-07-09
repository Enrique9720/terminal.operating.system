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
        // Obtenemos la lista de partes de trabajo para el año seleccionado
        $partes_trabajo_list = $railsider_model->get_partes_trabajo_parte_linea($year_seleccionado);

        // Definimos los tipos válidos de trabajo
        $valid_tipos = ['LIMPIEZA', 'PTI', 'AVERÍA', 'DAÑADO'];
        
        // Inicializamos un arreglo para contar cada tipo
        $totales_por_tipo = array_fill_keys($valid_tipos, 0);
        
        // Recorremos cada parte de trabajo obtenida
        foreach ($partes_trabajo_list as $row) {
            // Decodificamos el campo JSON con las líneas de parte
            $lineas = json_decode($row['lineas_parte'], true);
            if (is_array($lineas)) {
                foreach ($lineas as $linea) {
                    $tipo_trabajo = $linea['tipo_trabajo'] ?? null;
                    // Solo contamos si el tipo de trabajo es uno de los válidos
                    if (in_array($tipo_trabajo, $valid_tipos)) {
                        $totales_por_tipo[$tipo_trabajo]++;
                    }
                }
            }
        }
        
        // Armamos el arreglo para el gráfico Donut
        foreach ($totales_por_tipo as $tipo => $total) {
            $datos_donut_chart[] = array(
                'label' => $tipo,
                'value' => $total
            );
        }
    }
}

// Cargamos la vista
require_once('../views/parte_trabajo_stats_view.php');
