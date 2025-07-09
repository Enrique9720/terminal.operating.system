
<?php
class conexion_db
{
	public static function conectar()
	{

		$database = $_SESSION['db_name'];
		$host = $_SESSION['db_url'];
		$user = $_SESSION['db_user'];
		$pass = $_SESSION['db_pass'];

		try {

			$conexion = new PDO("mysql:dbname=" . $database . ";host=" . $host . "", $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
			$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$conexion->exec("SET CHARACTER SET UTF8");
		} catch (Exception $e) {
			die("Error" . $e->getMessage());
			echo "Linea del error " . $e->getLine();
		}

		return $conexion;
	}
}
?>