<!DOCTYPE html>
<html lang="es">

<head>
  <title>Salida de Camión</title>
  <?php
  //Plantilla con los inludes de las librerias y CSS usados por todas las paginas de la APP
  require_once('../tpl/header_includes.php');
  ?>
  <style>
    table {
      font-size: 12px;
    }
    .select2 {
      width:100%!important;
    }
  </style>

  <!-- Custom Functions JavaScript -->
  <script src="../functions/entrada_camion_functions.js"></script>
  <script src="../assets/inputmask/jquery.inputmask.bundle.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const form = document.querySelector('form')
      form.addEventListener('submit', event => {
        // submit event detected
        const fecha_salida = document.querySelector('#fecha_salida');
        const hora_salida = document.querySelector('#hora_salida');
        //console.log("fecha_salida: "+fecha_salida.value);
        //console.log("hora_salida: "+hora_salida.value);

        //sacamos datos de ultimas fechas de entrada y salida
        num_cont_1 = $('#num_cont_1').val();
        //console.log("num_cont_1: "+num_cont_1);
        $.ajax({
          type: "POST",
          url: "../ajax/existe_contenedor.php",
          data: {
            'num_contenedor': num_cont_1
          },
          cache: false,
          success: function(returned) {
            var obj = $.parseJSON(returned);
            jQuery(obj).each(function(i, item) {
              //fecha_salida_ultima = item.fecha_salida_ultima;
              fecha_entrada_ultima = item.fecha_entrada_ultima;
              fecha_entrada_ultima = fecha_entrada_ultima.split(" ")[0];
              //console.log("fecha_entrada_ultima: "+fecha_entrada_ultima);
            })
          },
          async: false,
          error: function() {
            alert("failure");
          }
        });

        //Si la fecha de nueva entrada es anterior a la ultima fecha de salida registrada para ese contenedor
        if (new Date(fecha_salida.value) < new Date(fecha_entrada_ultima)) {
          event.preventDefault();
          alert('Error: Fecha de salida (' + fecha_salida.value + ') es anterior a la ultima fecha de entrada (' + fecha_entrada_ultima + ') del contenedor ' + num_cont_1);
        }

      })
    })
  </script>

  <script>
    $(document).ready(function() {

      //Establecemos inputs de fecha y hora de entrada
      var now = new Date();
      var now2 = new Date(now.getFullYear(), now.getMonth(), now.getDate(), now.getHours()+2, now.getMinutes());
      $('#fecha_salida')[0].valueAsDate = now2;
      $('#hora_salida')[0].valueAsDate = now2;

      //cargamos select2 de contenedores en stock
      load_ajax_select2("#num_cont_1", "", "../ajax/contenedores_stock_list.php");

      load_select2("#id_origen", "");
      load_select2("#id_destino", "");

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
                tara_contenedor = item.tara_contenedor;
                cif_propietario_actual = item.cif_propietario_actual;
                nombre_comercial_propietario = item.nombre_comercial_propietario;
                id_tipo_mercancia_actual_contenedor = item.id_tipo_mercancia_actual_contenedor;
                descripcion_mercancia = item.descripcion_mercancia;
                id_destinatario_actual = item.id_destinatario_actual;
                if (id_destinatario_actual == null) {
                  id_destinatario_actual = '';
                }
                //console.log(id_destinatario_actual);
                nombre_destinatario = item.nombre_destinatario;
                if (nombre_destinatario == null) {
                  nombre_destinatario = '';
                }

                //console.log(nombre_destinatario);
                peso_bruto_actual_contenedor = item.peso_bruto_actual_contenedor;
                peso_mercancia_actual_contenedor = item.peso_mercancia_actual_contenedor;
                num_booking_actual_contenedor = item.num_booking_actual_contenedor;
                num_precinto_actual_contenedor = item.num_precinto_actual_contenedor;
                temperatura_actual_contenedor = item.temperatura_actual_contenedor;
                codigo_estacion_ferrocarril_actual_contenedor = item.codigo_estacion_ferrocarril_actual_contenedor;
                num_peligro_adr_actual_contenedor = item.num_peligro_adr_actual_contenedor;
                num_onu_adr_actual_contenedor = item.num_onu_adr_actual_contenedor;
                num_clase_adr_actual_contenedor = item.num_clase_adr_actual_contenedor;
                cod_grupo_embalaje_adr_actual_contenedor = item.cod_grupo_embalaje_adr_actual_contenedor;
                //scamos datos al seleccionar num_contenedor
                var option = new Option(id_tipo_contenedor_iso, id_tipo_contenedor_iso, true, true);
                $("#id_tipo_cont_1").append(option).trigger('change');
                $("#longitud_cont_1").val(longitud_tipo_contenedor);
                $("#descripcion_cont_1").val(descripcion_tipo_contenedor);
                $("#propietario_cont_1").val(cif_propietario_actual).trigger('change');

                if((cif_propietario_actual != 'A60389624') /*BILBAO*/ && (cif_propietario_actual != 'A96764097') /*VALENCIA*/){
                  var option = new Option(nombre_destinatario, id_destinatario_actual, true, true);
                  $("#destinatario_cont_1").append(option).trigger('change');
                }

                $("#num_estacion_destino").val(codigo_estacion_ferrocarril_actual_contenedor).trigger('change');
                $("#mercancia_cont_1").val(id_tipo_mercancia_actual_contenedor).trigger('change');
                $("#peso_mercancia_cont_1").val(peso_mercancia_actual_contenedor);
                $("#num_booking_cont_1").val(num_booking_actual_contenedor);
                $("#num_precinto_cont_1").val(num_precinto_actual_contenedor);
                //$("#temperatura_cont_1").val(temperatura_actual_contenedor);
                var option = new Option(num_peligro_adr_actual_contenedor, num_peligro_adr_actual_contenedor, true, true);
                $("#mercancia_num_peligro_adr_cont_1").append(option).trigger('change');
                var option = new Option(num_onu_adr_actual_contenedor, num_onu_adr_actual_contenedor, true, true);
                $("#mercancia_onu_adr_cont_1").append(option).trigger('change');
                $("#mercancia_clase_adr_cont_1").val(num_clase_adr_actual_contenedor).trigger('change');
                $("#mercancia_grupo_embalaje_adr_cont_1").val(cod_grupo_embalaje_adr_actual_contenedor).trigger('change');
                //Cargamos tara contenedor en su input
                $("#tara_cont_1").val(tara_contenedor);


              } else {
                //alert(text);
                //borramos datos al borrar el num_contenedor
                $("#id_tipo_cont_1").val('').trigger('change');
                $("#longitud_cont_1").val('');
                $("#descripcion_cont_1").val('');
                $("#propietario_cont_1").val('').trigger('change');
                $("#destinatario_cont_1").val('').trigger('change');
                $("#num_estacion_destino").val('').trigger('change');
                $("#mercancia_cont_1").val('').trigger('change');
                $("#peso_mercancia_cont_1").val('');
                $("#num_booking_cont_1").val('');
                $("#num_precinto_cont_1").val('');
                $("#temperatura_cont_1").val('');
                $("#mercancia_num_peligro_adr_cont_1").val('').trigger('change');
                $("#mercancia_onu_adr_cont_1").val('').trigger('change');
                $("#mercancia_clase_adr_cont_1").val('').trigger('change');
                $("#mercancia_grupo_embalaje_adr_cont_1").val('').trigger('change');
                $('#nombre_conductor').prop("disabled", false);
                $('#apellidos_conductor').prop("disabled", false);
                $("#nombre_conductor").val('');
                $("#apellidos_conductor").val('');
                //Cargamos tara contenedor en su input
                $("#tara_cont_1").val();

              }
            })
          },
          error: function() {
            alert("failure");
          }
        });

      });

      //cargamos select2 de empresas transportistas
      load_ajax_select2("#emp_transportista", "", "../ajax/empresas_transportistas_list.php");
      //cargamos select2 para propietarios
      load_select2("#propietario_cont_1", "");
      //cargamos select2 de tipos de contenedores
      load_ajax_select2("#id_tipo_cont_1", "", "../ajax/tipo_contenedor_iso_list.php");

      //al elegir id_tipo_cont_1, ponemos su longitud y descripcion en los inputs
      $('#id_tipo_cont_1').change(function() {
        id_tipo_cont_1 = $('#id_tipo_cont_1').find(":selected").text();
        $.ajax({
          type: "POST",
          url: "../ajax/get_tipo_contenedor_iso.php",
          data: {
            id_tipo_contenedor_iso: id_tipo_cont_1
          },
          success: function(returned) {
            var obj = $.parseJSON(returned);
            jQuery(obj).each(function(i, item) {
              text = item.text;
              if (text != 'No hay resultados') {
                id = item.id;
                longitud_tipo_contenedor = item.longitud_tipo_contenedor;
                descripcion_tipo_contenedor = item.descripcion_tipo_contenedor;
                $("#longitud_cont_1").val(longitud_tipo_contenedor);
                $("#descripcion_cont_1").val(descripcion_tipo_contenedor);
                if (descripcion_tipo_contenedor.indexOf("REEFER") >= 0) {
                  $('#temperatura_cont_1').prop("disabled", false);
                } else {
                  $('#temperatura_cont_1').prop("disabled", true);
                }
              } else {
                //alert(text);
                $("#longitud_cont_1").val('');
                $("#descripcion_cont_1").val('');
                $('#temperatura_cont_1').prop("disabled", true);
              }
            })
          },
          error: function() {
            alert("failure");
          }
        });
      });

      //cargamos select2 para empresa de origen
      load_select2_customtags("#origen_entrada", "", "../ajax/empresas_destino_origen_list.php");
      //cargamos select2 para empresa destinatarias
      load_select2_customtags("#destinatario_cont_1", "", "../ajax/empresas_destino_origen_list.php");
      $('#datos_destinatario_renfe').hide();
      //cargamos select2 de tipos de mercancia
      load_select2("#mercancia_cont_1", "");


      ////////////////////////////////////////////////////////////////////////////////////// INICIO SELECCION MERCANCIA //////////////////////////////////////////////////////////////////////////////////////
      //cargamos select2 de campos de mercancia peligrosa
      load_ajax_select2("#mercancia_num_peligro_adr_cont_1", "", "../ajax/adr_num_peligro_list.php");
      load_ajax_select2("#mercancia_onu_adr_cont_1", "", "../ajax/adr_onu_list.php");
      load_select2("#mercancia_clase_adr_cont_1", "");
      load_select2("#mercancia_grupo_embalaje_adr_cont_1", "");
      //ocultamos panel ADR
      $('#panel_adr').hide();
      $('#datos_booking').hide();

      //Habilitamos el campo numero ONU si la mercancia seleccionada es peligrosa
      $('#mercancia_cont_1').change(function() {
        mercancia_cont_1 = $('#mercancia_cont_1').find(":selected").text();
        console.log(mercancia_cont_1);

        if ((mercancia_cont_1 == 'VACÍO') || (mercancia_cont_1 == 'VACÍO-SUCIO') || (mercancia_cont_1 == '')) {
          $('#peso_mercancia_cont_1').prop("required", false);
          //$('#peso_mercancia_cont_1').prop("disabled", true);
          $('#num_booking_cont_1').prop("required", false);
          //$('#num_booking_cont_1').prop("disabled", true);
          $('#num_precinto_cont_1').prop("required", false);
          //$('#num_precinto_cont_1').prop("disabled", true);
          $('#datos_booking').hide();
        } else {
          $('#peso_mercancia_cont_1').prop("required", true);
          //$('#peso_mercancia_cont_1').prop("disabled", false);
          $('#num_booking_cont_1').prop("required", true);
          //$('#num_booking_cont_1').prop("disabled", false);
          $('#num_precinto_cont_1').prop("required", true);
          //$('#num_precinto_cont_1').prop("disabled", false);
          $('#datos_booking').show();
        }

        if ((mercancia_cont_1 == 'MERCANCÍA PELIGROSA') || (mercancia_cont_1 == 'VACÍO-SUCIO')) {
          //mostramos panel para mercancia peligrosa
          $('#panel_adr').show();
          //habilitamos campos para mercancia peligrosa
          //$('#mercancia_num_peligro_adr_cont_1').prop("disabled", false);
          //$('#mercancia_onu_adr_cont_1').prop("disabled", false);
          //$('#mercancia_clase_adr_cont_1').prop("disabled", false);
          //$('#mercancia_grupo_embalaje_adr_cont_1').prop("disabled", false);
          //hacemos campos requeridos para validad formulario
          $('#mercancia_num_peligro_adr_cont_1').prop("required", true);
          $('#mercancia_onu_adr_cont_1').prop("required", true);
          //$('#mercancia_clase_adr_cont_1').prop("required", true);
          //$('#mercancia_grupo_embalaje_adr_cont_1').prop("required", true);
        } else {
          //ocultamos panel para mercancia peligrosa
          $('#panel_adr').hide();
          //deshabilitamos campos para mercancia peligrosa
          //$('#mercancia_num_peligro_adr_cont_1').prop("disabled", true);
          //$('#mercancia_onu_adr_cont_1').prop("disabled", true);
          $('#mercancia_clase_adr_cont_1').prop("disabled", true);
          $('#mercancia_grupo_embalaje_adr_cont_1').prop("disabled", true);
          //quitamos campos requeridos para validad formulario
          $('#mercancia_num_peligro_adr_cont_1').prop("required", false);
          $('#mercancia_onu_adr_cont_1').prop("required", false);
          //$('#mercancia_clase_adr_cont_1').prop("required", false);
          //$('#mercancia_grupo_embalaje_adr_cont_1').prop("required", false);
          //borramos valores de los inputs
          $("#mercancia_num_peligro_adr_cont_1").val('').trigger('change');
          $("#mercancia_onu_adr_cont_1").val('').trigger('change');
          $("#mercancia_clase_adr_cont_1").val('').trigger('change');
          $("#mercancia_grupo_embalaje_adr_cont_1").val('').trigger('change');
        }
      });

      //al elegir numero ONU adr, ponemos su descripcion
      $('#mercancia_onu_adr_cont_1').change(function() {
        num_onu_adr = $('#mercancia_onu_adr_cont_1').find(":selected").text();
        $.ajax({
          type: "POST",
          url: "../ajax/get_adr_onu.php",
          data: {
            num_onu_adr: num_onu_adr
          },
          success: function(returned) {
            var obj = $.parseJSON(returned);
            jQuery(obj).each(function(i, item) {
              text = item.text;
              if (text != 'No hay resultados') {
                id = item.id;
                descripcion_onu_adr = item.descripcion_onu_adr;
                $("#mercancia_onu_descripcion_adr_cont_1").val(descripcion_onu_adr);

              } else {
                //alert(text);
                $("#mercancia_onu_descripcion_adr_cont_1").val('');
              }
            })
          },
          error: function() {
            alert("failure");
          }
        });
      });

      //al elegir numero ONU adr, ponemos su descripcion
      $('#mercancia_num_peligro_adr_cont_1').change(function() {
        num_peligro_adr = $('#mercancia_num_peligro_adr_cont_1').find(":selected").text();
        $.ajax({
          type: "POST",
          url: "../ajax/get_adr_num_peligro.php",
          data: {
            num_peligro_adr: num_peligro_adr
          },
          success: function(returned) {
            var obj = $.parseJSON(returned);
            jQuery(obj).each(function(i, item) {
              text = item.text;
              if (text != 'No hay resultados') {
                id = item.id;
                descripcion_peligro_adr = item.descripcion_peligro_adr;
                $("#mercancia_num_peligro_descripcion_adr_cont").val(descripcion_peligro_adr);

              } else {
                //alert(text);
                $("#mercancia_num_peligro_descripcion_adr_cont").val('');
              }
            })
          },
          error: function() {
            alert("failure");
          }
        });
      });
      ////////////////////////////////////////////////////////////////////////////////////// FIN SELECCION MERCANCIA //////////////////////////////////////////////////////////////////////////////////////

      //cargamos select2 de dni de conductores
      load_select2_customtags("#dni_conductor", "", "../ajax/conductores_list.php");
      //al elegir dni_conductor, ponemos su nombre y apellidos en los inputs
      $('#dni_conductor').change(function() {
        dni_conductor = $('#dni_conductor').find(":selected").text();
        $.ajax({
          type: "POST",
          url: "../ajax/get_conductor.php",
          data: {
            dni_conductor: dni_conductor
          },
          success: function(returned) {
            var obj = $.parseJSON(returned);
            jQuery(obj).each(function(i, item) {
              text = item.text;
              if (text != 'No hay resultados') {
                id = item.id;
                nombre_conductor = item.nombre_conductor;
                apellidos_conductor = item.apellidos_conductor;
                $("#nombre_conductor").val(nombre_conductor);
                $("#apellidos_conductor").val(apellidos_conductor);
                $('#nombre_conductor').prop("disabled", true);
                $('#apellidos_conductor').prop("disabled", true);

              } else {
                //alert(text);
                $('#nombre_conductor').prop("disabled", false);
                $('#apellidos_conductor').prop("disabled", false);
                $("#nombre_conductor").val('');
                $("#apellidos_conductor").val('');

              }
            })
          },
          error: function() {
            alert("failure");
          }
        });

      });

      $('#propietario_cont_1').change(function() {
        propietario_cont_1 = $('#propietario_cont_1').find(":selected").text();
        //console.log(propietario_cont_1);

        //al elegir propietario, borramos el campo de destinatario
        $("#destinatario_cont_1").val('').trigger('change');

        if (propietario_cont_1 == 'RENFE') {
          //mostramos datos adicionales destinatario RENFE
          $('#datos_destinatario_renfe').show();
          //hacer required el campo destinatario_cont_1
          $('#destinatario_cont_1').prop("required", true);
          $('#num_estacion_destino').prop("required", true);
          //$('#num_estacion_destino').prop("disabled", false);
          //cargamos select 2 para num_estacion_destino
          load_select2("#num_estacion_destino", "");
          //cargamos el select2 solo para destinatarios de renfe
          load_ajax_select2("#destinatario_cont_1", "", "../ajax/empresas_destino_origen_renfe_list.php");
          //al elegir destinatario siendo renfe

          $('#destinatario_cont_1').change(function() {
            id_destinatario = $('#destinatario_cont_1').find(":selected").val();
            //console.log(id_destinatario);

            if (id_destinatario != undefined) {
              $.ajax({
                type: "POST",
                url: "../ajax/get_num_teco.php",
                data: {
                  id_destinatario: id_destinatario
                },
                success: function(returned) {
                  //console.log(returned);
                  var obj = $.parseJSON(returned);
                  jQuery(obj).each(function(i, item) {
                    text = item.text;
                    if (text != 'No hay resultados') {
                      id = item.id;
                      nombre_empresa_destino_origen = item.nombre_empresa_destino_origen;
                      num_tarjeta_teco = item.num_tarjeta_teco;
                      $("#num_tarjeta_teco").val(num_tarjeta_teco);
                    } else {
                      //alert(text);
                      $("#num_tarjeta_teco").val('');
                    }
                  })
                },
                error: function() {
                  alert("failure");
                }
              });
            }

          });

        } else {
          //ocultamos datos adicionales destinatario RENFE
          $('#datos_destinatario_renfe').hide();
          $('#destinatario_cont_1').prop("required", false);
          $('#num_estacion_destino').prop("required", false);
          //cargamos el select2 para todos los destinatarios
          load_select2_customtags("#destinatario_cont_1", "", "../ajax/empresas_destino_origen_list.php");
          $("#num_tarjeta_teco").val('');
          $("#num_estacion_destino").val('').trigger('change');
          //$('#num_estacion_destino').prop("disabled", true);
        }


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

      <form role="form" autocomplete="off" action="../controllers/salida_camion_controller.php" method="post" id="form_entrada_camion">

        <div class="row">
          <div class="col-lg-12" style="margin-top:20px;padding-left:0;">
            <div class="well well-sm">
              <?php if ($_SESSION['roles_array'][0]['nombre_rol'] == "admin") : ?><button type="submit" class="btn btn-primary btn_guardar" id="btn_guardar1" name="submit"><i class="fa fa-lg fa-save"></i> Guardar</button><?php endif; ?>
              <a class="btn btn-default" onclick="window.location.reload()"><i class="glyphicon glyphicon-refresh"></i> Recargar</a>
            </div>
          </div>
        </div>

        <center>
          <h3><i class="fas fa-sign-in-alt" aria-hidden="true"></i> Salida de Contenedor en Camión</h3>
        </center>

        <div class="col-lg-12" style="margin-top:20px;padding-left:0;">

          <div class="panel panel-default">
            <div class="panel-heading">Fecha Transporte</div>
            <div class="panel-body">
              <div class="row">
                <div class="col-sm-4"></div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Fecha:</label>
                    <input type="date" class="form-control" id="fecha_salida" name="fecha_salida" required>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Hora:</label>
                    <input type="time" class="form-control" id="hora_salida" name="hora_salida" step="60" required>
                  </div>
                </div>
                <div class="col-sm-3"></div>
              </div>


              <div class="row">
                <div class="col-sm-4"></div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Origen Ferroviario:</label>
                    <select class="form-control id_origen select_2" id="id_origen" name="id_origen" required>
                      <option value=''></option>
                      <?php foreach ($origen_list as $origen_line) {
                        echo "
      				                  <option value='" . $origen_line['id_origen'] . "'>" . $origen_line['nombre_origen'] . "</option>";
                      } ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Destino Ferroviario:</label>
                    <select class="form-control id_destino select_2" id="id_destino" name="id_destino" required>
                      <option value=''></option>
                      <?php foreach ($destino_list as $destino_line) {
                        echo "
      				                  <option value='" . $destino_line['id_destino'] . "'>" . $destino_line['nombre_destino'] . "</option>";
                      } ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-4"></div>
              </div>



            </div>
          </div>



          <div class="panel panel-default">
            <div class="panel-heading">Datos Contenedor</div>
            <div class="panel-body">

              <div class="row">
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Nº Contenedor:</label>
                    <select class="form-control num_cont select_2" id="num_cont_1" name="num_cont_1" required></select>
                    <div id="error_contenedor"></div>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Tipo:</label>
                    <select class="form-control id_tipo_cont select_2" id="id_tipo_cont_1" name="id_tipo_cont_1" disabled required></select>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Longitud:</label>
                    <input type="text" class="form-control longitud_cont" id="longitud_cont_1" name="longitud_cont_1" disabled>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Descripcion:</label>
                    <input type="text" class="form-control descripcion_cont" id="descripcion_cont_1" name="descripcion_cont_1" disabled>
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Tara:</label>
                    <input type="number" class="form-control tara_cont" id="tara_cont_1" name="tara_cont_1" required disabled>
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Propietario:</label>
                    <select class="form-control propietario_cont select_2" id="propietario_cont_1" name="propietario_cont_1" disabled required>
                      <option value=''></option>
                      <?php foreach ($propietarios_list as $propietarios_line) {
                        echo "
      				                  <option value='" . $propietarios_line['cif_propietario'] . "'>" . $propietarios_line['nombre_comercial_propietario'] . "</option>";
                      } ?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <label>Origen / Destino:</label>
                    <select class="form-control destinatario_cont select_2" id="destinatario_cont_1" name="destinatario_cont_1"></select>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <label>Mercancía:</label>
                    <select class="form-control mercancia_cont select_2" id="mercancia_cont_1" name="mercancia_cont_1" required disabled>
                      <option value=''></option>
                      <?php foreach ($mercancias_list as $mercancias_line) {
                        echo "
      				                  <option value='" . $mercancias_line['id_tipo_mercancia'] . "'>" . $mercancias_line['descripcion_mercancia'] . "</option>";
                      } ?>
                    </select>
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Peso Mercancía (Kg):</label>
                    <input type="number" class="form-control peso_mercancia_cont" id="peso_mercancia_cont_1" name="peso_mercancia_cont_1" min="0" max="99999" step="1" disabled required>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Temperatura:</label>
                    <input type="number" class="form-control temperatura_cont" id="temperatura_cont_1" name="temperatura_cont_1" min="-100" max="100" step="1" disabled>
                  </div>
                </div>
                <div class="col-sm-1"></div>
              </div>

              <div class="row" id="datos_booking">
                <div class="col-sm-3"></div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <label>Nº Booking:</label>
                    <input type="text" class="form-control num_booking_cont_1" id="num_booking_cont_1" name="num_booking_cont_1" disabled>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <label>Nº Precinto:</label>
                    <input type="text" class="form-control num_precinto_cont_1" id="num_precinto_cont_1" name="num_precinto_cont_1" disabled>
                  </div>
                </div>
                <div class="col-sm-3"></div>
              </div>

              <div class="row" id="datos_destinatario_renfe">
                <div class="col-sm-3"></div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <label>Tarjeta TECO:</label>
                    <input type="text" class="form-control num_tarjeta_teco" id="num_tarjeta_teco" name="num_tarjeta_teco" disabled>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <label>Estación destino:</label>
                    <select class="form-control num_estacion_destino select_2" id="num_estacion_destino" name="num_estacion_destino" disabled>
                      <option value=''></option>
                      <?php foreach ($estaciones_ferrocarril_renfe_list as $estaciones_ferrocarril_renfe_line) {
                        echo "
      				                  <option value='" . $estaciones_ferrocarril_renfe_line['codigo_estacion_ferrocarril'] . "'>" . $estaciones_ferrocarril_renfe_line['nombre_estacion_ferrocarril'] . " (" . $estaciones_ferrocarril_renfe_line['codigo_estacion_ferrocarril'] . ")" . "</option>";
                      } ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-3"></div>
              </div>

            </div>
          </div>

          <div class="panel panel-default" id="panel_adr">
            <div class="panel-heading">Datos Mercancía Peligrosa (ADR)</div>
            <div class="panel-body">

              <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <label>Nº Peligro:</label>
                    <select class="form-control mercancia_num_peligro_adr_cont_1 select_2" id="mercancia_num_peligro_adr_cont_1" name="mercancia_num_peligro_adr_cont_1" disabled>
                    </select>
                  </div>
                </div>
                <div class="col-sm-7">
                  <div class="form-group">
                    <label>Descripción Nº Peligro:</label>
                    <input type="text" class="form-control mercancia_num_peligro_descripcion_adr_cont" id="mercancia_num_peligro_descripcion_adr_cont" name="mercancia_num_peligro_descripcion_adr_cont" disabled>
                  </div>
                </div>
                <div class="col-sm-1"></div>
              </div>

              <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <label>Nº ONU:</label>
                    <select class="form-control mercancia_onu_adr_cont select_2" id="mercancia_onu_adr_cont_1" name="mercancia_onu_adr_cont_1" disabled>
                    </select>
                  </div>
                </div>
                <div class="col-sm-7">
                  <div class="form-group">
                    <label>Descripción ONU:</label>
                    <input type="text" class="form-control mercancia_onu_descripcion_adr_cont" id="mercancia_onu_descripcion_adr_cont_1" name="mercancia_onu_descripcion_adr_cont_1" disabled>
                  </div>
                </div>
                <div class="col-sm-1"></div>
              </div>

              <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <label>Clase:</label>
                    <select class="form-control mercancia_clase_adr_cont select_2" id="mercancia_clase_adr_cont_1" name="mercancia_clase_adr_cont_1" disabled>
                      <option value=''></option>
                      <?php foreach ($adr_clase_list as $adr_clase_line) {
                        echo "
      				                  <option value='" . $adr_clase_line['num_clase_adr'] . "'>" . $adr_clase_line['num_clase_adr'] . "</option>";
                      } ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <label>Grupo Embalaje:</label>
                    <select class="form-control mercancia_grupo_embalaje_adr_cont select_2" id="mercancia_grupo_embalaje_adr_cont_1" name="mercancia_grupo_embalaje_adr_cont_1" disabled>
                      <option value=''></option>
                      <?php foreach ($adr_grupo_embalaje_list as $adr_grupo_embalaje_line) {
                        echo "
      				                  <option value='" . $adr_grupo_embalaje_line['cod_grupo_embalaje_adr'] . "'>" . $adr_grupo_embalaje_line['cod_grupo_embalaje_adr'] . "</option>";
                      } ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-3"></div>
              </div>

              <center>
                <label>
                  <input type="checkbox" id="materia_peligrosa_checkbox" name="materia_peligrosa_checkbox" value="true"/>
                  CONTIENE MATERIA PELIGROSA PARA EL MEDIO AMBIENTE
                </label>
                <img src="../images/materia_peligrosa.png" alt="Imagen Materia Peligrosa" style="width: 50px; height: 50px; margin-left: 10px;">
              </center>

            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading">Datos Empresa Transportista</div>
            <div class="panel-body">
              <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label>Transportista:</label>
                    <div class="input-group">
                      <select class="form-control emp_transportista select_2" id="emp_transportista" name="emp_transportista" required></select>
                      <div class="input-group-btn">
                        <button class="btn btn-success add_emp_transportista" type="button">
                          <i class="fa fa-lg fa-plus" aria-hidden="true"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Matrícula Tractora:</label>
                    <input type="text" class="form-control matricula_tractora" id="matricula_tractora" name="matricula_tractora" maxlength="10" required>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Matrícula Remolque:</label>
                    <input type="text" class="form-control matricula_remolque" id="matricula_remolque" name="matricula_remolque" maxlength="10" required>
                  </div>
                </div>
                <div class="col-sm-2"></div>
              </div>
            </div>
          </div>


          <div class="panel panel-default">
            <div class="panel-heading">Datos Conductor</div>
            <div class="panel-body">
              <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Dni conductor:</label>
                    <select class="form-control dni_conductor select_2" id="dni_conductor" name="dni_conductor" required>
                    </select>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <label>Nombre conductor:</label>
                    <input type="text" class="form-control nombre_conductor" id="nombre_conductor" name="nombre_conductor" required>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <label>Apellidos conductor:</label>
                    <input type="text" class="form-control apellidos_conductor" id="apellidos_conductor" name="apellidos_conductor" required>
                  </div>
                </div>
                <div class="col-sm-2"></div>
              </div>
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading">Observaciones</div>
            <div class="panel-body">
              <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-8">
                  <div class="form-group">
                    <label>Observaciones:</label>
                    <textarea class="form-control" rows="4" id="observaciones" name="observaciones"></textarea>
                  </div>
                  <div class="col-sm-2"></div>
                </div>
              </div>
            </div>
          </div>


          <div class="row">
            <div class="col-lg-12" style="margin-top:20px;padding-left:0;">
              <div class="well well-sm">
                <?php if ($_SESSION['roles_array'][0]['nombre_rol'] == "admin") : ?><button type="submit" class="btn btn-primary btn_guardar" id="btn_guardar2" name="submit"><i class="fa fa-lg fa-save"></i> Guardar</button><?php endif; ?>
              </div>
            </div>
          </div>


        </div> <!--Fin div col-lg-12-->
      </form>

    </div>
  </div>
  <!-- /#wrapper -->
  </div>
</body>

</html>
