<!DOCTYPE html>
<html lang="es">

<head>
  <title>Incidencia Nº <?php echo $num_incidencia; ?></title>
  <?php
  //Plantilla con los inludes de las librerias y CSS usados por todas las paginas de la APP
  require_once('../tpl/header_includes.php');
  ?>

  <script>
    $(document).ready(function() {
      table_incidencia_observaciones = $('#table_incidencia_observaciones').DataTable({
        columns: [{
            data: 'observaciones'
          },
          {
            data: 'acciones'
          },
        ],
        columnDefs: [{
          "targets": 0,
          "className": "text-center",
          "width": "100%"
        }],
        ordering: false,
        autoWidth: false,
        iDisplayLength: -1,
        //scrollY: '10vh',
        bPaginate: false,
        bFilter: false,
        bInfo: false,
        bScrollCollapse: true
      });

      table_incidencia_contenedor = $('#table_incidencia_contenedor').DataTable({
        columns: [{
            data: 'tipo_incidencia'
          },
          {
            data: 'estado_incidencia'
          },
          {
            data: 'boton_edit'
          },
        ],
        columnDefs: [{
            "targets": 0,
            "className": "text-center",
            "width": "75%"
          },
          {
            "targets": 1,
            "className": "text-center",
            "width": "20%"
          },
          {
            "targets": 2,
            "className": "text-center",
            "width": "5%"
          }
        ],
        order: [
          [0, 'asc']
        ],
        ordering: true,
        autoWidth: false,
        iDisplayLength: -1,
        //scrollY: '10vh',
        bPaginate: false,
        bFilter: false,
        bInfo: false,
        bScrollCollapse: true
      });
    });
  </script>

  <style>
  </style>

  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
</head>

<body>
  <div id="wrapper">
    <!-- Top Menu and Sidebar -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
      <?php
      //Plantilla con el menu del header
      require_once("../tpl/header_menu.php");

      //Plantilla con el aside usado SOLO POR ESTA APP
      require_once("../tpl/aside.php");
      ?>
    </nav>

    <div class="container-fluid" id="page-wrapper">

      <div class="row">
        <div class="col-md-12" style="margin-top:20px;padding-left:0;">
          <div class="well well-sm">
            <a class="btn btn-success" href="../controllers/incidencia_nuevo_controller.php"><i class="glyphicon glyphicon-plus"></i> Nueva Incidencia</a>
            <a target="_blank" href="../controllers/pdf_generar_incidencia_controller.php?id_incidencia=<?php echo $id_incidencia; ?>" type="button" class="btn btn-danger" title="Generar Incidencia"><span class="fa fa-file-pdf" aria-hidden="true"></span> Generar Informe</a>
            <!--<a target="_blank" href="../controllers/pdf_generar_incidencia_controller.php?id_incidencia=<?php echo $id_incidencia; ?>&num_contenedor=<?php echo $num_contenedor; ?>" type="button" class="btn btn-danger" title="Generar Incidencia"><span class="fa fa-file-pdf" aria-hidden="true"></span> Generar Informe</a> -->
            <a target="_blank" href="../controllers/descarga_adjuntos_incidencia_controller.php?id_incidencia=<?php echo $id_incidencia; ?>" type="button" class="btn btn-warning" title="Descargar Archivos"><span class="fa fa-download" aria-hidden="true"></span> Descargar Adjuntos ZIP</a>
            <a class="btn btn-default" onclick="window.location.reload()"><i class="glyphicon glyphicon-refresh"></i> Recargar</a>
          </div>
        </div>
      </div>

      <center>
        <h3><i class="fas fa-exclamation-triangle"></i> Incidencia Nº <?php echo $num_incidencia; ?></h3>
      </center>

      <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
          <table id="table_incidencia_cabecera" class="table table-striped table-bordered" style="font-size: 12px;">
            <thead>
              <tr>
                <th>Fecha Incidencia</th>
                <th>Trabajador</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($incidencia as $incidencia_datos) { ?>
                <tr>
                  <td><?php echo $incidencia_datos['fecha_incidencia']; ?></td>
                  <td><?php echo $incidencia_datos['user_insert']; ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <div class="col-md-4"></div>
      </div>

      <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
          <table id="table_incidencia_contenedor" class="table table-striped table-bordered" style="font-size: 12px;">
            <thead>
              <tr>
                <th>Tipo incidencia</th>
                <th class="warning">Estado Incidencia</th>
                <th class="warning">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($incidencia as $incidencia_datos) { ?>
                <tr data-id="<?php echo $incidencia_datos['id_incidencia']; ?>" data-type="incidencia">
                  <td><?php echo $incidencia_datos['tipo_incidencia']; ?></td>
                  <td>
                    <select class="form-control estado-incidencia" disabled>
                      <option value="ABIERTA" <?php echo ($incidencia_datos['estado_incidencia'] == 'ABIERTA') ? 'selected' : ''; ?>>ABIERTA</option>
                      <option value="CERRADA" <?php echo ($incidencia_datos['estado_incidencia'] == 'CERRADA') ? 'selected' : ''; ?>>CERRADA</option>
                    </select>
                  </td>
                  <td>
                    <center>
                      <div class="btn-group">
                        <a type="button" id="" class="btn-editar btn-sm btn-info" title=""><span class="glyphicon glyphicon-pencil"></span></a>
                        <a type="button" id="" class="btn-guardar btn-sm btn-success" style="display:none;" title=""><span class="glyphicon glyphicon-floppy-disk"></span></a>
                      </div>
                    </center>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <div class="col-md-3"></div>
      </div>
      <br>

      <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
      <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
      <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

      <script>
        $(document).ready(function() {
          $('.estado-incidencia').select2({
            minimumResultsForSearch: Infinity
          }).prop("disabled", true);

          // Ejemplo de cómo habilitar el select cuando sea necesario
          $('.btn-editar').on('click', function() {
            $(this).closest('tr').find('.estado-incidencia').prop("disabled", false).select2();
          });

          // Ejemplo de cómo deshabilitar el select después de guardar cambios
          $('.btn-guardar').on('click', function() {
            $(this).closest('tr').find('.estado-incidencia').prop("disabled", true).select2();
          });
        });
      </script>

      <script>
        $(document).ready(function() {

          $('#table_incidencia_contenedor').DataTable();

          $('.btn-editar').click(function() {
            let row = $(this).closest('tr');
            let cells = row.find('td[contenteditable]');
            cells.attr('contenteditable', true);
            row.find('.estado-incidencia').prop('disabled', false);
            row.find('.btn-guardar').show();
            $(this).hide();
          });

          $('.btn-guardar').click(function() {
            let row = $(this).closest('tr');
            let cells = row.find('td[contenteditable]');
            cells.attr('contenteditable', false);
            row.find('.estado-incidencia').prop('disabled', true);
            row.find('.btn-editar').show();
            $(this).hide();

            // Obtener los datos de la fila
            let id = row.data('id');
            let type = row.data('type');
            //let observaciones = cells[0].innerText;
            let estado = row.find('.estado-incidencia').val();

            // Crear el payload para enviar
            let payload = {
              id: id,
              type: type,
              //observaciones: observaciones,
              estado: estado
            };

            // Enviar los datos al servidor usando $.ajax
            $.ajax({
              url: '../ajax/cambiar_observaciones.php',
              type: 'POST',
              contentType: 'application/json',
              data: JSON.stringify(payload),
              success: function(data) {
                if (data.success) {
                  alert('Datos guardados exitosamente');
                }
                /*else {
                                 alert('Hubo un error al guardar los datos: ' + data.message);
                               }*/
              },
              error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('Hubo un error al guardar los datos');
              }
            });
          });

        });
      </script>

      <?php if ( ($id_tipo_incidencia == 1) || ($id_tipo_incidencia == 3) ) { ?><!--1, 3-->
        <div class="row">
          <div class="col-md-1"></div>
          <div class="col-md-10">
            <table id="table_incidencia_contenedor" class="table table-striped table-bordered" style="font-size: 12px;">
              <thead>
                <tr>
                  <th>Nº Contenedor</th>
                  <th>Estado de Carga</th>
                  <th class="success">Entrada</th>
                  <th class="success">Fecha Entrada</th>
                  <th class="success">Tipo Entrada</th>
                  <th class="danger">Salida</th>
                  <th class="danger">Fecha Salida</th>
                  <th class="danger">Tipo Salida</th>
                  <th>Fecha Transbordo</th>
                  <th>Nº Contenedor transbordo</th>
                  <th>Propietario</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($incidencia_contenedor as $incidencia_contenedor_line) { ?>
                  <tr>
                    <td><?php echo $incidencia_contenedor_line['num_contenedor']; ?></td>
                    <td><?php echo $incidencia_contenedor_line['estado_carga_contenedor']; ?></td>
                    <td>
                      <center>
                        <a target="_blank" href="../controllers/entrada_resumen_controller.php?id_entrada=<?php echo $incidencia_contenedor_line['id_entrada']; ?>" type="button" id="<?php echo $incidencia_contenedor_line['id_entrada']; ?>" class="btn btn-sm btn-default view_record2" title="Ver"><?php echo $incidencia_contenedor_line['num_expedicion_entrada']; ?></a>
                    </td>
                    </center>
                    <td><?php echo $incidencia_contenedor_line['fecha_entrada']; ?></td>
                    <td><?php echo $incidencia_contenedor_line['tipo_entrada']; ?></td>

                    <td>
                      <center>
                        <?php if ($incidencia_contenedor_line['id_salida'] != '') { ?>
                          <a target="_blank" href="../controllers/salida_resumen_controller.php?id_salida=<?php echo $incidencia_contenedor_line['id_salida']; ?>" type="button" id="<?php echo $incidencia_contenedor_line['id_salida']; ?>" class="btn btn-sm btn-default view_record2" title="Ver"><?php echo $incidencia_contenedor_line['num_expedicion_salida']; ?></a>
                        <?php } ?>
                    </td>
                    </center>

                    <td><?php echo $incidencia_contenedor_line['fecha_salida']; ?></td>
                    <td><?php echo $incidencia_contenedor_line['tipo_salida']; ?></td>
                    <td><?php echo $incidencia_contenedor_line['fecha_transbordo']; ?></td>
                    <td><?php echo $incidencia_contenedor_line['num_contenedor_transbordo']; ?></td>
                    <td><?php echo $incidencia_contenedor_line['nombre_comercial_propietario']; ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <div class="col-md-1"></div>
        </div>
      <?php } ?>

      <?php if ( ($id_tipo_incidencia == 2) ) { ?><!--RETRASO CAMION (2)-->
        <div class="row">
          <div class="col-md-1"></div>
          <div class="col-md-10">
            <table id="table_incidencia_contenedor" class="table table-striped table-bordered" style="font-size: 12px;">
              <thead>
                <tr>
                  <th>Nº Contenedor</th>
                  <th class="success">Entrada</th>
                  <th class="success">Fecha Entrada</th>
                  <th class="success">Tipo Entrada</th>
                  <th>Propietario</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($incidencia_retraso_camion as $incidencia_retraso_camion_line) { ?>
                  <tr>
                    <td><?php echo $incidencia_retraso_camion_line['num_contenedor']; ?></td>
                    <td>
                      <center>
                        <a target="_blank" href="../controllers/entrada_resumen_controller.php?id_entrada=<?php echo $incidencia_retraso_camion_line['id_entrada']; ?>" type="button" id="<?php echo $incidencia_retraso_camion_line['id_entrada']; ?>" class="btn btn-sm btn-default view_record2" title="Ver"><?php echo $incidencia_retraso_camion_line['num_expedicion_entrada']; ?></a>
                    </td>
                    </center>
                    <td><?php echo $incidencia_retraso_camion_line['fecha_entrada']; ?></td>
                    <td><?php echo $incidencia_retraso_camion_line['tipo_entrada']; ?></td>
                    <td><?php echo $incidencia_retraso_camion_line['nombre_comercial_propietario']; ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <div class="col-md-1"></div>
        </div>
      <?php } ?>

      <?php if ( ($id_tipo_incidencia == 4) ) { ?><!-- FRENADO TREN (4)-->
        <div class="row">
          <div class="col-md-1"></div>
          <div class="col-md-10">
            <table id="table_incidencia_contenedor" class="table table-striped table-bordered" style="font-size: 12px;">
              <thead>
                <tr>
                  <th class="danger">Salida</th>
                  <th class="danger">Fecha Salida</th>
                  <th class="danger">Tipo Salida</th>
                  <th>Propietario</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($incidencia_frenado_tren as $incidencia_frenado_tren_line) { ?>
                  <tr>
                    <td>
                      <center>
                        <a target="_blank" href="../controllers/salida_resumen_controller.php?id_salida=<?php echo $incidencia_frenado_tren_line['id_salida']; ?>" type="button" id="<?php echo $incidencia_frenado_tren_line['id_salida']; ?>" class="btn btn-sm btn-default view_record2" title="Ver"><?php echo $incidencia_frenado_tren_line['num_expedecion_salida']; ?></a>
                    </td>
                    </center>
                    <td><?php echo $incidencia_frenado_tren_line['fecha_salida']; ?></td>
                    <td><?php echo $incidencia_frenado_tren_line['tipo_salida']; ?></td>
                    <td><?php echo $incidencia_frenado_tren_line['nombre_comercial_propietario']; ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <div class="col-md-1"></div>
        </div>
      <?php } ?>

      <?php if ( ($id_tipo_incidencia == 5) ) { ?><!-- RETRASO TREN (5)-->
        <div class="row">
          <div class="col-md-1"></div>
          <div class="col-md-10">
            <table id="table_incidencia_contenedor" class="table table-striped table-bordered" style="font-size: 12px;">
              <thead>
                <tr>
                  <th class="success">Entrada</th>
                  <th class="success">Fecha Entrada</th>
                  <th class="success">Tipo Entrada</th>
                  <th>Propietario</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($incidencia_retraso_tren as $incidencia_retraso_tren_line) { ?>
                  <tr>
                    <td>
                      <center>
                        <a target="_blank" href="../controllers/entrada_resumen_controller.php?id_entrada=<?php echo $incidencia_retraso_tren_line['id_entrada']; ?>" type="button" id="<?php echo $incidencia_retraso_tren_line['id_entrada']; ?>" class="btn btn-sm btn-default view_record2" title="Ver"><?php echo $incidencia_retraso_tren_line['num_expedicion_entrada']; ?></a>
                    </td>
                    </center>
                    <td><?php echo $incidencia_retraso_tren_line['fecha_entrada']; ?></td>
                    <td><?php echo $incidencia_retraso_tren_line['tipo_entrada']; ?></td>
                    <td><?php echo $incidencia_retraso_tren_line['nombre_comercial_propietario']; ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <div class="col-md-1"></div>
        </div>
      <?php } ?>

      <?php if ( ($id_tipo_incidencia == 6) ) { ?><!--MMPP (6)-->
        <div class="row">
          <div class="col-md-1"></div>
          <div class="col-md-10">
            <table id="table_incidencia_contenedor" class="table table-striped table-bordered" style="font-size: 12px;">
              <thead>
                <tr>
                  <th>Nº Contenedor</th>
                  <th>Dias Estancia</th>
                  <th class="noVis not-export-col success">Expedición Entrada</th>
                  <th class="success">Fecha Entrada</th>
                  <th class="success">Tipo Entrada</th>
                  <th class="noVis not-export-col danger">Expedición Salida</th>
                  <th class="danger">Fecha Salida</th>
                  <th class="danger">Tipo Salida</th>
                  <th>Propietario</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($incidencia_demora_mmpp as $incidencia_demora_mmpp_line) { ?>
                  <tr>
                    <td><?php echo $incidencia_demora_mmpp_line['num_contenedor']; ?></td>
                    <td><?php echo $incidencia_demora_mmpp_line['dias_estancia']; ?></td>
                    <td>
                      <center>
                        <div class="btn-group">
                          <?php if ($incidencia_demora_mmpp_line['tipo_entrada'] === 'TREN') { ?>
                            <a target="_blank" href="../controllers/entrada_resumen_controller.php?id_entrada=<?php echo $incidencia_demora_mmpp_line['id_entrada']; ?>" type="button" id="<?php echo $incidencia_demora_mmpp_line['id_entrada']; ?>" class="btn btn-sm btn-default view_record2" title="Ver"><?php echo $incidencia_demora_mmpp_line['num_expedicion_entrada']; ?></a>
                          <?php } elseif ($incidencia_demora_mmpp_line['tipo_entrada'] === 'CAMIÓN') { ?>
                            <a target="_blank" href="../controllers/entrada_resumen_controller.php?id_entrada=<?php echo $incidencia_demora_mmpp_line['id_entrada']; ?>" type="button" id="<?php echo $incidencia_demora_mmpp_line['id_entrada']; ?>" class="btn btn-sm btn-default view_record2" title="Ver"><?php echo $incidencia_demora_mmpp_line['entrada_camion']; ?></a>
                          <?php } ?>
                        </div>
                      </center>

                    </td>
                    <td><?php echo $incidencia_demora_mmpp_line['fecha_entrada']; ?></td>
                    <td><?php echo $incidencia_demora_mmpp_line['tipo_entrada']; ?></td>
                    <td>
                      <center>
                        <div class="btn-group">
                          <?php if ($incidencia_demora_mmpp_line['tipo_salida'] === 'TREN') { ?>
                            <a target="_blank" href="../controllers/salida_resumen_controller.php?id_salida=<?php echo $incidencia_demora_mmpp_line['id_salida']; ?>" type="button" id="<?php echo $incidencia_demora_mmpp_line['id_salida']; ?>" class="btn btn-sm btn-default view_record2" title="Ver"><?php echo $incidencia_demora_mmpp_line['num_expedicion_salida']; ?></a>
                          <?php } elseif ($incidencia_demora_mmpp_line['tipo_salida'] === 'CAMIÓN') { ?>
                            <a target="_blank" href="../controllers/salida_resumen_controller.php?id_salida=<?php echo $incidencia_demora_mmpp_line['id_salida']; ?>" type="button" id="<?php echo $incidencia_demora_mmpp_line['id_salida']; ?>" class="btn btn-sm btn-default view_record2" title="Ver"><?php echo $incidencia_demora_mmpp_line['salida_camion']; ?></a>
                          <?php } ?>
                        </div>
                      </center>
                    </td>
                    <td><?php echo $incidencia_demora_mmpp_line['fecha_salida']; ?></td>
                    <td><?php echo $incidencia_demora_mmpp_line['tipo_salida']; ?></td>
                    <td><?php echo $incidencia_demora_mmpp_line['nombre_comercial_propietario']; ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <div class="col-md-1"></div>
        </div>
      <?php } ?>

      <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
          <table id="table_incidencia_observaciones" class="table table-striped table-bordered" style="font-size: 12px;">
            <thead>
              <tr>
                <th class="warning">Observaciones</th>
                <th class="warning">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($incidencia as $incidencia_datos) { ?>
                <tr data-id="<?php echo $incidencia_datos['id_incidencia']; ?>" data-type="incidencia">
                  <td contenteditable="false"><?php echo $incidencia_datos['observaciones']; ?></td>
                  <td>
                    <center>
                      <div class="btn-group">
                        <a type="button" id="" class="btn-editar btn-sm btn-info" title=""><span class="glyphicon glyphicon-pencil"></span></a>
                        <a type="button" id="" class="btn-guardar btn-sm btn-success" style="display:none;" title=""><span class="glyphicon glyphicon-floppy-disk"></span></a>
                      </div>
                    </center>
                    <!-- <button class="btn-editar"><i class="fa fa-pencil" style="font-size:18px"></i></button>
                    <button class="btn-guardar" style="display:none;"><i class="fa fa-floppy-o"></i></button>-->
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <div class="col-md-3"></div>
      </div>
      <script>
        $(document).ready(function() {

          $('#table_incidencia_observaciones').DataTable();
          //$('#menu').metisMenu();

          $('.btn-editar').click(function() {
            let row = $(this).closest('tr');
            let cells = row.find('td[contenteditable]');
            cells.attr('contenteditable', true);
            row.find('.btn-guardar').show();
            $(this).hide();
          });

          $('.btn-guardar').click(function() {
            let row = $(this).closest('tr');
            let cells = row.find('td[contenteditable]');
            cells.attr('contenteditable', false);
            row.find('.btn-editar').show();
            $(this).hide();

            // Obtener los datos de la fila
            let id = row.data('id');
            let type = row.data('type');
            let observaciones = cells[0].innerText;

            // Crear el payload para enviar
            let payload = {
              id: id,
              type: type,
              observaciones: observaciones
            };

            // Enviar los datos al servidor usando $.ajax
            $.ajax({
              url: '../ajax/cambiar_observaciones.php',
              type: 'POST',
              contentType: 'application/json',
              data: JSON.stringify(payload),
              success: function(data) {
                if (data.success) {
                  alert('Datos guardados exitosamente');
                }
                /* else {
									alert('Hubo un error al guardar los datos: ' + data.message);
								}
                */
              },
              error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('Hubo un error al guardar los datos');
              }
            });

          });

        });
      </script>





      <center>
        <h3>Eventos</h3>
        <a href="#" type="button" id="" class="btn btn-success add_record" title="Alta evento"><i class="glyphicon glyphicon-plus"></i> Evento</a>
      </center>

      <br>

      <?php //if (count($incidencia_eventos) > 0) {
      ?>
      <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
          <table id="table_incidencia_eventos" class="table table-striped table-bordered" style="font-size: 12px;">
            <thead>
              <tr>
                <th>Fecha</th>
                <th>Nombre evento</th>
                <th class="warning">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($incidencia_eventos as $incidencia_evento) { ?>
                <tr id="<?php echo $incidencia_evento['id_evento']; ?>">
                  <td><?php echo $incidencia_evento['fecha_evento']; ?></td>
                  <td><?php echo $incidencia_evento['nombre_evento']; ?></td>
                  <td>
                    <center>
                      <div class="btn-group">
                        <a href="#" type="button" id="<?php echo $incidencia_evento['id_evento']; ?>" class="btn btn-sm btn-default view_record" title="Ver Evento"><span class="glyphicon glyphicon-eye-open"></span></a>
                        <a href="#" type="button" id="<?php echo $incidencia_evento['id_evento']; ?>" class="btn btn-sm btn-success edit_record" title="Editar Evento"><span class="glyphicon glyphicon-pencil"></span></a>
                        <a href="#" type="button" id="<?php echo $incidencia_evento['id_evento']; ?>" class="btn btn-sm btn-danger delete_record" title="Borrar Evento"><span class="glyphicon glyphicon-trash"></span></a>
                      </div>
                    </center>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <div class="col-md-1"></div>
      </div>
      <br>
      <?php //}
      ?>

      <script>
        $(document).ready(function() {
          table_incidencia_eventos = $('#table_incidencia_eventos').DataTable({
            columns: [{
                data: 'fecha_evento'
              },
              {
                data: 'nombre_evento'
              },
              {
                data: 'acciones_evento'
              },
            ],
            columnDefs: [{
                "targets": 0,
                "className": "text-center",
                "width": "10%"
              },
              {
                "targets": 1,
                "className": "text-center",
                "width": "80%"
              },
              {
                "targets": 2,
                "className": "text-center",
                "width": "10%"
              }
            ],
            order: [
              [0, 'asc']
            ],
            ordering: true,
            autoWidth: false,
            iDisplayLength: -1,
            //scrollY: '10vh',
            bPaginate: false,
            bFilter: false,
            bInfo: false,
            bScrollCollapse: true
          });
        });
      </script>
    </div>
  </div>
  <!-- /#wrapper -->
  </div>
</body>

</html>
