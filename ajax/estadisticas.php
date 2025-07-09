<?php
//iniciamos la sesion
session_start();
//cargamos el modelo con la clase que interactua con la tabla clientes
require_once("../models/railsider_model.php");
//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");
require_once("../functions/estadisticas_functions.js");
//comprobamos que el usuario esta logeado
check_logged_user();

if (isset($_POST['like'])) {
    $like = strip_tags(trim($_POST['like']));
    //echo $like;

    $railsider_model = new railsider_model();

    //obtenemos el numero de contenedores total por año
    $num_contenedores = $railsider_model->get_contenedores_total($year);

    if (count($num_contenedores) > 0) {
        foreach ($num_contenedores as $key => $value) {
            $año = $value['año'];
            $num_contenedor_camion_por_mes = $value['num_contenedor_camion_por_año'];
            $num_contenedor_vagon_por_mes = $value['num_contenedor_vagon_por_año'];
            $total_contenedores_por_año = $value['total_contenedores_por_año'];
        }

        $data = array(
            'id' => $like,
            'num_contenedor_camion_por_año' => $num_contenedor_camion_por_año,
            'num_contenedor_vagon_por_año' => $num_contenedor_vagon_por_año,
            'total_contenedores_por_año' => $total_contenedores_por_año,
            'text' => 'Hay resultados'
        );
    } else {
        $data[] = array('id' => $num_onu_adr, 'text' => 'No hay resultados');
    }

    //Devolvemos el objeto JSON
    echo json_encode($data);
}
