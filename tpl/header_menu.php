<!-- jQuery Modal -->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>-->
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />-->

<script>
</script>

<style>
	.navbar-header .navbar-brand {
		padding: 10px 0px 0px 55px;
	}

	@media (max-width: 991px) {
		.navbar-header {
			width: 60%;
			display: inline-block;
			vertical-align: middle;
		}

		.navbar-header .navbar-brand {
			padding-left: 10px;
		}

		.nav.navbar-top-links.navbar-right {
			display: inline-block;
			float: right;
		}

		.nav.navbar-top-links li:last-child {
			margin-right: 0;
		}
	}
</style>


<div class="navbar-header">
	<button type="button" class="collapsed navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	</button>
	<center><a class="navbar-brand" href="../controllers/plan_semanal_controller.php" style="height:60px;"><img src="../images/logogms_2.png" style="height:40px;" /></a></center>
</div><!-- /.navbar-header -->

<ul class="nav navbar-top-links navbar-right">

	<li class="dropdown">
		<a class="dropdown-toggle  header_menu_item" data-toggle="dropdown" href="#">
			<i class="fa fa-user fa-fw"></i> <?php echo $_SESSION['username']; ?> <i class="fa fa-caret-down"></i>
		</a>
		<ul class="dropdown-menu dropdown-user">
			<li><a href="#"><i class="fa fa-user fa-fw"></i> Mi Perfil</a>
			</li>

			<li><a href="#"><i class="fa fa-gear fa-fw"></i> Ajustes</a>
			</li>

			<!-- <li class="divider"></li> -->
			<li><a href="../controllers/logout_controller.php"><i class="fa fa-sign-out fa-fw"></i> Salir</a>
			</li>
		</ul>
		<!-- /.dropdown-user -->
	</li>
	<!-- /.dropdown -->
</ul>
<!-- /.navbar-top-links -->