<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Se incluyen las librerías necesarias para Morris.js -->
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
  <title>Estadísticas Traspasos <?php echo htmlspecialchars($year_seleccionado); ?></title>
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

    <div id="page-wrapper">
      <!-- Formulario para seleccionar el año -->
      <form class="form-inline" role="form" action="../controllers/transbordos_stats_controller.php" method="post">
        <br>
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
        <!-- Se usa el name "submit" para detectar el envío -->
        <button type="submit" name="submit" class="btn btn-primary">Ver Estadísticas</button>
      </form>

      <h3><center>ESTADÍSTICAS TRANSBORDOS</center></h3>

      <div class="row">
        <div class="col-sm-12 text-center">
          <h4><b>Cantidad de transbordos realizados en <?php echo $year_seleccionado?></b></h4>
          <!-- Este div contendrá el gráfico Donut -->
          <div id="pie-chart-transbordos" style="height: 300px;"></div>
        </div>
      </div>
    </div> <!-- page-wrapper -->
  </div> <!-- wrapper -->
</body>
</html>

<!-- Script para inicializar el gráfico Donut -->
<script>
  $(document).ready(function() {
    Morris.Donut({
      element: 'pie-chart-transbordos',
      data: <?php echo json_encode($datos_donut_chart); ?>,
      // Puedes definir tantos colores como incidencias tengas
      colors: ['#003A5D'],
      hideHover: 'auto',
      resize: true
    });
  });
</script>
