<div class="modal fade" id="modal_file_upload" role="dialog">
	<div class="modal-dialog modal-dialog-centered">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<center>
					<h4 class="modal-title" id="file_upload">Subir Documentación</h4>
				</center>
			</div>

			<form id="form_file_upload">
				<input type="hidden" id="id_entrada_upload" name="id_entrada_upload" value="<?php echo $id_entrada_upload ?>" required>
				<input type="hidden" id="num_packing_upload" name="num_packing_upload" value="<?php echo $num_packing ?>" required>
				<input type="hidden" id="id_salida_upload" name="id_salida_upload" value="<?php echo $id_salida_upload ?>" required>

				<div class="modal-body">

					<div class="row">
						<div class="col-sm-1"></div>
						<div class="col-sm-4">
							<div class="form-group">
								<label>Tipo Fichero:</label>

								<select class="form-control" id="id_tipo_fichero_upload" name="id_tipo_fichero_upload" required>
									<option value=''></option>
									<?php foreach ($tipos_ficheros_list as $tipos_ficheros_line) {
										echo "<option value='" . $tipos_ficheros_line['id_tipo_fichero'] . "'>" . $tipos_ficheros_line['tipo_fichero'] . "</option>";
									} ?>
								</select>

							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label>Subir Fichero:</label>
								<input type="file" class="form-control" id="fichero_upload" name="fichero_upload" required>
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
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary" id="subir"><i class="fa fa-lg fa-arrow-up"></i> Subir</button>
					<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-lg fa-times"></i> Cerrar</button>
				</div>
			</form>

		</div>
	</div>
</div>

<script>
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//SCRIPT PARA SUBIR UN FICHERO EN VENTANA MODAL
	$(document).ready(function() {

		//al hacer click en el boton de subir fichero
		$(document).on('click', '.add_fichero', function(event) {

			id = this.id;
			//reseteamos los campos del formulario, ya que deben de estar vacios al ser una lata nueva de registro
			$("form#form_file_upload")[0].reset();
			//PONEMOS TITULO A LA VENTANA MODAL Y ABRIMOS MODAL
			$("#file_upload").html('Subir Fichero a Entrada: <strong>' + id + '</strong>');
			$("#modal_file_upload").modal();
			$("#id_tipo_fichero_upload").val("1");
		});

		$("form#form_file_upload").submit(function(event) {

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
				url: "../ajax/fichero_upload.php",
				contentType: false,
				processData: false, //If you want to send a DOMDocument, or other non-processed data, set this option to false.
				data: form_upload_file,
				//data: {'id_entrada': this.id, 'form_upload_file': form_upload_file},
				beforeSend: function() {
					$("#progress-bar").css("width", "0%");
					$("#progress-bar").html("0%");
				},
				success: function(returned) {

					var obj = $.parseJSON(returned);
					jQuery(obj).each(function(i, item) {
						text = item.text;
						if (text != 'No hay resultados') {

							id = item.id;
							ruta_fichero = item.ruta_fichero;
							id_tipo_fichero = item.id_tipo_fichero;
							tipo_movimiento = item.tipo_movimiento;
							text = item.text;
							status = item.status;

							$("#resultado_upload").html(text);

							if (status == "success") {
								window.setTimeout(function() {
									$("#modal_file_upload").modal('hide');
									$("#resultado_upload").empty();
									$("#progress-bar").css("width", "0%");
									$("#progress-bar").html("0%");
									$("form#form_file_upload")[0].reset();
									document.location.href = String(document.location.href).replace("#", "");
									var item_ = {
										tipo_fichero: item.tipo_fichero,
										extension: item.extension,
										operaciones: '<div class="btn-group"><a href="' + item.ruta_fichero + '" target="_blank" type="button" class="btn btn-sm btn-default ver_fichero" title="Ver"><span class="fa fa-eye" aria-hidden="true"></span></a>' + '<a href="' + item.ruta_fichero + '" download type="button" class="btn btn-sm btn-primary descargar_fichero" title="Descargar"><span class="fa fa-arrow-down" aria-hidden="true"></span></a>' + '<a href="#" type="button" id="' + item.id + '" class="btn btn-sm btn-danger delete_record" title="Borrar"><span class="glyphicon glyphicon-trash"></span></a></div>',
									};
									table_ficheros.row.add(item_);
									table_ficheros.draw(false);
								}, 1500);
							}

						} else {
							alert(text);
						}
					})
				},
				error: function(xhr) {
					$("#resultado_upload").html("Upload Failed : " + xhr.statusText);
				}
			});

		});

	});
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
</script>



<script>
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$(document).ready(function() {

		$(document).on('click', '.delete_record', function(event) {

			if (confirm("Borrar Fichero") == true) {

				fila_fichero = $(this).parents('tr');
				$.ajax({
					type: "POST",
					url: "../ajax/fichero_delete.php",
					data: {
						'id_fichero': this.id,
					},
					success: function(returned) {
						var obj = $.parseJSON(returned);
						jQuery(obj).each(function(i, item) {
							text = item.text;
							if (text == 'Fichero Borrado') {
								id = item.id;

								//borramos la fila seleccionada que es la que estamos actualizando
								table_ficheros.row(fila_fichero).remove().draw();
								document.location.href = String(document.location.href).replace("#", "");

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