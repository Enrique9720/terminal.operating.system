<!DOCTYPE html>
<html lang="es">

<head>
  <title>Plan semanal</title>
  <?php
  //Plantilla con los inludes de las librerias y CSS usados por todas las paginas de la APP
  require_once('../tpl/header_includes.php');
  ?>
  <script src="../functions/plan_semanal.js"></script>
  <script>
    var calendar;
    $(document).ready(function() {

      //Inicialización
      getpropietarios();
      getorigenes();
      getdestinos();

      $("#fecha").jqxDateTimeInput({
        width: '100%',
        height: '35px',
        firstDayOfWeek: 1,
        formatString: "  dd/MM/yyyy",
        value: null,
      });

      $('#fecha').on('valueChanged', function(event) {
        var jsDate = event.args.date;
        console.log(jsDate);
        var hora_combo = document.getElementById("hora");
        $("#hora").empty();
        var option = document.createElement("option");
        option.text = "Hora";
        option.disabled = true;
        hora_combo.add(option);
        if ((jsDate.getDay() != 6) && (jsDate.getDay() != 0)) {
          var hora_permitida = ["08:00", "09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00", "18:00"];
          for (i = 0; i < hora_permitida.length; i++) {
            var option = document.createElement("option");
            option.text = hora_permitida[i];
            hora_combo.add(option);
          }
        }
        hora_combo.selectedIndex = 0;
      });

      //al rellenar numero de expedicion o tipo de cita, comprobamos que no exista
      $('#num_expedicion').on('blur', function(event) {
        num_expedicion_check();
      });
      $('#tipo_cita').on('change', function(event) {
        num_expedicion_check();
      });


      var calendar_height = $(window).height() - 120;
      // Inicializar calendario de descargas
      var calendarEl = document.getElementById('calendar');
      calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'es',
        firstDay: 1,
        //timeZone: 'UTC',
        initialView: 'timeGridWeek',
        height: calendar_height,
        allDaySlot: false,
        slotMinTime: "08:00",
        slotMaxTime: "19:00",
        slotDuration: "1:00",
        expandRows: true,
        businessHours: {
          // days of week. an array of zero-based day of week integers (0=Sunday)
          daysOfWeek: [1, 2, 3, 4, 5], // Monday - Thursday
          startTime: '08:00', // a start time (10am in this example)
          endTime: '20:00', // an end time (6pm in this example)
        },
        eventConstraint: "businessHours",
        eventDrop: function(info) {
          var tipo_cita = info.event.extendedProps['tipo_cita'];
          var id_cita = info.event.extendedProps['id'];
          var date = info.event.start;
          var fecha = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
          var hora = date.getHours() + ":" + date.getMinutes();
          //console.log('eventDrop: '+info.event.title + " - " + id + " - " + tipo_cita + " (" + fecha + " " + hora + ")");
          modificarHorarioCita(tipo_cita, id_cita, fecha, hora);
        },
        eventClick: function(info) {

          //alert('Event: ' + info.event.title);
          //PONEMOS TITULO A LA VENTANA MODAL Y ABRIMOS MODAL


          num_expedicion = info.event.title;
          tipo_cita = info.event.extendedProps['tipo_cita'];

          if (tipo_cita == "carga") {

            $('#table_lineas_carga').dataTable().fnClearTable();


            $.ajax({
              type: "POST",
              url: "../ajax/get_linea_carga_por_num_expedicion.php",
              data: {
                'num_expedicion': num_expedicion
              },
              cache: false,
              async: false,
              success: function(returned) {
                //console.log(returned);
                var obj = $.parseJSON(returned);
                //console.log(obj);
                jQuery(obj).each(function(i, item) {

                  var item_ = {
                    num_contenedor: item.num_contenedor,
                    id_tipo_contenedor_iso: item.id_tipo_contenedor_iso,
                    longitud_tipo_contenedor: item.longitud_tipo_contenedor,
                    descripcion_tipo_contenedor: item.descripcion_tipo_contenedor,
                    nombre_comercial_propietario: item.nombre_comercial_propietario_actual
                  };
                  //console.log(item_);

                  table_lineas_carga.row.add(item_);
                  table_lineas_carga.draw(false);

                })
              },
              error: function() {
                alert("failure");
              }
            });

            $("#modal_cita_carga_view_record_title").html('<strong>Salida Tren: ' + num_expedicion + '</strong>');
            $("#modal_cita_carga_view_record").modal();

          }
          //console.log(info.event);



        },

        eventContent: function(arg, createElement) {
          let element = document.createElement("i");
          var tipo_cita = arg.event.extendedProps['tipo_cita'];
          console.log(arg.event.extendedProps);
          if (tipo_cita == "carga") {
            element.innerHTML = arg.event.extendedProps['nombre_comercial_propietario'] + ":<br>" + arg.event.extendedProps['num_expedicion'] + "<br>" + arg.event.extendedProps['nombre_destino'];
          } else {
            element.innerHTML = arg.event.extendedProps['nombre_comercial_propietario'] + ":<br> " + arg.event.extendedProps['num_expedicion'] + "<br>" + arg.event.extendedProps['nombre_origen'];
          }
          let arrayOfDomNodes = [element];
          return {
            domNodes: arrayOfDomNodes
          };
        },

        datesSet: function(dateInfo) {
          //console.log("DATES: ",dateInfo.start,dateInfo.end);
          loadCalendarioCitas(dateInfo.start, dateInfo.end);
        }
      });
      calendar.render();
    });
  </script>
  <style>
    .fc-header-toolbar {
      padding-top: 1em;
      padding-left: 1em;
      padding-right: 1em;
    }

    table {
      font-size: 11px;
    }

    .fc-event-main {
      font-size: 10px;
    }
  </style>

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
      <div class="row h-100" style="margin:0">
        <div class="col-md-8 col-lg-8 h-100" style="text-align:center;border-right: 1px solid #ddd;">
          <div id='calendar-container'>
            <div id='calendar'></div>
            <div style="margin: 0 auto;">
              <table style="margin: 0 auto;text-align:center; border-spacing: 5px;border-collapse: separate;font-size:10px;">
                <tr>
                  <td style="padding:10px;margin:100px;background:#21b6b6;color:white;border-radius: 5px;">CARGA</td>
                  <td style="padding:10px;margin:10px;background:#ff8d00;color:white; border-radius: 5px;">DESCARGA</td>
                </tr>
              </table>
            </div>
          </div>
        </div>

        <div class="col-md-4 col-lg-4 h-100" style="text-align:center;">
          <h3 class="mb-0">PLANIFICAR CARGA/DESCARGA DE TRENES</h3>
          <!-- Icon Divider-->
          <div class="divider-custom" style="margin-bottom:10px;">
            <div class="divider-custom-icon">
              <i class="fas fa-clipboard-list fa-2x"></i>
            </div>
          </div>
          <form method="POST" id="citaForm" name="citaForm" style="border:1px solid #bbb;padding:15px;border-radius:5px;margin-bottom:10px;">
            <div class="control-group">
              <div class="form-group floating-label-form-group controls mb-0 pb-2">
                <select class="form-control" id="tipo_cita" onchange="tipoCitaChange()">
                  <option value="" disabled selected>Tipo de operaci&oacute;n</option>
                  <option>CARGA</option>
                  <option>DESCARGA</option>
                </select>
              </div>
            </div>
            <div class="control-group">
              <div class="form-group floating-label-form-group controls mb-0 pb-2">
                <div id='fecha'></div>
              </div>
            </div>
            <div class="control-group">
              <div class="form-group floating-label-form-group controls mb-0 pb-0">
                <select class="form-control" id="hora">
                  <option value="" disabled selected>Hora</option>
                </select>
              </div>
            </div>

            <div class="control-group">
              <div class="form-group floating-label-form-group controls mb-0 pb-2">
                <select class="form-control" id="propietarios_combo" onchange="propietariochange()">
                  <option value="" disabled selected>Propietario</option>
                </select>
              </div>
            </div>

            <!--  -->
            <div class="control-group">
              <div class="form-group floating-label-form-group controls mb-0 pb-2">
                <input class="form-control" id="num_expedicion" type="text" placeholder="Nº expedici&oacute;n" />
                <div id="error_num_expedicion"></div>
              </div>
            </div>


            <div class="control-group">
              <div class="form-group floating-label-form-group controls mb-0 pb-0">
                <select class="form-control" id="origen_combo">
                  <option value="" disabled selected>Origen</option>
                </select>
              </div>
            </div>

            <div class="control-group">
              <div class="form-group floating-label-form-group controls mb-0 pb-0">
                <select class="form-control" id="destino_combo">
                  <option value="" disabled selected>Destino</option>
                </select>
              </div>
            </div>


            <!--  -->
            <div class="control-group">
              <div class="form-group floating-label-form-group controls mb-0 pb-2">
                <textarea class="form-control" id="observaciones" rows="5" placeholder="Observaciones"></textarea>
              </div>
            </div>

            <div class="form-group">
              <input class="form-control" id="num_contenedores_check" type="hidden" />
              <button class="btn btn-info" type="button" id="lineas_carga_button" style="display:none;" disabled>Añadir Contenedores</button>
            </div>

            <div id="success"></div>
          </form>

          <!-- <div class="form-group">
              <button class="btn btn-primary btn-xl" id="validarCitaButton" onclick="validarCita()">Validar</button>
            </div> -->

          <?php if ($_SESSION['roles_array'][0]['nombre_rol'] === 'admin') : ?>
            <div class="form-group">
              <button class="btn btn-primary btn-xl" id="validarCitaButton" onclick="validarCita()">Validar</button>
            </div>
          <?php endif; ?>
          
        </div>
      </div>
    </div>

    <!-- /#wrapper -->


  </div>
</body>

</html>