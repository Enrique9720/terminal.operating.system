<?php

session_start();
///////////////////////*CARGA DE MODELOS*////////////////////////////////////////////
require_once("../models/railsider_model.php");
/////////////////////////////////////////////////////////////////////////////////////
//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");
//comprobamos que el usuario esta logeado
check_logged_user();
////////////////////////////////////////////////////////////////

//instanciamos el modelo para acceso a la BBDD de usuarios
$railsider_model = new railsider_model();

//echo "<pre>"; print_r($_POST); echo "</pre>";

if (isset($_POST['id_tipo_incidencia'])) {
    $id_tipo_incidencia = $_POST['id_tipo_incidencia'];

    switch ($id_tipo_incidencia) {
            /*case 1: //AVERÍA REEFER
            // Obtener la entrada del camión
            $get_contenedor_reefer = $railsider_model->get_contenedores_stock_reefer_incidencia();

            // Verificar si la lista de tipos de incidencia está definida y no está vacía
            if (isset($get_contenedor_reefer) && !empty($get_contenedor_reefer)) {
                // Generar el select para tipos de incidencia
                echo '<div class="form-group">
                                 <label>Avería Reefer:</label>
                                 <select class="form-control select2" id="id_entrada_num_contenedor" name="id_entrada_num_contenedor">';

                echo '<option value=""></option>';
                // Iterar sobre la lista de tipos de incidencia y crear las opciones del select
                foreach ($get_contenedor_reefer as $get_contenedor_reefer_line) {
                    echo '<option value="' . $get_contenedor_reefer_line['id_entrada'] . '-' . $get_contenedor_reefer_line['num_contenedor'] . '">';
                    echo $get_contenedor_reefer_line['id_entrada'] . ' - ' . $get_contenedor_reefer_line['num_contenedor'] . ' - ' . $get_contenedor_reefer_line['nombre_comercial_propietario'];
                    echo '</option>';
                }

                echo '</select>
                               </div>';
            } else {
                // Mostrar mensaje de error si la lista de tipos de incidencia no está disponible
                echo '<div class="form-group">
                                 <label>Avería Reefer:</label>
                                 <select class="form-control">
                                     <option value="">No hay tipos de incidencia disponibles</option>
                                 </select>
                               </div>';
            }
            break;*/
        case 2: //RETRASO ENTRADA CAMIÓN
            // Obtener la entrada del camión
            $get_entradas_camion = $railsider_model->get_entrada_camion_incidencia();

            // Verificar si la lista de tipos de incidencia está definida y no está vacía
            if (isset($get_entradas_camion) && !empty($get_entradas_camion)) {
                // Generar el select para tipos de incidencia
                echo '<div class="form-group">
                                <label>Entrada Retraso Camión:</label>
                                <select class="form-control select2" id="id_entrada" name="id_entrada">';

                echo '<option value=""></option>';
                // Iterar sobre la lista de tipos de incidencia y crear las opciones del select
                foreach ($get_entradas_camion as $get_entradas_camion_line) {
                    echo '<option value="' . $get_entradas_camion_line['id_entrada'] . '">';
                    echo $get_entradas_camion_line['id_entrada'] . ' - ' . $get_entradas_camion_line['num_contenedor'] . ' - ' . $get_entradas_camion_line['nombre_comercial_propietario'];
                    echo '</option>';
                }

                echo '</select>
                              </div>';
            } else {
                // Mostrar mensaje de error si la lista de tipos de incidencia no está disponible
                echo '<div class="form-group">
                                <label>Entrada Retraso Camión:</label>
                                <select class="form-control">
                                    <option value="">No hay tipos de incidencia disponibles</option>
                                </select>
                              </div>';
            }
            break;
        case 3: //DAÑO UTI
            /* // Obtener la entrada del camión
            $get_contenedores_stock = $railsider_model->get_contenedores_stock_ajax_incidencia($search);

            // Verificar si la lista de contenedores está definida y no está vacía
            if (isset($get_contenedores_stock) && !empty($get_contenedores_stock)) {
                // Generar el select para contenedores
                echo '<div class="form-group">
                        <label>Contenedor Dañado:</label>
                        <select class="form-control select2" id="id_entrada_num_contenedor" name="id_entrada_num_contenedor">
                            <option value=""></option>';
                // Iterar sobre la lista de contenedores y crear las opciones del select
                foreach ($get_contenedores_stock as $get_contenedores_stock_line) {
                    echo '<option value="' . $get_contenedores_stock_line['id_entrada'] . '-' . $get_contenedores_stock_line['num_contenedor'] . '">';
                    echo $get_contenedores_stock_line['id_entrada'] . ' - ' . $get_contenedores_stock_line['num_contenedor'] . ' - ' . $get_contenedores_stock_line['nombre_comercial_propietario'];
                    echo '</option>';
                }
                echo '</select>
                    </div>';
            } else {
                // Mostrar mensaje de error si la lista de contenedores no está disponible
                echo '<div class="form-group">
                        <label>Contenedor Dañado:</label>
                        <select class="form-control">
                            <option value="">No hay contenedores disponibles</option>
                        </select>
                    </div>';
            }

            $get_tipos_daños_utis = $railsider_model->get_tipos_daños_utis($search);
            // Verificar si la lista de tipos de daño está definida y no está vacía
            if (isset($get_tipos_daños_utis) && !empty($get_tipos_daños_utis)) {
                // Generar el select para tipos de daño
                echo '<div class="form-group">
                        <label>Tipo de Daño:</label>
                        <select class="form-control select2" id="tipo_de_daño" name="tipo_de_daño" enabled>
                            <option value=""></option>';
                // Iterar sobre la lista de tipos de daño y crear las opciones del select
                foreach ($get_tipos_daños_utis as $get_tipos_daños_utis_line) {
                    echo '<option value="' . $get_tipos_daños_utis_line['id_tipo_daño_uti'] . '">';
                    echo $get_tipos_daños_utis_line['tipo_daño_uti'];
                    echo '</option>';
                }
                echo '</select>
                    </div>';
            } else {
                // Mostrar mensaje de error si la lista de tipos de daño no está disponible
                echo '<div class="form-group">
                        <label>Tipo de Daño:</label>
                        <select class="form-control">
                            <option value="">No hay tipos de daño disponibles</option>
                        </select>
                    </div>';
            }

            // Agregar campo de descripción (inicialmente oculto y deshabilitado)
            echo '<div class="form-group" id="campo_descripcion" style="display: none;">
                    <label>Descripción del tipo de daño (FALTA DE ELEMENTOS U OTROS):</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" disabled></textarea>
                </div>';

            // Incluir el script para manejar la lógica de habilitación/deshabilitación            
            echo '<script>
                    $(document).ready(function() {
                        // Cuando se seleccione un contenedor dañado, habilitar el campo "Tipo de Daño"
                        $("#contenedor_dañado").change(function() {
                            var contenedorSeleccionado = $(this).val();
                            
                            if (contenedorSeleccionado) {
                                $("#tipo_de_daño").prop("disabled", false); // Habilitar "Tipo de Daño"
                            } else {
                                $("#tipo_de_daño").prop("disabled", true); // Deshabilitar "Tipo de Daño" si no hay selección
                                $("#campo_descripcion").hide(); // Ocultar campo de descripción
                                $("#descripcion").prop("disabled", true); // Deshabilitar descripción
                            }
                        });

                        // Cuando se seleccione un tipo de daño específico, habilitar el campo de descripción
                        $("#tipo_de_daño").change(function() {
                            var tipoDeDañoSeleccionado = $(this).find("option:selected").text();
                            // Condición para mostrar el campo de descripción
                            if (tipoDeDañoSeleccionado === "FALTA DE ELEMENTOS" || tipoDeDañoSeleccionado === "OTRAS") {
                                $("#campo_descripcion").show(); // Mostrar campo de descripción
                                $("#descripcion").prop("disabled", false); // Habilitar descripción
                            } else {
                                $("#campo_descripcion").hide(); // Ocultar campo de descripción
                                $("#descripcion").prop("disabled", true); // Deshabilitar descripción
                            }
                        });
                    });
                </script>';
            break;*/
        case 4: //FRENADO TREN
            $movimientos_list = $railsider_model->get_salida_tren_incidencia();
            //echo "<pre>";
            //print_r($movimientos_list);
            //echo "</pre>";

            // Verificar si la lista de tipos de incidencia está definida y no está vacía
            if (isset($movimientos_list) && !empty($movimientos_list)) {
                // Generar el select para tipos de incidencia
                echo '<div class="form-group">
                                <label>Frenado Tren:</label>
                                <select class="form-control select2" id="id_salida" name="id_salida">';

                echo '<option value=""> </option>';
                // Iterar sobre la lista de tipos de incidencia y crear las opciones del select
                foreach ($movimientos_list as $movimientos_list_line) {
                    echo '<option value="' . $movimientos_list_line['id_salida'] . '">';
                    echo $movimientos_list_line['num_expedicion'] . ' - ' . $movimientos_list_line['nombre_comercial_propietario'];
                    echo '</option>';
                }

                echo '</select>
                              </div>';
            } else {
                // Mostrar mensaje de error si la lista de tipos de incidencia no está disponible
                echo '<div class="form-group">
                                <label>Frenado Tren:</label>
                                <select class="form-control">
                                    <option value="">No hay tipos de incidencia disponibles</option>
                                </select>
                              </div>';
            }
            break;
        case 5: //RETRASO TREN
            // Obtener la entrada del tren
            $get_entradas_tren = $railsider_model->get_entrada_tren_incidencia();

            // Verificar si la lista de tipos de incidencia está definida y no está vacía
            if (isset($get_entradas_tren) && !empty($get_entradas_tren)) {
                // Generar el select para tipos de incidencia
                echo '<div class="form-group">
                                <label>Entrada Retraso Tren:</label>
                                <select class="form-control select2" id="id_entrada" name="id_entrada">';

                echo '<option value=""></option>';
                // Iterar sobre la lista de tipos de incidencia y crear las opciones del select
                foreach ($get_entradas_tren as $get_entradas_tren_line) {
                    echo '<option value="' . $get_entradas_tren_line['id_entrada'] . '">';
                    echo $get_entradas_tren_line['num_expedicion'] . ' - ' . $get_entradas_tren_line['nombre_comercial_propietario'];
                    echo '</option>';
                }

                echo '</select>
                              </div>';
            } else {
                // Mostrar mensaje de error si la lista de tipos de incidencia no está disponible
                echo '<div class="form-group">
                                <label>Entrada Retraso Tren:</label>
                                <select class="form-control">
                                    <option value="">No hay tipos de incidencia disponibles</option>
                                </select>
                              </div>';
            }
            break;
        case 6: //ESTANCIA M.M.P.P.
            // Obtener la estancia de la m.m.p.p
            $movimientos_list = $railsider_model->get_estancia_contenedor_mmpp();

            // Verificar si la lista de tipos de incidencia esta definida y no esta vaci­a
            if (isset($movimientos_list) && !empty($movimientos_list)) {
                echo '<form method="GET" action="../controllers/incidencia_controller.php">'; // Agrega el formulario con el método GET
                // Generar el select para tipos de incidencia
                echo '<div class="form-group">
                            <label>Demora Mercancia Peligrosa:</label>
                            <select class="form-control select2" id="id_salida_num_contenedor" name="id_salida_num_contenedor" onchange="this.form.submit()>';

                echo '<option value=""> </option>';
                // Iterar sobre la lista de tipos de incidencia y crear las opciones del select
                foreach ($movimientos_list as $movimientos_list_line) {
                    // Verificar si id_salida esta vacia
                    if (empty($movimientos_list_line['id_salida'])) {
                        // Marcar que el contenedor esta en stock y hacerlo no seleccionable
                        echo '<option value="" disabled>';
                        echo 'STOCK - ' . $movimientos_list_line['num_contenedor'] . ' - ' . $movimientos_list_line['dias_estancia'] . ' dias estacionado - ' . $movimientos_list_line['nombre_comercial_propietario'];
                    } else {
                        $value = $movimientos_list_line['id_salida'] . '-' . $movimientos_list_line['num_contenedor'];
                        echo '<option value="' . htmlspecialchars($value) . '">';
                        echo 'Salida - ' . $movimientos_list_line['num_expedicion_salida'] . ' - ' . $movimientos_list_line['num_contenedor'] . ' - ' . $movimientos_list_line['dias_estancia'] . ' dias estacionado - ' . $movimientos_list_line['nombre_comercial_propietario'];
                    }
                    echo '</option>';
                }

                echo '</select>
                          </div>';
            } else {
                // Mostrar mensaje de error si la lista de tipos de incidencia no esta disponible
                echo '<div class="form-group">
                            <label>Demora Mercancia Peligrosa:</label>
                            <select class="form-control">
                                <option value="">No hay tipos de incidencia disponibles</option>
                            </select>
                          </div>';
            }
            break;

        case 7: //OTRO
            echo '';
            break;
        default:
            echo '';
            break;
    }
}
