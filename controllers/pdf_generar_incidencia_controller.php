<?php

session_start();

// Cargar dependencias e inicializar conexiones
require_once "../models/conexion_db.php";
require_once "../functions/functions.php";
require_once "../models/railsider_model.php";
require_once '../assets/autoload.php';
require_once '../assets/dompdf/autoload.inc.php';

// Referencia al espacio de nombres Dompdf
use Dompdf\Dompdf;
use Dompdf\Options;

check_logged_user();
//echo "<pre>"; print_r($_GET); echo "</pre>";

if (isset($_GET["id_incidencia"])) {
    $action = $_GET['action'] ?? 'generate'; // Obtener la acción desde la URL

    // Desinfectar la entrada para evitar la inyección SQL
    $id_incidencia = filter_input(INPUT_GET, 'id_incidencia', FILTER_SANITIZE_NUMBER_INT) ?? null;
    if (!$id_incidencia) {
        echo "Error: Invalid Incident ID.";
        exit;
    }

    try {
        // Recoger y validar id_evento
        $id_evento = filter_input(INPUT_GET, 'id_evento', FILTER_SANITIZE_NUMBER_INT) ?? null;
    } catch (Exception $e) {
        if (!$id_evento) {
            echo "Error: Invalid Event ID.";
            exit;
        }
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }

    // Inicializa el modelo
    $railsider_model = new railsider_model();

    // Obtener detalles del incidente
    $incidencia = $railsider_model->get_incidencia($id_incidencia);
    if (!$incidencia) {
        echo "Error: Incident not found.";
        exit;
    }

    try {
        //$evento = $railsider_model->get_incidencia_eventos($id_incidencia);
        $evento = $railsider_model->get_ficheros_por_id_fichero_por_id_evento($id_incidencia);
    } catch (Exception $e) {
        if (!$evento) {
            echo "Error: Event not found.";
            exit;
        }
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }

    // Inicializar variables
    $num_incidencia = $incidencia[0]['num_incidencia'];
    $tipo_incidencia = $incidencia[0]['tipo_incidencia'];

    // Unificar diferentes tipos de incidencias
    $contenedor_data = [];
    $incident_specific_data = [];
    switch ($tipo_incidencia) {
        case 'AVERIA REEFER':
            $contenedor_data = $railsider_model->get_incidencia_contenedor($id_incidencia);
            $incident_specific_data = process_contenedor_data($contenedor_data);
            break;
        case 'DAÑO UTI':
            $contenedor_data = $railsider_model->get_incidencia_contenedor($id_incidencia);
            $incident_specific_data = process_contenedor_data($contenedor_data);
            break;
        case 'RETRASO CAMIÓN':
            $contenedor_data = $railsider_model->get_incidencia_retraso_camion($id_incidencia);
            $incident_specific_data = process_contenedor_data($contenedor_data);
            break;
        case 'FRENADO TREN':
            $contenedor_data = $railsider_model->get_incidencia_frenado($id_incidencia);
            $incident_specific_data = process_contenedor_data($contenedor_data);
            break;
        case 'RETRASO TREN':
            $contenedor_data = array_merge(
                $railsider_model->get_incidencia_retraso_tren($id_incidencia),
                $railsider_model->get_incidencia_retraso_tren_entrada($id_incidencia)
            );
            $incident_specific_data = process_contenedor_data($contenedor_data);
            break;
        case 'ESTANCIA M.M.P.P.':
            $contenedor_data = $railsider_model->get_incidencia_demora_mmpp2($id_incidencia);
            $incident_specific_data = process_contenedor_data($contenedor_data);
            break;
        case 'OTRO':
            $contenedor_data = $railsider_model->get_incidencia($id_incidencia);
            $incident_specific_data = process_contenedor_data($contenedor_data);
            break;
        default:
            echo "Error: Invalid Incident Type.";
            exit;
    }

    if (!$incident_specific_data) {
        echo "Error: No data available for this incident type.";
        exit;
    }

    // ReÃºne tipos de archivos
    $tipos_ficheros_list = $railsider_model->get_tipos_ficheros();
    $tipos_ficheros = array_column($tipos_ficheros_list, 'tipo_fichero', 'id_tipo_fichero');

    // ReÃºne archivos de eventos
    //$ficheros_evento = $railsider_model->get_ficheros_por_id_evento($id_evento);
    //$ficheros_nombres = array_column($ficheros_evento, 'nombre_fichero');

    // Preparar contenido HTML-PDF
    $html = generate_html_content_pdf($incidencia[0], $incident_specific_data, $evento);
    // Generar el PDF
    generate_pdf($html, "INFORME_INCIDENCIA_" . $num_incidencia . ".pdf");

    // Preparar contenido HTML-HTML
    $html = generate_html_content_html($incidencia[0], $incident_specific_data, $evento);
    // Generar el PDF
    generate_pdf($html, "INFORME_INCIDENCIA_" . $num_incidencia . ".pdf");

    /* // Genera el contenido HTML o PDF basado en la acción
    if ($action === 'generate') {
        // Generar el PDF
        $html = generate_html_content_pdf($incidencia[0], $incident_specific_data, $evento);
        generate_pdf($html, "INFORME_INCIDENCIA_" . $id_incidencia . ".pdf");

        // Mostrar el PDF al usuario
        header("Content-Type: application/pdf");
        header("Content-Disposition: inline; filename=INFORME_INCIDENCIA_" . $id_incidencia . ".pdf");
        readfile("INFORME_INCIDENCIA_" . $id_incidencia . ".pdf");
        exit;
    } elseif ($action === 'view') {
        // Generar el HTML para visualización
        $html = generate_html_content_html($incidencia[0], $incident_specific_data, $evento);

        // Muestra el HTML al usuario
        echo $html;
        exit;
    } else {
        die("Acción no válida.");
    } */
} else {
    echo "Error: No id_incidencia provided.";
}

/**
 * Función para procesar datos del contenedor.
 */

function process_contenedor_data($contenedor_data)
{
    if (empty($contenedor_data)) {
        return [];
    }

    $first_entry = $contenedor_data[0];

    // Translate estado_carga_contenedor
    $estado_carga_contenedor =
        $first_entry['estado_carga_contenedor'] === 'C' ? 'CARGADO' : ($first_entry['estado_carga_contenedor'] === 'V' ? 'VACÍO' : '');


    // Determine entrada/salida expedition numbers based on tipo_entrada/tipo_salida
    $expedicion_entrada_key = $first_entry['tipo_entrada'] === 'TREN' ? 'num_expedicion_entrada' : 'Entrada Camión';
    $expedicion_salida_key = $first_entry['tipo_salida'] === 'TREN' ? 'num_expedecion_salida' : 'Salida Camión';

    // Prepare the return array with the adapted keys
    $result = [
        'num_contenedor' => $first_entry['num_contenedor'],
        'estado_carga_contenedor' => $estado_carga_contenedor,
        $expedicion_entrada_key => $first_entry[$first_entry['tipo_entrada'] === 'TREN' ? 'num_expedicion_entrada' : 'id_entrada'],
        'fecha_entrada' => $first_entry['fecha_entrada'],
        'tipo_entrada' => $first_entry['tipo_entrada'],
        $expedicion_salida_key => $first_entry[$first_entry['tipo_salida'] === 'TREN' ? 'num_expedecion_salida' : 'id_salida'],
        'fecha_salida' => $first_entry['fecha_salida'],
        'tipo_salida' => $first_entry['tipo_salida'],
        'fecha_transbordo' => $first_entry['fecha_transbordo'],
        'num_contenedor_transbordo' => $first_entry['num_contenedor_transbordo'],
        'dias_estancia' => $first_entry['dias_estancia'],
        'nombre_comercial_propietario' => $first_entry['nombre_comercial_propietario'],
    ];

    return $result;
}

/**
 * Función para generar contenido HTML para GENERAR PDF
 */
function generate_html_content_pdf($incident, $data, $evento)
{
    // Genera el contenido HTML específico para el PDF
    $html = "
    <!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Informe Incidencia {$incident['num_incidencia']}</title>
        <link href='../../../assets/font-awesome/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                color: #003a5d;
                margin: 0;
                padding: 20px;
                font-size: 12px;
            }

            .header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 5px;
                background-color: #fff;
                color: #fff;
            }

            .header img {
                height: 40px;
            }

            .container {
                background-color: #fff;
                padding: 10px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                margin-top: 15px;

                /* Control de longitud */
                width: 100%; 
                height: auto; 
                max-width: auto;
                min-width: auto;
                max-height: auto;
                min-height: auto;

                page-break-inside: avoid;  /* Evitar romper el contenedor dentro de las páginas. */
            }

            h2 {
                color: #003a5d;
                border-bottom: 2px solid #8abd24;
                padding-bottom: 5px;
                font-size: 18px;
                margin-top: 10px;
                margin-bottom: 10px;
            }

            h3 {
                color: #003a5d;
                border-bottom: 2px solid #8abd24;
                padding-bottom: 5px;
                font-size: 16px;
                margin-top: 8px;
                margin-bottom: 8px;
            }

            .form-group {
                margin-bottom: 10px;
            }

            .form-group label {
                display: block;
                margin-bottom: 3px;
                font-size: 12px;
            }

            .form-group input,
            .form-group select,
            .form-group textarea {
                width: 100%;
                padding: 6px;
                box-sizing: border-box;
                border: 1px solid #ccc;
                border-radius: 4px;
                font-size: 12px;
            }

            .observaciones,
            .fotos,
            .eventos {
                margin-top: 15px;
            }

            .hidden {
                display: none;
            }

            .tipo-incidencia-radio {
                position: absolute;
                left: -9999px;
            }

            .tipo-incidencia-radio:checked ~ .container .containerFields {
                display: block;
            }

            /* Styles for tables */
            table {
                width: 100%;
                border-collapse: collapse;
                margin: 8px 0;
                font-size: 12px;
                page-break-inside: avoid; /*  Evitar saltos de página dentro de las tablas */
            }

            tr {
                /*page-break-inside: avoid;*/ /* Evitar saltos de página dentro de las filas de la tabla */
                /*page-break-after: avoid;*/ /* Permitir saltos de página después de filas  */
            }

            table, th, td {
                border: 1px solid #ddd;
                
            }

            th, td {
                padding: 6px;
                text-align: left;
                page-break-inside: avoid; /* Evite romperse dentro de las celdas. */
            }

            th {
                background-color: #003a5d;
                color: white;
            }

            .img-preview {
                width: 80px;
                height: 80px;
                object-fit: cover;
                border-radius: 5px;
            }

            /* Styles for photo gallery */
            .photo-gallery {
                display: block;
                overflow: hidden;
                margin-top: 15px;
            }

            .photo-item {
                float: left;
                width: 22%;
                margin-right: 1%;
                margin-bottom: 10px;
                border: 1px solid #ddd;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s;
            }

            .photo-item:hover {
                transform: scale(1.05);
            }

            .photo-item img {
                width: 100%;
                height: auto;
                object-fit: cover;
            }

            .photo-caption {
                padding: 6px;
                background-color: #f4f4f4;
                text-align: center;
                font-size: 12px;
            }

            /* Clear fix */
            .photo-gallery::after {
                content: '';
                display: table;
                clear: both;
            }

            /* PDF Viewer */
            .pdf-viewer {
                margin-top: 15px;
                display: flex;
                flex-wrap: wrap;
            }

            .pdf-item {
                width: 100%;
                margin-bottom: 20px;
                box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s;
                border: 1px solid #ddd;
                border-radius: 8px;
                overflow: hidden;
                text-align: center;
                background-color: #f4f4f4;
            }

            .pdf-item iframe {
                width: 100%;
                height: 400px;
                border: none;
            }

            .pdf-caption {
                padding: 6px;
                background-color: #fff;
                font-size: 12px;
            }

            .photo-gallery {
                page-break-inside: avoid; /* Evita romper la galería de fotos.  */
            }

            .photo-item {
                page-break-inside: avoid; /* Evite romper elementos fotográficos individuales */
            }

            /* Estilos para el pie de página */
            .footer {
                position: fixed;
                bottom: 0;
                width: 100%;
                text-align: center;
                font-size: 10px;
                color: #003a5d;
            }
            
            /* Estilo para el contenido del pie de página */
            .page-number:before {
                content: 'Página ' counter(page);
            }

            /* Salto de página después de Detalles Generales */
            .page-break {
                page-break-after: always;
            }

        </style>
    </head>
    <body>
        <!-- Primera Página -->
        <div class='header'>
            <img src='data:image/png;base64," . base64_encode(file_get_contents('../images/logo_ms_terminal_2.png')) . "' alt='Company Logo' />
            <h3 style='margin-top:5px; float:right;'>Informe incidencia Nº {$incident['num_incidencia']}</h3>
        </div>

        <div class='container'>
            <h3>Detalles Generales</h3>
            <table>
                <tr>
                    <th>Número de Incidencia</th>
                    <td>{$incident['num_incidencia']}</td>
                </tr>
                <tr>
                    <th>Fecha de Incidencia</th>
                    <td>{$incident['fecha_incidencia']}</td>
                </tr>
                <tr>
                    <th>Trabajador</th>
                    <td>" . strtoupper($incident['user_insert']) . "</td>
                </tr>
                <tr>
                    <th>Tipo de Incidencia</th>
                    <td>{$incident['tipo_incidencia']}</td>
                </tr>
                <tr>
                    <th>Estado</th>
                    <td>{$incident['estado_incidencia']}</td>
                </tr>
                <tr>
                    <th>Observaciones</th>
                    <td>{$incident['observaciones']}</td>
                </tr>
            </table>
        </div>

        <div class='container page-break'>
            <h3>Detalles Específicos</h3>
            <table>";

    // Recorre datos de incidentes específicos y crea filas de tabla
    try {
        foreach ($data as $key => $value) {
            $html .= "<tr><th>" . ucfirst(str_replace('_', ' ', $key)) . "</th><td>{$value}</td></tr>";
        }
    } catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }

    // Finaliza la tabla de Detalles Específicos
    $html .= "</table></div>

        <!-- Segunda Página -->
        <div class='header'>
            <img src='data:image/png;base64," . base64_encode(file_get_contents('../images/logo_ms_terminal_2.png')) . "' alt='Company Logo' />
            <h3 style='margin-top:5px; float:right;'>Informe incidencia Nº {$incident['num_incidencia']}</h3>
        </div>

        <div class='container'>
            <h3>Eventos</h3>
            <table>
                <tr>
                    <th>Fecha del Evento</th>
                    <th>Descripción del Evento</th>
                    <th>Fichero(s) del Evento</th>
                </tr>";

    // Agrupar los eventos por fecha y nombre
    $current_event_id = null;
    foreach ($evento as $evento_line) {
        $id_evento = $evento_line['id_evento'];
        $fecha_evento = $evento_line['fecha_evento'];
        $nombre_evento = $evento_line['nombre_evento'];
        $nombre_fichero = $evento_line['nombre_fichero'];

        // Comienza una nueva fila para un nuevo evento
        if ($id_evento !== $current_event_id) {
            // Cierra la lista de ficheros del evento anterior
            if ($current_event_id !== null) {
                $html .= "</ul></td></tr>";
            }

            // Inicia una nueva fila para el evento actual
            $html .= "<tr>
                        <td>{$fecha_evento}</td>
                        <td>{$nombre_evento}</td>
                        <td><ul>";

            // Actualiza el id del evento actual
            $current_event_id = $id_evento;
        }

        // Agrega los ficheros del evento actual
        $html .= "<li>- {$nombre_fichero}</li>";
    }

    // Cierra la última lista de ficheros del último evento
    $html .= "</ul></td></tr>";

    // Finaliza la tabla de eventos
    $html .= "</table></div>";

    /* // Agregar datos del archivo de eventos
    $html .= "<h3>Ficheros Adjuntos</h3>
            <ul>";

    // Usar un array para evitar duplicados
    $ficheros_adicionados = [];

    foreach ($evento as $evento_line) {
        $nombre_fichero = $evento_line['nombre_fichero'];

        // Comprobar si el fichero ya está añadido
        if (!in_array($nombre_fichero, $ficheros_adicionados)) {
            $html .= "<li>{$nombre_fichero}</li>";
            $ficheros_adicionados[] = $nombre_fichero;
        }
    }

    $html .= "</ul>
            </div>"; */

    // Sección de Fotos de los Eventos
    /* $html .= "<div class='container'>
        <h3>Fotos de los Eventos</h3>
        <div class='photo-gallery'>";

    foreach ($evento as $evento_line) {
        $nombre_fichero = $evento_line['nombre_fichero'];
        $id_incidencia = $evento_line['id_incidencia'];

        // Solo mostrar si el fichero es una imagen
        if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $nombre_fichero)) {
            $ruta_imagen = "../uploads/incidencias_eventos/" . $id_incidencia . "/" . $nombre_fichero;
            $html .= "<div class='photo-item'>
                <img src='{$ruta_imagen}' alt='{$nombre_fichero}' class='img-preview' />
                <div class='photo-caption'>{$nombre_fichero}</div>
            </div>";
        }
    }

    $html .= "</div>
            </div>";

    // Sección de Documentos PDF de los Eventos
    $html .= "<div class='container'>
        <h3>Documentos PDF de los Eventos</h3>
        <div class='pdf-viewer'>";

    // List all PDF files related to the events
    foreach ($evento as $evento_line) {
        $nombre_fichero = $evento_line['nombre_fichero'];
        $id_incidencia = $evento_line['id_incidencia'];

        // Only display if the file is a PDF
        if (preg_match('/\.pdf$/i', $nombre_fichero)) {
            $ruta_pdf = "../uploads/incidencias_eventos/" . $id_incidencia . "/" . $nombre_fichero;
            $html .= "<div class='pdf-item'>
                <iframe src='{$ruta_pdf}'></iframe>
                <div class='pdf-caption'>{$nombre_fichero}</div>
            </div>";
        }
    } */

    $html .= "</div>
            </div>

            <!-- <div class='footer'>
                <br>
                <span class='page-number'></span>
            </div> -->

    </body>
    </html>";
    return $html;
}


/**
 * Función para generar contenido HTML para VER HTML
 */
function generate_html_content_html($incident, $data, $evento)
{
    // Genera el contenido HTML para visualización en el navegador
    //ob_start();
    $html = "
    <!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Informe Incidencia {$incident['num_incidencia']}</title>
        <link href='../../../assets/font-awesome/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                color: #003a5d;
                margin: 0;
                padding: 20px;
            }

            .header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px;
                background-color: #fff; //#003a5d
                color: #fff;
            }

            .header img {
                height: 50px;
            }

            .container {
                background-color: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                margin-top: 20px;
            }

            h2 {
                color: #003a5d;
                border-bottom: 2px solid #8abd24;
                padding-bottom: 5px;
            }

            h3 {
                color: #003a5d;
                border-bottom: 2px solid #8abd24;
                padding-bottom: 5px;
            }

            .form-group {
                margin-bottom: 15px;
            }

            .form-group label {
                display: block;
                margin-bottom: 5px;
            }

            .form-group input,
            .form-group select,
            .form-group textarea {
                width: 100%;
                padding: 8px;
                box-sizing: border-box;
                border: 1px solid #ccc;
                border-radius: 4px;
            }

            .observaciones,
            .fotos,
            .eventos {
                margin-top: 20px;
            }

            .hidden {
                display: none;
            }

            /* CSS para ocultar/mostrar campos basado en el tipo de incidencia */
            .tipo-incidencia-radio {
                position: absolute;
                left: -9999px;
            }

            .tipo-incidencia-radio:checked ~ .container .containerFields {
                display: block;
            }

            /* Styles for tables */
            table {
                width: 100%;
                border-collapse: collapse;
                margin: 10px 0;
            }

            table, th, td {
                border: 1px solid #ddd;
            }

            th, td {
                padding: 8px;
                text-align: left;
            }

            th {
                background-color: #003a5d;
                color: white;
            }

            .img-preview {
                width: 100px;
                height: 100px;
                object-fit: cover;
                border-radius: 5px;
            }

            /* Styles for photo gallery */
            .photo-gallery {
                display: block;
                overflow: hidden;
                margin-top: 20px;
            }

            .photo-item {
                float: left;
                width: 23%; /* 4 images per row with margin */
                margin-right: 1%;
                margin-bottom: 15px;
                border: 1px solid #ddd;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s;
            }

            .photo-item:hover {
                transform: scale(1.05);
            }

            .photo-item img {
                width: 100%;
                height: auto;
                object-fit: cover;
            }

            .photo-caption {
                padding: 8px;
                background-color: #f4f4f4;
                text-align: center;
                font-size: 14px;
            }

            /* Clear fix */
            .photo-gallery::after {
                content: '';
                display: table;
                clear: both;
            }

            /* PDF Viewer */
            .pdf-viewer {
                margin-top: 20px;
                display: flex;
                flex-wrap: wrap;
            }

            .pdf-item {
                width: 100%;
                margin-bottom: 30px;
                box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s;
                border: 1px solid #ddd;
                border-radius: 8px;
                overflow: hidden;
                text-align: center;
                background-color: #f4f4f4;
            }

            .pdf-item iframe {
                width: 100%;
                height: 500px; /* Cambia este valor según tus necesidades */
                border: none;
            }

            .pdf-caption {
                padding: 8px;
                background-color: #fff;
                font-size: 14px;
            }

            /* Print-specific styles */
            @media print {
                .header {
                    display: none; /* Opcionalmente ocultar el encabezado en impresión */
                }

                .container {
                    margin: 0;
                    padding: 0;
                    border: none;
                    box-shadow: none;
                    page-break-inside: avoid; /* Evite romper el contenedor dentro de las páginas. */
                }

                table {
                    page-break-inside: avoid; /*  Evitar saltos de página dentro de las tablas */
                }

                tr {
                    page-break-inside: avoid; /* Evitar saltos de página dentro de las filas de la tabla */
                    page-break-after: auto; /* Permitir saltos de página después de filas  */
                }

                td, th {
                    page-break-inside: avoid; /* Evite romperse dentro de las células. */
                }

                .photo-gallery {
                    page-break-inside: avoid; /* Evita romper la galería de fotos.  */
                }

                .photo-item {
                    page-break-inside: avoid; /* Evite romper elementos fotográficos individuales */
                }

                /* Estilos para el pie de página */
                .footer {
                    position: fixed;
                    bottom: 0;
                    width: 100%;
                    text-align: center;
                    font-size: 12px;
                    color: #003a5d;
                }

                /* Estilo para el contenido del pie de página */
                .page-number:before {
                    content: 'Página ' counter(page);
                }

                /* Evitar el corte de contenido en la impresión */
                /*.container, .photo-gallery {
                    page-break-inside: avoid;
                }
            }
        </style>
    </head>
    <body>
        <div class='header'>
            <img src='data:image/png;base64," . base64_encode(file_get_contents('../images/logogms2.png')) . "' alt='Company Logo' />
            <h3 style='margin-top:5px; float:right;'>Informe incidencia Nº {$incident['num_incidencia']}</h3>
        </div>

        <div class='container'>
            <h3>Detalles Generales</h3>
            <table>
                <tr>
                    <th>Número de Incidencia</th>
                    <td>{$incident['num_incidencia']}</td>
                </tr>
                <tr>
                    <th>Fecha de Incidencia</th>
                    <td>{$incident['fecha_incidencia']}</td>
                </tr>
                <tr>
                    <th>Trabajador</th>
                    <td>{$incident['user_insert']}</td>
                </tr>
                <tr>
                    <th>Tipo de Incidencia</th>
                    <td>{$incident['tipo_incidencia']}</td>
                </tr>
                <tr>
                    <th>Estado</th>
                    <td>{$incident['estado_incidencia']}</td>
                </tr>
                <tr>
                    <th>Observaciones</th>
                    <td>{$incident['observaciones']}</td>
                </tr>
            </table>

            <h3>Detalles Específicos</h3>
            <table>";

    // Recorre datos de incidentes específicos y crea filas de tabla
    try {
        foreach ($data as $key => $value) {
            $html .= "<tr><th>" . ucfirst(str_replace('_', ' ', $key)) . "</th><td>{$value}</td></tr>";
        }
    } catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }

    // Sección de Eventos
    $html .= "</table>
            <h3>Eventos</h3>
            <table>
                <tr>
                    <th>Fecha del Evento</th>
                    <th>Nombre del Evento</th>
                    <th>Fichero(s) del Evento</th>
                </tr>";

    // Agrupar los eventos por fecha y nombre
    $current_event_id = null;
    foreach ($evento as $evento_line) {
        $id_evento = $evento_line['id_evento'];
        $fecha_evento = $evento_line['fecha_evento'];
        $nombre_evento = $evento_line['nombre_evento'];
        $nombre_fichero = $evento_line['nombre_fichero'];

        // Comienza una nueva fila para un nuevo evento
        if ($id_evento !== $current_event_id) {
            // Cierra la lista de ficheros del evento anterior
            if ($current_event_id !== null) {
                $html .= "</ul></td></tr>";
            }

            // Inicia una nueva fila para el evento actual
            $html .= "<tr>
                        <td>{$fecha_evento}</td>
                        <td>{$nombre_evento}</td>
                        <td><ul>";

            // Actualiza el id del evento actual
            $current_event_id = $id_evento;
        }

        // Agrega los ficheros del evento actual
        $html .= "<li>- {$nombre_fichero}</li>";
    }

    // Cierra la última lista de ficheros del último evento
    $html .= "</ul></td></tr>";

    // Finaliza la tabla de eventos
    $html .= "</table>";

    // Agregar datos del archivo de eventos
    $html .= "<h3>Ficheros Adjuntos</h3>
            <ul>";

    // Usar un array para evitar duplicados
    $ficheros_adicionados = [];

    foreach ($evento as $evento_line) {
        $nombre_fichero = $evento_line['nombre_fichero'];

        // Comprobar si el fichero ya está añadido
        if (!in_array($nombre_fichero, $ficheros_adicionados)) {
            $html .= "<li>{$nombre_fichero}</li>";
            $ficheros_adicionados[] = $nombre_fichero;
        }
    }

    $html .= "</ul>
            </div>";

    // Sección de Fotos de los Eventos
    $html .= "<div class='container'>
        <h3>Fotos de los Eventos</h3>
        <div class='photo-gallery'>";

    foreach ($evento as $evento_line) {
        $nombre_fichero = $evento_line['nombre_fichero'];
        $id_incidencia = $evento_line['id_incidencia'];

        // Solo mostrar si el fichero es una imagen
        if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $nombre_fichero)) {
            $ruta_imagen = "../uploads/incidencias_eventos/" . $id_incidencia . "/" . $nombre_fichero;
            $html .= "<div class='photo-item'>
                <img src='{$ruta_imagen}' alt='{$nombre_fichero}' class='img-preview' />
                <div class='photo-caption'>{$nombre_fichero}</div>
            </div>";
        }
    }

    $html .= "</div>
            </div>";

    // Sección de Documentos PDF de los Eventos
    $html .= "<div class='container'>
        <h3>Documentos PDF de los Eventos</h3>
        <div class='pdf-viewer'>";

    // List all PDF files related to the events
    foreach ($evento as $evento_line) {
        $nombre_fichero = $evento_line['nombre_fichero'];
        $id_incidencia = $evento_line['id_incidencia'];

        // Only display if the file is a PDF
        if (preg_match('/\.pdf$/i', $nombre_fichero)) {
            $ruta_pdf = "../uploads/incidencias_eventos/" . $id_incidencia . "/" . $nombre_fichero;
            $html .= "<div class='pdf-item'>
                <iframe src='{$ruta_pdf}'></iframe>
                <div class='pdf-caption'>{$nombre_fichero}</div>
            </div>";
        }
    }

    $html .= "</div>
            </div>

            <div class='footer'>
                <span class='page-number'></span>
            </div>

    </body>
    </html>";
    /*$html = ob_get_contents();
    ob_end_clean(); */

    echo $html; // Muestra el HTML generado
}

/**
 * Función para generar PDF usando Dompdf
 */
function generate_pdf($html, $filename)
{
    // Inicializar Dompdf
    $dompdf = new Dompdf();

    // Cargar contenido HTML
    $dompdf->loadHtml($html);

    // Establecer el tamaño y la orientación del papel
    $dompdf->setPaper('A4', 'portrait');

    // Renderizar PDF
    $dompdf->render();

    // Salida PDF
    $dompdf->stream($filename, array("Attachment" => false));
    //file_put_contents($filename, $dompdf->output());
}
