<!DOCTYPE html>
<html lang="es">

<head>
  <title>Parte de Trabajo Nº <?php echo $id_parte_trabajo; ?></title>
  <?php
  //Plantilla con los inludes de las librerias y CSS usados por todas las paginas de la APP
  require_once('../tpl/header_includes.php');
  ?>

  <script>
    $(document).ready(function() {

      //Reenvio de CODECO erroneo
      //al hacer click en el boton de reenvio codeco
      $(document).on('click', '.resend_codeco', function(event) {
        $.ajax({
          type: "POST",
          url: "../ajax/resend_codeco.php",
          data: {
            'id_codeco': this.id,
          }, //recogemos el id del boton de view_record
          success: function(returned) {
            var obj = $.parseJSON(returned);
            jQuery(obj).each(function(i, item) {
              text = item.text;
              if (text == 'success') {
                location.reload();
              } else {
                alert(text);
              }
            })
          },
          error: function() {
            alert("failure");
          }
        });
      });
    });

    table_entrada_camion_incidencia = $('#table_averia_reefer_daño_uti_incidencia').DataTable({
      columns: [{
          data: 'num_incidencia'
        },
        {
          data: 'tipo_incidencia'
        },
        {
          data: 'estado_incidencia'
        }
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
  </script>

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

      <form role="form" autocomplete="off" action="" method="post" id="form_parte_trabajo">

        <div class="row">
          <div class="col-md-12" style="margin-top:20px;padding-left:0;">
            <div class="well well-sm">
              <a class="btn btn-success" href="../controllers/parte_trabajo_nuevo_controller.php"><i class="glyphicon glyphicon-plus"></i> Nuevo Parte</a>
              <a class="btn btn-default" onclick="window.location.reload()"><i class="glyphicon glyphicon-refresh"></i> Recargar</a>
            </div>
          </div>
        </div>

        <center>
          <h3><i class="fas fa-wrench"></i> Parte de Trabajo Nº <?php echo $id_parte_trabajo; ?></h3>
        </center>

        <div class="row">
          <div class="col-md-4"></div>
          <div class="col-md-4">
            <table id="table_parte_trabajo_cabecera" class="table table-striped table-bordered" style="font-size: 12px;">
              <thead>
                <tr>
                  <th>Fecha Parte</th>
                  <th>Trabajador</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($parte_trabajo as $parte_trabajo_datos) { ?>
                  <tr>
                    <td><?php echo $parte_trabajo_datos['fecha_parte_trabajo']; ?></td>
                    <td><?php echo $parte_trabajo_datos['user_insert']; ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <div class="col-md-4"></div>
        </div>

        <div class="row">
          <div class="col-md-4"></div>
          <div class="col-md-4">
            <table id="table_parte_trabajo_contenedor" class="table table-striped table-bordered" style="font-size: 12px;">
              <thead>
                <tr>
                  <th class="warning">Nº Contenedor</th>
                  <th class="warning">Tipo</th>
                  <th class="warning">Longitud</th>
                  <th class="warning">Descripción</th>
                  <th class="warning">Propietario</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($parte_trabajo as $parte_trabajo_datos) { ?>
                  <tr>
                    <td><?php echo $parte_trabajo_datos['num_contenedor']; ?></td>
                    <td><?php echo $parte_trabajo_datos['id_tipo_contenedor_iso']; ?></td>
                    <td><?php echo $parte_trabajo_datos['longitud_tipo_contenedor']; ?></td>
                    <td><?php echo $parte_trabajo_datos['descripcion_tipo_contenedor']; ?></td>
                    <td><?php echo $parte_trabajo_datos['nombre_comercial_propietario']; ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <div class="col-md-4"></div>
        </div>

        <div class="row">
          <div class="col-md-5"></div>
          <div class="col-md-2">
            <table id="table_parte_trabajo_lineas" class="table table-striped table-bordered" style="font-size: 12px;">
              <thead>
                <tr>
                  <th>Trabajo Realizado</th>
                  <!--<th>Categoría</th> -->
                </tr>
              </thead>
              <tbody>
                <?php foreach ($parte_trabajo_lineas as $parte_trabajo_linea) { ?>
                  <tr>
                    <td><?php echo $parte_trabajo_linea['tipo_trabajo']; ?></td>
                    <!-- <td><?php //echo $parte_trabajo_linea['categoria']; ?></td> -->
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <div class="col-md-5"></div>
        </div>


        <div class="row">
          <div class="col-md-3"></div>
          <div class="col-md-6">
            <table id="table_parte_trabajo_observaciones" class="table table-striped table-bordered" style="font-size: 12px;">
              <thead>
                <tr>
                  <th>Observaciones</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($parte_trabajo as $parte_trabajo_datos) { ?>
                  <tr>
                    <td><?php echo $parte_trabajo_datos['observaciones']; ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <div class="col-md-3"></div>
        </div>


        <div class="row">
          <center>
            <h3>Fotos</h3>
          </center>
          <div class="col-md-4"></div>
          <div class="col-md-4">
            <div id="fotos_contenedor" class="fotorama" data-height="600">
              <?php foreach ($fotos_list as $fotos_line) {
                echo "<img src='" . $fotos_line['ruta_fichero'] . "'>";
              } ?>
            </div>
          </div>
          <div class="col-md-4"></div>
        </div>

        <div class="row">
          <div class="col-sm-12">
            <center>
              <h3>Incidencia</h3>
            </center>
          </div>
          <div class="col-sm-3"></div>
          <div class="col-sm-6">
            <table id="table_averia_reefer_daño_uti_incidencia" class="table table-striped table-bordered" style="font-size: 12px;">
              <thead>
                <tr>
                  <th>Num Incidencia</th>
                  <th>Tipo Incidencia</th>
                  <th>Estado Incidencia</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($averia_daño_incidencia_list as $averia_daño_incidencia_line) { ?>
                  <tr>
                    <td>
                      <center><a target="_blank" href="../controllers/incidencia_controller.php?id_incidencia=<?php echo $averia_daño_incidencia_line['id_incidencia']; ?>" type="button" id="<?php echo $averia_daño_incidencia_line['id_incidencia']; ?>" class="btn btn-sm btn-default view_record" title="Ver"><?php echo $averia_daño_incidencia_line['num_incidencia']; ?></a></center>
                    </td>
                    <td><?php echo $averia_daño_incidencia_line['tipo_incidencia']; ?></td>
                    <td><?php echo $averia_daño_incidencia_line['estado_incidencia']; ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <div class="col-sm-3"></div>
        </div>

        <div class="row">
          <div class="col-sm-12">
            <center>
              <h4>CODECO</h4>
            </center>
          </div>
          <div class="col-sm-3"></div>
          <div class="col-sm-6">

            <table id="table_envio_codeco" class="table table-striped table-bordered" style="font-size: 12px;">
              <thead>
                <tr>
                  <th>ID Codeco</th>
                  <th>Nº Contenedor</th>
                  <th>Estado envío</th>
                  <th>Error</th>
                  <th>Correo</th>
                </tr>

                <?php foreach ($codeco_info_list as $codeco_info_line) { ?>
                  <tr>
                    <td><?php echo $codeco_info_line['id_codeco']; ?></td>
                    <td><?php echo $codeco_info_line['num_contenedor']; ?></td>
                    <td>
                      <?php
                      //echo $codeco_info_line['check_envio'];
                      if ($codeco_info_line['check_envio'] == 1) {
                        echo "<i class='fa fa-check-circle fa-lg text-success' aria-hidden='true'></i>";
                      } else {
                        echo "<i class='fa fa-times-circle fa-lg text-danger' aria-hidden='true'></i>";
                      }
                      ?>
                    </td>
                    <td><?php echo $codeco_info_line['error_envio']; ?></td>
                    <td><!-- Correo -->
                      <?php
                      if ($codeco_info_line['check_envio'] == 0) { ?>
                        <a href="#" type="button" id="<?php echo $codeco_info_line['id_codeco']; ?>" class="btn btn-warning resend_codeco" title="Reenviar Codeco">
                          <span class="fa fa-send-o" aria-hidden="false"></span> Reenviar Correo </a>
                      <?php } ?>
                    </td>
                  </tr>
                <?php } ?>
              </thead>

              <tbody>
              </tbody>
            </table>


          </div>
          <div class="col-sm-3"></div>
        </div>
        
      </form>
    </div>
  </div>
  <!-- /#wrapper -->
  </div>
</body>

</html>