<!-- //////// LIBRERIA PARA MINI MODAL DE BORRAR FICHERO EN MODAL DE EDITAR EVENTO //////////////////////// -->
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- //////////////////////////////////////////////////////////////////////////////////////////////////// -->

<!--MODAL ALTA Y EDICION DE REGISTROS-->
<div class="modal fade" id="modal_edit_record" role="dialog">
  <div class="modal-dialog modal-dialog-centered">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <center>
          <h4 class="modal-title" id="modal_edit_record_title">Modal title</h4>
        </center>
      </div>

      <form id="form_registro">
        <input type="hidden" id="id_incidencia" name="id_incidencia" required value="<?php echo $id_incidencia; ?>">
        <input type="hidden" id="id_evento" name="id_evento" required value="">
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Fecha:</label>
                <input type="date" class="form-control" id="fecha_evento" name="fecha_evento" required>
              </div>
            </div>
            <div class="col-sm-3"></div>
          </div>

          <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
              <div class="form-group">
                <label>Descripción Evento:</label>
                <textarea class="form-control" id="nombre_evento" name="nombre_evento" rows="5" cols="10"></textarea>
                <!-- <input type="textarea" class="form-control" id="nombre_evento" name="nombre_evento" > -->
              </div>
            </div>
            <div class="col-sm-1"></div>
          </div>

          <div class="row" id="fichero_add_row">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">

              <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                  <div class="form-group">
                    <label>Subir Fichero:</label>
                    <input type="file" class="form-control" id="fichero_upload" name="fichero_upload[]" multiple accept=".xls, .xlsx, .eml, .pdf, .txt, .doc, .docx, .jpg, .jpeg, .png, .gif, .msg" onchange="updateList()">
                  </div>
                  <div class="form-group">
                    <div id="fileList"></div>
                  </div>
                </div>
                <div class="col-sm-1"></div>
              </div>

              <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                  <div class="progress-bar bg-success" id='progress-bar' role="progressbar" style="width:0%;">0%</div>
                </div>
                <div class="col-sm-1"></div>
              </div>

              <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                  <div id='resultado_upload'></div>
                </div>
                <div class="col-sm-1"></div>
              </div>

            </div>
            <div class="col-sm-1"></div>
          </div>

          <div class="row" id="fichero_edit_row">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
              <label>Ficheros:</label>
              <table id="table_ficheros_edit" class="table table-striped table-bordered dataTable table-hover">
                <thead>
                  <tr>
                    <th>Documento</th>
                    <th>Operaciones</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
            <div class="col-sm-1"></div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="guardar"><i class="fa fa-lg fa-save"></i> Guardar</button>
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-lg fa-times"></i> Cerrar</button>
        </div>
      </form>

    </div>
  </div>
</div>


<script>
  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  function updateList(){
      var input = document.getElementById('fichero_upload');
      var output = document.getElementById('fileList');
      var children = "";
      for (var i = 0; i < input.files.length; ++i) {
          children += '<li>' + input.files.item(i).name + '</li>';
      }
      output.innerHTML = '<ul>'+children+'</ul>';
  }


  //SCRIPT PARA INSERTAR UN REGISTRO EN VENTANA MODAL
  $(document).ready(function() {

    //al hacer click en el boton de añadir registro
    $(document).on('click', '.add_record', function(event) {
      id = this.id;
      //reseteamos los campos del formulario, ya que deben de estar vacios al ser una alta nueva de registro
      $("form#form_registro")[0].reset();
      $("#resultado_upload").empty();
      $("#fileList").empty();

      //reseteamos inputs
      //$("#fecha_evento").val("");
      //$("#nombre_evento").val("");
      //Establecemos input de fecha
      var now = new Date();
      $('#fecha_evento')[0].valueAsDate = now;

      $("#fichero_edit_row").hide();

      //quitamos al boton de guardar la clase que se utiliza para actualizar registros
      $("#form_registro").removeClass("update_form");
      //agregamos al boton de guardar la clase que se utiliza para actualizar registros
      $("#form_registro").addClass("insert_form");

      //PONEMOS TITULO A LA VENTANA MODAL
      $("#modal_edit_record_title").html('<strong>Nuevo Evento</strong>');
      //Abrimos la ventana modal
      $("#modal_edit_record").modal();
      $("#id_tipo_fichero_upload").val("1");
    });


    $("form#form_registro").submit(function(event) {

      event.preventDefault(); //prevenir el envio del form via ajax, hasta que no esten todos los campos requeridos

      if ($("#form_registro").hasClass("insert_form")) {

        var form_registro = new FormData(this);

        $.ajax({

          xhr: function() { //Callback for creating the XMLHttpRequest object
            var httpReq = new XMLHttpRequest(); //monitor an upload's progress. //amount of progress
            httpReq.upload.addEventListener("progress", function(ele) {
              if (ele.lengthComputable) { //property is a boolean flag indicating if the resource concerned by the ProgressEvent has a length that can be calculated.
                var percentage = ((ele.loaded / ele.total) * 100);
                //console.log(percentage);
                $("#progress-bar").css("width", percentage + "%");
                $("#progress-bar").html(Math.round(percentage) + "%");
              }
            });
            return httpReq;
          },
          beforeSend: function() {
            $("#progress-bar").css("width", "0%");
            $("#progress-bar").html("0%");
          },

          type: "POST",
          url: "../ajax/incidencia_evento_insert.php",
          contentType: false,
          processData: false, //If you want to send a DOMDocument, or other non-processed data, set this option to false.
          data: form_registro,
          //async: false,
          success: function(returned) {
            var obj = $.parseJSON(returned);
            jQuery(obj).each(function(i, item) {
              text = item.text;
              if (text != 'No hay resultados') {
                var id = item.id_evento;
                fecha_evento = item.fecha_evento;
                nombre_evento = item.nombre_evento;
                id_incidencia = item.id_incidencia;
                text_fichero = item.text_fichero;
                //console.log(text_fichero);
                jQuery(text_fichero).each(function(j, item2) {
                  $("#resultado_upload").append(item2.text);
                })


                window.setTimeout(function() {
                  $("#fileList").empty();
                  $("#progress-bar").css("width", "0%");
                  $("#progress-bar").html("0%");
                  $("#modal_edit_record").modal('hide');
                  $("form#form_registro")[0].reset();
                  //quitamos al boton de guardar la clase que se utiliza para insertar registros
                  $("#form_registro").removeClass("insert_form");


                  //agregamos una nueva fila a la tabla de datatables
                  table_incidencia_eventos.row.add({
                    fecha_evento: fecha_evento,
                    nombre_evento: nombre_evento,
                    acciones_evento: '<center>\
  											<div class="btn-group">\
                          <a href="#" type="button" id="' + id + '" class="btn btn-sm btn-default view_record" title="Ver Evento"><span class="glyphicon glyphicon-eye-open"></span></a>\
                          <a href="#" type="button" id="' + id + '" class="btn btn-sm btn-success edit_record" title="Editar Evento"><span class="glyphicon glyphicon-pencil"></span></a>\
                      		<a href="#" type="button" id="' + id + '" class="btn btn-sm btn-danger delete_record" title="Borrar Evento"><span class="glyphicon glyphicon-trash"></span></a>\
  											</div>\
  										</center>'
                  }).node().id = id;

                  table_incidencia_eventos.draw(false);
                  $("#" + id + ".view_record").trigger("click");


                }, 1500);


                //document.location.href = String(document.location.href).replace("#", "");



              } else {
                alert(text);
              }
            })
          },
          error: function() {
            alert("failure");
          }
        });


      }
    });






  });

  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
</script>

<script>
  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //SCRIPT PARA EDITAR UN REGISTRO EN VENTANA MODAL
  $(document).ready(function() {
    //al hacer click en el boton de editar
    $(document).on('click', '.edit_record', function(event) {

      $("form#form_registro")[0].reset();
      $('#table_ficheros_edit tbody').empty();
      $("#resultado_upload").empty();
      $("#fileList").empty();

      $.ajax({
        type: "POST",
        url: "../ajax/incidencia_evento_get.php",
        data: {
          'id_evento': this.id,
        },
        success: function(returned) {
          var obj = $.parseJSON(returned);
          jQuery(obj).each(function(i, item) {
            text = item.text;
            if (text != 'No hay resultados') {
              id = item.id_evento;
              fecha_evento = item.fecha_evento;
              nombre_evento = item.nombre_evento;
              id_incidencia = item.id_incidencia;
            } else {
              alert(text);
            }
          })

          //METEMOS LOS DATOS EN LOS INPUTS DEL FORMULARIO
          $("#id_evento").val(id);
          $("#fecha_evento").val(fecha_evento);
          $("#nombre_evento").val(nombre_evento);

          $("#fichero_edit_row").show();

          //Extraemos los ficheros de cada REGISTRO y los pasamos a la tabla de ficheros
          $.ajax({
            type: "POST",
            url: "../ajax/incidencia_evento_ficheros_get.php",
            data: {
              'id_evento': id,
              'tipo_modal': 'edit_record'
            },
            success: function(returned) {
              var obj = $.parseJSON(returned);
              const table_ficheros_edit = $('#table_ficheros_edit').DataTable({
                //data: obj,
                columns: [{
                    data: 'nombre_fichero'
                  },
                  {
                    data: 'boton_fichero'
                  },
                ],
                order: [
                  [0, 'desc']
                ],
                autoWidth: true,
                iDisplayLength: 25,
                scrollX: false,
                bPaginate: false,
                bFilter: false,
                bInfo: false,
                bScrollCollapse: false
              });
              //destruimos la tabla
              table_ficheros_edit.destroy();

              jQuery(obj).each(function(i, item) {
                text = item.text;
                if (text != 'No hay resultados') {

                  id = item.id;
                  ruta_fichero = item.ruta_fichero;
                  boton_fichero = item.boton_fichero;
                  id_tipo_fichero = item.id_tipo_fichero;
                  tipo_fichero = item.tipo_fichero;
                  nombre_fichero = item.nombre_fichero;

                  //agregamos una nueva fila a la tabla de datatables
                  table_ficheros_edit.row.add({
                    nombre_fichero: nombre_fichero,
                    boton_fichero: boton_fichero,
                  }).node().id = id;

                  table_ficheros_edit.draw(false);

                } else {
                  //alert(text);
                }
              })
            },
            error: function() {
              alert("failure");
            }
          });

          //quitamos al boton de guardar la clase que se utiliza para insertar registros
          $("#form_registro").removeClass("insert_form");
          //agregamos al boton de guardar la clase que se utiliza para actualizar registros
          $("#form_registro").addClass("update_form");

          //PONEMOS TITULO A LA VENTANA MODAL Y ABRIMOS MODAL
          $("#modal_edit_record_title").html('Editar Evento: <strong>' + id + '</strong>');
          $("#modal_edit_record").modal();

        },
        error: function() {
          alert("failure");
        }
      });
    });


    $("form#form_registro").submit(function(event) {

      event.preventDefault(); //prevenir el envio del form via ajax, hasta que no esten todos los campos requeridos
      if ($("#form_registro").hasClass("update_form")) {

        var form_registro = new FormData(this);

        $.ajax({

          xhr: function() { //Callback for creating the XMLHttpRequest object
            var httpReq = new XMLHttpRequest(); //monitor an upload's progress. //amount of progress
            httpReq.upload.addEventListener("progress", function(ele) {
              if (ele.lengthComputable) { //property is a boolean flag indicating if the resource concerned by the ProgressEvent has a length that can be calculated.
                var percentage = ((ele.loaded / ele.total) * 100);
                //console.log(percentage);
                $("#progress-bar").css("width", percentage + "%");
                $("#progress-bar").html(Math.round(percentage) + "%");
              }
            });
            return httpReq;
          },
          beforeSend: function() {
            $("#progress-bar").css("width", "0%");
            $("#progress-bar").html("0%");
          },

          type: "POST",
          url: "../ajax/incidencia_evento_update.php",
          contentType: false,
          processData: false, //If you want to send a DOMDocument, or other non-processed data, set this option to false.
          data: form_registro,
          success: function(returned) {
            var obj = $.parseJSON(returned);
            jQuery(obj).each(function(i, item) {
              text = item.text;
              if (text != 'No hay resultados') {

                id = item.id_evento;
                fecha_evento = item.fecha_evento;
                nombre_evento = item.nombre_evento;
                id_incidencia = item.id_incidencia;
                text_fichero = item.text_fichero;
                //console.log(text_fichero);
                jQuery(text_fichero).each(function(j, item2) {
                  $("#resultado_upload").append(item2.text);
                })

                window.setTimeout(function() {
                  $("#fileList").empty();
                  $("#progress-bar").css("width", "0%");
                  $("#progress-bar").html("0%");
                  $("#modal_edit_record").modal('hide');
                  $("form#form_registro")[0].reset();
                  //quitamos al boton de guardar la clase que se utiliza para insertar registros
                  $("#form_registro").removeClass("update_form");

                  if ($('#table_incidencia_eventos').length) {
                    table_incidencia_eventos.row('#' + id).remove().draw(false);
                    //agregamos una nueva fila a la tabla de datatables
                    table_incidencia_eventos.row.add({
                      fecha_evento: fecha_evento,
                      nombre_evento: nombre_evento,
                      acciones_evento: '<center>\
    											<div class="btn-group">\
                            <a href="#" type="button" id="' + id + '" class="btn btn-sm btn-default view_record" title="Ver Evento"><span class="glyphicon glyphicon-eye-open"></span></a>\
                            <a href="#" type="button" id="' + id + '" class="btn btn-sm btn-success edit_record" title="Editar Evento"><span class="glyphicon glyphicon-pencil"></span></a>\
                        		<a href="#" type="button" id="' + id + '" class="btn btn-sm btn-danger delete_record" title="Borrar Evento"><span class="glyphicon glyphicon-trash"></span></a>\
    											</div>\
    										</center>'
                    }).node().id = id;
                    table_incidencia_eventos.draw(false);
                  }
                  $("#" + id + ".view_record").trigger("click");

                }, 1500);


              } else {
                alert(text);
              }
            })

          },
          error: function() {
            alert("failure");
          }
        });
      }

    });

  });
  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
</script>


<!--MODAL VISTA DE REGISTROS-->
<div class="modal fade" id="modal_view_record" role="dialog">
  <div class="modal-dialog modal-dialog-centered">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <center>
          <h4 class="modal-title" id="modal_view_record_title">Modal title</h4>
        </center>
      </div>

      <div class="modal-body">
        <div class="row">
          <div class="col-sm-1"></div>
          <div class="col-sm-5">
            <div class="form-group">
              <label>Fecha Evento:</label>
              <div id="fecha_evento_view" name="fecha_evento_view"></div>
            </div>
          </div>
          <div class="col-sm-5">
            <div class="form-group">
              <label>Descripción Evento:</label>
              <div id="nombre_evento_view" name="nombre_evento_view"></div>
            </div>
          </div>
          <div class="col-sm-1"></div>
        </div>

        <div class="row">
          <div class="col-sm-1"></div>
          <div class="col-sm-10">
            <label>Ficheros:</label>
            <table id="ficheros_view" class="table table-striped table-bordered dataTable table-hover">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Operaciones</th>
                </tr>
              </thead>
            </table>
          </div>
          <div class="col-sm-1"></div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-lg fa-times"></i> Cerrar</button>
      </div>

    </div>
  </div>
</div>

<script>
  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //SCRIPT PARA VER REGISTRO EN VENTANA MODAL
  $(document).ready(function() {
    //al hacer click en el boton de ver registro
    $(document).on('click', '.view_record', function(event) {
      $.ajax({
        type: "POST",
        url: "../ajax/incidencia_evento_get.php",
        data: {
          'id_evento': this.id,
        }, //recogemos el id del boton de view_record
        success: function(returned) {
          var obj = $.parseJSON(returned);
          jQuery(obj).each(function(i, item) {
            text = item.text;
            if (text != 'No hay resultados') {
              id = item.id_evento;
              fecha_evento = item.fecha_evento;
              nombre_evento = item.nombre_evento;
              id_incidencia = item.id_incidencia;
            } else {
              alert(text);
            }
          })

          //METEMOS LOS DATOS EN LOS PARRAFOS DE LA VENTANA MODAL
          $("#fecha_evento_view").html(fecha_evento);
          $("#nombre_evento_view").html(nombre_evento);

          //Extraemos los ficheros de cada REGISTRO y los pasamos a la tabla de ficheros
          $.ajax({
            type: "POST",
            url: "../ajax/incidencia_evento_ficheros_get.php",
            data: {
              'id_evento': id,
              'tipo_modal': 'view_record'
            },
            success: function(returned) {
              var obj = $.parseJSON(returned);
              var table = $('#ficheros_view').DataTable({
                data: obj,
                columns: [{
                    data: 'nombre_fichero'
                  },
                  {
                    data: 'boton_fichero'
                  },
                ],
                order: [
                  [0, 'desc']
                ],
                autoWidth: true,
                iDisplayLength: 25,
                scrollX: false,
                bPaginate: false,
                bFilter: false,
                bInfo: false,
                bScrollCollapse: false
              });
              //destruimos la tabla
              table.destroy();
            },
            error: function() {
              alert("failure");
            }
          });

          //PONEMOS TITULO A LA VENTANA MODAL Y ABRIMOS MODAL
          $("#modal_view_record_title").html('ID Evento: <strong>' + id + '</strong>');
          $("#modal_view_record").modal();

        },
        error: function() {
          alert("failure");
        }
      });

    });

  });
  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
</script>


<!--HTML para modal de confirmacion de borrado de registro-->

<div class="modal fade" id="modal_delete_record" role="dialog">
  <div class="modal-dialog modal-dialog-centered">
    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <center>
          <h4 class="modal-title" id="modal-delete-title">Modal title</h4>
        </center>
      </div>

      <div class="modal-body">

        <div class="row">
          <div class="col-sm-1"></div>
          <div class="col-sm-5">
            <div class="form-group">
              <label>Fecha Evento:</label>
              <div id="fecha_evento_delete" name="fecha_evento_delete"></div>
            </div>
          </div>
          <div class="col-sm-5">
            <div class="form-group">
              <label>Descripción Evento:</label>
              <div id="nombre_evento_delete" name="nombre_evento_delete"></div>
            </div>
          </div>
          <div class="col-sm-1"></div>
        </div>

        <div class="row">
          <div class="col-sm-1"></div>
          <div class="col-sm-10">
            <label>Ficheros:</label>
            <table id="ficheros_delete" class="table table-striped table-bordered dataTable table-hover">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Operaciones</th>
                </tr>
              </thead>
            </table>
          </div>
          <div class="col-sm-1"></div>
        </div>

      </div>

      <div class="modal-footer">
        <center><span class="label label-danger" style="font-size:16px;">¿Borrar Registro?</span></center>
        <a href="#"><button type="button" class="btn btn-danger delete_record_button"><i class="fas fa-lg fa-trash"></i> Si</button></a>
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-lg fa-times"></i> No</button>
      </div>

    </div>
  </div>
</div>

<script>
  //ORIGINAL
  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //SCRIPT PARA BORRAR REGISTRO EN VENTANA MODAL
  $(document).ready(function() {
    //al hacer click en el boton de borrar
    $(document).on('click', '.delete_record', function(event) {

      $.ajax({
        type: "POST",
        url: "../ajax/incidencia_evento_get.php",
        data: {
          'id_evento': this.id,
        },
        success: function(returned) {
          var obj = $.parseJSON(returned);
          jQuery(obj).each(function(i, item) {
            text = item.text;
            if (text != 'No hay resultados') {
              id = item.id_evento;
              fecha_evento = item.fecha_evento;
              nombre_evento = item.nombre_evento;
              id_incidencia = item.id_incidencia;
            } else {
              alert(text);
            }
          })

          //METEMOS LOS DATOS EN LOS PARRAFOS DE LA VENTANA MODAL
          $("#fecha_evento_delete").html(fecha_evento);
          $("#nombre_evento_delete").html(nombre_evento);

          //Extraemos los ficheros de cada REGISTRO y los pasamos a la tabla de ficheros
          $.ajax({
            type: "POST",
            url: "../ajax/incidencia_evento_ficheros_get.php",
            data: {
              'id_evento': id,
              'tipo_modal': 'delete_record'
            },
            success: function(returned) {
              var obj = $.parseJSON(returned);
              var table = $('#ficheros_delete').DataTable({
                data: obj,
                columns: [{
                    data: 'nombre_fichero'
                  },
                  {
                    data: 'boton_fichero'
                  },
                ],
                order: [
                  [0, 'desc']
                ],
                autoWidth: true,
                iDisplayLength: 25,
                scrollX: false,
                bPaginate: false,
                bFilter: false,
                bInfo: false,
                bScrollCollapse: false
              });
              //destruimos la tabla
              table.destroy();
            },
            error: function() {
              alert("failure");
            }
          });

          $('.delete_record_button').attr('id', id);
          //PONEMOS TITULO A LA VENTANA MODAL Y ABRIMOS MODAL
          $("#modal-delete-title").html('ID Evento: <strong>' + id + '</strong>');
          $("#modal_delete_record").modal();

        },
        error: function() {
          alert("failure");
        }
      });
    });


    $(document).on('click', '.delete_record_button', function(event) {
      $.ajax({
        type: "POST",
        url: "../ajax/incidencia_evento_delete.php",
        data: {
          'id_evento': this.id,
        },
        success: function(returned) {
          var obj = $.parseJSON(returned);
          jQuery(obj).each(function(i, item) {
            text = item.text;
            if (text == 'No hay resultados') {
              id = item.id_evento;

              //borramos la fila seleccionada que es la que estamos actualizando
              table_incidencia_eventos.row('#' + id).remove().draw(false);
              //cerramos ventana modal
              $("#modal_delete_record").modal('hide');

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
  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
</script>

<script>
  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //SCRIPT PARA BORRAR UN FICHERO EN VENTANA MODAL

  $(document).ready(function() {
    // Al hacer click en el botón de borrar_fichero
    $(document).on('click', '.borrar_fichero', function(event) {
      event.preventDefault(); // Previene la acción por defecto del botón, si es un enlace

      // Alerta de confirmación con SweetAlert2
      Swal.fire({
        title: 'El fichero será eliminado permanentemente.',
        text: "¿Deseas continuar?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminalo',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "POST",
            url: "../ajax/incidencia_evento_fichero_delete.php",
            data: {
              'id_fichero': this.id,
            },
            success: function(returned) {
              obj = $.parseJSON(returned);
              $(obj).each(function(i, item) {
                text = item.text;
                id = item.id_fichero;

                if (text == 'No hay resultados') {
                  // Borramos la fila seleccionada que es la que estamos actualizando
                  $('#table_ficheros_edit').DataTable().row('#' + id).remove().draw();
                  $('#table_ficheros_edit').DataTable().destroy();
                } else {
                  Swal.fire('Error', text, 'error');
                }
              });
            },
            error: function(xhr, status, error) {
              console.error("AJAX Error:", status, error);
              Swal.fire('Error', "Error al intentar borrar el fichero. Por favor, inténtalo de nuevo.", 'error');
            }
          });
        }
      });
    });
  });

  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
</script>
