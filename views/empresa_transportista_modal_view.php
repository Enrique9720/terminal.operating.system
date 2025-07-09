<!--MODAL ALTA DE REGISTROS-->
<div class="modal fade" id="modal_edit_record" role="dialog">
   <div class="modal-dialog modal-dialog-centered">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
             <center><h4 class="modal-title" id="modal_edit_record_title">Modal title</h4></center>
         </div>

    		 <form id="form_registro_modal">
    			 <div class="modal-body">

            <div class="row">
              <div class="col-sm-2"></div>
              <div class="col-sm-8">
                <div class="form-group">
    							<label>CIF Empresa:</label>
    							<input type="text" class="form-control" id="cif_empresa_transportista" name="cif_empresa_transportista" required>
                  <div id="error_cif"></div>
    						</div>
              </div>
              <div class="col-sm-2"></div>
            </div>

            <div class="row">
    					<div class="col-sm-2"></div>
              <div class="col-sm-8">
                <div class="form-group">
    							<label>Nombre Empresa:</label>
                  <input type="text" class="form-control" id="nombre_empresa_transportista" name="nombre_empresa_transportista" required>
    						</div>
              </div>
              <div class="col-sm-2"></div>
            </div>

            <div class="row">
              <div class="col-sm-2"></div>
              <div class="col-sm-8">
                <div class="form-group">
                  <label>Dirección Empresa:</label>
                  <textarea class="form-control" rows="5" id="direccion_empresa_transportista" name="direccion_empresa_transportista"></textarea>
                </div>
                <div class="col-sm-2"></div>
              </div>
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
		//COMPROBACION DE CLAVE PRIMARIA AL DAR DE ALTA REGISTRO
		$(document).ready(function(){
			$('#cif_empresa_transportista').blur(function(){
        cif_empresa_transportista = $('#cif_empresa_transportista').val()
				//console.log('cif_empresa_transportista: ' + cif_empresa_transportista);
				$.ajax({
					type: "POST",
					url: "../ajax/check_cif_empresa_transportista.php",
					data: {
            'cif_empresa_transportista': cif_empresa_transportista
          },
					success: function(returned){
						var obj = $.parseJSON(returned);
            jQuery(obj).each(function(i, item){
              id = item.id;
              nombre_empresa_transportista = item.nombre_empresa_transportista;
              direccion_empresa_transportista = item.direccion_empresa_transportista;
              text = item.text;
              if(text != 'No hay resultados'){
                mensaje_error = '<center><span class="label label-danger">CIF '+ cif_empresa_transportista + ' ya existe para ' + nombre_empresa_transportista +'</span></center>';
                $("#error_cif").html(mensaje_error);
              }else{
                mensaje_error = '';
                $("#error_cif").empty();
              }
              if(mensaje_error != ''){
                $('#guardar').prop( "disabled", true );
              }else{
                $('#guardar').prop( "disabled", false );
              }
            })
					},
					error: function(){
						alert("failure");
					}
				});
			});
		});

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//SCRIPT PARA INSERTAR UN REGISTRO EN VENTANA MODAL
      $(document).ready(function(){

        //al hacer click en el boton de añadir registro
        $(document).on('click', '.add_emp_transportista', function(event){
  				//reseteamos los campos del formulario, ya que deben de estar vacios al ser una alta nueva de registro
  				$("form#form_registro_modal")[0].reset();
          //vaciamos el div de error
          $("#error_cif").empty();
  				//PONEMOS TITULO A LA VENTANA MODAL
  				$("#modal_edit_record_title").html('<strong>Alta Empresa de Transporte</strong>');
  				//Abrimos la ventana modal
  				$("#modal_edit_record").modal();
        });

			$("form#form_registro_modal").submit(function(event){
				event.preventDefault(); //prevenir el envio del form via ajax, hasta que no esten todos los campos requeridos
					$.ajax({
						type: "POST",
						url: "../ajax/empresa_transportista_insert.php",
						data: $('form#form_registro_modal').serialize(),
						success: function(returned){
							var obj = $.parseJSON(returned);
							jQuery(obj).each(function(i, item){
								text = item.text;
								if(text != 'No hay resultados'){
                  id = item.id;
                  nombre_empresa_transportista = item.nombre_empresa_transportista;
                  direccion_empresa_transportista = item.direccion_empresa_transportista;
									$("#modal_edit_record").modal('hide');
									$("form#form_registro_modal")[0].reset();
								}else{
									alert(text);
								}
							})
						},
						error: function(){
							alert("failure");
						}
					});
      });

    });
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
</script>
