<!DOCTYPE html>
<html lang="es">

<head>
  <title>Parte de Trabajo</title>
  <?php
  //Plantilla con los inludes de las librerias y CSS usados por todas las paginas de la APP
  require_once('../tpl/header_includes.php');
  ?>
  <!--Subida de ficheros-->
  <link rel="stylesheet" href="../css/upload_photo.css">
  <script src="../js/upload_photo.js"></script>
  <script>
    jQuery(document).ready(function() {
      ImgUpload();
    });
  </script>


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
      $('#fecha_parte_trabajo')[0].valueAsDate = now2;
      $('#hora_parte_trabajo')[0].valueAsDate = now2;

      //cargamos select2 de contenedores en stock
      load_ajax_select2("#num_cont_1", "", "../ajax/contenedores_stock_list.php");
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
                cif_propietario_actual = item.cif_propietario_actual;
                nombre_comercial_propietario = item.nombre_comercial_propietario;

                if (descripcion_tipo_contenedor.toUpperCase().indexOf("REEFER") >= 0) {
                  $('#AVERÍA').prop("disabled", false);
                } else {
                  $('#AVERÍA').prop("disabled", true);
                  $('#AVERÍA').prop("checked", false);
                }
                $("#id_tipo_cont_1").val(id_tipo_contenedor_iso);
                $("#longitud_cont_1").val(longitud_tipo_contenedor);
                $("#descripcion_cont_1").val(descripcion_tipo_contenedor);
                $("#propietario_cont_1").val(nombre_comercial_propietario);
              } else {
                //alert(text);
                //borramos datos al borrar el num_contenedor
                $('#AVERÍA').prop("disabled", false);
                $("#id_tipo_cont_1").val('');
                $("#longitud_cont_1").val('');
                $("#descripcion_cont_1").val('');
                $("#propietario_cont_1").val('');
              }
            })
          },
          error: function() {
            alert("failure");
          }
        });
      });

      //al marcar alguna incidencia
      $(".checkbox_inciencia").change(function() {
        if (this.checked) {
          $(this).parent().find('.form-check-label').css('color', 'red');
        } else {
          $(this).parent().find('.form-check-label').css('color', '#333');
        }
      });
    });

    $(document).ready(function() {
      $("form#form_parte_trabajo").submit(function(event) {

        event.preventDefault(); //prevenir el envio del form via ajax, hasta que no esten todos los campos requeridos
        var form_upload_file = new FormData(this);

        $.ajax({
          xhr: function() { //Callback for creating the XMLHttpRequest object
            var httpReq = new XMLHttpRequest(); //monitor an upload's progress. //amount of progress
            httpReq.upload.addEventListener("progress", function(ele) {
              if (ele.lengthComputable) { //property is a boolean flag indicating if the resource concerned by the ProgressEvent has a length that can be calculated.
                var percentage = ((ele.loaded / ele.total) * 100);
                $("#progress-bar").css("width", percentage + "%");
                $("#progress-bar").html(Math.round(percentage) + "%");
              }
            });
            return httpReq;
          },
          type: "POST",
          url: "../ajax/validar_parte_trabajo.php",
          contentType: false,
          processData: false, //If you want to send a DOMDocument, or other non-processed data, set this option to false.
          data: form_upload_file,
          beforeSend: function() {
            $("#progress-bar").css("width", "0%");
            $("#progress-bar").html("0%");
            $("#files").prop('disabled', true);
            $("#validar").prop('disabled', true);
          },
          success: function(returned) {

            //$("#resultado_validacion").empty();
            //$("#resultado_ubicacion").empty();
            $("#resultado_upload").empty();
            var obj = $.parseJSON(returned);
            jQuery(obj).each(function(i, item) {

              num_contenedor = item.num_contenedor;
              id_parte_trabajo = item.id_parte_trabajo;
              status = item.status;
              text_fichero = item.text_fichero;

              $(text_fichero).each(function(i, item) {
                id_foto = item.id_foto;
                file = item.file;
                text = item.text;
                ruta_foto = item.ruta_foto;
                $("#resultado_upload").append(text);
              });

              if (status == 'success') {
                alert("Parte Trabajo dado de alta en el sistema correctamente");
                document.location = '../controllers/parte_trabajo_controller.php?id_parte=' + id_parte_trabajo;
              } else {
                alert("ERROR: hubo algún fallo al crear el parte"); //
              }

            })


          },
          error: function(xhr) {
            $("#resultado_upload").html("Upload Failed : " + xhr.statusText);
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

      <!--<form role="form" autocomplete="off" action="" method="post" id="form_parte_trabajo">-->
      <form method="POST" id="form_parte_trabajo" name="form_parte_trabajo" enctype="multipart/form-data">

        <div class="row">
          <div class="col-lg-12" style="margin-top:20px;padding-left:0;">
            <div class="well well-sm">
              <a class="btn btn-default" onclick="window.location.reload()"><i class="glyphicon glyphicon-refresh"></i> Recargar</a>
            </div>
          </div>
        </div>

        <center>
          <h3><i class="fas fa-wrench"></i> Nuevo Parte de Trabajo</h3>
        </center>

        <div class="col-lg-12" style="margin-top:20px;padding-left:0;">

          <div class="row">
            <div class="col-sm-3 col-xs-0"></div>
            <div class="col-sm-3 col-xs-6">
              <div class="form-group">
                <label>Fecha:</label>
                <input type="date" class="form-control" id="fecha_parte_trabajo" name="fecha_parte_trabajo" required>
              </div>
            </div>
            <div class="col-sm-3 col-xs-6">
              <div class="form-group">
                <label>Hora:</label>
                <input type="time" class="form-control" id="hora_parte_trabajo" name="hora_parte_trabajo" step="60" required>
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
                <input type="text" class="form-control id_tipo_cont" id="id_tipo_cont_1" name="id_tipo_cont_1" placeholder="Tipo" disabled>
              </div>
            </div>
            <div class="col-sm-3 col-xs-6">
              <div class="form-group">
                <input type="text" class="form-control longitud_cont" id="longitud_cont_1" name="longitud_cont_1" placeholder="Longitud" disabled>
              </div>
            </div>
            <div class="col-sm-3 col-xs-0"></div>
          </div>

          <div class="row">
            <div class="col-sm-3 col-xs-0"></div>
            <div class="col-sm-3 col-xs-6">
              <div class="form-group">
                <input type="text" class="form-control descripcion_cont" id="descripcion_cont_1" name="descripcion_cont_1" placeholder="Descripción" disabled>
              </div>
            </div>
            <div class="col-sm-3 col-xs-6">
              <div class="form-group">
                <input type="text" class="form-control propietario_cont" id="propietario_cont_1" name="propietario_cont_1" placeholder="Propietario" disabled>
              </div>
            </div>
            <div class="col-sm-3 col-xs-0"></div>
          </div>

          <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Trabajos realizados:</label>

                <?php foreach ($tipos_trabajos_list as $tipos_trabajos_line) { ?>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="<?php echo $tipos_trabajos_line['tipo_trabajo']; ?>" name="<?php echo $tipos_trabajos_line['tipo_trabajo']; ?>" value="<?php echo $tipos_trabajos_line['id_tipo_trabajo']; ?>">
                    <label class="form-check-label" for="<?php echo $tipos_trabajos_line['tipo_trabajo']; ?>"><?php echo $tipos_trabajos_line['tipo_trabajo']; ?></label>
                  </div>
                <?php } ?>

              </div>
            </div>
            <div class="col-sm-3"></div>
          </div>


          <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Incidencias detectadas:</label>

                <?php foreach ($tipos_incidencias_list as $tipos_incidencias_line) { ?>
                  <div class="form-check">
                    <input class="form-check-input checkbox_inciencia" type="checkbox" id="<?php echo $tipos_incidencias_line['tipo_trabajo']; ?>" name="<?php echo $tipos_incidencias_line['tipo_trabajo']; ?>" value="<?php echo $tipos_incidencias_line['id_tipo_trabajo']; ?>">
                    <label class="form-check-label" for="<?php echo $tipos_incidencias_line['tipo_trabajo']; ?>"><?php echo $tipos_incidencias_line['tipo_trabajo']; ?></label>
                  </div>
                <?php } ?>

              </div>
            </div>
            <div class="col-sm-3"></div>
          </div>

          <div class="row">
            <div class="col-sm-3 col-xs-0"></div>
            <div class="col-sm-6 col-xs-12">
              <div class="form-group">
                <label>Observaciones:</label>
                <textarea class="form-control" rows="3" id="observaciones" name="observaciones"></textarea>
              </div>
            </div>
            <div class="col-sm-3 col-xs-0"></div>
          </div>

          <div class="row">
            <div class="col-sm-3 col-xs-0"></div>
            <div class="col-sm-6 col-xs-12">
              <div class="control-group">
                <center>
                  <div class="upload__box">
                    <div class="upload__btn-box">
                      <label class="upload__btn">
                        <i class="fas fa-plus fa-lg" aria-hidden="true"></i> Fotos
                        <input class="form-control upload__inputfile" id="files" type="file" name="files[]" accept="image/png, image/gif, image/jpeg" / multiple>
                      </label>
                    </div>
                    <div class="upload__img-wrap"></div>
                  </div>
                </center>

                <p id="files-area">
                  <span id="filesList">
                    <span id="files-names"></span>
                  </span>
                </p>



              </div>
            </div>
            <div class="col-sm-3 col-xs-0"></div>
          </div>

          <div class="row">
            <div class="col-sm-3 col-xs-0"></div>
            <div class="col-sm-6 col-xs-12">
              <div class="form-group">
                <div class="progress-bar bg-success" id='progress-bar' role="progressbar" style="width:0%;">0%</div>
                <div id='resultado_upload'></div>
              </div>
            </div>
            <div class="col-sm-3 col-xs-0"></div>
          </div>

          <div class="row">
            <div class="col-sm-12 col-xs-12" style="margin-top:20px;padding-left:0;">
              <div class="control-group">
                <center>
                  <?php if ($_SESSION['roles_array'][0]['nombre_rol'] == "admin") : ?><button type="submit" class="btn btn-primary btn_guardar" id="btn_guardar1" name="submit"><i class="fa fa-lg fa-save"></i> Guardar</button><?php endif; ?>
              </div>
              </center>
            </div>
          </div>
        </div>
        <br />
        <br />


    </div> <!--Fin div col-lg-12-->
    </form>

  </div>
  </div>
  <!-- /#wrapper -->
  </div>
</body>

</html>