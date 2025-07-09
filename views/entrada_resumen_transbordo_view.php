<!DOCTYPE html>

<html lang="es">

<head>
	<title>Resumen Entrada Transbordo <?php echo $num_transbordo ?></title>

	<?php
	//Plantilla con los inludes de las librerias y CSS usados por todas las paginas de la APP
	require_once('../tpl/header_includes.php');
	?>

	<!-- Custom Functions JavaScript -->
	<script src="../functions/documentacion_functions.js"></script>

	<script>
		$(document).ready(function() {

			var num_expedicion_salida = '<?php echo $num_transbordo ?>';

			table_transbordo_resumen = $('#table_transbordo_resumen').DataTable({
				columns: [{
						data: 'id_transbordo'
					},
					{
						data: 'fecha_transbordo'
					},
					{
						data: 'num_contenedor_origen'
					},
					{
						data: 'num_contenedor_destino'
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

			table_lineas_entrada = $('#table_lineas_entrada').DataTable({
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

			<div class="row">
				<div class="col-md-12" style="padding-top:10px;">
					<div class="well well-sm">
						<a class="btn btn-default" onclick="window.location.reload()"><i class="glyphicon glyphicon-refresh"></i> Recargar</a>
					</div>
				</div>

				<center>
					<h3>Entrada Transbordo</h3>
				</center>
				<center>
					<h4>Nº Transbordo: <?php echo $num_transbordo ?></h4>
				</center>

				<div class="col-md-12" style="padding-top:10px;">
					<div class="col-sm-3"></div>
					<div class="col-sm-6">
						<table id="table_transbordo_resumen" class="table table-striped table-bordered" style="font-size: 12px;">
							<thead>
								<tr>
									<th>Nº Transbordo</th>
									<th>Fecha</th>
									<th>Nº Contenedor Origen</th>
									<th>Nº Contenedor Destino</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($entrada_transbordo_list as $entrada_transbordo_line) { ?>
									<tr>
										<td><?php echo $entrada_transbordo_line['id_transbordo']; ?></td>
										<td><?php echo $entrada_transbordo_line['fecha_transbordo']; ?></td>
										<td><?php echo $entrada_transbordo_line['num_contenedor_origen']; ?></td>
										<td><?php echo $entrada_transbordo_line['num_contenedor_destino']; ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
					<div class="col-sm-3"></div>
				</div>
			</div>
			<!-- /#wrapper -->
		</div>


</body>

</html>