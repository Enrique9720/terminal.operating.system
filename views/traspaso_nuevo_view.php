<!DOCTYPE html>
<html lang="es">

<head>
  <title>Traspaso</title>
  <?php
  //Plantilla con los inludes de las librerias y CSS usados por todas las paginas de la APP
  require_once('../tpl/header_includes.php');
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

      //Establecemos inputs de fecha y hora de entrada
      var now = new Date();
      var now2 = new Date(now.getFullYear(), now.getMonth(), now.getDate(), now.getHours() + 1, now.getMinutes());
      $('#fecha_traspaso')[0].valueAsDate = now2;
      $('#hora_traspaso')[0].valueAsDate = now2;

      //cargamos select2 de contenedores en stock
      load_ajax_select2("#num_cont_1", "", "../ajax/contenedores_stock_list.php");
      load_select2("#propietario_cont_nuevo", "");
      //al elegir un contenedor, ponemos sus datos en los inputs correspondientes
      $('#num_cont_1').change(function() {
        num_cont_1 = $('#num_cont_1').find(":selected").text();
        //console.log(num_cont_1);
        $.ajax({
          type: "POST",
          url: "../ajax/get_contenedor.php",
          data: {
            num_cont_1: num_cont_1
          },
          success: function(returned) {
            var obj = $.parseJSON(returned);
            jQuery(obj).each(function(i, item) {
              text = item.text;
              if (text != 'No hay resultados') {
                id = item.id;
                id_tipo_contenedor_iso = item.id_tipo_contenedor_iso;
                longitud_tipo_contenedor = item.longitud_tipo_contenedor;
                descripcion_tipo_contenedor = item.descripcion_tipo_contenedor;
                cif_propietario_anterior = item.cif_propietario_actual;
                nombre_comercial_propietario = item.nombre_comercial_propietario;

                $("#id_tipo_cont_1").val(id_tipo_contenedor_iso);
                $("#longitud_cont_1").val(longitud_tipo_contenedor);
                $("#descripcion_cont_1").val(descripcion_tipo_contenedor);
                $("#nombre_comercial_propietario_cont_anterior").val(nombre_comercial_propietario);
                $("#propietario_cont_anterior").val(cif_propietario_anterior);

                //eliminar option del propietario en el select
                $("#propietario_cont_nuevo option[value='" + cif_propietario_anterior + "']").each(function() {
                  $(this).remove();
                });

              } else {
                //alert(text);
                //borramos datos al borrar el num_contenedor
                $("#id_tipo_cont_1").val('');
                $("#longitud_cont_1").val('');
                $("#descripcion_cont_1").val('');
                $("#propietario_cont_anterior").val('');
                //restablecer select propietario
                $('#propietario_cont_nuevo').empty();
                $('#propietario_cont_nuevo').append('<option value=""></option>');

                $.ajax({
                  url: "../ajax/get_propietarios.php",
                  type: "POST",
                  dataType: "json",
                  async: false,
                  data: {},
                  cache: false,
                  success: function(result) {
                    $.each(result.value, function(index, value) {
                      //por cada propietario
                      cif_propietario = value.cif_propietario;
                      nombre_comercial_propietario = value.nombre_comercial_propietario;
                      $('#propietario_cont_nuevo').append('<option value="' + cif_propietario + '">' + nombre_comercial_propietario + '</option>');
                    });
                  },
                  error: function() {}
                });
              }
            })
          },
          error: function() {
            alert("failure");
          }
        });
      });

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

      <form role="form" autocomplete="off" action="../controllers/traspaso_nuevo_controller.php" method="post" id="form_traspaso" name="form_traspaso">

        <div class="row">
          <div class="col-lg-12" style="margin-top:20px;padding-left:0;">
            <div class="well well-sm">
              <?php if ($_SESSION['roles_array'][0]['nombre_rol'] == "admin") : ?><button type="submit" class="btn btn-primary btn_guardar" id="submit" name="submit"><i class="fa fa-lg fa-save"></i> Guardar</button><?php endif; ?>
              <a class="btn btn-default" onclick="window.location.reload()"><i class="glyphicon glyphicon-refresh"></i> Recargar</a>
            </div>
          </div>
        </div>

        <center>
          <h3><i class="fas fa-exchange-alt"></i> Nuevo Traspaso</h3>
        </center>

        <div class="col-lg-12" style="margin-top:20px;padding-left:0;">

          <div class="row">
            <div class="col-sm-3 col-xs-0"></div>
            <div class="col-sm-3 col-xs-6">
              <div class="form-group">
                <label>Fecha:</label>
                <input type="date" class="form-control" id="fecha_traspaso" name="fecha_traspaso" required>
              </div>
            </div>
            <div class="col-sm-3 col-xs-6">
              <div class="form-group">
                <label>Hora:</label>
                <input type="time" class="form-control" id="hora_traspaso" name="hora_traspaso" step="60" required>
              </div>
            </div>
            <div class="col-sm-3 col-xs-0"></div>
          </div>

          <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Nº Contenedor:</label>
                <select class="form-control num_cont select2" id="num_cont_1" name="num_cont_1" required></select>
                <div id="error_contenedor"></div>
              </div>
            </div>
            <div class="col-sm-3"></div>
          </div>

          <div class="row">
            <div class="col-sm-3 col-xs-0"></div>
            <div class="col-sm-3 col-xs-6">
              <div class="form-group">
                <input type="text" class="form-control id_tipo_cont" id="id_tipo_cont_1" name="id_tipo_cont_1" placeholder="Tipo" readonly>
              </div>
            </div>
            <div class="col-sm-3 col-xs-6">
              <div class="form-group">
                <input type="text" class="form-control longitud_cont" id="longitud_cont_1" name="longitud_cont_1" placeholder="Longitud" readonly>
              </div>
            </div>
            <div class="col-sm-3 col-xs-0"></div>
          </div>

          <div class="row">
            <div class="col-sm-3 col-xs-0"></div>
            <div class="col-sm-3 col-xs-6">
              <div class="form-group">
                <input type="text" class="form-control descripcion_cont" id="descripcion_cont_1" name="descripcion_cont_1" placeholder="Descripción" readonly>
              </div>
            </div>
            <div class="col-sm-3 col-xs-6">
              <div class="form-group">
                <input type="text" class="form-control" id="nombre_comercial_propietario_cont_anterior" name="nombre_comercial_propietario_cont_anterior" placeholder="Propietario" readonly>
                <input type="hidden" id="propietario_cont_anterior" name="propietario_cont_anterior" value="">
              </div>
            </div>
            <div class="col-sm-3 col-xs-0"></div>
          </div>

          <div class="row">
            <div class="col-sm-3 col-xs-0"></div>
            <div class="col-sm-6 col-xs-12">
              <div class="form-group">
                <label>Propietario:</label>
                <select class="form-control propietario_cont_nuevo select_2" id="propietario_cont_nuevo" name="propietario_cont_nuevo" required>
                  <option value=''></option>
                  <?php foreach ($propietarios_list as $propietarios_line) {
                    echo "<option value='" . $propietarios_line['cif_propietario'] . "'>" . $propietarios_line['nombre_comercial_propietario'] . "</option>";
                  } ?>
                </select>
              </div>
            </div>
            <div class="col-sm-3 col-xs-0"></div>
          </div>

        </div> <!--Fin div col-lg-12-->
      </form>

    </div>
  </div>
  <!-- /#wrapper -->
  </div>
</body>

</html>