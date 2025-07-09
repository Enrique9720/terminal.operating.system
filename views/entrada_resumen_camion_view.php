<!DOCTYPE html>

<html lang="es">

<head>
	<title>Resumen Entrada Camión <?php echo $num_expedicion ?></title>

	<?php
	//Plantilla con los inludes de las librerias y CSS usados por todas las paginas de la APP
	require_once('../tpl/header_includes.php');
	?>

	<!-- Custom Functions JavaScript -->
	<script src="../functions/documentacion_functions.js"></script>

	<script>
		$(document).ready(function() {

			//Reenvio de CODECO erroneo
			//al hacer click en el boton de reenvio codeco
			$(document).on('click', '.resend_codeco', function(event) {
				$.ajax({
					type: "POST",
					url: "../ajax/resend_codeco.php",
					data: {
						'id_codeco': this.id,
					}, //recogemos el id del boton de view_record
					success: function(returned) {
						var obj = $.parseJSON(returned);
						jQuery(obj).each(function(i, item) {
							text = item.text;
							if (text == 'success') {
								location.reload();
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


			var $num_expedicion = '<?php echo $num_expedicion ?>';

			table_entrada_resumen = $('#table_entrada_resumen').DataTable({
				columns: [{
						data: 'fecha_entrada'
					},
					{
						data: 'nombre_propietario'
					},
					{
						data: 'nombre_origen'
					},
					{
						data: 'nombre_destino'
					},
				],
				ordering: false,
				autoWidth: false,
				iDisplayLength: -1,
				//scrollY: '10vh',
				bPaginate: false,
				bFilter: false,
				bInfo: false,
				bScrollCollapse: true
			});

			table_entrada_camion_resumen = $('#table_entrada_camion_resumen').DataTable({
				columns: [{
						data: 'nombre_empresa_transportista'
					},
					{
						data: 'conductor'
					},
					{
						data: 'matriculas'
					},
				],
				ordering: false,
				autoWidth: false,
				iDisplayLength: -1,
				//scrollY: '10vh',
				bPaginate: false,
				bFilter: false,
				bInfo: false,
				bScrollCollapse: true
			});

			table_lineas_entrada_camion = $('#table_lineas_entrada_camion').DataTable({
				columns: [{
						data: 'num_contenedor'
					},
					{
						data: 'id_tipo_contenedor_iso'
					},
					{
						data: 'longitud_tipo_contenedor'
					},
					{
						data: 'descripcion_tipo_contenedor'
					},
					{
						data: 'tara_contenedor'
					},
					{
						data: 'estado_carga_contenedor'
					},
					{
						data: 'peso_mercancia_contenedor'
					},
					{
						data: 'temperatura_contenedor'
					},
					{
						data: 'descripcion_mercancia'
					},
					{
						data: 'num_booking_contenedor'
					},
					{
						data: 'num_precinto_contenedor'
					},
				],

				columnDefs: [{ //num_contenedor
						"targets": 0,
						"className": "text-left",
						"width": "10%"
					},
					{ //num_contenedor
						"targets": 1,
						"className": "text-left",
						"width": "5%"
					},

				],

				ordering: false,
				autoWidth: false,
				iDisplayLength: -1,
				//scrollY: '10vh',
				bPaginate: false,
				bFilter: false,
				bInfo: false,
				bScrollCollapse: true
			});

			table_entrada_camion_mercancia_peligrosa_resumen = $('#table_entrada_camion_mercancia_peligrosa_resumen').DataTable({
				columns: [{
						data: 'num_peligro_adr'
					},
					{
						data: 'descripcion_peligro_adr'
					},
					{
						data: 'num_onu_adr'
					},
					{
						data: 'descripcion_onu_adr'
					},
					{
						data: 'num_clase_adr'
					},
					{
						data: 'cod_grupo_embalaje_adr'
					},
				],
				columnDefs: [{
						"targets": 1,
						"className": "text-left",
						"width": "35%"
					},
					{
						"targets": 3,
						"className": "text-left",
						"width": "35%"
					}


				],
				ordering: false,
				autoWidth: false,
				iDisplayLength: -1,
				//scrollY: '10vh',
				bPaginate: false,
				bFilter: false,
				bInfo: false,
				bScrollCollapse: true
			});

			table_entrada_camion_destinatario_resumen = $('#table_entrada_camion_destinatario_resumen').DataTable({
				columns: [{
						data: 'nombre_destinatario'
					},
					{
						data: 'num_tarjeta_teco'
					},
					{
						data: 'codigo_estacion_ferrocarril'
					},
				],
				columnDefs: [{
					"targets": 0,
					"className": "text-left",
					"width": "60%"
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

			table_entrada_camion_observaciones = $('#table_entrada_camion_observaciones').DataTable({
				columns: [{
						data: 'observaciones'
					},
					{
						data: 'acciones'
					},
				],
				columnDefs: [{
					"targets": 0,
					"className": "text-center",
					"width": "100%"
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

			table_ficheros = $('#table_ficheros').DataTable({
				columns: [{
						data: 'tipo_fichero'
					},
					{
						data: 'extension'
					},
					{
						data: 'operaciones'
					},
				],
				ordering: true,
				autoWidth: false,
				iDisplayLength: -1,
				//scrollY: '10vh',
				bPaginate: false,
				bFilter: false,
				bInfo: false,
				bScrollCollapse: true
			});

			table_entrada_camion_incidencia = $('#table_entrada_camion_incidencia').DataTable({
				columns: [{
						data: 'num_incidencia'
					},
					{
						data: 'tipo_incidencia'
					},
					{
						data: 'estado_incidencia'
					}
				],
				ordering: true,
				autoWidth: false,
				iDisplayLength: -1,
				//scrollY: '10vh',
				bPaginate: false,
				bFilter: false,
				bInfo: false,
				bScrollCollapse: true
			});



		});
	</script>

	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
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

			<div class="row">
				<div class="col-md-12" style="padding-top:10px;">
					<div class="well well-sm">
						<a href="../controllers/entrada_camion_controller.php" type="button" class="btn btn-primary" title="Añadir Entrada Camión"><span class="fa fa-plus" aria-hidden="true"></span> Entrada Camión</a>
						<?php if ($_SESSION['roles_array'][0]['nombre_rol'] == "admin") : ?><a href="#" type="button" id="<?php echo $num_expedicion ?>" class="btn btn-success add_fichero" title="Subir Fichero"><span class="fa fa-arrow-up" aria-hidden="true"></span> Subir Fichero</a><?php endif; ?>
						<a target="_blank" href="../controllers/pdf_uti_carretera_controller.php?id=<?php echo $id_entrada; ?>&tipo=entrada" type="button" class="btn btn-danger" title="PDF UTIs"><span class="fa fa-file-pdf" aria-hidden="true"></span> PDF UTIs Carretera</a>
						<a class="btn btn-default" onclick="window.location.reload()"><i class="glyphicon glyphicon-refresh"></i> Recargar</a>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<center>
						<h3>Entrada Camión</h3>
					</center>
				</div>
				<div class="col-sm-12">
					<center>
						<h4>Nº Expedición: <?php echo $num_expedicion ?></h4>
					</center>
				</div>

				<div class="col-sm-3"></div>
				<div class="col-sm-6">
					<table id="table_entrada_resumen" class="table table-striped table-bordered" style="font-size: 12px;">
						<thead>
							<tr>
								<th>Fecha Entrada</th>
								<th>Propietario</th>
								<th>Origen Ferroviario</th>
								<th>Destino Ferroviario</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($entrada_camion_list as $entrada_camion_line) { ?>
								<tr>
									<td><?php echo $entrada_camion_line['fecha_entrada']; ?></td>
									<td><?php echo $entrada_camion_line['nombre_comercial_propietario']; ?></td>
									<td><?php echo $entrada_camion_line['nombre_origen']; ?></td>
									<td><?php echo $entrada_camion_line['nombre_destino']; ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="col-sm-3"></div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<center>
						<h4>Transportista</h4>
					</center>
				</div>
				<div class="col-sm-2"></div>
				<div class="col-sm-8">
					<table id="table_entrada_camion_resumen" class="table table-striped table-bordered" style="font-size: 12px;">
						<thead>
							<tr>
								<th>Transportista</th>
								<th>Conductor</th>
								<th>Matrículas</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($entrada_camion_list as $entrada_camion_line) { ?>
								<tr>
									<td><?php echo $entrada_camion_line['nombre_empresa_transportista']; ?></td>
									<td><?php echo "(" . $entrada_camion_line['dni_conductor'] . ") " . $entrada_camion_line['nombre_conductor'] . " " . $entrada_camion_line['apellidos_conductor']; ?></td>
									<td><?php echo $entrada_camion_line['matricula_tractora'] . " - " . $entrada_camion_line['matricula_remolque']; ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="col-sm-2"></div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<center>
						<h4>Datos Contenedor</h4>
					</center>
				</div>
				<div class="col-sm-12" style="padding-top:10px;">
					<table id="table_lineas_entrada_camion" class="table table-striped table-bordered" style="font-size: 12px;">
						<thead>
							<tr>
								<th>Nº contenedor</th>
								<th>Tipo</th>
								<th>Longitud</th>
								<th>Descripción</th>
								<th>Tara</th>
								<th>Estado carga</th>
								<th>Peso Mercancía</th>
								<th>Temperatura</th>
								<th>Mercancía</th>
								<th>Nº Booking</th>
								<th>Nº Precinto</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($entrada_camion_list as $entrada_camion_line) { ?>
								<tr>
									<td><?php echo $entrada_camion_line['num_contenedor']; ?></td>
									<td><?php echo $entrada_camion_line['id_tipo_contenedor_iso']; ?></td>
									<td><?php echo $entrada_camion_line['longitud_tipo_contenedor']; ?></td>
									<td><?php echo $entrada_camion_line['descripcion_tipo_contenedor']; ?></td>
									<td><?php echo $entrada_camion_line['tara_contenedor']; ?></td>
									<td><?php echo $entrada_camion_line['estado_carga_contenedor']; ?></td>
									<td><?php echo $entrada_camion_line['peso_mercancia_contenedor']; ?></td>
									<td><?php echo $entrada_camion_line['temperatura_contenedor']; ?></td>
									<td><?php echo $entrada_camion_line['descripcion_mercancia']; ?></td>
									<td><?php echo $entrada_camion_line['num_booking_contenedor']; ?></td>
									<td><?php echo $entrada_camion_line['num_precinto_contenedor']; ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
			<?php if ($flag_mercancia_peligrosa) { //solo imprimimos tabla mercancia peligrosa si hay
			?>
				<div class="row">
					<div class="col-sm-12">
						<center>
							<h4>Mercancía Peligrosa</h4>
						</center>
					</div>
					<div class="col-sm-2"></div>
					<div class="col-sm-8">
						<table id="table_entrada_camion_mercancia_peligrosa_resumen" class="table table-striped table-bordered" style="font-size: 12px;">
							<thead>
								<tr>
									<th>Nº Peligro</th>
									<th>ONU Peligro</th>
									<th>Nº ONU</th>
									<th>ONU Descripción</th>
									<th>Clase</th>
									<th>Grupo Embalaje</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($entrada_camion_list as $entrada_camion_line) { ?>
									<tr>
										<td><?php echo $entrada_camion_line['num_peligro_adr']; ?></td>
										<td><?php echo $entrada_camion_line['descripcion_peligro_adr']; ?></td>
										<td><?php echo $entrada_camion_line['num_onu_adr']; ?></td>
										<td><?php echo $entrada_camion_line['descripcion_onu_adr']; ?></td>
										<td><?php echo $entrada_camion_line['num_clase_adr']; ?></td>
										<td><?php echo $entrada_camion_line['cod_grupo_embalaje_adr']; ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
					<div class="col-sm-2"></div>
				</div>
			<?php } ?>


			<div class="row">
				<div class="col-sm-12">
					<center>
						<h4>Origen / Destino</h4>
					</center>
				</div>
				<div class="col-sm-3"></div>
				<div class="col-sm-6">
					<table id="table_entrada_camion_destinatario_resumen" class="table table-striped table-bordered" style="font-size: 12px;">
						<thead>
							<tr>
								<th>Origen / Destino</th>
								<th>Nº Tarjeta TECO</th>
								<th>Estación Destino</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($entrada_camion_list as $entrada_camion_line) { ?>
								<tr>
									<td><?php echo $entrada_camion_line['nombre_destinatario']; ?></td>
									<td><?php echo $entrada_camion_line['num_tarjeta_teco']; ?></td>
									<td><?php echo $entrada_camion_line['codigo_estacion_ferrocarril']; ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="col-sm-3"></div>
			</div>


			<div class="row">
				<div class="col-sm-12">
					<center>
						<h4>Observaciones</h4>
					</center>
				</div>
				<div class="col-sm-3"></div>
				<div class="col-sm-6">
					<table id="table_entrada_camion_observaciones" class="table table-striped table-bordered" style="font-size: 12px;">
						<thead>
							<tr>
								<th class="warning">Observaciones</th>
								<th class="warning">Acciones</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($entrada_camion_list as $entrada_camion_line) { ?>
								<tr data-id="<?php echo $entrada_camion_line['id_entrada']; ?>" data-type="entrada">
									<td contenteditable="false"><?php echo $entrada_camion_line['observaciones']; ?></td>
									<td>
										<center>
											<div class="btn-group">
												<a type="button" id="" class="btn-editar btn-sm btn-success" title=""><span class="glyphicon glyphicon-pencil"></span></a>
												<a type="button" id="" class="btn-guardar btn-sm btn-info" style="display:none;" title=""><span class="glyphicon glyphicon-floppy-disk"></span></a>
											</div>
										</center>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="col-sm-3"></div>
			</div>

			<script>
				$(document).ready(function() {
					$('#table_entrada_camion_observaciones').DataTable();
					$('#menu').metisMenu(); // Asegúrate de que el selector es correcto y el elemento existe

					$('.btn-editar').click(function() {
						let row = $(this).closest('tr');
						let cells = row.find('td[contenteditable]');
						cells.attr('contenteditable', true);
						row.find('.btn-guardar').show();
						$(this).hide();
					});

					$('.btn-guardar').click(function() {
						let row = $(this).closest('tr');
						let cells = row.find('td[contenteditable]');
						cells.attr('contenteditable', false);
						row.find('.btn-editar').show();
						$(this).hide();

						// Obtener los datos de la fila
						let id = row.data('id');
						let type = row.data('type');
						let observaciones = cells[0].innerText;

						// Crear el payload para enviar
						let payload = {
							id: id,
							type: type,
							observaciones: observaciones
						};

						// Enviar los datos al servidor usando $.ajax
						$.ajax({
							url: '../ajax/cambiar_observaciones.php',
							type: 'POST',
							contentType: 'application/json',
							data: JSON.stringify(payload),
							success: function(data) {
								if (data.success) {
									alert('Datos guardados exitosamente');
								}
								/*else {
									alert('Hubo un error al guardar los datos: ' + data.message);
								}*/
							},
							error: function(xhr, status, error) {
								console.error('Error:', error);
								alert('Hubo un error al guardar los datos');
							}
						});
					});
				});
			</script>


			<div class="row">
				<div class="col-sm-12">
					<center>
						<h4>Ficheros</h4>
					</center>
				</div>
				<div class="col-sm-4"></div>
				<div class="col-sm-4">
					<table id="table_ficheros" class="table table-striped table-bordered" style="font-size: 12px;">
						<thead>
							<tr>
								<th>Documento</th>
								<th>Extensión</th>
								<th>Operaciones</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($ficheros_list as $ficheros_line) { ?>
								<tr>
									<td><?php echo $ficheros_line['tipo_fichero']; ?></td>
									<td><?php echo $ficheros_line['extension']; ?></td>
									<td>
										<div class="btn-group">
											<a href="<?php echo $ficheros_line['ruta_fichero']; ?>" target="_blank" type="button" class="btn btn-sm btn-default ver_fichero" title="Ver"><span class="fa fa-eye" aria-hidden="true"></span></a>
											<a href="<?php echo $ficheros_line['ruta_fichero']; ?>" download type="button" class="btn btn-sm btn-primary descargar_fichero" title="Descargar"><span class="fa fa-arrow-down" aria-hidden="true"></span></a>
											<?php if ($_SESSION['roles_array'][0]['nombre_rol'] == "admin") : ?><a href="#" type="button" id="<?php echo $ficheros_line['id_fichero']; ?>" class="btn btn-sm btn-danger delete_record" title="Borrar"><span class="glyphicon glyphicon-trash"></span></a><?php endif; ?>
										</div>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="col-sm-4"></div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<center>
						<h4>Incidencia</h4>
					</center>
				</div>
				<div class="col-sm-3"></div>
				<div class="col-sm-6">
					<table id="table_entrada_camion_incidencia" class="table table-striped table-bordered" style="font-size: 12px;">
						<thead>
							<tr>
								<th>Num Incidencia</th>
								<th>Tipo Incidencia</th>
								<th>Estado Incidencia</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($entrada_camion_incidencia_list as $entrada_camion_incidencia_line) { ?>
								<tr>
									<td><center><a target="_blank" href="../controllers/incidencia_controller.php?id_incidencia=<?php echo $entrada_camion_incidencia_line['id_incidencia']; ?>" type="button" id="<?php echo $entrada_camion_incidencia_line['id_incidencia']; ?>" class="btn btn-sm btn-default view_record" title="Ver"><?php echo $entrada_camion_incidencia_line['num_incidencia']; ?></a></center></td>
									<td><?php echo $entrada_camion_incidencia_line['tipo_incidencia']; ?></td>
									<td><?php echo $entrada_camion_incidencia_line['estado_incidencia']; ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="col-sm-3"></div>
			</div>


			<div class="row">
				<div class="col-sm-12">
					<center>
						<h4>CODECO</h4>
					</center>
				</div>
				<div class="col-sm-3"></div>
				<div class="col-sm-6">

					<table id="table_envio_codeco" class="table table-striped table-bordered" style="font-size: 12px;">
						<thead>
							<tr>
								<th>ID Codeco</th>
								<th>Nº Contenedor</th>
								<th>Estado envío</th>
								<th>Error</th>
								<th>Correo</th>
							</tr>

							<?php foreach ($codeco_info_list as $codeco_info_line) { ?>
								<tr>
									<td><?php echo $codeco_info_line['id_codeco']; ?></td>
									<td>
										<?php
										echo $codeco_info_line['num_contenedor'];
										if ($codeco_info_line['id_parte_trabajo'] != '') { //Codeco con daño o averia de contenedor
											echo '&nbsp;<a target="_blank" href="../controllers/parte_trabajo_controller.php?id_parte=' . $codeco_info_line['id_parte_trabajo'] . '" type="button" class="btn btn-sm btn-danger" title="Ver"><i class="fas fa-wrench" aria-hidden="true"></i></a>';
										}
										?>
									</td>
									<td>
										<?php
										//echo $codeco_info_line['check_envio'];
										if ($codeco_info_line['check_envio'] == 1) {
											echo "<i class='fa fa-check-circle fa-lg text-success' aria-hidden='true'></i>";
										} else {
											echo "<i class='fa fa-times-circle fa-lg text-danger' aria-hidden='true'></i>";
										}
										?>
									</td>
									<td><?php echo $codeco_info_line['error_envio']; ?></td>
									<td><!-- Correo -->
										<?php
										if ($codeco_info_line['check_envio'] == 0) { ?>
											<a href="#" type="button" id="<?php echo $codeco_info_line['id_codeco']; ?>" class="btn btn-warning resend_codeco" title="Reenviar Codeco">
												<span class="fa fa-send-o" aria-hidden="false"></span> Reenviar Correo </a>
										<?php } ?>
									</td>
								</tr>
							<?php } ?>
						</thead>

						<tbody>
						</tbody>
					</table>


				</div>
				<div class="col-sm-3"></div>
			</div>

		</div>
	</div>
	<!-- /#wrapper -->

</body>

</html>