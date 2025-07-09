<div class="navbar-default sidebar" role="navigation">
  <div class="sidebar-nav navbar-collapse collapse">
    <!-- <h1 style="font-size: 2em; color: #00497b; text-align: center; text-shadow: 1px 1px #000000; font-family: 'Harabara';">MSTerminal</h1> -->
    <a href="../controllers/plan_semanal_controller.php" style="padding:15px">
      <img src="../images/logo_ms_terminal_2.png" style="height:100px;" />
    </a>

    <ul class="nav" id="side-menu">
      <li>
        <a href="../controllers/plan_semanal_controller.php">
          <i class="fa fa-calendar"></i> Plan semanal trenes</a>
      </li>

      <li>
        <a href="#"><i class="fa fa-arrow-circle-o-down"></i> Entradas<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
          <?php if ($_SESSION['roles_array'][0]['nombre_rol'] == "admin") : ?>
            <li>
              <a href="../controllers/entrada_tren_controller.php">
                <i class="fas fa-subway"></i> Entrada Tren</a>
            </li>
          <?php endif; ?>
          <?php if ($_SESSION['roles_array'][0]['nombre_rol'] == "admin") : ?>
            <li>
              <a href="../controllers/entrada_camion_controller.php">
                <i class="fas fa-truck"></i> Entrada Camion</a>
            </li>
          <?php endif; ?>
          <li>
            <a href="#"><i class="fa fa-table"></i> Listado Entradas<span class="fa arrow"></span></a>
            <ul class="nav nav-third-level">
              <!--<li>
                <a href="../controllers/entradas_list_controller.php?year=2024"> Año 2024</a>
              </li> -->
              <li>
                <a href="../controllers/entradas_list_controller.php?year=2025"> Año 2025</a>
              </li>
            </ul>
          </li>
        </ul>
        <!-- /.nav-second-level -->
      </li>

      <li>
        <a href="#"><i class="fa fa-arrow-circle-o-up"></i> Salidas<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
          <?php if ($_SESSION['roles_array'][0]['nombre_rol'] == "admin") : ?>
            <li>
              <a href="../controllers/salida_tren_controller.php">
                <i class="fas fa-subway"></i> Salida Tren</a>
            </li>
          <?php endif; ?>
          <?php if ($_SESSION['roles_array'][0]['nombre_rol'] == "admin") : ?>
            <li>
              <a href="../controllers/salida_camion_controller.php">
                <i class="fas fa-truck"></i> Salida Camion</a>
            </li>
          <?php endif; ?>
          <li>
            <a href="#"><i class="fa fa-table"></i> Listado Salidas<span class="fa arrow"></span></a>
            <ul class="nav nav-third-level">
              <!-- <li>
                <a href="../controllers/salidas_list_controller.php?year=2024"> Año 2024</a>
              </li> -->
              <li>
                <a href="../controllers/salidas_list_controller.php?year=2025"> Año 2025</a>
              </li>
            </ul>
          </li>
        </ul>
        <!-- /.nav-second-level -->
      </li>

      <li>
        <a href="#"><i class="fas fa-arrows-alt-h"></i> Trapaso<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
          <?php if ($_SESSION['roles_array'][0]['nombre_rol'] == "admin") : ?>
            <li>
              <a href="../controllers/traspaso_nuevo_controller.php">
                <i class="fas fa-plus"></i> Traspaso</a>
            </li>
          <?php endif; ?>
          <li>
            <a href="#"><i class="fa fa-table"></i> Listado Traspasos<span class="fa arrow"></span></a>
            <ul class="nav nav-third-level">
              <!-- <li>
                <a href="../controllers/traspaso_list_controller.php?year=2024"> Año 2024</a>
              </li> -->
              <li>
                <a href="../controllers/traspaso_list_controller.php?year=2025"> Año 2025</a>
              </li>
            </ul>
          </li>

        </ul>
        <!-- /.nav-second-level -->
      </li>

      <li>
        <a href="#"><i class="fas fa-exchange-alt"></i> Historico movimientos<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">

          <li>
            <a href="../controllers/historico_movimientos_controller.php">
              <i class="fas fa-exchange-alt"></i> TODOS</a>
          </li>
          <li>
            <a href="../controllers/historico_movimientos_propietario_controller.php?propietario=CCIS-BILBAO">
              <i class="fas fa-exchange-alt"></i> CCIS-BILBAO</a>
          </li>

          <li>
            <a href="../controllers/historico_movimientos_propietario_controller.php?propietario=SICSA-VALENCIA">
              <i class="fas fa-exchange-alt"></i> SICSA-VALENCIA</a>
          </li>

          <li>
            <a href="../controllers/historico_movimientos_propietario_controller.php?propietario=RENFE">
              <i class="fas fa-exchange-alt"></i> RENFE</a>
          </li>

        </ul>
        <!-- /.nav-second-level -->
      </li>

      <li>
        <a href="#"><i class="fas fa-cubes"></i></i> Stock contenedores<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">

          <li>
            <a href="../controllers/stock_contenedores_controller.php">
              <i class="fas fa-cubes"></i> Stock General</a>
          </li>
          <li>
            <a href="../controllers/stock_contenedores_propietario_controller.php?propietario=CCIS-BILBAO">
              <i class="fas fa-cubes"></i> CCIS-BILBAO</a>
          </li>

          <li>
            <a href="../controllers/stock_contenedores_propietario_controller.php?propietario=SICSA-VALENCIA">
              <i class="fas fa-cubes"></i> SICSA-VALENCIA</a>
          </li>

          <li>
            <a href="../controllers/stock_contenedores_propietario_controller.php?propietario=RENFE">
              <i class="fas fa-cubes"></i> RENFE</a>
          </li>

        </ul>
        <!-- /.nav-second-level -->
      </li>

      <li>
        <a href="../controllers/historico_contenedores_controller.php">
          <i class="fas fa-history"></i> Hist&oacute;rico contenedores </a>
      </li>

      <li>
        <a href="#"><i class="fas fa-wrench"></i> Partes de Trabajo<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
          <?php //if ($_SESSION['roles_array'][0]['nombre_rol'] == "admin") : 
          ?>
          <li>
            <a href="../controllers/parte_trabajo_nuevo_controller.php">
              <i class="fas fa-plus"></i> Parte de Trabajo</a>
          </li>
          <?php //endif; 
          ?>
          <li>
            <a href="#"><i class="fa fa-table"></i> Listado Partes de Trabajos<span class="fa arrow"></span></a>
            <ul class="nav nav-third-level">
              <!--<li>
                <a href="../controllers/partes_trabajo_list_controller.php?year=2024"> Año 2024</a>
              </li> -->
              <li>
                <a href="../controllers/partes_trabajo_list_controller.php?year=2025"> Año 2025</a>
              </li>
            </ul>
          </li>

        </ul>
        <!-- /.nav-second-level -->
        <!--</li> -->

      <li>
        <a href="#"><i class="fas fa-arrows-alt-h"></i> Transbordo<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
          <?php if ($_SESSION['roles_array'][0]['nombre_rol'] == "admin") :
          ?>
            <li>
              <a href="../controllers/transbordo_nuevo_controller.php">
                <i class="fas fa-plus"></i> Transbordo</a>
            </li>
          <?php endif;
          ?>
          <li>
            <a href="#"><i class="fa fa-table"></i> Listado Transbordos<span class="fa arrow"></span></a>
            <ul class="nav nav-third-level">
              <!--<li>
                <a href="../controllers/transbordo_list_controller.php?year=2024"> Año 2024</a>
              </li> -->
              <li>
                <a href="../controllers/transbordo_list_controller.php?year=2025"> Año 2025</a>
              </li>
            </ul>
          </li>

        </ul>
        <!-- /.nav-second-level -->
      </li>

      <li>
        <a href="#"><i class="fas fa-exclamation-triangle"></i> Incidencias<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
          <?php if ($_SESSION['roles_array'][0]['nombre_rol'] == "admin") :
          ?>
            <li>
              <a href="../controllers/incidencia_nuevo_controller.php">
                <i class="fas fa-exclamation-triangle"></i> Incidencia</a>
            </li>
          <?php endif;
          ?>
          <li>
            <a href="#"><i class="fa fa-table"></i> Listado de Incidencias<span class="fa arrow"></span></a>
            <ul class="nav nav-third-level">
              <!--<li>
                <a href="../controllers/incidencia_list_controller.php?year=2024"> Año 2024</a>
              </li> -->
              <li>
                <a href="../controllers/incidencia_list_controller.php?year=2025"> Año 2025</a>
              </li>
            </ul>
          </li>

        </ul>
        <!-- /.nav-second-level -->
      </li>

      <li>
        <a href="#"><i class="fas fa-euro-sign"></i> Facturaci&oacute;n<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">

          <li>
            <a href="#"><i class="fa fa-table"></i> CCIS-BILBAO<span class="fa arrow"></span></a>
            <ul class="nav nav-third-level">
              <!--<li>
                <a href="../controllers/facturacion_controller.php?cliente=CCIS-BILBAO&year=2024"> Año 2024</a>
              </li> -->
              <li>
                <a href="../controllers/facturacion_controller.php?cliente=CCIS-BILBAO&year=2025"> Año 2025</a>
              </li>
            </ul>
          </li>

          <li>
            <a href="#"><i class="fa fa-table"></i> RENFE<span class="fa arrow"></span></a>
            <ul class="nav nav-third-level">
              <!--<li>
                <a href="../controllers/facturacion_controller.php?cliente=RENFE&year=2024"> Año 2024</a>
              </li> -->
              <li>
                <a href="../controllers/facturacion_controller.php?cliente=RENFE&year=2025"> Año 2025</a>
              </li>
            </ul>
          </li>

          <li>
            <a href="#"><i class="fa fa-table"></i> SICSA-VALENCIA<span class="fa arrow"></span></a>
            <ul class="nav nav-third-level">
              <!--<li>
                <a href="../controllers/facturacion_controller.php?cliente=SICSA-VALENCIA&year=2024"> Año 2024</a>
              </li> -->
              <li>
                <a href="../controllers/facturacion_controller.php?cliente=SICSA-VALENCIA&year=2025"> Año 2025</a>
              </li>
            </ul>
          </li>

          <li>
            <a href="#"><i class="fa fa-table"></i> CONTINENTAL-RAIL<span class="fa arrow"></span></a>
            <ul class="nav nav-third-level">
              <!--<li>
                <a href="../controllers/facturacion_controller.php?cliente=CONTINENTAL-RAIL&year=2024"> Año 2024</a>
              </li> -->
              <li>
                <a href="../controllers/facturacion_controller.php?cliente=CONTINENTAL-RAIL&year=2025"> Año 2025</a>
              </li>
            </ul>
          </li>

          <li>
            <a href="#"><i class="fa fa-table"></i> GMF-RAILWAY<span class="fa arrow"></span></a>
            <ul class="nav nav-third-level">
              <!--<li>
                <a href="../controllers/facturacion_controller.php?cliente=GMF-RAILWAY&year=2024"> Año 2024</a>
              </li> -->
              <li>
                <a href="../controllers/facturacion_controller.php?cliente=GMF-RAILWAY&year=2025"> Año 2025</a>
              </li>
            </ul>
          </li>

        </ul>
        <!-- /.nav-second-level -->
      </li>


      <li>
        <a href="#"><i class="fa fa-fw fa-bar-chart-o"></i> Estadisiticas<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">

          <li>
            <a href="../controllers/general_stats_controller.php"><i class="fa fa-fw fa-area-chart"></i> General</a>
          </li>
          <li>
            <a href="../controllers/traspasos_stats_controller.php"><i class="fa fa-fw fa-line-chart"></i> Traspasos</a>
          </li>
          <li>
            <a href="../controllers/parte_trabajo_stats_controller.php"><i class="fa fa-fw fa-bar-chart"></i> Partes de Trabajo</a>
          </li>
          <li>
            <a href="../controllers/transbordos_stats_controller.php"><i class="fa fa-fw fa-pie-chart"></i> Transbordos</a>
          </li>
          <li>
            <a href="../controllers/incidencias_stats_controller.php"><i class="fa fa-fw fa-pie-chart"></i> Incidencias</a>
          </li>
          <li>
            <a href="../controllers/facturacion_stats_controller.php"><i class="fa fa-fw fa-area-chart"></i> Facturacion</a>
          </li>
          <li>
            <a href="../controllers/time_stats_controller.php"><i class="fa fa-fw fa-hourglass-half"></i> Tiempo de espera</a>
          </li>

        </ul>
        <!-- /.nav-second-level -->
      </li>

    </ul>
  </div>
  <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->