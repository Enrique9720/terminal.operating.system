<!DOCTYPE html>
<html lang="es">

<head>
  <title>Transbordo</title>
  <?php
  include_once('../tpl/header_includes.php');
  ?>

  <style>
    table {
      font-size: 12px;
    }

    .select2 {
      width: 100% !important;
    }
  </style>

  <script>
    $(document).ready(function() {
      // Configuración inicial de fechas y horas
      const now = new Date();
      $('#fecha_transbordo')[0].valueAsDate = now;
      $('#hora_transbordo').val(now.toTimeString().slice(0, 5));

      // Deshabilitar elementos iniciales
      $('#num_cont_2').prop('disabled', true);
      $('#submit').prop('disabled', true);

      // Validar si los propietarios son iguales para habilitar el botón 'Guardar'
      function validarPropietarios() {
        const propietarioOrigen = $('#nombre_comercial_propietario_cont_anterior').val().trim();
        const propietarioDestino = $('#nombre_comercial_propietario_cont_destino').val().trim();

        if (propietarioOrigen && propietarioDestino && propietarioOrigen === propietarioDestino) {
          $('#submit').prop('disabled', false);
        } else {
          $('#submit').prop('disabled', true);
        }
      }

      // Configurar los cambios en los selectores de contenedores
      function setupContenedorHandlers(numCont, idTipo, longitud, descripcion, propietario, estadoCargaContenedor) {
        $(numCont).change(function() {
          const selectedCont = $(this).val();

          // Limpiar datos si no hay un contenedor seleccionado
          if (!selectedCont) {
            clearContenedorData(idTipo, longitud, descripcion, propietario, estadoCargaContenedor);
            validarPropietarios();
            return;
          }

          // Realizar solicitud AJAX para obtener los datos del contenedor
          $.ajax({
            type: "POST",
            url: "../ajax/get_contenedor.php",
            data: {
              num_cont_1: selectedCont
            },
            dataType: "json",
            success: function(data) {
              console.log(data); // Verificar datos devueltos
              if (data && Array.isArray(data) && data.length > 0 && data[0].text !== 'No hay resultados') {
                const contenedor = data[0];
                $(idTipo).val(contenedor.id_tipo_contenedor_iso || '');
                $(longitud).val(contenedor.longitud_tipo_contenedor || '');
                $(descripcion).val(contenedor.descripcion_tipo_contenedor || '');
                $(propietario).val(contenedor.nombre_comercial_propietario || '');
                $(estadoCargaContenedor).val(contenedor.estado_carga_contenedor || ''); // Actualización correcta del estado

                // Cargar el segundo contenedor si es el primero
                if (numCont === "#num_cont_1") {
                  const propietario = contenedor.nombre_comercial_propietario || '';
                  const url = `../ajax/contenedores_stock_noIncidencia_vacio_list.php?nombre_comercial_propietario=${encodeURIComponent(propietario)}`;

                  load_ajax_select2("#num_cont_2", "", url);
                  $('#num_cont_2').prop('disabled', false);

                  setupContenedorHandlers("#num_cont_2", "#id_tipo_cont_2", "#longitud_cont_2", "#descripcion_cont_2", "#nombre_comercial_propietario_cont_destino", "#estado_carga_cont_2");
                }
                validarPropietarios();
              } else {
                clearContenedorData(idTipo, longitud, descripcion, propietario, estadoCargaContenedor);
                validarPropietarios();
              }
            },
            error: function(xhr, status, error) {
              console.error("Error en la solicitud AJAX:", error);
              alert("Ocurrió un error al obtener los datos del contenedor. Intente nuevamente.");
            }
          });
        });
      }

      // Limpiar datos del contenedor
      function clearContenedorData(idTipo, longitud, descripcion, propietario, estadoCargaContenedor) {
        $(idTipo).val('');
        $(longitud).val('');
        $(descripcion).val('');
        $(propietario).val('');
        $(estadoCargaContenedor).val('');
      }

      // Configuración inicial de select2 y eventos
      load_ajax_select2("#num_cont_1", "", "../ajax/contenedor_cargado_danado_stock_list.php");
      setupContenedorHandlers("#num_cont_1", "#id_tipo_cont_1", "#longitud_cont_1", "#descripcion_cont_1", "#nombre_comercial_propietario_cont_anterior", "#estado_carga_cont_1");

      // Validar propietarios cuando se modifiquen los campos
      $('#nombre_comercial_propietario_cont_anterior, #nombre_comercial_propietario_cont_destino').on('input', validarPropietarios);
    });
  </script>
</head>

<body>
  <div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;">
      <?php
      include_once("../tpl/header_menu.php");
      include_once("../tpl/aside.php");
      ?>
    </nav>

    <div class="container-fluid" id="page-wrapper">
      <form role="form" autocomplete="off" action="../controllers/transbordo_nuevo_controller.php" method="post" id="form_transbordo" name="form_transbordo">
        <h3 class="text-center"><i class="fas fa-exchange-alt"></i> Nuevo Transbordo</h3>

        <!-- Datos del contenedor origen -->
        <fieldset>
          <legend>Contenedor Origen</legend>
          <div class="form-group">
            <label for="fecha_transbordo">Fecha:</label>
            <input type="date" class="form-control" id="fecha_transbordo" name="fecha_transbordo" required>
          </div>
          <div class="form-group">
            <label for="hora_transbordo">Hora:</label>
            <input type="time" class="form-control" id="hora_transbordo" name="hora_transbordo" step="60" required>
          </div>
          <div class="form-group">
            <label for="num_cont_1">Nº Contenedor:</label>
            <select class="form-control select2" id="num_cont_1" name="num_cont_1" required></select>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="id_tipo_cont_1" name="id_tipo_cont_1" placeholder="Tipo" readonly>
            <input type="text" class="form-control" id="longitud_cont_1" name="longitud_cont_1" placeholder="Longitud" readonly>
            <input type="text" class="form-control" id="descripcion_cont_1" name="descripcion_cont_1" placeholder="Descripción" readonly>
            <input type="text" class="form-control" id="nombre_comercial_propietario_cont_anterior" name="nombre_comercial_propietario_cont_anterior" placeholder="Propietario" readonly>
            <input type="text" class="form-control" id="estado_carga_cont_1" name="estado_carga_cont_1" placeholder="Estado Carga Contenedor" readonly>
          </div>
        </fieldset>

        <br>

        <!-- Datos del contenedor destino -->
        <fieldset>
          <legend>Contenedor Destino</legend>
          <div class="form-group">
            <label for="num_cont_2">Nº Contenedor:</label>
            <select class="form-control select2" id="num_cont_2" name="num_cont_2" required></select>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="id_tipo_cont_2" name="id_tipo_cont_2" placeholder="Tipo" readonly>
            <input type="text" class="form-control" id="longitud_cont_2" name="longitud_cont_2" placeholder="Longitud" readonly>
            <input type="text" class="form-control" id="descripcion_cont_2" name="descripcion_cont_2" placeholder="Descripción" readonly>
            <input type="text" class="form-control" id="nombre_comercial_propietario_cont_destino" name="nombre_comercial_propietario_cont_destino" placeholder="Propietario" readonly>
            <input type="text" class="form-control" id="estado_carga_cont_2" name="estado_carga_cont_2" placeholder="Estado Carga Contenedor" readonly>
          </div>
        </fieldset>

        <div class="form-group text-center">
          <button type="submit" class="btn btn-primary" id="submit" name="submit"><i class="fa fa-lg fa-save"></i> Guardar</button>
          <button type="button" class="btn btn-default" onclick="window.location.reload()"><i class="glyphicon glyphicon-refresh"></i> Recargar</button>
        </div>
      </form>
    </div>
  </div>
</body>

</html>