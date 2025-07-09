<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Estadísticas Facturación</title>
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
</head>

<body>
	<div id="wrapper">
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
			<?php
			require_once('../tpl/aside.php');
			require_once('../tpl/header_includes.php');
			require_once('../tpl/header_menu.php');
			?>
		</nav>
	</div>
	<div id="page-wrapper">
		<form class="form-inline" role="form" action="../controllers/facturacion_stats_controller.php" method="post">
			<br>
			<div class="form-group">
				<label for="nombre_comercial_cliente">Cliente:</label>
				<select class="form-control" id="nombre_comercial_cliente" name="nombre_comercial_cliente" required>
					<option value="">Seleccione un cliente</option>
					<?php foreach ($cliente_datos as $cliente): ?>
						<option value="<?= htmlspecialchars($cliente['nombre_comercial_cliente'], ENT_QUOTES, 'UTF-8'); ?>"
							<?= ($cliente_seleccionado === $cliente['nombre_comercial_cliente']) ? 'selected' : ''; ?>>
							<?= htmlspecialchars($cliente['nombre_comercial_cliente'], ENT_QUOTES, 'UTF-8'); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="form-group">
				<label for="year">Año:</label>
				<select class="form-control" id="year" name="year" required>
					<option value="">Seleccione un año</option>
					<?php foreach ($years_disponibles as $year): ?>
						<option value="<?= htmlspecialchars($year['year'], ENT_QUOTES, 'UTF-8'); ?>"
							<?= ($year_seleccionado === $year['year']) ? 'selected' : ''; ?>>
							<?= htmlspecialchars($year['year'], ENT_QUOTES, 'UTF-8'); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>
			<!-- Se agregó el atributo name="submit" para detectar el envío del formulario -->
			<button type="submit" name="submit" class="btn btn-primary">Ver Estadísticas</button>
		</form>

		<h3><center>ESTADÍSITICAS FACTURACIÓN</center></h3>

		<div class="row">
			<br>
			<?php foreach ($datos_area_chart as $key => $chart_data): ?>
				<div class="col-sm-6 text-center">
					<h4><b><?= strtoupper(str_replace('_', ' ', $key)); ?></b></h4>
					<label class="label label-default">Importe mensual del año seleccionado</label>
					<?php if (!empty($chart_data)): ?>
						<div id="area-chart-<?= $key; ?>" style="height: 300px;"></div>
					<?php else: ?>
						<p>No hay datos disponibles para este gráfico.</p>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			<?php foreach ($datos_area_chart as $key => $chart_data): ?>
				<?php if (!empty($chart_data)): ?>
					// Convertimos el array PHP a variable JavaScript
					var data_<?= $key; ?> = <?= json_encode($chart_data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;

					// Ordenamos el array por 'año_mes' parseando año y mes
					data_<?= $key; ?>.sort(function(a, b) {
						// Separamos en año y mes usando el guión como separador
						var partsA = a.año_mes.split('-'),
							partsB = b.año_mes.split('-');

						// Convertimos a números (esto se asegura que '1' se compare correctamente contra '10')
						var yearA = parseInt(partsA[0], 10),
							monthA = parseInt(partsA[1], 10),
							yearB = parseInt(partsB[0], 10),
							monthB = parseInt(partsB[1], 10);

						// Primero comparamos los años
						if (yearA !== yearB) {
							return yearA - yearB;
						}
						// Si el año es igual, comparamos el mes
						return monthA - monthB;
					});

					console.log("Datos ordenados para <?= $key; ?>:", data_<?= $key; ?>);

					// Creamos el gráfico con los datos ordenados
					Morris.Area({
						element: 'area-chart-<?= $key; ?>',
						parseTime: false,
						data: data_<?= $key; ?>,
						xkey: 'año_mes',
						ykeys: ['importe'],
						labels: ['Importe'],
						postUnits: ' €',
						behaveLikeLine: true,
						hideHover: 'auto',
						resize: true,
						redraw: true
					});
				<?php endif; ?>
			<?php endforeach; ?>
		});
	</script>


</body>

</html>