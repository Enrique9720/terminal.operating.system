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

        <div class="row" style="display:none;" id="contenedores_tabla_fila">
          <div class="col-sm-2"></div>
          <div class="col-sm-8">
            <table id="contenedor_view" class="table table-striped table-bordered dataTable table-hover">
              <thead>
                <tr>
                  <th>Nº Contenedor</th>
                  <th>numero_correcto</th>
                  <th>duplicado</th>
                  <th>existe</th>
                  <th>propietario</th>
                  <th>reservado</th>
                  <th>stock</th>
                  <th>Error</th>

                </tr>
              </thead>
            </table>
          </div>
          <div class="col-sm-2"></div>
          <div class="col-sm-12"><center><strong>Total Contenedores: </strong><span id="total_contenedores"></span><center></div>
        </div>

      <div class="row" id="contenedores_textarea_fila">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
          <div class="control-group">
            <div class="form-group floating-label-form-group controls mb-0 pb-2">
              <textarea class="form-control" id="contenedores_list" rows="15" placeholder="Introduzca un Nº de Contenedor por línea"></textarea>
            </div>
          </div>
        </div>
        <div class="col-sm-2"></div>
      </div>


      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="guardar_contenedores"><i class="fa fa-sm fa-save" aria-hidden="true"></i> Guardar</button>
        <button type="button" class="btn btn-success" id="editar_contenedores"><i class="fa fa-sm fa-pencil" aria-hidden="true"></i> Editar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-sm fa-times"></i> Cerrar</button>

      </div>

    </div>
  </div>
</div>


<script>
  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  $(document).ready(function(){

    table = $('#contenedor_view').DataTable( {
      columns: [
        { data: 'num_contenedor' },
        { data: 'contenedor_numero_correcto_check', 'visible': false },
        { data: 'contenedor_duplicado_check', 'visible': false },
        { data: 'contenedor_existe_check', 'visible': false },
        { data: 'contenedor_propietario_check', 'visible': false },
        { data: 'contenedor_reservado_check', 'visible': false },
        { data: 'contenedor_stock_check', 'visible': false },
        { data: 'mensaje_error', 'visible': true },
      ],
      createdRow: function ( row, data, index ) {
        //console.log(data);
        if(
          data['contenedor_numero_correcto_check'] == "SI" &&
          data['contenedor_duplicado_check'] == "NO" &&
          data['contenedor_existe_check'] == "SI" &&
          data['contenedor_propietario_check'] == "SI" &&
          data['contenedor_reservado_check'] == "NO" &&
          data['contenedor_stock_check'] == "SI"
        ){
          $(row).addClass('success');
        }else if(
          data['contenedor_numero_correcto_check'] == "SI" &&
          data['contenedor_duplicado_check'] == "NO" &&
          data['contenedor_existe_check'] == "SI" &&
          data['contenedor_propietario_check'] == "SI" &&
          data['contenedor_reservado_check'] == "NO" &&
          data['contenedor_stock_check'] == "NO"
        ){
          $(row).addClass('warning');
        }else if(
          data['contenedor_numero_correcto_check'] == "NO" ||
          data['contenedor_duplicado_check'] == "SI" ||
          data['contenedor_existe_check'] == "NO" ||
          data['contenedor_propietario_check'] == "NO" ||
          data['contenedor_reservado_check'] == "SI"
        ){
          $(row).addClass('danger');
        }
      },
      columnDefs: [{
        "targets": 7,
        "width": "73%"
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

     //al hacer click en el boton de ver registro
     $(document).on('click', '#lineas_carga_button', function(event){

       //PONEMOS TITULO A LA VENTANA MODAL Y ABRIMOS MODAL
       $("#modal_view_record_title").html('<strong>Contenedores a Cargar</strong>');
       $("#modal_view_record").modal();

       $(document).on('click', '#editar_contenedores', function(event){
         $('#editar_contenedores').prop('disabled', true);
         $('#guardar_contenedores').prop('disabled', false);
         $("#contenedores_textarea_fila").show();
         $("#contenedores_tabla_fila").hide();
         $('#contenedor_view').dataTable().fnClearTable();
         $("#total_contenedores").html();

       });

      $(document).on('click', '#guardar_contenedores', function(event){
        $('#guardar_contenedores').prop('disabled', true);
        $('#editar_contenedores').prop('disabled', false);
        $('#contenedor_view').dataTable().fnClearTable();
        $("#contenedores_textarea_fila").hide();
        $("#contenedores_tabla_fila").show();

        var cif_propietario = document.forms["citaForm"]["propietarios_combo"].value;
        var contenedores_lineas = $('#contenedores_list').val().split(/\n/);
        //console.log(contenedores_lineas);
        //console.log("contenedores:");
        var contenedores = [];
        var num_contenedores_check = true;
        for (var i=0; i < contenedores_lineas.length; i++) {
          // only push this line if it contains a non whitespace character.
          if (/\S/.test(contenedores_lineas[i])) {
            num_contenedor = $.trim(contenedores_lineas[i]);
            num_contenedor = num_contenedor.split("-").join("");
            num_contenedor = num_contenedor.split(".").join("");
            //console.log(num_contenedor);

            $.ajax({
                type: "POST",
                url: "../ajax/contenedor_linea_carga.php",
                data: {
                  'num_contenedor': num_contenedor,
                  'cif_propietario': cif_propietario,
                },
                cache: false,
                async: false,
                success: function(returned){
                    //console.log(returned);
                    var obj = $.parseJSON(returned);
                    //console.log(obj);
                    jQuery(obj).each(function(i, item){

                      //detectar si contenedor duplicado
                      for (var j=0; j < contenedores.length; j++) {
                        num_cont_anterior = contenedores[j]['num_contenedor'];
                        if(item.num_contenedor == num_cont_anterior){
                          item.contenedor_duplicado_check = "SI";
      										item.mensaje_error = "Duplicado.";
                        }else{
                          item.contenedor_duplicado_check = "NO";
                        }
                      }

                      var item_ = {
    										num_contenedor: item.num_contenedor,
                        contenedor_numero_correcto_check: item.contenedor_numero_correcto_check,
                        contenedor_duplicado_check: item.contenedor_duplicado_check,
                        contenedor_existe_check: item.contenedor_existe_check,
    										contenedor_propietario_check: item.contenedor_propietario_check,
                        contenedor_reservado_check: item.contenedor_reservado_check,
                        contenedor_stock_check: item.contenedor_stock_check,
    										mensaje_error: item.mensaje_error
    									};
                      contenedores.push(item_);
                      ////check para habilitar o deshabilitar envio formulario
                      if(
                        item_.contenedor_numero_correcto_check == "NO" ||
                        item_.contenedor_duplicado_check == "SI" ||
                        item_.contenedor_existe_check == "NO" ||
                        item_.contenedor_propietario_check == "NO" ||
                        item_.contenedor_reservado_check == "SI"
                      ){
                        num_contenedores_check = false;
                      }
                    })
                },
                error: function(){
                    alert("failure");
                }
            });

          }
        }

        console.log(contenedores);
        //metemos valor de check para habilitar o deshabilitar envio formulario
        $('#num_contenedores_check').val(num_contenedores_check);
        table.rows.add( contenedores );
        table.draw(false);

        total_contenedores = table.rows().count();
        console.log(total_contenedores);
        $("#total_contenedores").html(total_contenedores);

      });

      });

  });
  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
</script>
