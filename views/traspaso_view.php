<!DOCTYPE html>
<html lang="es">

<head>
  <title>Traspaso <?php echo $id_traspaso; ?></title>
  <?php
  //Plantilla con los inludes de las librerias y CSS usados por todas las paginas de la APP
  require_once('../tpl/header_includes.php');
  ?>

  <script>
    /*$(document).ready(function() {
      table_traspaso_lineas = $('#table_traspaso_cabecera').DataTable({
        columns: [
          { data: 'fecha_traspaso' },
          { data: 'num_contenedor' }
        ],
        ordering: false,
        autoWidth: true,
        iDisplayLength: -1,
        scrollX: true,
        //scrollY: '10vh',
        bPaginate: false,
        bFilter: false,
        bInfo: false,
        bScrollCollapse: true
      });
    });
    
    $(document).ready(function() {
      table_traspaso_lineas = $('#table_traspaso_lineas').DataTable({
        columns: [
          { data: 'estado_carga_contenedor' },
          { data: 'descripcion_mercancia' },
          { data: 'num_peligro_adr' },
          { data: 'num_onu_adr' },
          { data: 'num_clase_adr' },
          { data: 'cod_grupo_embalaje_adr' },
          { data: 'peso_mercancia_contenedor' },
          { data: 'peso_bruto_contenedor' },
          { data: 'num_booking_contenedor' },
          { data: 'num_precinto_contenedor' },
          { data: 'temperatura_contenedor' }
        ],
        ordering: false,
        autoWidth: true,
        iDisplayLength: -1,
        scrollX: true,
        //scrollY: '10vh',
        bPaginate: false,
        bFilter: false,
        bInfo: false,
        bScrollCollapse: true
      });
    });*/
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

      <form role="form" autocomplete="off" action="" method="post" id="form_traspaso">

        <div class="row">
          <div class="col-lg-12" style="margin-top:20px;padding-left:0;">
            <div class="well well-sm">
              <a class="btn btn-success" href="../controllers/traspaso_nuevo_controller.php"><i class="glyphicon glyphicon-plus"></i> Nuevo Traspaso</a>
              <a class="btn btn-default" onclick="window.location.reload()"><i class="glyphicon glyphicon-refresh"></i> Recargar</a>
            </div>
          </div>
        </div>

        <center>
          <h3><i class="fas fa-wrench"></i> Traspaso <?php echo $id_traspaso; ?></h3>
        </center>

        <div class="col-lg-12" style="margin-top:20px;padding-left:0;">
          <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
              <table id="table_traspaso_cabecera" class="table table-striped table-bordered" style="font-size: 12px;">
                <thead>
                  <tr>
                    <th>Fecha Traspaso</th>
                    <th>Nº Contenedor</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($traspasos_list as $traspasos_line) { ?>
                    <tr>
                      <td><?php echo $traspasos_line['fecha_traspaso']; ?></td>
                      <td><?php echo $traspasos_line['num_contenedor']; ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <div class="col-sm-4"></div>
          </div>

          <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
              <table id="table_traspaso_contenedor" class="table table-striped table-bordered" style="font-size: 12px;">
                <thead>
                  <tr>
                    <th>CIF Propietario Anterior</th>
                    <th>Propietario Anterior</th>
                    <th>CIF Propietario Actual</th>
                    <th>Propietario Actual</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($traspasos_list as $traspasos_line) { ?>
                    <tr>
                      <td><?php echo $traspasos_line['cif_propietario_anterior']; ?></td>
                      <td><?php echo $traspasos_line['nombre_comercial_propietario_anterior']; ?></td>
                      <td><?php echo $traspasos_line['cif_propietario_actual']; ?></td>
                      <td><?php echo $traspasos_line['nombre_comercial_propietario_actual']; ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <div class="col-sm-3"></div>
          </div>

          <br />

          <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
              <table id="table_traspaso_lineas" class="table table-striped table-bordered" style="font-size: 12px;">
                <thead>
                  <tr>
                    <th>Estado</th>
                    <th>Tipo Mercancía</th>
                    <th>Peso Mercancía</th>
                    <th>Peso Bruto</th>
                    <th>Nº Booking</th>
                    <th>Nº Precinto</th>
                    <th>Temperatura</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($traspasos_list as $traspasos_line) { ?>
                    <tr>
                      <td><?php echo $traspasos_line['estado_carga_contenedor']; ?></td>
                      <td><?php echo $traspasos_line['descripcion_mercancia']; ?></td>
                      <td><?php echo $traspasos_line['peso_mercancia_contenedor']; ?></td>
                      <td><?php echo $traspasos_line['peso_bruto_contenedor']; ?></td>
                      <td><?php echo $traspasos_line['num_booking_contenedor']; ?></td>
                      <td><?php echo $traspasos_line['num_precinto_contenedor']; ?></td>
                      <td><?php echo $traspasos_line['temperatura_contenedor']; ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <div class="col-sm-1"></div>
          </div>

          <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
              <table id="table_traspaso_lineas2" class="table table-striped table-bordered" style="font-size: 12px;">
                <thead>
                  <tr>
                    <th>Nº Peligro</th>
                    <th>Nº ONU</th>
                    <th>Clase</th>
                    <th>Grupo Embalaje</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($traspasos_list as $traspasos_line) { ?>
                    <tr>
                      <td><?php echo $traspasos_line['num_peligro_adr']; ?></td>
                      <td><?php echo $traspasos_line['num_onu_adr']; ?></td>
                      <td><?php echo $traspasos_line['num_clase_adr']; ?></td>
                      <td><?php echo $traspasos_line['cod_grupo_embalaje_adr']; ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <div class="col-sm-1"></div>
          </div>

          <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
              <table id="table_traspaso_observaciones" class="table table-striped table-bordered" style="font-size: 12px;">
                <thead>
                  <tr>
                    <th>Estacion Ferrocarril</th>
                    <th>Destinatario</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($traspasos_list as $traspasos_line) { ?>
                    <tr>
                      <td><?php echo $traspasos_line['codigo_estacion_ferrocarril_actual_contenedor']; ?></td>
                      <td><?php echo $traspasos_line['id_destinatario_actual']; ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <div class="col-sm-3"></div>
          </div>

          <!---------------
          <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
              <table id="table_traspaso_observaciones" class="table table-striped table-bordered" style="font-size: 12px;">
                <thead>
                  <tr>
                    <th>Observaciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php //foreach ($traspaso as $traspaso_datos) { ?>
                    <tr>
                      <td><?php //echo $traspaso_datos['observaciones']; ?></td>
                    </tr>
                  <?php //} ?>
                </tbody>
              </table>
            </div>
            <div class="col-sm-3"></div>
          </div>
          --------------->

          <!-- <div class="row">
            <center>
              <h3>Fotos</h3>
            </center>
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
              <div id="fotos_contenedor" class="fotorama" data-height="600">
                <?php //foreach ($fotos_list as $fotos_line) {
                  //echo "<img src='" . $fotos_line['ruta_fichero'] . "'>";
                //} ?>
              </div>
            </div>
            <div class="col-sm-4"></div>
          </div> -->

        </div> <!--Fin div col-lg-12-->
      </form>

    </div>
  </div>
  <!-- /#wrapper -->
  </div>
</body>

</html>
