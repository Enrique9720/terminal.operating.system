<!DOCTYPE html>
<html lang="es">

<head>
  <title>Transbordo <?php echo $id_transbordo; ?></title>
  <?php
  require_once('../tpl/header_includes.php');
  ?>
  <style>
    .section-header {
      background-color: #f7f7f7;
      padding: 5px;
      margin-bottom: 20px;
      border: 1px solid #ddd;
      border-radius: 2px;
      text-align: left;
      font-weight: bold;
      font-size: 1.1em;
    }

    .section-container {
      margin-bottom: 30px;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
      background-color: #fafafa;
    }

    table {
      width: 100%;
      margin-bottom: 20px;
      font-size: 14px;
    }

    table th,
    table td {
      text-align: center;
      vertical-align: middle;
    }

    .highlight-origin {
      border-left: 3px solid #28a745;
      border-right: 3px solid #28a745;
      border-top: 3px solid #28a745;
      border-bottom: 3px solid #28a745;
    }

    .highlight-destination {
      border-left: 3px solid #007bff;
      border-right: 3px solid #007bff;
      border-top: 3px solid #007bff;
      border-bottom: 3px solid #007bff;
    }
  </style>
</head>

<body>
  <div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
      <?php
      require_once("../tpl/header_menu.php");
      require_once("../tpl/aside.php");
      ?>
    </nav>

    <div class="container-fluid" id="page-wrapper">
      <form role="form" autocomplete="off" action="" method="post" id="form_transbordo">

        <div class="row">
          <div class="col-lg-12">
            <div class="well well-sm">
              <a class="btn btn-success" href="../controllers/transbordo_nuevo_controller.php"><i class="glyphicon glyphicon-plus"></i> Nuevo Transbordo</a>
              <a class="btn btn-default" onclick="window.location.reload()"><i class="glyphicon glyphicon-refresh"></i> Recargar</a>
            </div>
          </div>
        </div>

        <center>
          <h3><i class="fas fa-wrench"></i> Transbordo de Mercancía <?php echo $id_transbordo; ?></h3>
        </center>

        <!-- ORIGEN -->
        <div class="section-container highlight-origin">
          <div class="section-header">DETALLES DEL CONTENEDOR ORIGEN</div>

          <table id="table_transbordo_cabecera" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Fecha Transbordo</th>
                <th>Nº Contenedor Origen</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($transbordos_list as $transbordos_line) { ?>
                <tr>
                  <td><?php echo $transbordos_line['fecha_transbordo']; ?></td>
                  <td><?php echo $transbordos_line['num_contenedor_origen']; ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>

          <table id="table_transbordo_lineas" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Estado Carga</th>
                <th>Peso Mercancía</th>
                <th>Nº Booking</th>
                <th>Nº Precinto</th>
                <th>Temperatura</th>
                <th>Tipo Mercancía</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($transbordos_list as $transbordos_line) { ?>
                <tr>
                  <!--<td><?php //echo $transbordos_line['estado_carga_contenedor_origen']; ?></td>-->
                  <td>
                    <?php
                    echo $transbordos_line['estado_carga_contenedor_origen'] === 'C' ? 'CARGADO' : ($transbordos_line['estado_carga_contenedor_origen'] === 'V' ? 'VACÍO' : '');
                    ?>
                  </td>
                  <td><?php echo $transbordos_line['peso_mercancia_actual_contenedor_origen']; ?></td>
                  <td><?php echo $transbordos_line['num_booking_actual_contenedor_origen']; ?></td>
                  <td><?php echo $transbordos_line['num_precinto_actual_contenedor_origen']; ?></td>
                  <td><?php echo $transbordos_line['temperatura_actual_contenedor_origen']; ?></td>
                  <td><?php echo $transbordos_line['descripcion_mercancia_origen']; ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>

          <table id="table_transbordo_lineas" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Nº Peligro</th>
                <th>Nº ONU</th>
                <th>Clase</th>
                <th>Grupo Embalaje</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($transbordos_list as $transbordos_line) { ?>
                <tr>
                  <td><?php echo $transbordos_line['num_peligro_adr_actual_contenedor_origen']; ?></td>
                  <td><?php echo $transbordos_line['num_onu_adr_actual_contenedor_origen']; ?></td>
                  <td><?php echo $transbordos_line['num_clase_adr_actual_contenedor_origen']; ?></td>
                  <td><?php echo $transbordos_line['cod_grupo_embalaje_adr_actual_contenedor_origen']; ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>

        <!-- DESTINO -->
        <div class="section-container highlight-destination">
          <div class="section-header">DETALLES DEL CONTENEDOR DESTINO</div>

          <table id="table_transbordo_contenedor_destino" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Nº Contenedor Destino</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($transbordos_list as $transbordos_line) { ?>
                <tr>
                  <td><?php echo $transbordos_line['num_contenedor_destino']; ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>

          <table id="table_transbordo_lineas_destino" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Estado Carga</th>
                <th>Peso Mercancía</th>
                <th>Nº Booking</th>
                <th>Nº Precinto</th>
                <th>Temperatura</th>
                <th>Tipo Mercancía</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($transbordos_list as $transbordos_line) { ?>
                <tr>
                  <!--<td><?php //echo $transbordos_line['estado_carga_contenedor_destino']; ?></td>-->
                  <td>
                    <?php
                    echo $transbordos_line['estado_carga_contenedor_destino'] === 'C' ? 'CARGADO' : ($transbordos_line['estado_carga_contenedor_destino'] === 'V' ? 'VACÍO' : '');
                    ?>
                  </td>
                  <td><?php echo $transbordos_line['peso_mercancia_actual_contenedor_destino']; ?></td>
                  <td><?php echo $transbordos_line['num_booking_actual_contenedor_destino']; ?></td>
                  <td><?php echo $transbordos_line['num_precinto_actual_contenedor_destino']; ?></td>
                  <td><?php echo $transbordos_line['temperatura_actual_contenedor_destino']; ?></td>
                  <td><?php echo $transbordos_line['descripcion_mercancia_destino']; ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>

          <table id="table_transbordo_lineas_destino" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Nº Peligro</th>
                <th>Nº ONU</th>
                <th>Clase</th>
                <th>Grupo Embalaje</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($transbordos_list as $transbordos_line) { ?>
                <tr>
                  <td><?php echo $transbordos_line['num_peligro_adr_actual_contenedor_destino']; ?></td>
                  <td><?php echo $transbordos_line['num_onu_adr_actual_contenedor_destino']; ?></td>
                  <td><?php echo $transbordos_line['num_clase_adr_actual_contenedor_destino']; ?></td>
                  <td><?php echo $transbordos_line['cod_grupo_embalaje_adr_actual_contenedor_destino']; ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
    </div>

    </form>
  </div>
  </div>
</body>

</html>