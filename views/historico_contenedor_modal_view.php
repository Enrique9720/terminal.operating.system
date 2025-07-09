<!--MODAL VISTA DE REGISTROS-->
<div class="modal fade" id="modal_view_record" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-lg">
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
          <div class="col-sm-12">
            <table id="contenedor_view" class="table table-striped table-bordered dataTable table-hover">
              <thead>
                <tr>
                  <th class="success">Expedición Entrada</th>
                  <th class="success">Tipo Entrada</th>
                  <th class="success">Fecha Entrada</th>
                  <th class="success">Mercancía</th>
                  <th class="success">Propietario (E)</th>
                  <th class="danger">Expedición Salida</th>
                  <th class="danger">Tipo Salida</th>
                  <th class="danger">Fecha Salida</th>
                  <th class="danger">Propietario (S)</th>
                </tr>
              </thead>
            </table>
          </div>
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
  $(document).ready(function(){

    var table = $('#contenedor_view').DataTable( {
      columns: [
        { data: 'num_expedicion_entrada' },
        { data: 'tipo_entrada' },
        { data: 'fecha_entrada' },
        { data: 'descripcion_mercancia_entrada' },
        { data: 'nombre_comercial_propietario_entrada' },
        { data: 'num_expedicion_salida' },
        { data: 'tipo_salida' },
        { data: 'fecha_salida' },
        { data: 'nombre_comercial_propietario_salida' },
      ],
      order: [[2,'desc']],
      autoWidth: true,
      iDisplayLength: 25,
      scrollX: false,
      bPaginate: false,
      bFilter: false,
      bInfo: false,
      bScrollCollapse: false
    } );

     //al hacer click en el boton de ver registro
     $(document).on('click', '.view_record', function(event){
          $('#contenedor_view').dataTable().fnClearTable();
          $.ajax({
              type: "POST",
              url: "../ajax/get_historico_contenedor.php",
              data: {'num_contenedor': this.id,}, //recogemos el id del boton de view_record
              success: function(returned){
                  var obj = $.parseJSON(returned);
                  jQuery(obj).each(function(i, item){
                        console.log(item);
                      text = item.text;
                      if(text != 'No hay resultados'){
                        num_contenedor = item.id;
                        var item_ = {
      										id_entrada: item.id_entrada,
                          num_expedicion_entrada: item.num_expedicion_entrada,
      										tipo_entrada: item.tipo_entrada,
      										fecha_entrada: item.fecha_entrada,
                          descripcion_mercancia_entrada: item.descripcion_mercancia_entrada,
                          nombre_comercial_propietario_entrada: item.nombre_comercial_propietario_entrada,
      										id_salida: item.id_salida,
                          num_expedicion_salida: item.num_expedicion_salida,
      										tipo_salida: item.tipo_salida,
      										fecha_salida: item.fecha_salida,
                          nombre_comercial_propietario_salida: item.nombre_comercial_propietario_salida,
      										//operacion: "<button id='"+resp.id_palet+"' class='remove btn-danger'><i class='fa fa-trash-alt'></i></button>"
      									};

                        //console.log(item_);
      									table.row.add( item_ );
      									table.draw(false);

                      }else{
                          alert(text);
                      }
                  })

                  //PONEMOS TITULO A LA VENTANA MODAL Y ABRIMOS MODAL
                  $("#modal_view_record_title").html('<strong>'+num_contenedor+'</strong>');
                  $("#modal_view_record").modal();
              },
              error: function(){
                  alert("failure");
              }
          });
      });
  });
  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
</script>
