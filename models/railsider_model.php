<?php
if (!defined('ROOTPATH')) {
	define('ROOTPATH', __DIR__);
}

class railsider_model
{

	//Variable para recoger la conexion a la BD
	private $conexion;
	//Variable para recoger el resultado de la consulta
	private $result;

	//Funcion constructora de la clase
	public function __construct()
	{

		//Importamos el fichero con la clase conectar para poder establecer la conexion a la BD
		require_once(ROOTPATH . "/conexion_db.php");

		//Realizamos la conexion a la BD a traves del metodo estatico "conexion()" de la clase "conectar",
		//esta conexion la guardamos en la variable conexion de la clase en la que estamos.
		$this->conexion = conexion_db::conectar();

		//Establecemos que la variable productos de la clase en la que estamos es un array
		$this->result = array();
	}

	public function get_ultima_entrada($num_contenedor)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				cs.num_contenedor,
				cs.id_entrada,
			  e.fecha_entrada,
			  te.id_tipo_entrada,
			  te.tipo_entrada,
			  (CASE
			  	WHEN (te.tipo_entrada) = 'TREN'
			    	THEN (SELECT estado_carga_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
			    WHEN (te.tipo_entrada) = 'CAMIÓN'
			    	THEN (SELECT estado_carga_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
			    WHEN (te.tipo_entrada) = 'TRASPASO'
			    	THEN (SELECT estado_carga_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
			   END) AS estado_carga_contenedor,
		    (CASE
		        WHEN (te.tipo_entrada) = 'TREN'
		        	THEN (SELECT id_tipo_mercancia  FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
		        WHEN (te.tipo_entrada) = 'CAMIÓN'
		        	THEN (SELECT id_tipo_mercancia  FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
		        WHEN (te.tipo_entrada) = 'TRASPASO'
		        	THEN (SELECT id_tipo_mercancia  FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
		    END) AS id_tipo_mercancia
			FROM control_stock cs INNER JOIN entrada e ON e.id_entrada = cs.id_entrada
			INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada
			WHERE cs.num_contenedor = :num_contenedor AND cs.id_salida IS NULL;
		");

		$query->execute(array(
			':num_contenedor' => $num_contenedor
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_citas_carga($fecha_min, $fecha_max)
	{

		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
				SELECT
					cc.id_cita_carga,
					cc.num_expedicion,
					cc.fecha,
					cc.hora,
					cc.observaciones,
					cc.cif_propietario,
					c.nombre_propietario,
					c.nombre_comercial_propietario,
					dt.nombre_destino
				FROM (cita_carga cc INNER JOIN propietario c ON c.cif_propietario = cc.cif_propietario) INNER JOIN destino_tren dt ON cc.id_destino = dt.id_destino
				WHERE cc.fecha BETWEEN :fecha_min AND :fecha_max
			");

		$query->execute(array(':fecha_min' => $fecha_min, ':fecha_max' => $fecha_max));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_cita_carga($num_expedicion)
	{

		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				cc.id_cita_carga,
				cc.num_expedicion,
				cc.fecha,
				cc.hora,
				cc.observaciones,
				cc.cif_propietario,
				cc.id_origen,
				ot.nombre_origen,
				cc.id_destino,
				dt.nombre_destino
			FROM (cita_carga cc INNER JOIN origen_tren ot ON ot.id_origen = cc.id_origen)
				INNER JOIN destino_tren dt ON dt.id_destino = cc.id_destino
			WHERE cc.num_expedicion = :num_expedicion;
		");

		$query->execute(array(
			':num_expedicion' => $num_expedicion
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_cita_descarga($num_expedicion)
	{

		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
				SELECT
					cd.id_cita_descarga,
					cd.num_expedicion,
					cd.fecha,
					cd.hora,
					cd.observaciones,
					cd.cif_propietario,
					cd.id_origen,
					ot.nombre_origen,
					cd.id_destino,
					dt.nombre_destino
				FROM (cita_descarga cd INNER JOIN origen_tren ot ON ot.id_origen = cd.id_origen)
					INNER JOIN destino_tren dt ON dt.id_destino = cd.id_destino
				WHERE cd.num_expedicion = :num_expedicion;
			");

		$query->execute(array(
			':num_expedicion' => $num_expedicion
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_citas_carga_pendientes()
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
				SELECT *
				FROM cita_carga cc INNER JOIN propietario p ON cc.cif_propietario = p.cif_propietario
				WHERE NOT EXISTS (SELECT id_salida FROM salida s WHERE s.id_cita_carga = cc.id_cita_carga);
			");

		$query->execute();

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_citas_descarga($fecha_min, $fecha_max)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
				SELECT cd.id_cita_descarga, cd.num_expedicion, cd.fecha, cd.hora, cd.observaciones, cd.cif_propietario, c.nombre_propietario, c.nombre_comercial_propietario, ot.nombre_origen
				FROM (cita_descarga cd INNER JOIN propietario c ON c.cif_propietario = cd.cif_propietario) INNER JOIN origen_tren ot ON cd.id_origen = ot.id_origen
				WHERE cd.fecha BETWEEN :fecha_min AND :fecha_max
			");

		$query->execute(array(':fecha_min' => $fecha_min, ':fecha_max' => $fecha_max));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_citas_descarga_por_num_expedicion($num_expedicion)
	{

		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT cd.id_cita_descarga, cd.num_expedicion, cd.fecha, cd.hora, cd.observaciones, cd.cif_propietario, c.nombre_propietario, c.nombre_comercial_propietario, ot.nombre_origen
			FROM (cita_descarga cd INNER JOIN propietario c ON c.cif_propietario = cd.cif_propietario) INNER JOIN origen_tren ot ON cd.id_origen = ot.id_origen
			WHERE cd.num_expedicion = :num_expedicion;
		");

		$query->execute(array(
			':num_expedicion' => $num_expedicion
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_propietarios()
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
				SELECT cif_propietario, nombre_propietario, nombre_comercial_propietario, direccion_propietario, persona_contacto, email_contacto
				FROM propietario
			");

		$query->execute();

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_propietario_por_nombre_comercial($nombre_comercial_propietario)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
				SELECT cif_propietario, nombre_propietario, nombre_comercial_propietario, direccion_propietario, persona_contacto, email_contacto
				FROM propietario
				WHERE nombre_comercial_propietario = :nombre_comercial_propietario;
			");

		$query->execute(array(
			':nombre_comercial_propietario' => $nombre_comercial_propietario
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_cliente_por_nombre_comercial($nombre_comercial_cliente)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
				SELECT 
					id_cliente,
					cif_cliente, 
					nombre_cliente, 
					nombre_comercial_cliente, 
					direccion_cliente, 
					persona_contacto, 
					email_contacto
				FROM cliente
				WHERE nombre_comercial_cliente = :nombre_comercial_cliente;
			");

		$query->execute(array(
			':nombre_comercial_cliente' => $nombre_comercial_cliente
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_cliente_por_id_cliente($id_cliente)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
				SELECT 
					cif_cliente, 
					nombre_cliente, 
					nombre_comercial_cliente, 
					direccion_cliente, 
					persona_contacto, 
					email_contacto
				FROM cliente
				WHERE id_cliente = :id_cliente;
			");

		$query->execute(array(
			':id_cliente' => $id_cliente
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_cliente()
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
				SELECT cif_cliente, nombre_cliente, nombre_comercial_cliente, direccion_cliente, persona_contacto, email_contacto
				FROM cliente
				#WHERE nombre_comercial_cliente = :nombre_comercial_cliente;
			");

		$query->execute(array(
			//':nombre_comercial_cliente' => $nombre_comercial_cliente
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function get_years_disponibles()
	{
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT DISTINCT year
			FROM facturacion
			ORDER BY year DESC
    	");

		$query->execute();

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		$query = null;
		return $this->result;
	}

	public function get_years_disponibles_incidencias()
	{
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT DISTINCT YEAR(fecha_incidencia) AS year
			FROM incidencia
			ORDER BY year DESC;
    	");

		$query->execute();

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		$query = null;
		return $this->result;
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////

	function crear_cita_descarga($fecha, $hora, $cif_propietario, $num_expedicion, $id_origen, $id_destino, $observaciones)
	{

		try {
			$query = $this->conexion->prepare("
				INSERT INTO cita_descarga (fecha, hora, cif_propietario, num_expedicion, id_origen, id_destino, observaciones)
				VALUES (:fecha, :hora, :cif_propietario, :num_expedicion, :id_origen, :id_destino, :observaciones)
			");

			$result = $query->execute(array(
				':fecha' => $fecha,
				':hora' => $hora,
				':cif_propietario' => $cif_propietario,
				':num_expedicion' => $num_expedicion,
				':id_origen' => $id_origen,
				':id_destino' => $id_destino,
				':observaciones' => $observaciones
			));

			//cerramos la consulta a la BD
			$query = null;

			return $result;
		} catch (PDOException $e) {
			return "error: " . $e;
		}
	}

	function crear_cita_carga($fecha, $hora, $cif_propietario, $num_expedicion, $id_origen, $id_destino, $observaciones)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			INSERT INTO cita_carga (fecha, hora, cif_propietario, num_expedicion, id_origen, id_destino, observaciones)
			VALUES (:fecha, :hora, :cif_propietario, :num_expedicion, :id_origen, :id_destino, :observaciones);
    ");

		$this->result[] = $query->execute(array(
			':fecha' => $fecha,
			':hora' => $hora,
			':cif_propietario' => $cif_propietario,
			':num_expedicion' => $num_expedicion,
			':id_origen' => $id_origen,
			':id_destino' => $id_destino,
			':observaciones' => $observaciones
		));

		//Cerramos la conexion a la BD
		$query = null;

		//Obtenemos el id del registro insertado
		$this->result = $this->conexion->lastInsertId();

		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_traspasos($id_traspaso)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				t.id_traspaso,
				t.fecha_traspaso,
				t.num_contenedor,
				t.cif_propietario_anterior,
				(SELECT nombre_comercial_propietario FROM propietario WHERE cif_propietario = t.cif_propietario_anterior) AS nombre_comercial_propietario_anterior,
				t.cif_propietario_actual,
				(SELECT nombre_comercial_propietario FROM propietario WHERE cif_propietario = t.cif_propietario_actual) AS nombre_comercial_propietario_actual,
				t.estado_carga_contenedor,
				t.id_tipo_mercancia,
				tm.descripcion_mercancia,
				t.num_peligro_adr,
				t.num_onu_adr,
				t.num_clase_adr,
				t.cod_grupo_embalaje_adr,
				t.peso_mercancia_contenedor,
				t.peso_bruto_contenedor,
				t.num_booking_contenedor,
				t.num_precinto_contenedor,
				t.temperatura_contenedor,
				t.codigo_estacion_ferrocarril,
				t.id_destinatario
			FROM (traspaso t INNER JOIN tipo_mercancia tm ON tm.id_tipo_mercancia = t.id_tipo_mercancia)
				INNER JOIN propietario p ON p.cif_propietario = t.cif_propietario_anterior
			WHERE t.id_traspaso = :id_traspaso
		");

		$query->execute(array(
			':id_traspaso' => $id_traspaso
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_traspasos_por_year($year)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				t.id_traspaso,
				count(t.id_traspaso) as total,
				t.fecha_traspaso,
				t.num_contenedor,
				t.cif_propietario_anterior,
				(SELECT nombre_comercial_propietario FROM propietario WHERE cif_propietario = t.cif_propietario_anterior) AS nombre_comercial_propietario_anterior,
				t.cif_propietario_actual,
				(SELECT nombre_comercial_propietario FROM propietario WHERE cif_propietario = t.cif_propietario_actual) AS nombre_comercial_propietario_actual,
				t.estado_carga_contenedor,
				t.id_tipo_mercancia,
				tm.descripcion_mercancia,
				t.num_peligro_adr,
				t.num_onu_adr,
				t.num_clase_adr,
				t.cod_grupo_embalaje_adr,
				t.peso_mercancia_contenedor,
				t.peso_bruto_contenedor,
				t.num_booking_contenedor,
				t.num_precinto_contenedor,
				t.temperatura_contenedor,
				t.codigo_estacion_ferrocarril,
				t.id_destinatario
			FROM (traspaso t INNER JOIN tipo_mercancia tm ON tm.id_tipo_mercancia = t.id_tipo_mercancia)
				INNER JOIN propietario p ON p.cif_propietario = t.cif_propietario_anterior
			WHERE YEAR(t.fecha_traspaso) = :year
		");

		$query->execute(array(
			':year' => $year
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function insert_traspaso(
		$fecha_traspaso,
		$num_contenedor,
		$cif_propietario_anterior,
		$cif_propietario_actual,
		$estado_carga_contenedor,
		$id_tipo_mercancia,
		$num_peligro_adr,
		$num_onu_adr,
		$num_clase_adr,
		$cod_grupo_embalaje_adr,
		$peso_mercancia_contenedor,
		$peso_bruto_contenedor,
		$num_booking_contenedor,
		$num_precinto_contenedor,
		$temperatura_contenedor,
		$codigo_estacion_ferrocarril,
		$id_destinatario
	) {
		//BORRAMOS RESULTADOS DE CONSULTA ANTERIOR
		$this->result = array();

		$query = $this->conexion->prepare("
			INSERT INTO traspaso(
				fecha_traspaso,
				num_contenedor,
				cif_propietario_anterior,
				cif_propietario_actual,
				estado_carga_contenedor,
				id_tipo_mercancia,
				num_peligro_adr,
				num_onu_adr,
				num_clase_adr,
				cod_grupo_embalaje_adr,
				peso_mercancia_contenedor,
				peso_bruto_contenedor,
				num_booking_contenedor,
				num_precinto_contenedor,
				temperatura_contenedor,
				codigo_estacion_ferrocarril,
				id_destinatario
			)
			VALUES (
				:fecha_traspaso,
				:num_contenedor,
				:cif_propietario_anterior,
				:cif_propietario_actual,
				:estado_carga_contenedor,
				:id_tipo_mercancia,
				:num_peligro_adr,
				:num_onu_adr,
				:num_clase_adr,
				:cod_grupo_embalaje_adr,
				:peso_mercancia_contenedor,
				:peso_bruto_contenedor,
				:num_booking_contenedor,
				:num_precinto_contenedor,
				:temperatura_contenedor,
				:codigo_estacion_ferrocarril,
				:id_destinatario
			)
		");

		$this->result[] = $query->execute(array(
			':fecha_traspaso' => $fecha_traspaso,
			':num_contenedor' => $num_contenedor,
			':cif_propietario_anterior' => $cif_propietario_anterior,
			':cif_propietario_actual' => $cif_propietario_actual,
			':estado_carga_contenedor' => $estado_carga_contenedor,
			':id_tipo_mercancia' => $id_tipo_mercancia,
			':num_peligro_adr' => $num_peligro_adr,
			':num_onu_adr' => $num_onu_adr,
			':num_clase_adr' => $num_clase_adr,
			':cod_grupo_embalaje_adr' => $cod_grupo_embalaje_adr,
			':peso_mercancia_contenedor' => $peso_mercancia_contenedor,
			':peso_bruto_contenedor' => $peso_bruto_contenedor,
			':num_booking_contenedor' => $num_booking_contenedor,
			':num_precinto_contenedor' => $num_precinto_contenedor,
			':temperatura_contenedor' => $temperatura_contenedor,
			':codigo_estacion_ferrocarril' => $codigo_estacion_ferrocarril,
			':id_destinatario' => $id_destinatario,
		));

		//Cerramos la conexion a la BD
		$query = null;

		//Obtenemos el id del registro insertado
		$this->result = $this->conexion->lastInsertId();

		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function insert_salida_tipo_traspaso($id_salida, $id_traspaso)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			INSERT INTO salida_tipo_traspaso (id_salida, id_traspaso)
			VALUES (:id_salida, :id_traspaso);
    	");

		$this->result[] = $query->execute(array(
			':id_salida' => $id_salida,
			':id_traspaso' => $id_traspaso
		));

		//Cerramos la conexion a la BD
		$query = null;

		//Obtenemos el id del registro insertado
		$this->result = $this->conexion->lastInsertId();

		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function insert_salida_tipo_transbordo($id_salida, $id_transbordo)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			INSERT INTO salida_tipo_transbordo (id_salida, id_transbordo)
			VALUES (:id_salida, :id_transbordo);
    	");

		$this->result[] = $query->execute(array(
			':id_salida' => $id_salida,
			':id_transbordo' => $id_transbordo
		));

		//Cerramos la conexion a la BD
		$query = null;

		//Obtenemos el id del registro insertado
		$this->result = $this->conexion->lastInsertId();

		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_salida_tipo_traspaso($id_salida, $id_traspaso)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				id_salida,
				id_traspaso
			FROM salida_tipo_traspaso
		");

		$query->execute(array(
			':id_salida' => $id_salida,
			':id_traspaso' => $id_traspaso
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function insert_entrada_tipo_traspaso($id_entrada, $id_traspaso)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			INSERT INTO entrada_tipo_traspaso (id_entrada, id_traspaso)
			VALUES (:id_entrada, :id_traspaso);
    	");

		$this->result[] = $query->execute(array(
			':id_entrada' => $id_entrada,
			':id_traspaso' => $id_traspaso
		));

		//Cerramos la conexion a la BD
		$query = null;

		//Obtenemos el id del registro insertado
		$this->result = $this->conexion->lastInsertId();

		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function insert_entrada_tipo_transbordo($id_entrada, $id_transbordo)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			INSERT INTO entrada_tipo_transbordo (id_entrada, id_transbordo)
			VALUES (:id_entrada, :id_transbordo);
    	");

		$this->result[] = $query->execute(array(
			':id_entrada' => $id_entrada,
			':id_transbordo' => $id_transbordo
		));

		//Cerramos la conexion a la BD
		$query = null;

		//Obtenemos el id del registro insertado
		$this->result = $this->conexion->lastInsertId();

		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function insert_linea_carga($id_cita_carga, $num_contenedor)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			INSERT INTO linea_carga(id_cita_carga, num_contenedor)
			VALUES (:id_cita_carga, :num_contenedor);
    	");

		$this->result[] = $query->execute(array(
			':id_cita_carga' => $id_cita_carga,
			':num_contenedor' => $num_contenedor
		));

		//Cerramos la conexion a la BD
		$query = null;

		//Obtenemos el id del registro insertado
		$this->result = $this->conexion->lastInsertId();

		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_origenes()
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
				SELECT * FROM origen_tren
			");

		$query->execute();

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_destinos()
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
				SELECT * FROM destino_tren
			");

		$query->execute();

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function num_expedicion_carga_check($num_expedicion)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				id_cita_carga,
				num_expedicion,
				fecha,
				hora,
				observaciones,
				cif_propietario,
				id_origen,
				id_destino
			FROM cita_carga
			WHERE num_expedicion = :num_expedicion;
		");

		$query->execute(array(
			':num_expedicion' => $num_expedicion
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_vagones_ajax($search)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT DISTINCT num_vagon
			FROM entrada_vagon_contenedor
			WHERE num_vagon LIKE :search
			UNION
			SELECT DISTINCT num_vagon
			FROM salida_vagon_contenedor
			WHERE num_vagon LIKE :search
			ORDER BY num_vagon
			LIMIT 10;
		");

		$query->execute(array(
			':search' => "%" . $search . "%"
		));


		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function update_contenedor_id_cita_carga_temp(
		$num_contenedor,
		$id_cita_carga
	) {
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		$query = $this->conexion->prepare("
			UPDATE contenedor
			SET id_cita_carga_temp = :id_cita_carga
			WHERE num_contenedor = :num_contenedor
		");

		$query->execute(array(
			':num_contenedor' => $num_contenedor,
			':id_cita_carga' => $id_cita_carga
		));

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function contenedor_incidencia(
		$num_contenedor,
		$id_parte_trabajo
	) {
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		$query = $this->conexion->prepare("
			UPDATE contenedor
			SET incidencia = :id_parte_trabajo
			WHERE num_contenedor = :num_contenedor
		");

		$query->execute(array(
			':num_contenedor' => $num_contenedor,
			':id_parte_trabajo' => $id_parte_trabajo
		));

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function update_contenedor_linea_carga_temp(
		$id_cita_carga,
		$num_vagon,
		$pos_vagon,
		$num_contenedor,
		$pos_contenedor
	) {
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		$query = $this->conexion->prepare("
			UPDATE linea_carga
			SET
			pos_contenedor_temp = :pos_contenedor,
			num_vagon_temp = :num_vagon,
			pos_vagon_temp = :pos_vagon
			WHERE id_cita_carga = :id_cita_carga AND num_contenedor = :num_contenedor;
		");

		$query->execute(array(
			':id_cita_carga' => $id_cita_carga,
			':num_vagon' => $num_vagon,
			':pos_vagon' => $pos_vagon,
			':num_contenedor' => $num_contenedor,
			':pos_contenedor' => $pos_contenedor
		));

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function insert_no_contenedor_linea_carga_temp(
		$id_cita_carga,
		$num_vagon,
		$pos_vagon,
		$pos_contenedor
	) {
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			INSERT INTO linea_carga(
					id_cita_carga,
					num_contenedor,
					pos_contenedor_temp,
					num_vagon_temp,
					pos_vagon_temp
			)
			VALUES(
					:id_cita_carga,
					NULL,
					:pos_contenedor,
					:num_vagon,
					:pos_vagon
			);
    	");

		$this->result[] = $query->execute(array(
			':id_cita_carga' => $id_cita_carga,
			':num_vagon' => $num_vagon,
			':pos_vagon' => $pos_vagon,
			':pos_contenedor' => $pos_contenedor
		));

		//Cerramos la conexion a la BD
		$query = null;

		//Obtenemos el id del registro insertado
		$this->result = $this->conexion->lastInsertId();

		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function delete_contenedor_id_cita_carga_temp($num_contenedor)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		$query = $this->conexion->prepare("
			UPDATE contenedor
			SET id_cita_carga_temp = NULL
			WHERE num_contenedor = :num_contenedor
		");

		$query->execute(array(
			':num_contenedor' => $num_contenedor
		));

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_linea_carga_por_id($id_linea_carga)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				id_linea_carga,
			  	id_cita_carga,
			  	num_contenedor,
			  	pos_contenedor_temp,
			  	num_vagon_temp,
			  	pos_vagon_temp
			FROM linea_carga
			WHERE id_linea_carga = :id_linea_carga
		");

		$query->execute(array(
			':id_linea_carga' => $id_linea_carga
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_linea_carga_por_num_expedicion($num_expedicion)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				lc.id_linea_carga,
				lc.id_cita_carga,
				lc.num_contenedor,
				c.id_tipo_contenedor_iso,
				tci.longitud_tipo_contenedor,
				tci.descripcion_tipo_contenedor,
				lc.pos_contenedor_temp,
				lc.num_vagon_temp,
				lc.pos_vagon_temp,
				(SELECT e.id_entrada FROM control_stock cs INNER JOIN entrada e ON cs.id_entrada = e.id_entrada WHERE num_contenedor = lc.num_contenedor ORDER BY e.fecha_entrada DESC LIMIT 1) AS id_entrada_ultimo,
				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = id_entrada_ultimo) = 'TREN'
						THEN (SELECT cif_propietario FROM entrada_vagon_contenedor WHERE id_entrada = id_entrada_ultimo AND num_contenedor = lc.num_contenedor)
				  WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = id_entrada_ultimo) = 'CAMIÓN'
						THEN (SELECT cif_propietario FROM entrada_camion_contenedor WHERE id_entrada = id_entrada_ultimo AND num_contenedor = lc.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = id_entrada_ultimo) = 'TRASPASO'
						THEN (SELECT cif_propietario_actual FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = id_entrada_ultimo AND num_contenedor = lc.num_contenedor)
				END) AS cif_propietario_actual,
				(SELECT nombre_comercial_propietario FROM propietario WHERE cif_propietario = cif_propietario_actual) AS nombre_comercial_propietario_actual
			FROM ((linea_carga lc INNER JOIN contenedor c ON c.num_contenedor = lc.num_contenedor)
				INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso)
					INNER JOIN cita_carga cc ON cc.id_cita_carga = lc.id_cita_carga
			WHERE cc.num_expedicion = :num_expedicion
			ORDER BY lc.num_contenedor
		");

		$query->execute(array(
			':num_expedicion' => $num_expedicion
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function delete_contenedor_linea_carga_temp($num_contenedor, $id_cita_carga)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		$query = $this->conexion->prepare("
			UPDATE linea_carga
			SET
				pos_contenedor_temp = NULL,
				num_vagon_temp = NULL,
				pos_vagon_temp = NULL
			WHERE id_cita_carga = :id_cita_carga AND num_contenedor = :num_contenedor
		");

		$query->execute(array(
			':num_contenedor' => $num_contenedor,
			':id_cita_carga' => $id_cita_carga
		));

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function delete_no_contenedor_linea_carga_temp($id_linea_carga)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		$query = $this->conexion->prepare("
			DELETE
			FROM linea_carga
			WHERE id_linea_carga = :id_linea_carga
		");

		$query->execute(array(
			':id_linea_carga' => $id_linea_carga
		));

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function contenedor_reservado_cita_carga($num_contenedor)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT *
			FROM (cita_carga cc INNER JOIN linea_carga lc ON lc.id_cita_carga = cc.id_cita_carga)
				LEFT JOIN salida s ON s.id_cita_carga = cc.id_cita_carga
			WHERE lc.num_contenedor = :num_contenedor AND s.id_salida IS NULL;
		");

		$query->execute(array(
			':num_contenedor' => $num_contenedor
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function num_expedicion_descarga_check($num_expedicion)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT id_cita_descarga, num_expedicion, fecha, hora, observaciones, cif_propietario, id_origen, id_destino
			FROM cita_descarga
			WHERE num_expedicion = :num_expedicion;
		");

		$query->execute(array(
			':num_expedicion' => $num_expedicion
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_citas_descarga_pendientes()
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
				SELECT *
				FROM cita_descarga cd INNER JOIN propietario c ON cd.cif_propietario = c.cif_propietario
				WHERE NOT EXISTS (SELECT id_entrada FROM entrada e WHERE e.id_cita_descarga = cd.id_cita_descarga);
			");

		$query->execute();

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_tipos_mercancias_ajax($search)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT id_tipo_mercancia, descripcion_mercancia
			FROM tipo_mercancia
			WHERE descripcion_mercancia LIKE :search
			ORDER BY descripcion_mercancia
			LIMIT 10;
		");

		$query->execute(array(
			':search' => "%" . $search . "%"
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_mercancias()
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
				SELECT id_tipo_mercancia, descripcion_mercancia
				FROM tipo_mercancia
			");

		$query->execute(array());

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_mercancia_por_descripcion($descripcion_mercancia)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
				SELECT id_tipo_mercancia, descripcion_mercancia
				FROM tipo_mercancia
				WHERE descripcion_mercancia = :descripcion_mercancia;
			");

		$query->execute(array(
			':descripcion_mercancia' => $descripcion_mercancia
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_tipo_contenedor_iso_por_id($id_tipo_contenedor_iso)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
				SELECT id_tipo_contenedor_iso, longitud_tipo_contenedor, descripcion_tipo_contenedor, tara_contenedor
				FROM tipo_contenedor_iso
				WHERE id_tipo_contenedor_iso = :id_tipo_contenedor_iso;
			");

		$query->execute(array(
			':id_tipo_contenedor_iso' => $id_tipo_contenedor_iso
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_tipos_trabajos()
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT id_tipo_trabajo, tipo_trabajo, categoria
			FROM tipo_trabajo
			WHERE categoria = 'TRABAJO'
		");

		$query->execute(array());

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_tipos_incidencias()
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT id_tipo_trabajo, tipo_trabajo, categoria
			FROM tipo_trabajo
			WHERE categoria = 'INCIDENCIA'
		");

		$query->execute(array());

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function insert_incidencia_evento($id_incidencia, $fecha_evento, $nombre_evento)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			INSERT INTO incidencia_evento(fecha_evento, nombre_evento, id_incidencia)
			VALUES (:fecha_evento, :nombre_evento, :id_incidencia);
		");

		$query->execute(array(
			':id_incidencia' => $id_incidencia,
			':fecha_evento' => $fecha_evento,
			':nombre_evento' => $nombre_evento
		));

		//Cerramos la conexion a la BD
		$query = null;

		//Obtenemos el id del registro insertado
		$this->result = $this->conexion->lastInsertId();

		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_incidencia_()
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				id_incidencia,
				num_incidencia,
				fecha_incidencia,
				id_tipo_incidencia,
				estado_incidencia,
				user_insert,
				fecha_insert,
				observaciones
			FROM incidencia
		");

		$query->execute(array(
			//':id_incidencia' => $id_incidencia,
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_incidencia_evento_por_id($id_evento)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT id_evento, fecha_evento, nombre_evento, id_incidencia
			FROM incidencia_evento
			WHERE id_evento = :id_evento
		");

		$query->execute(array(
			':id_evento' => $id_evento
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_incidencia_eventos($id_incidencia)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT id_evento, fecha_evento, nombre_evento, id_incidencia
			FROM incidencia_evento
			WHERE id_incidencia = :id_incidencia
			ORDER BY fecha_evento
		");

		$query->execute(array(
			':id_incidencia' => $id_incidencia
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function delete_incidencia_evento($id_evento)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		$query = $this->conexion->prepare("
			DELETE FROM incidencia_evento
			WHERE id_evento = :id_evento
		");

		$query->execute(array(
			':id_evento' => $id_evento
		));

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function update_incidencia_evento($id_evento, $fecha_evento, $nombre_evento)
	{
		$query = $this->conexion->prepare("
			 UPDATE incidencia_evento
			 SET
			 fecha_evento = :fecha_evento,
			 nombre_evento = :nombre_evento
			 WHERE id_evento = :id_evento
		");

		$this->result = $query->execute(array(
			':id_evento' => $id_evento,
			':fecha_evento' => $fecha_evento,
			':nombre_evento' => $nombre_evento
		));

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function update_id_salida_incidencia_contenedor($id_salida, $num_contenedor)
	{
		$query = $this->conexion->prepare("
			UPDATE incidencia_contenedor
			SET id_salida = :id_salida
			WHERE num_contenedor = :num_contenedor;

		");

		$this->result = $query->execute(array(
			':id_salida' => $id_salida,
			':num_contenedor' => $num_contenedor
		));

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function insert_parte_trabajo(
		$fecha_parte_trabajo,
		$num_contenedor,
		$cif_propietario,
		$user_insert,
		$observaciones
	) {
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			INSERT INTO parte_trabajo(
			    fecha_parte_trabajo,
			    num_contenedor,
				cif_propietario,
			    fecha_insert,
			    user_insert,
				observaciones
			)
			VALUES (
			    :fecha_parte_trabajo,
			    :num_contenedor,
				:cif_propietario,
			    NOW(),
			    :user_insert,
				:observaciones
			);
    	");

		$this->result[] = $query->execute(array(
			':fecha_parte_trabajo' => $fecha_parte_trabajo,
			':num_contenedor' => $num_contenedor,
			':cif_propietario' => $cif_propietario,
			':user_insert' => $user_insert,
			':observaciones' => $observaciones
		));

		//Cerramos la conexion a la BD
		$query = null;

		//Obtenemos el id del registro insertado
		$this->result = $this->conexion->lastInsertId();

		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function insert_linea_parte_trabajo(
		$id_parte_trabajo,
		$id_tipo_trabajo
	) {
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			INSERT INTO parte_trabajo_linea(id_parte_trabajo, id_tipo_trabajo)
			VALUES (:id_parte_trabajo, :id_tipo_trabajo);
    	");

		$this->result[] = $query->execute(array(
			':id_parte_trabajo' => $id_parte_trabajo,
			':id_tipo_trabajo' => $id_tipo_trabajo
		));

		//Cerramos la conexion a la BD
		$query = null;

		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_parte_trabajo($id_parte_trabajo)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				pt.id_parte_trabajo,
				pt.fecha_parte_trabajo,
				pt.num_contenedor,
				pt.cif_propietario,
				p.nombre_comercial_propietario,
				c.id_tipo_contenedor_iso,
				tci.longitud_tipo_contenedor,
				tci.descripcion_tipo_contenedor,
				pt.fecha_insert,
				pt.user_insert,
				pt.observaciones
			FROM ((parte_trabajo pt INNER JOIN contenedor c ON c.num_contenedor = pt.num_contenedor)
				INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso)
					LEFT JOIN propietario p ON p.cif_propietario = pt.cif_propietario
			WHERE id_parte_trabajo = :id_parte_trabajo
		");

		$query->execute(array(
			':id_parte_trabajo' => $id_parte_trabajo
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_parte_trabajo_lineas($id_parte_trabajo)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT 
				ptl.id_parte_trabajo,
				ptl.id_tipo_trabajo,
				tt.tipo_trabajo, 
				tt.categoria
			FROM parte_trabajo_linea ptl INNER JOIN tipo_trabajo tt ON tt.id_tipo_trabajo = ptl.id_tipo_trabajo
			WHERE ptl.id_parte_trabajo = :id_parte_trabajo;
		");

		$query->execute(array(
			':id_parte_trabajo' => $id_parte_trabajo
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_partes_trabajo($year)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				pt.id_parte_trabajo,
				pt.fecha_parte_trabajo,
				pt.num_contenedor,
				pt.cif_propietario,
				p.nombre_comercial_propietario,
				c.id_tipo_contenedor_iso,
				tci.longitud_tipo_contenedor,
				tci.descripcion_tipo_contenedor,
				pt.fecha_insert,
				pt.user_insert,
				pt.observaciones
			FROM ((parte_trabajo pt INNER JOIN contenedor c ON c.num_contenedor = pt.num_contenedor)
				INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso)
					LEFT JOIN propietario p ON p.cif_propietario = pt.cif_propietario
			WHERE YEAR(fecha_parte_trabajo) = :year
		");

		$query->execute(array(
			':year' => $year
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_partes_trabajo_parte_linea($year)
	{
		// Limpiamos resultados anteriores, si los hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				pt.id_parte_trabajo,
				pt.fecha_parte_trabajo,
				pt.num_contenedor,
				pt.cif_propietario,
				p.nombre_comercial_propietario,
				c.id_tipo_contenedor_iso,
				tci.longitud_tipo_contenedor,
				tci.descripcion_tipo_contenedor,
				pt.fecha_insert,
				pt.user_insert,
				pt.observaciones,
				IF(
					GROUP_CONCAT(
						CONCAT(
							'{',
								'\"id_parte_trabajo\":', IFNULL(ptl.id_parte_trabajo, 'null'),
								',\"id_tipo_trabajo\":', IFNULL(ptl.id_tipo_trabajo, 'null'),
								',\"tipo_trabajo\":', IF(tt.tipo_trabajo IS NULL, 'null', CONCAT('\"', tt.tipo_trabajo, '\"')),
								',\"categoria\":', IF(tt.categoria IS NULL, 'null', CONCAT('\"', tt.categoria, '\"')),
							'}'
						)
					) IS NULL,
					'[]',
					CONCAT(
						'[',
						GROUP_CONCAT(
							CONCAT(
								'{',
									'\"id_parte_trabajo\":', IFNULL(ptl.id_parte_trabajo, 'null'),
									',\"id_tipo_trabajo\":', IFNULL(ptl.id_tipo_trabajo, 'null'),
									',\"tipo_trabajo\":', IF(tt.tipo_trabajo IS NULL, 'null', CONCAT('\"', tt.tipo_trabajo, '\"')),
									',\"categoria\":', IF(tt.categoria IS NULL, 'null', CONCAT('\"', tt.categoria, '\"')),
								'}'
							)
						),
						']'
					)
				) AS lineas_parte
			FROM parte_trabajo pt INNER JOIN contenedor c ON c.num_contenedor = pt.num_contenedor
				INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso
				LEFT JOIN propietario p ON p.cif_propietario = pt.cif_propietario
				LEFT JOIN parte_trabajo_linea ptl  ON ptl.id_parte_trabajo = pt.id_parte_trabajo
				LEFT JOIN tipo_trabajo tt ON tt.id_tipo_trabajo = ptl.id_tipo_trabajo
			WHERE YEAR(pt.fecha_parte_trabajo) = :year
			GROUP BY pt.id_parte_trabajo
    	");

		$query->execute([':year' => $year]);

		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $row;
		}

		// Cerramos la conexión a la BD
		$query = null;

		// Devolvemos el array con el resultado de la consulta
		return $this->result;
	}

	public function get_tipo_contenedor_iso()
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
				SELECT id_tipo_contenedor_iso, longitud_tipo_contenedor, descripcion_tipo_contenedor
				FROM tipo_contenedor_iso
			");

		$query->execute(array());

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_tipos_contenedores_iso_ajax($search)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT id_tipo_contenedor_iso, longitud_tipo_contenedor, descripcion_tipo_contenedor
			FROM tipo_contenedor_iso
			WHERE id_tipo_contenedor_iso LIKE :search
			ORDER BY id_tipo_contenedor_iso
			LIMIT 10;
		");

		$query->execute(array(
			':search' => $search . "%"
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_contenedor_traspaso($num_contenedor)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
			c.num_contenedor,
			c.tara_contenedor,
			c.estado_carga_contenedor,
			c.peso_bruto_actual_contenedor,
			c.peso_mercancia_actual_contenedor,
			c.num_booking_actual_contenedor,
			c.num_precinto_actual_contenedor,
			c.temperatura_actual_contenedor,
			c.id_tipo_mercancia_actual_contenedor,
			c.num_peligro_adr_actual_contenedor,
			c.num_onu_adr_actual_contenedor,
			c.num_clase_adr_actual_contenedor,
			c.cod_grupo_embalaje_adr_actual_contenedor,
			tm.descripcion_mercancia,
			c.id_tipo_contenedor_iso,
			tci.longitud_tipo_contenedor,
			tci.descripcion_tipo_contenedor,
			c.cif_propietario_actual,
			c.codigo_estacion_ferrocarril_actual_contenedor,
			p.nombre_comercial_propietario,
			c.id_destinatario_actual,
			edo.nombre_empresa_destino_origen AS nombre_destinatario,
			c.id_cita_carga_temp
			FROM (((contenedor c INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso)
				INNER JOIN tipo_mercancia tm ON tm.id_tipo_mercancia = c.id_tipo_mercancia_actual_contenedor) INNER JOIN propietario p ON p.cif_propietario = c.cif_propietario_actual)
					LEFT JOIN empresa_destino_origen edo ON edo.id_empresa_destino_origen = c.id_destinatario_actual
			WHERE num_contenedor = :num_contenedor;
		");

		$query->execute(array(
			':num_contenedor' => $num_contenedor
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_contenedor($num_contenedor)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
			c.num_contenedor,
			c.tara_contenedor,
			c.estado_carga_contenedor,
			c.peso_bruto_actual_contenedor,
			c.peso_mercancia_actual_contenedor,
			c.num_booking_actual_contenedor,
			c.num_precinto_actual_contenedor,
			c.temperatura_actual_contenedor,
			c.id_tipo_mercancia_actual_contenedor,
			c.num_peligro_adr_actual_contenedor,
			c.num_onu_adr_actual_contenedor,
			c.num_clase_adr_actual_contenedor,
			c.cod_grupo_embalaje_adr_actual_contenedor,
			tm.descripcion_mercancia,
			c.id_tipo_contenedor_iso,
			tci.longitud_tipo_contenedor,
			tci.descripcion_tipo_contenedor,
			c.cif_propietario_actual,
			c.codigo_estacion_ferrocarril_actual_contenedor,
			p.nombre_comercial_propietario,
			c.id_destinatario_actual,
			edo.nombre_empresa_destino_origen AS nombre_destinatario,
			c.id_cita_carga_temp
			FROM (((contenedor c INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso)
				INNER JOIN tipo_mercancia tm ON tm.id_tipo_mercancia = c.id_tipo_mercancia_actual_contenedor) INNER JOIN propietario p ON p.cif_propietario = c.cif_propietario_actual)
					LEFT JOIN empresa_destino_origen edo ON edo.id_empresa_destino_origen = c.id_destinatario_actual
			WHERE num_contenedor = :num_contenedor;
		");

		$query->execute(array(
			':num_contenedor' => $num_contenedor
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function update_contenedor_traspaso(
		$num_contenedor,
		$cif_propietario_actual
	) {
		$query = $this->conexion->prepare("
			 UPDATE contenedor
			 SET
			 cif_propietario_actual = :cif_propietario_actual
			 WHERE num_contenedor = :num_contenedor;
		");

		$this->result = $query->execute(array(
			':num_contenedor' => $num_contenedor,
			':cif_propietario_actual' => $cif_propietario_actual
		));

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function update_contenedor(
		$num_contenedor,
		$tara_contenedor,
		$estado_carga_contenedor,
		$peso_bruto_actual_contenedor,
		$peso_mercancia_actual_contenedor,
		$num_booking_actual_contenedor,
		$num_precinto_actual_contenedor,
		$temperatura_actual_contenedor,
		$id_tipo_mercancia_actual_contenedor,
		$num_peligro_adr_actual_contenedor,
		$num_onu_adr_actual_contenedor,
		$num_clase_adr_actual_contenedor,
		$cod_grupo_embalaje_adr_actual_contenedor,
		$id_tipo_contenedor_iso,
		$cif_propietario_actual,
		$codigo_estacion_ferrocarril_actual_contenedor,
		$id_destinatario_actual
	) {
		$query = $this->conexion->prepare("
			 UPDATE contenedor
			 SET tara_contenedor = :tara_contenedor,
			 estado_carga_contenedor = :estado_carga_contenedor,
			 peso_bruto_actual_contenedor = :peso_bruto_actual_contenedor,
			 peso_mercancia_actual_contenedor = :peso_mercancia_actual_contenedor,
			 num_booking_actual_contenedor = :num_booking_actual_contenedor,
			 num_precinto_actual_contenedor = :num_precinto_actual_contenedor,
			 temperatura_actual_contenedor = :temperatura_actual_contenedor,
			 id_tipo_mercancia_actual_contenedor = :id_tipo_mercancia_actual_contenedor,
			 num_peligro_adr_actual_contenedor = :num_peligro_adr_actual_contenedor,
			 num_onu_adr_actual_contenedor = :num_onu_adr_actual_contenedor,
			 num_clase_adr_actual_contenedor = :num_clase_adr_actual_contenedor,
			 cod_grupo_embalaje_adr_actual_contenedor = :cod_grupo_embalaje_adr_actual_contenedor,
			 id_tipo_contenedor_iso = :id_tipo_contenedor_iso,
			 cif_propietario_actual = :cif_propietario_actual,
			 codigo_estacion_ferrocarril_actual_contenedor = :codigo_estacion_ferrocarril_actual_contenedor,
			 id_destinatario_actual = :id_destinatario_actual
			 WHERE num_contenedor = :num_contenedor;
		");

		$this->result = $query->execute(array(
			':num_contenedor' => $num_contenedor,
			':tara_contenedor' => $tara_contenedor,
			':estado_carga_contenedor' => $estado_carga_contenedor,
			':peso_bruto_actual_contenedor' => $peso_bruto_actual_contenedor,
			':peso_mercancia_actual_contenedor' => $peso_mercancia_actual_contenedor,
			':num_booking_actual_contenedor' => $num_booking_actual_contenedor,
			':num_precinto_actual_contenedor' => $num_precinto_actual_contenedor,
			':temperatura_actual_contenedor' => $temperatura_actual_contenedor,
			':id_tipo_mercancia_actual_contenedor' => $id_tipo_mercancia_actual_contenedor,
			':num_peligro_adr_actual_contenedor' => $num_peligro_adr_actual_contenedor,
			':num_onu_adr_actual_contenedor' => $num_onu_adr_actual_contenedor,
			':num_clase_adr_actual_contenedor' => $num_clase_adr_actual_contenedor,
			':cod_grupo_embalaje_adr_actual_contenedor' => $cod_grupo_embalaje_adr_actual_contenedor,
			':id_tipo_contenedor_iso' => $id_tipo_contenedor_iso,
			':cif_propietario_actual' => $cif_propietario_actual,
			':codigo_estacion_ferrocarril_actual_contenedor' => $codigo_estacion_ferrocarril_actual_contenedor,
			':id_destinatario_actual' => $id_destinatario_actual
		));

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function update_contenedor_salida(
		$num_contenedor,
		$temperatura_actual_contenedor,
		$id_destinatario_actual
	) {
		$query = $this->conexion->prepare("
			 UPDATE contenedor
			 SET temperatura_actual_contenedor = :temperatura_actual_contenedor,
			 id_destinatario_actual = :id_destinatario_actual
			 WHERE num_contenedor = :num_contenedor;
		");

		$this->result = $query->execute(array(
			':num_contenedor' => $num_contenedor,
			':temperatura_actual_contenedor' => $temperatura_actual_contenedor,
			':id_destinatario_actual' => $id_destinatario_actual
		));

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function update_contenedor_salida_tren(
		$num_contenedor
	) {
		$query = $this->conexion->prepare("
			UPDATE contenedor
			SET
				id_cita_carga_temp = NULL
			WHERE num_contenedor = :num_contenedor;
		");

		$this->result = $query->execute(array(
			':num_contenedor' => $num_contenedor
		));

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	function insert_contenedor(
		$num_contenedor,
		$tara_contenedor,
		$estado_carga_contenedor,
		$peso_bruto_actual_contenedor,
		$peso_mercancia_actual_contenedor,
		$num_booking_actual_contenedor,
		$num_precinto_actual_contenedor,
		$temperatura_actual_contenedor,
		$id_tipo_mercancia_actual_contenedor,
		$num_peligro_adr_actual_contenedor,
		$num_onu_adr_actual_contenedor,
		$num_clase_adr_actual_contenedor,
		$cod_grupo_embalaje_adr_actual_contenedor,
		$id_tipo_contenedor_iso,
		$cif_propietario_actual,
		$codigo_estacion_ferrocarril_actual_contenedor,
		$id_destinatario_actual
	) {
		try {
			$query = $this->conexion->prepare("
					INSERT INTO contenedor(
						num_contenedor,
						tara_contenedor,
						estado_carga_contenedor,
						peso_bruto_actual_contenedor,
						peso_mercancia_actual_contenedor,
						num_booking_actual_contenedor,
						num_precinto_actual_contenedor,
						temperatura_actual_contenedor,
						id_tipo_mercancia_actual_contenedor,
						num_peligro_adr_actual_contenedor,
						num_onu_adr_actual_contenedor,
					  num_clase_adr_actual_contenedor,
					  cod_grupo_embalaje_adr_actual_contenedor,
						id_tipo_contenedor_iso,
						cif_propietario_actual,
						codigo_estacion_ferrocarril_actual_contenedor,
						id_destinatario_actual
					)
					VALUES (
						:num_contenedor,
						:tara_contenedor,
						:estado_carga_contenedor,
						:peso_bruto_actual_contenedor,
						:peso_mercancia_actual_contenedor,
						:num_booking_actual_contenedor,
						:num_precinto_actual_contenedor,
						:temperatura_actual_contenedor,
						:id_tipo_mercancia_actual_contenedor,
						:num_peligro_adr_actual_contenedor,
						:num_onu_adr_actual_contenedor,
					  :num_clase_adr_actual_contenedor,
					  :cod_grupo_embalaje_adr_actual_contenedor,
						:id_tipo_contenedor_iso,
						:cif_propietario_actual,
						:codigo_estacion_ferrocarril_actual_contenedor,
						:id_destinatario_actual
					);
				");

			$result = $query->execute(array(
				':num_contenedor' => $num_contenedor,
				':tara_contenedor' => $tara_contenedor,
				':estado_carga_contenedor' => $estado_carga_contenedor,
				':peso_bruto_actual_contenedor' => $peso_bruto_actual_contenedor,
				':peso_mercancia_actual_contenedor' => $peso_mercancia_actual_contenedor,
				':num_booking_actual_contenedor' => $num_booking_actual_contenedor,
				':num_precinto_actual_contenedor' => $num_precinto_actual_contenedor,
				':temperatura_actual_contenedor' => $temperatura_actual_contenedor,
				':id_tipo_mercancia_actual_contenedor' => $id_tipo_mercancia_actual_contenedor,
				':num_peligro_adr_actual_contenedor' => $num_peligro_adr_actual_contenedor,
				':num_onu_adr_actual_contenedor' => $num_onu_adr_actual_contenedor,
				':num_clase_adr_actual_contenedor' => $num_clase_adr_actual_contenedor,
				':cod_grupo_embalaje_adr_actual_contenedor' => $cod_grupo_embalaje_adr_actual_contenedor,
				':id_tipo_contenedor_iso' => $id_tipo_contenedor_iso,
				':cif_propietario_actual' => $cif_propietario_actual,
				':codigo_estacion_ferrocarril_actual_contenedor' => $codigo_estacion_ferrocarril_actual_contenedor,
				':id_destinatario_actual' => $id_destinatario_actual
			));

			//Cerramos la consulta a la BD
			$query = null;

			return $result;
		} catch (PDOException $e) {
			return "Error: " . $e;
		}
	}

	public function get_tipo_entrada_por_tipo($tipo_entrada)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
				SELECT id_tipo_entrada, tipo_entrada
				FROM tipo_entrada
				WHERE tipo_entrada = :tipo_entrada;
			");

		$query->execute(array(
			':tipo_entrada' => $tipo_entrada
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_tipo_salida_por_tipo($tipo_salida)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
				SELECT id_tipo_salida, tipo_salida
				FROM tipo_salida
				WHERE tipo_salida = :tipo_salida;
			");

		$query->execute(array(
			':tipo_salida' => $tipo_salida
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_entrada_por_id($id_entrada)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT e.id_entrada, e.fecha_entrada, e.fecha_insert, e.user_insert, e.id_tipo_entrada, te.tipo_entrada, e.id_cita_descarga
			FROM entrada e INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada
			WHERE id_entrada = :id_entrada
		");

		$query->execute(array(
			':id_entrada' => $id_entrada
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_salida_por_id($id_salida)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT s.id_salida, s.fecha_salida, s.fecha_insert, s.user_insert, s.id_tipo_salida, ts.tipo_salida AS tipo_salida, s.id_cita_carga
			FROM salida s INNER JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida
			WHERE id_salida = :id_salida
		");

		$query->execute(array(
			':id_salida' => $id_salida
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_num_expedicion_entrada_tipo_tren($id_entrada)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT e.id_entrada, ett.num_expedicion
			FROM (entrada e INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada)
				INNER JOIN entrada_tipo_tren ett ON ett.id_entrada = e.id_entrada
			WHERE e.id_entrada = :id_entrada
		");

		$query->execute(array(
			':id_entrada' => $id_entrada
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_num_expedicion_salida_tipo_tren($id_salida)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				s.id_salida,
				stt.num_expedicion
			FROM (salida s INNER JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida)
				INNER JOIN salida_tipo_tren stt ON stt.id_salida = s.id_salida
			WHERE s.id_salida = :id_salida
		");

		$query->execute(array(
			':id_salida' => $id_salida
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function insert_entrada($fecha_entrada, $id_tipo_entrada, $id_cita_descarga, $user_insert)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
				INSERT INTO entrada(fecha_entrada, fecha_insert, user_insert, id_tipo_entrada, id_cita_descarga)
				VALUES (:fecha_entrada, NOW(), :user_insert, :id_tipo_entrada, :id_cita_descarga);
      ");

		$this->result[] = $query->execute(array(
			':fecha_entrada' => $fecha_entrada,
			':id_tipo_entrada' => $id_tipo_entrada,
			':id_cita_descarga' => $id_cita_descarga,
			':user_insert' => $user_insert
		));

		//Cerramos la conexion a la BD
		$query = null;

		//Obtenemos el id del registro insertado
		$this->result = $this->conexion->lastInsertId();

		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function insert_salida($fecha_salida, $id_tipo_salida, $id_cita_carga, $user_insert)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
				INSERT INTO salida(fecha_salida, fecha_insert, user_insert, id_tipo_salida, id_cita_carga)
				VALUES (:fecha_salida, NOW(), :user_insert, :id_tipo_salida, :id_cita_carga);
      ");

		$this->result[] = $query->execute(array(
			':fecha_salida' => $fecha_salida,
			':id_tipo_salida' => $id_tipo_salida,
			':id_cita_carga' => $id_cita_carga,
			':user_insert' => $user_insert
		));

		//Cerramos la conexion a la BD
		$query = null;

		//Obtenemos el id del registro insertado
		$this->result = $this->conexion->lastInsertId();

		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	function insert_entrada_camion(
		$id_entrada,
		$num_expedicion,
		$matricula_tractora,
		$matricula_remolque,
		$dni_conductor,
		$cif_empresa_transportista,
		$id_origen,
		$id_destino,
		$observaciones
	) {
		try {
			$query = $this->conexion->prepare("
				INSERT INTO entrada_tipo_camion(
					id_entrada,
					num_expedicion,
					matricula_tractora,
					matricula_remolque,
					dni_conductor,
					cif_empresa_transportista,
					id_origen,
					id_destino,
					observaciones
				)
				VALUES (
					:id_entrada,
					:num_expedicion,
					:matricula_tractora,
					:matricula_remolque,
					:dni_conductor,
					:cif_empresa_transportista,
					:id_origen,
					:id_destino,
					:observaciones
				)
			");

			$result = $query->execute(array(
				':id_entrada' => $id_entrada,
				':num_expedicion' => $num_expedicion,
				':matricula_tractora' => $matricula_tractora,
				':matricula_remolque' => $matricula_remolque,
				':dni_conductor' => $dni_conductor,
				':cif_empresa_transportista' => $cif_empresa_transportista,
				':id_origen' => $id_origen,
				':id_destino' => $id_destino,
				':observaciones' => $observaciones
			));

			//cerramos la consulta a la BD
			$query = null;

			return $result;
		} catch (PDOException $e) {
			return "Error: " . $e;
		}
	}

	function insert_salida_camion(
		$id_salida,
		$num_expedicion,
		$matricula_tractora,
		$matricula_remolque,
		$dni_conductor,
		$cif_empresa_transportista,
		$id_origen,
		$id_destino,
		$observaciones
	) {
		try {
			$query = $this->conexion->prepare("
				INSERT INTO salida_tipo_camion(
					id_salida,
					num_expedicion,
					matricula_tractora,
					matricula_remolque,
					dni_conductor,
					cif_empresa_transportista,
					id_origen,
					id_destino,
					observaciones
				)
				VALUES (
					:id_salida,
					:num_expedicion,
					:matricula_tractora,
					:matricula_remolque,
					:dni_conductor,
					:cif_empresa_transportista,
					:id_origen,
					:id_destino,
					:observaciones
				)
			");

			$result = $query->execute(array(
				':id_salida' => $id_salida,
				':num_expedicion' => $num_expedicion,
				':matricula_tractora' => $matricula_tractora,
				':matricula_remolque' => $matricula_remolque,
				':dni_conductor' => $dni_conductor,
				':cif_empresa_transportista' => $cif_empresa_transportista,
				':id_origen' => $id_origen,
				':id_destino' => $id_destino,
				':observaciones' => $observaciones
			));

			//cerramos la consulta a la BD
			$query = null;

			return $result;
		} catch (PDOException $e) {
			return "Error: " . $e;
		}
	}

	function insert_entrada_camion_contenedor(
		$id_entrada,
		$num_contenedor,
		$estado_carga_contenedor,
		$id_tipo_mercancia,
		$num_peligro_adr,
		$num_onu_adr,
		$num_clase_adr,
		$cod_grupo_embalaje_adr,
		$peso_mercancia_contenedor,
		$num_booking_contenedor,
		$num_precinto_contenedor,
		$temperatura_contenedor,
		$cif_propietario,
		$codigo_estacion_ferrocarril,
		$id_destinatario
	) {
		try {
			$query = $this->conexion->prepare("
			INSERT INTO entrada_camion_contenedor(
				id_entrada,
				num_contenedor,
				estado_carga_contenedor,
				id_tipo_mercancia,
				num_peligro_adr,
				num_onu_adr,
				num_clase_adr,
				cod_grupo_embalaje_adr,
				peso_mercancia_contenedor,
				num_booking_contenedor,
		    num_precinto_contenedor,
				temperatura_contenedor,
				cif_propietario,
				codigo_estacion_ferrocarril,
				id_destinatario
			)
			VALUES (
				:id_entrada,
				:num_contenedor,
				:estado_carga_contenedor,
				:id_tipo_mercancia,
				:num_peligro_adr,
				:num_onu_adr,
				:num_clase_adr,
				:cod_grupo_embalaje_adr,
				:peso_mercancia_contenedor,
				:num_booking_contenedor,
		    :num_precinto_contenedor,
				:temperatura_contenedor,
				:cif_propietario,
				:codigo_estacion_ferrocarril,
				:id_destinatario
			);
			");

			$result = $query->execute(array(
				':id_entrada' => $id_entrada,
				':num_contenedor' => $num_contenedor,
				':estado_carga_contenedor' => $estado_carga_contenedor,
				':id_tipo_mercancia' => $id_tipo_mercancia,
				':num_peligro_adr' => $num_peligro_adr,
				':num_onu_adr' => $num_onu_adr,
				':num_clase_adr' => $num_clase_adr,
				':cod_grupo_embalaje_adr' => $cod_grupo_embalaje_adr,
				':peso_mercancia_contenedor' => $peso_mercancia_contenedor,
				':num_booking_contenedor' => $num_booking_contenedor,
				':num_precinto_contenedor' => $num_precinto_contenedor,
				':temperatura_contenedor' => $temperatura_contenedor,
				':cif_propietario' => $cif_propietario,
				':codigo_estacion_ferrocarril' => $codigo_estacion_ferrocarril,
				':id_destinatario' => $id_destinatario
			));

			//cerramos la consulta a la BD
			$query = null;

			return $result;
		} catch (PDOException $e) {
			return "Error: " . $e;
		}
	}

	function insert_salida_camion_contenedor(
		$id_salida,
		$num_contenedor,
		$temperatura_contenedor,
		$id_destinatario
	) {
		try {
			$query = $this->conexion->prepare("
			INSERT INTO salida_camion_contenedor(
				id_salida,
				num_contenedor,
				temperatura_contenedor,
				id_destinatario
			)
			VALUES (
				:id_salida,
				:num_contenedor,
				:temperatura_contenedor,
				:id_destinatario
			);
			");

			$result = $query->execute(array(
				':id_salida' => $id_salida,
				':num_contenedor' => $num_contenedor,
				':temperatura_contenedor' => $temperatura_contenedor,
				':id_destinatario' => $id_destinatario
			));

			//cerramos la consulta a la BD
			$query = null;

			return $result;
		} catch (PDOException $e) {
			return "Error: " . $e;
		}
	}

	public function get_entrada_tipo_camion_por_id_entrada_por_num_contenedor($id_entrada, $num_contenedor)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				etc.num_expedicion,
				etc.cif_empresa_transportista,
				etc.matricula_tractora,
				ecc.id_tipo_mercancia,
				tm.descripcion_mercancia,
				ecc.num_peligro_adr,
				ap.descripcion_peligro_adr,
				ecc.num_onu_adr,
				ao.descripcion_onu_adr,
				ecc.num_clase_adr,
				ecc.cod_grupo_embalaje_adr,
				ecc.cif_propietario,
				p.nombre_comercial_propietario,
				ecc.id_destinatario,
				edo.id_empresa_destino_origen,
				edo.nombre_empresa_destino_origen,
				edo.num_tarjeta_teco,
				ecc.num_booking_contenedor,
				ecc.num_precinto_contenedor,
				ecc.estado_carga_contenedor,
				ecc.peso_mercancia_contenedor,
				ecc.peso_mercancia_contenedor + c.tara_contenedor AS peso_bruto_contenedor,
				ecc.temperatura_contenedor,
				ecc.codigo_estacion_ferrocarril,
				efr.nombre_estacion_ferrocarril
			FROM (((((((entrada_tipo_camion etc INNER JOIN entrada_camion_contenedor ecc ON ecc.id_entrada = etc.id_entrada)
				INNER JOIN tipo_mercancia tm ON tm.id_tipo_mercancia = ecc.id_tipo_mercancia)
					INNER JOIN propietario p ON p.cif_propietario = ecc.cif_propietario)
						LEFT JOIN empresa_destino_origen edo ON edo.id_empresa_destino_origen = ecc.id_destinatario)
							INNER JOIN contenedor c ON c.num_contenedor = ecc.num_contenedor)
								LEFT JOIN estacion_ferrocarril_renfe efr ON efr.codigo_estacion_ferrocarril = ecc.codigo_estacion_ferrocarril)
									LEFT JOIN adr_peligro ap ON ap.num_peligro_adr = ecc.num_peligro_adr)
										LEFT JOIN adr_onu ao ON ao.num_onu_adr = ecc.num_onu_adr
			WHERE etc.id_entrada = :id_entrada AND ecc.num_contenedor = :num_contenedor;
		");

		$query->execute(array(
			':id_entrada' => $id_entrada,
			':num_contenedor' => $num_contenedor
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_entrada_tipo_camion_por_id_entrada_por_num_contenedor2($id_entrada, $num_contenedor)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				etc.id_entrada,
				etc.num_expedicion,
				etc.cif_empresa_transportista,
				etc.matricula_tractora,
				ecc.id_tipo_mercancia,
				tm.descripcion_mercancia,
				ecc.num_peligro_adr,
				ap.descripcion_peligro_adr,
				ecc.num_onu_adr,
				ao.descripcion_onu_adr,
				ecc.num_clase_adr,
				ecc.cod_grupo_embalaje_adr,
				ecc.cif_propietario,
				p.nombre_comercial_propietario,
				ecc.id_destinatario,
				edo.id_empresa_destino_origen,
				edo.nombre_empresa_destino_origen,
				edo.num_tarjeta_teco,
				ecc.num_booking_contenedor,
				ecc.num_precinto_contenedor,
				ecc.estado_carga_contenedor,
				ecc.peso_mercancia_contenedor,
				ecc.peso_mercancia_contenedor + c.tara_contenedor AS peso_bruto_contenedor,
				ecc.temperatura_contenedor,
				ecc.codigo_estacion_ferrocarril,
				efr.nombre_estacion_ferrocarril,
				cs.id_salida
			FROM entrada_tipo_camion etc INNER JOIN entrada_camion_contenedor ecc ON ecc.id_entrada = etc.id_entrada
				INNER JOIN tipo_mercancia tm ON tm.id_tipo_mercancia = ecc.id_tipo_mercancia
					INNER JOIN propietario p ON p.cif_propietario = ecc.cif_propietario
						LEFT JOIN empresa_destino_origen edo ON edo.id_empresa_destino_origen = ecc.id_destinatario
							INNER JOIN contenedor c ON c.num_contenedor = ecc.num_contenedor
								LEFT JOIN estacion_ferrocarril_renfe efr ON efr.codigo_estacion_ferrocarril = ecc.codigo_estacion_ferrocarril
									LEFT JOIN adr_peligro ap ON ap.num_peligro_adr = ecc.num_peligro_adr
										LEFT JOIN adr_onu ao ON ao.num_onu_adr = ecc.num_onu_adr
                                        INNER JOIN entrada e ON e.id_entrada = ecc.id_entrada
                                        INNER JOIN control_stock cs ON cs.id_entrada = e.id_entrada
			WHERE etc.id_entrada = :id_entrada AND ecc.num_contenedor = :num_contenedor;
		");

		$query->execute(array(
			':id_entrada' => $id_entrada,
			':num_contenedor' => $num_contenedor
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_entrada_tipo_traspaso_por_id_entrada_por_num_contenedor($id_entrada, $num_contenedor)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				t.id_traspaso,
				t.fecha_traspaso,
				t.num_contenedor,
				t.cif_propietario_anterior,
				(SELECT nombre_comercial_propietario FROM propietario WHERE cif_propietario = t.cif_propietario_anterior) AS nombre_comercial_propietario_anterior,
				t.cif_propietario_actual AS cif_propietario,
				(SELECT nombre_comercial_propietario FROM propietario WHERE cif_propietario = t.cif_propietario_actual) AS nombre_comercial_propietario,
				t.estado_carga_contenedor,
				t.id_tipo_mercancia,
				tm.descripcion_mercancia,
				t.num_peligro_adr,
				ap.descripcion_peligro_adr,
				t.num_onu_adr,
				ao.descripcion_onu_adr,
				t.num_clase_adr,
				t.cod_grupo_embalaje_adr,
				t.id_destinatario,
				edo.nombre_empresa_destino_origen,
				edo.num_tarjeta_teco,
				t.peso_mercancia_contenedor,
				t.peso_bruto_contenedor,
				t.num_booking_contenedor,
				t.num_precinto_contenedor,
				t.temperatura_contenedor,
				t.codigo_estacion_ferrocarril,
			  efr.nombre_estacion_ferrocarril
			FROM ((((((traspaso t INNER JOIN entrada_tipo_traspaso ett ON ett.id_traspaso = t.id_traspaso)
				INNER JOIN tipo_mercancia tm ON tm.id_tipo_mercancia = t.id_tipo_mercancia)
			    	INNER JOIN contenedor c ON c.num_contenedor = t.num_contenedor)
			        	LEFT JOIN adr_peligro ap ON ap.num_peligro_adr = t.num_peligro_adr)
			            	LEFT JOIN adr_onu ao ON ao.num_onu_adr = t.num_onu_adr)
			                	LEFT JOIN empresa_destino_origen edo ON edo.id_empresa_destino_origen = t.id_destinatario)
			                    	LEFT JOIN estacion_ferrocarril_renfe efr ON efr.codigo_estacion_ferrocarril = t.codigo_estacion_ferrocarril
			WHERE ett.id_entrada = :id_entrada AND t.num_contenedor = :num_contenedor;
		");

		$query->execute(array(
			':id_entrada' => $id_entrada,
			':num_contenedor' => $num_contenedor
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_salida_tipo_camion_por_id_salida_por_num_contenedor($id_salida, $num_contenedor)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				stc.num_expedicion,
				stc.id_salida,
				scc.temperatura_contenedor,
				scc.id_destinatario,
				edo.nombre_empresa_destino_origen AS nombre_destinatario
			FROM ((salida_tipo_camion stc INNER JOIN salida_camion_contenedor scc ON scc.id_salida = stc.id_salida)
					LEFT JOIN empresa_destino_origen edo ON edo.id_empresa_destino_origen = scc.id_destinatario)
						#INNER JOIN propietario p ON p.cif_propietario = scc.cif_propietario
			WHERE stc.id_salida = :id_salida AND scc.num_contenedor = :num_contenedor;
		");

		$query->execute(array(
			':id_salida' => $id_salida,
			':num_contenedor' => $num_contenedor
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_salida_tipo_camion_por_id_salida_por_num_contenedor2($id_salida, $num_contenedor)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
		SELECT
			  scc.num_contenedor,
			  c.id_tipo_contenedor_iso,
			  scc.id_salida,
			  stc.num_expedicion,
			  s.fecha_salida,
			  s.id_tipo_salida,
			  cs.id_entrada,
			  e.fecha_entrada,
			  e.id_tipo_entrada,
			  te.tipo_entrada,
			  ecc.estado_carga_contenedor,
              c.cif_propietario_actual
			FROM salida_camion_contenedor scc INNER JOIN salida_tipo_camion stc ON stc.id_salida = scc.id_salida
				INNER JOIN salida s ON s.id_salida = stc.id_salida
				INNER JOIN control_stock cs on cs.num_contenedor = scc.num_contenedor AND cs.id_salida = :id_salida
				INNER JOIN entrada e ON cs.id_entrada = e.id_entrada
				INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada
				INNER JOIN contenedor c ON c.num_contenedor = cs.num_contenedor
				INNER JOIN entrada_camion_contenedor ecc ON ecc.num_contenedor = scc.num_contenedor
                WHERE scc.id_salida = :id_salida AND scc.num_contenedor = :num_contenedor
				GROUP BY scc.num_contenedor
		");

		$query->execute(array(
			':id_salida' => $id_salida,
			':num_contenedor' => $num_contenedor
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_salida_tipo_tren_por_id_salida_por_num_contenedor($id_salida, $num_contenedor)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				stt.num_expedicion,
				stt.id_salida
			FROM (salida_tipo_tren stt INNER JOIN salida_vagon_contenedor svc ON svc.id_salida = stt.id_salida)
			WHERE stt.id_salida = :id_salida AND svc.num_contenedor = :num_contenedor;
		");

		$query->execute(array(
			':id_salida' => $id_salida,
			':num_contenedor' => $num_contenedor
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_salida_tipo_tren_por_id_salida_por_num_contenedor2($id_salida, $num_contenedor)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
			  svc.num_contenedor,
			  c.id_tipo_contenedor_iso,
			  svc.id_salida,
			  stt.num_expedicion,
			  s.fecha_salida,
			  s.id_tipo_salida,
              ts.tipo_salida,
			  cs.id_entrada,
			  e.fecha_entrada,
			  e.id_tipo_entrada,
			  te.tipo_entrada,
			  evc.estado_carga_contenedor,
              c.cif_propietario_actual,
              p.nombre_comercial_propietario
			FROM salida_vagon_contenedor svc INNER JOIN salida_tipo_tren stt ON stt.id_salida = svc.id_salida
				INNER JOIN salida s ON s.id_salida = stt.id_salida
                INNER JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida
				INNER JOIN control_stock cs on cs.num_contenedor = svc.num_contenedor AND cs.id_salida = :id_salida
				INNER JOIN entrada e ON cs.id_entrada = e.id_entrada
				INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada
				INNER JOIN contenedor c ON c.num_contenedor = cs.num_contenedor
                INNER JOIN propietario p ON p.cif_propietario = c.cif_propietario_actual
				INNER JOIN entrada_vagon_contenedor evc ON evc.num_contenedor = svc.num_contenedor
			WHERE svc.id_salida = :id_salida AND svc.num_contenedor = :num_contenedor
			GROUP BY svc.num_contenedor
		");

		$query->execute(array(
			':id_salida' => $id_salida,
			':num_contenedor' => $num_contenedor
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_ultimo_num_expedicion_entrada_tipo_camion()
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT num_expedicion
			FROM entrada_tipo_camion
			ORDER BY num_expedicion DESC
			LIMIT 1
		");

		$query->execute(array());

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_ultimo_num_expedicion_salida_tipo_camion()
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT num_expedicion
			FROM salida_tipo_camion
			ORDER BY num_expedicion DESC
			LIMIT 1
		");

		$query->execute(array());

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_datos_salida_tipo_tren($id_cita_carga)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				lc.id_linea_carga,
				lc.id_cita_carga,
				lc.num_contenedor,
				lc.pos_contenedor_temp,
				lc.num_vagon_temp,
				lc.pos_vagon_temp
			FROM linea_carga lc LEFT JOIN contenedor c ON c.num_contenedor = lc.num_contenedor
			WHERE lc.id_cita_carga = :id_cita_carga AND (c.id_cita_carga_temp = :id_cita_carga OR c.id_cita_carga_temp IS NULL);
		");

		$query->execute(array(
			':id_cita_carga' => $id_cita_carga
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	function insert_entrada_tren($id_entrada, $num_expedicion)
	{
		try {
			$query = $this->conexion->prepare("
					INSERT INTO entrada_tipo_tren(id_entrada, num_expedicion)
					VALUES (:id_entrada, :num_expedicion);
				");

			$result = $query->execute(array(
				':id_entrada' => $id_entrada,
				':num_expedicion' => $num_expedicion
			));

			//cerramos la consulta a la BD
			$query = null;

			return $result;
		} catch (PDOException $e) {
			return "Error: " . $e;
		}
	}

	function insert_salida_tren($id_salida, $num_expedicion)
	{
		try {
			$query = $this->conexion->prepare("
					INSERT INTO salida_tipo_tren(id_salida, num_expedicion)
					VALUES (:id_salida, :num_expedicion);
				");

			$result = $query->execute(array(
				':id_salida' => $id_salida,
				':num_expedicion' => $num_expedicion
			));

			//cerramos la consulta a la BD
			$query = null;

			return $result;
		} catch (PDOException $e) {
			return "Error: " . $e;
		}
	}

	function insert_entrada_vagon_contenedor(
		$id_entrada,
		$num_vagon,
		$pos_vagon,
		$pos_contenedor,
		$num_contenedor,
		$estado_carga_contenedor,
		$id_tipo_mercancia,
		$num_peligro_adr,
		$num_onu_adr,
		$num_clase_adr,
		$cod_grupo_embalaje_adr,
		$tara_contenedor,
		$peso_bruto_contenedor,
		$temperatura_contenedor,
		$cif_propietario,
		$id_destinatario
	) {
		try {
			$query = $this->conexion->prepare("
				INSERT INTO entrada_vagon_contenedor(
				    id_entrada,
				    num_vagon,
				    pos_vagon,
				    pos_contenedor,
				    num_contenedor,
				    estado_carga_contenedor,
				    id_tipo_mercancia,
				    num_peligro_adr,
				    num_onu_adr,
				    num_clase_adr,
				    cod_grupo_embalaje_adr,
					tara_contenedor,
				    peso_bruto_contenedor,
				    temperatura_contenedor,
				    cif_propietario,
				    id_destinatario
				)
				VALUES (
				    :id_entrada,
				    :num_vagon,
				    :pos_vagon,
				    :pos_contenedor,
				    :num_contenedor,
				    :estado_carga_contenedor,
				    :id_tipo_mercancia,
				    :num_peligro_adr,
				    :num_onu_adr,
				    :num_clase_adr,
				    :cod_grupo_embalaje_adr,
					:tara_contenedor,
				    :peso_bruto_contenedor,
				    :temperatura_contenedor,
				    :cif_propietario,
				    :id_destinatario
				)
			");

			$result = $query->execute(array(
				':id_entrada' => $id_entrada,
				':num_vagon' => $num_vagon,
				':pos_vagon' => $pos_vagon,
				':pos_contenedor' => $pos_contenedor,
				':num_contenedor' => $num_contenedor,
				':estado_carga_contenedor' => $estado_carga_contenedor,
				':id_tipo_mercancia' => $id_tipo_mercancia,
				':num_peligro_adr' => $num_peligro_adr,
				':num_onu_adr' => $num_onu_adr,
				':num_clase_adr' => $num_clase_adr,
				':cod_grupo_embalaje_adr' => $cod_grupo_embalaje_adr,
				':tara_contenedor' => $tara_contenedor,
				':peso_bruto_contenedor' => $peso_bruto_contenedor,
				':temperatura_contenedor' => $temperatura_contenedor,
				':cif_propietario' => $cif_propietario,
				':id_destinatario' => $id_destinatario
			));

			//cerramos la consulta a la BD
			$query = null;

			return $result;
		} catch (PDOException $e) {
			return "Error: " . $e;
		}
	}

	function insert_salida_vagon_contenedor(
		$id_salida,
		$num_vagon,
		$pos_vagon,
		$pos_contenedor,
		$num_contenedor
	) {
		try {
			$query = $this->conexion->prepare("
				INSERT INTO salida_vagon_contenedor(
				    id_salida,
				    num_vagon,
				    pos_vagon,
				    pos_contenedor,
				    num_contenedor
				)
				VALUES (
				    :id_salida,
				    :num_vagon,
				    :pos_vagon,
				    :pos_contenedor,
				    :num_contenedor
				)
			");

			$result = $query->execute(array(
				':id_salida' => $id_salida,
				':num_vagon' => $num_vagon,
				':pos_vagon' => $pos_vagon,
				':pos_contenedor' => $pos_contenedor,
				':num_contenedor' => $num_contenedor
			));

			//cerramos la consulta a la BD
			$query = null;

			return $result;
		} catch (PDOException $e) {
			return "Error: " . $e;
		}
	}

	function insert_control_stock(
		$num_contenedor,
		$id_entrada
	) {
		try {
			$query = $this->conexion->prepare("
				INSERT INTO control_stock(id_entrada, num_contenedor)
				VALUES (:id_entrada, :num_contenedor);
			");

			$result = $query->execute(array(
				':id_entrada' => $id_entrada,
				':num_contenedor' => $num_contenedor
			));

			//cerramos la consulta a la BD
			$query = null;

			//obtenemos el id del registro insertado
			$this->result = $this->conexion->lastInsertId();

			return $result;
		} catch (PDOException $e) {
			return "Error: " . $e;
		}
	}

	function update_control_stock(
		$num_contenedor,
		$id_entrada,
		$id_salida
	) {
		$query = $this->conexion->prepare("
				UPDATE control_stock
				SET id_salida = :id_salida
				WHERE num_contenedor = :num_contenedor AND id_entrada = :id_entrada;
			");

		$this->result = $query->execute(array(
			':num_contenedor' => $num_contenedor,
			':id_entrada' => $id_entrada,
			':id_salida' => $id_salida
		));

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	function update_salida_control_stock(
		$num_contenedor,
		$id_salida
	) {
		$query = $this->conexion->prepare("
				UPDATE control_stock
				SET id_salida = :id_salida
				WHERE num_contenedor = :num_contenedor AND id_salida IS NULL;
			");

		$this->result = $query->execute(array(
			':num_contenedor' => $num_contenedor,
			':id_salida' => $id_salida
		));

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	function update_entrada_control_stock(
		$num_contenedor,
		$id_entrada
	) {
		$query = $this->conexion->prepare("
				UPDATE control_stock
				SET id_entrada = :id_entrada
				WHERE num_contenedor = :num_contenedor AND id_entrada IS NULL;
			");

		$this->result = $query->execute(array(
			':num_contenedor' => $num_contenedor,
			':id_entrada' => $id_entrada
		));

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_entrada_vagon_contenedor_por_id_entrada($id_entrada)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
				SELECT *
				FROM entrada_vagon_contenedor
				WHERE id_entrada = :id_entrada
			");

		$query->execute(array(
			':id_entrada' => $id_entrada
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_salida_vagon_contenedor_por_id_salida($id_salida)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
				SELECT *
				FROM salida_vagon_contenedor
				WHERE id_salida = :id_salida
			");

		$query->execute(array(
			':id_salida' => $id_salida
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_entrada_tipo_tren_por_id_entrada_por_num_contenedor($id_entrada, $num_contenedor)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
				SELECT
					ett.num_expedicion,
					evc.id_tipo_mercancia,
					tm.descripcion_mercancia,
					evc.num_peligro_adr,
					ap.descripcion_peligro_adr,
					evc.num_onu_adr,
					ao.descripcion_onu_adr,
					evc.num_clase_adr,
					evc.cod_grupo_embalaje_adr,
					evc.peso_bruto_contenedor,
					evc.cif_propietario,
					p.nombre_comercial_propietario,
					evc.id_destinatario,
					edo.id_empresa_destino_origen,
					edo.nombre_empresa_destino_origen,
					edo.num_tarjeta_teco,
					evc.num_vagon,
					evc.pos_vagon,
					evc.pos_contenedor,
					evc.estado_carga_contenedor,
					evc.id_tipo_mercancia,
					evc.peso_bruto_contenedor,
					evc.peso_bruto_contenedor - c.tara_contenedor AS peso_mercancia_contenedor,
					evc.temperatura_contenedor
				FROM ((((((entrada_tipo_tren ett INNER JOIN entrada_vagon_contenedor evc ON evc.id_entrada = ett.id_entrada)
					INNER JOIN tipo_mercancia tm ON tm.id_tipo_mercancia = evc.id_tipo_mercancia)
						INNER JOIN propietario p ON p.cif_propietario = evc.cif_propietario)
							LEFT JOIN empresa_destino_origen edo ON edo.id_empresa_destino_origen = evc.id_destinatario)
								INNER JOIN contenedor c ON c.num_contenedor = evc.num_contenedor)
									LEFT JOIN adr_peligro ap ON ap.num_peligro_adr = evc.num_peligro_adr)
										LEFT JOIN adr_onu ao ON ao.num_onu_adr = evc.num_onu_adr
				WHERE ett.id_entrada = :id_entrada AND evc.num_contenedor = :num_contenedor;
			");

		$query->execute(array(
			':id_entrada' => $id_entrada,
			':num_contenedor' => $num_contenedor
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_entrada_tipo_tren_por_id_entrada_por_num_contenedor2($id_entrada, $num_contenedor)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
				SELECT
					ett.id_entrada,
					ett.num_expedicion,
					evc.id_tipo_mercancia,
					tm.descripcion_mercancia,
					evc.num_peligro_adr,
					ap.descripcion_peligro_adr,
					evc.num_onu_adr,
					ao.descripcion_onu_adr,
					evc.num_clase_adr,
					evc.cod_grupo_embalaje_adr,
					evc.peso_bruto_contenedor,
					evc.cif_propietario,
					p.nombre_comercial_propietario,
					evc.id_destinatario,
					edo.id_empresa_destino_origen,
					edo.nombre_empresa_destino_origen,
					edo.num_tarjeta_teco,
					evc.num_vagon,
					evc.pos_vagon,
					evc.pos_contenedor,
					evc.estado_carga_contenedor,
					evc.id_tipo_mercancia,
					evc.peso_bruto_contenedor,
					evc.peso_bruto_contenedor - c.tara_contenedor AS peso_mercancia_contenedor,
					evc.temperatura_contenedor,
					cs.id_salida
				FROM entrada_tipo_tren ett INNER JOIN entrada_vagon_contenedor evc ON evc.id_entrada = ett.id_entrada
					INNER JOIN tipo_mercancia tm ON tm.id_tipo_mercancia = evc.id_tipo_mercancia
						INNER JOIN propietario p ON p.cif_propietario = evc.cif_propietario
							LEFT JOIN empresa_destino_origen edo ON edo.id_empresa_destino_origen = evc.id_destinatario
								INNER JOIN contenedor c ON c.num_contenedor = evc.num_contenedor
									LEFT JOIN adr_peligro ap ON ap.num_peligro_adr = evc.num_peligro_adr
										LEFT JOIN adr_onu ao ON ao.num_onu_adr = evc.num_onu_adr
										INNER JOIN entrada e ON e.id_entrada = evc.id_entrada
                                        INNER JOIN control_stock cs ON cs.id_entrada = e.id_entrada
				WHERE ett.id_entrada = :id_entrada AND evc.num_contenedor = :num_contenedor;
			");

		$query->execute(array(
			':id_entrada' => $id_entrada,
			':num_contenedor' => $num_contenedor
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_contenedores_salida_tren_pedidos($id_cita_carga)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT lc.id_cita_carga,
				lc.num_contenedor,
				c.id_tipo_contenedor_iso,
				tci.longitud_tipo_contenedor,
				tci.descripcion_tipo_contenedor,
				c.cif_propietario_actual,
				p.nombre_comercial_propietario,
				c.peso_bruto_actual_contenedor,
				c.id_tipo_mercancia_actual_contenedor,
				tm.descripcion_mercancia,
				c.id_cita_carga_temp
				FROM ((((linea_carga lc INNER JOIN cita_carga cc ON lc.id_cita_carga = cc.id_cita_carga)
					INNER JOIN contenedor c ON c.num_contenedor = lc.num_contenedor)
						INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso)
							INNER JOIN propietario p ON p.cif_propietario = c.cif_propietario_actual)
								INNER JOIN tipo_mercancia tm ON tm.id_tipo_mercancia = c.id_tipo_mercancia_actual_contenedor
				WHERE lc.id_cita_carga = :id_cita_carga;
			");

		$query->execute(array(
			':id_cita_carga' => $id_cita_carga
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_contenedores_cita_carga_temp($id_cita_carga)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
				SELECT
					lc.id_linea_carga,
					lc.id_cita_carga,
					lc.num_contenedor,
					lc.pos_contenedor_temp,
					lc.num_vagon_temp,
					lc.pos_vagon_temp,
					c.id_tipo_contenedor_iso,
					tci.longitud_tipo_contenedor,
					tci.descripcion_tipo_contenedor,
					c.cif_propietario_actual,
					p.nombre_comercial_propietario,
					c.peso_bruto_actual_contenedor,
					c.id_tipo_mercancia_actual_contenedor,
					tm.descripcion_mercancia,
					c.id_cita_carga_temp
					FROM ((((linea_carga lc INNER JOIN cita_carga cc ON lc.id_cita_carga = cc.id_cita_carga)
						INNER JOIN contenedor c ON c.num_contenedor = lc.num_contenedor)
							INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso)
								INNER JOIN propietario p ON p.cif_propietario = c.cif_propietario_actual)
									INNER JOIN tipo_mercancia tm ON tm.id_tipo_mercancia = c.id_tipo_mercancia_actual_contenedor
					WHERE lc.id_cita_carga = :id_cita_carga AND c.id_cita_carga_temp = :id_cita_carga
					UNION
					SELECT
						lc.id_linea_carga,
						lc.id_cita_carga,
            lc.num_contenedor,
            lc.pos_contenedor_temp,
            lc.num_vagon_temp,
            lc.pos_vagon_temp,
            '' AS id_tipo_contenedor_iso,
            '' AS longitud_tipo_contenedor,
            '' AS descripcion_tipo_contenedor,
            '' AS cif_propietario_actual,
            '' AS nombre_comercial_propietario,
            '' AS peso_bruto_actual_contenedor,
            '' AS id_tipo_mercancia_actual_contenedor,
            '' AS descripcion_mercancia,
            '' AS id_cita_carga_temp
					FROM (linea_carga lc INNER JOIN cita_carga cc ON lc.id_cita_carga = cc.id_cita_carga)
					WHERE lc.id_cita_carga = :id_cita_carga AND lc.num_contenedor IS NULL;
			");

		$query->execute(array(
			':id_cita_carga' => $id_cita_carga
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_contenedor_salida_tren_pedido($id_cita_carga, $num_contenedor)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				lc.id_linea_carga,
				lc.id_cita_carga,
				lc.num_contenedor,
				lc.pos_contenedor_temp,
				lc.num_vagon_temp,
				lc.pos_vagon_temp,
				c.id_tipo_contenedor_iso,
				tci.longitud_tipo_contenedor,
				tci.descripcion_tipo_contenedor,
				c.cif_propietario_actual,
				p.nombre_comercial_propietario,
				c.peso_bruto_actual_contenedor,
				c.id_tipo_mercancia_actual_contenedor,
				tm.descripcion_mercancia,
				c.id_cita_carga_temp
				FROM ((((linea_carga lc INNER JOIN cita_carga cc ON lc.id_cita_carga = cc.id_cita_carga)
					INNER JOIN contenedor c ON c.num_contenedor = lc.num_contenedor)
						INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso)
							INNER JOIN propietario p ON p.cif_propietario = c.cif_propietario_actual)
								INNER JOIN tipo_mercancia tm ON tm.id_tipo_mercancia = c.id_tipo_mercancia_actual_contenedor
				WHERE lc.id_cita_carga = :id_cita_carga AND lc.num_contenedor = :num_contenedor;
			");

		$query->execute(array(
			':id_cita_carga' => $id_cita_carga,
			':num_contenedor' => $num_contenedor
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_no_contenedor_salida_tren_pedido(
		$id_cita_carga,
		$pos_contenedor,
		$num_vagon,
		$pos_vagon
	) {
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
				SELECT id_linea_carga, id_cita_carga, num_contenedor, pos_contenedor_temp, num_vagon_temp, pos_vagon_temp
				FROM linea_carga
				WHERE id_cita_carga = :id_cita_carga AND
					  	num_contenedor IS NULL AND
				      pos_contenedor_temp = :pos_contenedor AND
				      num_vagon_temp = :num_vagon AND
				      pos_vagon_temp = :pos_vagon;
			");

		$query->execute(array(
			':id_cita_carga' => $id_cita_carga,
			':pos_contenedor' => $pos_contenedor,
			':num_vagon' => $num_vagon,
			':pos_vagon' => $pos_vagon
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_contenedores_salida_tren_pedidos_ajax($id_cita_carga, $search)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT lc.id_cita_carga,
				lc.num_contenedor,
				c.id_tipo_contenedor_iso,
				tci.longitud_tipo_contenedor,
				tci.descripcion_tipo_contenedor,
				c.cif_propietario_actual,
				p.nombre_comercial_propietario,
				c.peso_bruto_actual_contenedor,
				c.id_tipo_mercancia_actual_contenedor,
				tm.descripcion_mercancia,
				c.id_cita_carga_temp
				FROM ((((linea_carga lc INNER JOIN cita_carga cc ON lc.id_cita_carga = cc.id_cita_carga)
					INNER JOIN contenedor c ON c.num_contenedor = lc.num_contenedor)
						INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso)
							INNER JOIN propietario p ON p.cif_propietario = c.cif_propietario_actual)
								INNER JOIN tipo_mercancia tm ON tm.id_tipo_mercancia = c.id_tipo_mercancia_actual_contenedor
				WHERE lc.id_cita_carga = :id_cita_carga AND c.id_cita_carga_temp IS NULL AND lc.num_contenedor LIKE :search
				LIMIT 10;
			");

		$query->execute(array(
			':id_cita_carga' => $id_cita_carga,
			':search' => "%" . $search . "%"
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_entrada_tipo_tren_por_id_entrada($id_entrada)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
				SELECT *
				FROM entrada_tipo_tren
				WHERE id_entrada = :id_entrada
			");

		$query->execute(array(
			':id_entrada' => $id_entrada
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_salida_tipo_tren_por_id_salida($id_salida)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
				SELECT
					stt.id_salida,
					stt.num_expedicion,
					s.fecha_salida,
					s.id_tipo_salida,
					ts.tipo_salida,
					svc.num_contenedor,
					c.cif_propietario_actual,
					p.nombre_comercial_propietario
				FROM salida_tipo_tren stt INNER JOIN salida s ON s.id_salida = stt.id_salida
				INNER JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida
				INNER JOIN salida_vagon_contenedor svc ON svc.id_salida = stt.id_salida
				INNER JOIN contenedor c ON c.num_contenedor = svc.num_contenedor
				INNER JOIN propietario p ON p.cif_propietario = c.cif_propietario_actual
				WHERE stt.id_salida = :id_salida
			");

		$query->execute(array(
			':id_salida' => $id_salida
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_salida_tipo_tren_por_id_salida2($id_salida)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
				SELECT
					stt.id_salida,
					stt.num_expedicion,
					s.fecha_salida,
					s.id_tipo_salida,
					ts.tipo_salida,
					svc.num_contenedor,
					c.cif_propietario_actual,
					p.nombre_comercial_propietario
				FROM salida_tipo_tren stt INNER JOIN salida s ON s.id_salida = stt.id_salida
				INNER JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida
				INNER JOIN salida_vagon_contenedor svc ON svc.id_salida = stt.id_salida
				INNER JOIN contenedor c ON c.num_contenedor = svc.num_contenedor
				INNER JOIN propietario p ON p.cif_propietario = c.cif_propietario_actual
				WHERE stt.id_salida = :id_salida
				GROUP BY id_salida
			");

		$query->execute(array(
			':id_salida' => $id_salida
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function contenedor_en_stock($num_contenedor)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				cs.id_control_stock,
				cs.id_ubicacion,
				cs.id_entrada,
				cs.id_salida,
				cs.num_contenedor,
				c.id_tipo_contenedor_iso,
				tci.longitud_tipo_contenedor,
				tci.descripcion_tipo_contenedor,
				c.cif_propietario_actual,
				p.nombre_comercial_propietario,
				c.peso_bruto_actual_contenedor,
				c.id_tipo_mercancia_actual_contenedor,
				tm.descripcion_mercancia,
				c.id_cita_carga_temp
			FROM (((control_stock cs INNER JOIN contenedor c ON c.num_contenedor = cs.num_contenedor)
				INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso)
					INNER JOIN propietario p ON p.cif_propietario = c.cif_propietario_actual)
						INNER JOIN tipo_mercancia tm ON tm.id_tipo_mercancia = c.id_tipo_mercancia_actual_contenedor
			WHERE cs.num_contenedor = :num_contenedor AND cs.id_salida IS NULL
		");

		$query->execute(array(
			':num_contenedor' => $num_contenedor
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function ultima_salida_contenedor($num_contenedor)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT cs.id_control_stock,
			cs.num_contenedor,
			cs.id_ubicacion,
			cs.id_entrada,
			cs.id_salida,
			s.fecha_salida,
			s.fecha_insert,
			s.fecha_insert,
			s.user_insert,
			s.id_tipo_salida,
			ts.tipo_salida,
			s.id_cita_carga
			FROM (control_stock cs INNER JOIN salida s ON cs.id_salida = s.id_salida)
				INNER JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida
			WHERE cs.num_contenedor = :num_contenedor AND s.fecha_salida IS NOT NULL
			ORDER BY s.fecha_salida DESC
			LIMIT 1;
		");

		$query->execute(array(
			':num_contenedor' => $num_contenedor
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_control_stock_por_fecha($fecha_stock)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				cs.id_control_stock,
				cs.num_contenedor,
			  c.tara_contenedor,
				c.incidencia,
			  c.id_tipo_contenedor_iso,
			  tci.longitud_tipo_contenedor,
			  tci.descripcion_tipo_contenedor,
				cs.id_entrada,
				e.fecha_entrada,
				e.id_tipo_entrada,
				te.tipo_entrada,
				cs.id_salida,
				IF(DATE(s.fecha_salida) >= :fecha_stock, NULL, s.fecha_salida) AS fecha_salida2,
				s.fecha_salida,
				s.id_tipo_salida,
				ts.tipo_salida,
				(CASE
			  	WHEN (te.tipo_entrada) = 'TREN'
						THEN (SELECT cif_propietario FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
						THEN (SELECT cif_propietario FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
						THEN (SELECT cif_propietario_actual FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS cif_propietario_actual,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
						THEN (SELECT nombre_comercial_propietario FROM entrada_vagon_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_vagon_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
						THEN (SELECT nombre_comercial_propietario FROM entrada_camion_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_camion_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
						THEN (SELECT nombre_comercial_propietario FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN propietario ON propietario.cif_propietario = traspaso.cif_propietario_actual WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS nombre_comercial_propietario,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
						THEN (SELECT estado_carga_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
						THEN (SELECT estado_carga_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
						THEN (SELECT estado_carga_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS estado_carga_contenedor,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
			     		THEN (SELECT num_expedicion FROM entrada_tipo_tren WHERE id_entrada = cs.id_entrada)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT num_expedicion FROM entrada_tipo_camion WHERE id_entrada = cs.id_entrada)
				END) AS num_expedicion_entrada,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
			     		THEN (SELECT peso_bruto_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT peso_mercancia_contenedor+c.tara_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
          WHEN (te.tipo_entrada) = 'TRASPASO'
	 			      THEN (SELECT peso_bruto_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS peso_bruto_contenedor,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
			     		THEN (SELECT peso_bruto_contenedor-c.tara_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT peso_mercancia_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
	 	 			    THEN (SELECT peso_mercancia_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS peso_mercancia_contenedor,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
			     		THEN (SELECT id_tipo_mercancia FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT id_tipo_mercancia FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				   	WHEN (te.tipo_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT id_tipo_mercancia FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS id_tipo_mercancia,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
			     		THEN (SELECT descripcion_mercancia FROM entrada_vagon_contenedor INNER JOIN tipo_mercancia ON tipo_mercancia.id_tipo_mercancia = entrada_vagon_contenedor.id_tipo_mercancia WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT descripcion_mercancia FROM entrada_camion_contenedor INNER JOIN tipo_mercancia ON tipo_mercancia.id_tipo_mercancia = entrada_camion_contenedor.id_tipo_mercancia WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT descripcion_mercancia FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN tipo_mercancia ON tipo_mercancia.id_tipo_mercancia = traspaso.id_tipo_mercancia WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS descripcion_mercancia,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
			     		THEN (SELECT id_destinatario FROM entrada_vagon_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = entrada_vagon_contenedor.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT id_destinatario FROM entrada_camion_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = entrada_camion_contenedor.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT id_destinatario FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS id_destinatario,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
			     		THEN (SELECT nombre_empresa_destino_origen FROM entrada_vagon_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = entrada_vagon_contenedor.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT nombre_empresa_destino_origen FROM entrada_camion_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = entrada_camion_contenedor.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT nombre_empresa_destino_origen FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = traspaso.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS nombre_destinatario,
				(CASE
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT num_booking_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT num_booking_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS num_booking_contenedor,
				(CASE
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT num_precinto_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT num_precinto_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS num_precinto_contenedor,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
			     		THEN (SELECT temperatura_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT temperatura_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT temperatura_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS temperatura_contenedor
			FROM (((((control_stock cs INNER JOIN entrada e ON e.id_entrada = cs.id_entrada)
				LEFT JOIN salida s ON s.id_salida = cs.id_salida)
			    	INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada)
			        	LEFT JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida)
			            	INNER JOIN contenedor c ON c.num_contenedor = cs.num_contenedor)
			                	INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso
			WHERE DATE(e.fecha_entrada) < :fecha_stock AND cs.num_contenedor NOT IN (SELECT num_contenedor FROM contenedor_generador)
			HAVING fecha_salida2 IS NULL;
		");

		$query->execute(array(
			':fecha_stock' => $fecha_stock
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_control_stock_por_fecha_por_propietario($fecha_stock, $nombre_comercial_propietario)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				cs.id_control_stock,
				cs.num_contenedor,
			  	c.tara_contenedor,
				c.incidencia,
			  	c.id_tipo_contenedor_iso,
			  	tci.longitud_tipo_contenedor,
			  	tci.descripcion_tipo_contenedor,
				cs.id_entrada,
				e.fecha_entrada,
				e.id_tipo_entrada,
				te.tipo_entrada,
				cs.id_salida,
				IF(DATE(s.fecha_salida) >= :fecha_stock, NULL, s.fecha_salida) AS fecha_salida2,
				s.fecha_salida,
				s.id_tipo_salida,
				ts.tipo_salida,
				(CASE
			  	WHEN (te.tipo_entrada) = 'TREN'
						THEN (SELECT cif_propietario FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
						THEN (SELECT cif_propietario FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
						THEN (SELECT cif_propietario_actual FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS cif_propietario_actual,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
						THEN (SELECT nombre_comercial_propietario FROM entrada_vagon_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_vagon_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
						THEN (SELECT nombre_comercial_propietario FROM entrada_camion_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_camion_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
						THEN (SELECT nombre_comercial_propietario FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN propietario ON propietario.cif_propietario = traspaso.cif_propietario_actual WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS nombre_comercial_propietario,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
						THEN (SELECT estado_carga_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
						THEN (SELECT estado_carga_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
						THEN (SELECT estado_carga_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS estado_carga_contenedor,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
			     		THEN (SELECT num_expedicion FROM entrada_tipo_tren WHERE id_entrada = cs.id_entrada)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT num_expedicion FROM entrada_tipo_camion WHERE id_entrada = cs.id_entrada)
				END) AS num_expedicion_entrada,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
			     		THEN (SELECT peso_bruto_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT peso_mercancia_contenedor+c.tara_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
         			WHEN (te.tipo_entrada) = 'TRASPASO'
	 			      THEN (SELECT peso_bruto_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS peso_bruto_contenedor,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
			     		THEN (SELECT peso_bruto_contenedor-c.tara_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT peso_mercancia_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
	 	 			    THEN (SELECT peso_mercancia_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS peso_mercancia_contenedor,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
			     		THEN (SELECT id_tipo_mercancia FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT id_tipo_mercancia FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				   	WHEN (te.tipo_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT id_tipo_mercancia FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS id_tipo_mercancia,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
			     		THEN (SELECT descripcion_mercancia FROM entrada_vagon_contenedor INNER JOIN tipo_mercancia ON tipo_mercancia.id_tipo_mercancia = entrada_vagon_contenedor.id_tipo_mercancia WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT descripcion_mercancia FROM entrada_camion_contenedor INNER JOIN tipo_mercancia ON tipo_mercancia.id_tipo_mercancia = entrada_camion_contenedor.id_tipo_mercancia WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT descripcion_mercancia FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN tipo_mercancia ON tipo_mercancia.id_tipo_mercancia = traspaso.id_tipo_mercancia WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS descripcion_mercancia,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
			     		THEN (SELECT id_destinatario FROM entrada_vagon_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = entrada_vagon_contenedor.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT id_destinatario FROM entrada_camion_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = entrada_camion_contenedor.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT id_destinatario FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS id_destinatario,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
			     		THEN (SELECT nombre_empresa_destino_origen FROM entrada_vagon_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = entrada_vagon_contenedor.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT nombre_empresa_destino_origen FROM entrada_camion_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = entrada_camion_contenedor.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT nombre_empresa_destino_origen FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = traspaso.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS nombre_destinatario,
				(CASE
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT num_booking_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT num_booking_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS num_booking_contenedor,
				(CASE
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT num_precinto_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT num_precinto_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS num_precinto_contenedor,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
			     		THEN (SELECT temperatura_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT temperatura_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT temperatura_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS temperatura_contenedor
			FROM (((((control_stock cs INNER JOIN entrada e ON e.id_entrada = cs.id_entrada)
				LEFT JOIN salida s ON s.id_salida = cs.id_salida)
			    	INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada)
			        	LEFT JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida)
			            	INNER JOIN contenedor c ON c.num_contenedor = cs.num_contenedor)
			                	INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso
			WHERE DATE(e.fecha_entrada) < :fecha_stock AND cs.num_contenedor NOT IN (SELECT num_contenedor FROM contenedor_generador)
			HAVING fecha_salida2 IS NULL AND nombre_comercial_propietario = :nombre_comercial_propietario;
		");

		$query->execute(array(
			':fecha_stock' => $fecha_stock,
			':nombre_comercial_propietario' => $nombre_comercial_propietario
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_control_stock_por_fecha_por_renfe($fecha_hoy, $num_contenedor)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				cs.id_control_stock,
				cs.num_contenedor,
			  	c.tara_contenedor,
				c.incidencia,
			  	c.id_tipo_contenedor_iso,
			  	tci.longitud_tipo_contenedor,
			  	tci.descripcion_tipo_contenedor,
				cs.id_entrada,
				e.fecha_entrada,
				e.id_tipo_entrada,
				te.tipo_entrada,
				cs.id_salida,
				#IF(DATE(s.fecha_salida) >= :fecha_hoy OR s.fecha_salida = '0000-00-00 00:00:00', NULL, s.fecha_salida) AS fecha_salida2,
				IF(DATE(s.fecha_salida) >= :fecha_hoy, NULL, s.fecha_salida) AS fecha_salida2,
				s.fecha_salida,
				s.id_tipo_salida,
				ts.tipo_salida,
				(CASE
			  	WHEN (te.tipo_entrada) = 'TREN'
						THEN (SELECT cif_propietario FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
						THEN (SELECT cif_propietario FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
						THEN (SELECT cif_propietario_actual FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS cif_propietario_actual,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
						THEN (SELECT nombre_comercial_propietario FROM entrada_vagon_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_vagon_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
						THEN (SELECT nombre_comercial_propietario FROM entrada_camion_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_camion_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
						THEN (SELECT nombre_comercial_propietario FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN propietario ON propietario.cif_propietario = traspaso.cif_propietario_actual WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS nombre_comercial_propietario,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
						THEN (SELECT estado_carga_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
						THEN (SELECT estado_carga_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
						THEN (SELECT estado_carga_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS estado_carga_contenedor,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
			     		THEN (SELECT num_expedicion FROM entrada_tipo_tren WHERE id_entrada = cs.id_entrada)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT num_expedicion FROM entrada_tipo_camion WHERE id_entrada = cs.id_entrada)
				END) AS num_expedicion_entrada,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
			     		THEN (SELECT peso_bruto_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT peso_mercancia_contenedor+c.tara_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
          			WHEN (te.tipo_entrada) = 'TRASPASO'
	 			      THEN (SELECT peso_bruto_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS peso_bruto_contenedor,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
			     		THEN (SELECT peso_bruto_contenedor-c.tara_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT peso_mercancia_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
	 	 			    THEN (SELECT peso_mercancia_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS peso_mercancia_contenedor,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
			     		THEN (SELECT id_tipo_mercancia FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT id_tipo_mercancia FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				   	WHEN (te.tipo_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT id_tipo_mercancia FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS id_tipo_mercancia,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
			     		THEN (SELECT descripcion_mercancia FROM entrada_vagon_contenedor INNER JOIN tipo_mercancia ON tipo_mercancia.id_tipo_mercancia = entrada_vagon_contenedor.id_tipo_mercancia WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT descripcion_mercancia FROM entrada_camion_contenedor INNER JOIN tipo_mercancia ON tipo_mercancia.id_tipo_mercancia = entrada_camion_contenedor.id_tipo_mercancia WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT descripcion_mercancia FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN tipo_mercancia ON tipo_mercancia.id_tipo_mercancia = traspaso.id_tipo_mercancia WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS descripcion_mercancia,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
			     		THEN (SELECT id_destinatario FROM entrada_vagon_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = entrada_vagon_contenedor.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT id_destinatario FROM entrada_camion_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = entrada_camion_contenedor.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT id_destinatario FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS id_destinatario,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
			     		THEN (SELECT nombre_empresa_destino_origen FROM entrada_vagon_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = entrada_vagon_contenedor.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT nombre_empresa_destino_origen FROM entrada_camion_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = entrada_camion_contenedor.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT nombre_empresa_destino_origen FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = traspaso.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS nombre_destinatario,
				(CASE
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT num_booking_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT num_booking_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS num_booking_contenedor,
				(CASE
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT num_precinto_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT num_precinto_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS num_precinto_contenedor,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
			     		THEN (SELECT temperatura_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT temperatura_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT temperatura_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS temperatura_contenedor
			FROM (((((control_stock cs INNER JOIN entrada e ON e.id_entrada = cs.id_entrada)
				LEFT JOIN salida s ON s.id_salida = cs.id_salida)
			    	INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada)
			        	LEFT JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida)
			            	INNER JOIN contenedor c ON c.num_contenedor = cs.num_contenedor)
			                	INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso
                                INNER JOIN tipo_mercancia tm ON tm.id_tipo_mercancia = c.id_tipo_mercancia_actual_contenedor
			WHERE DATE(e.fecha_entrada) <= :fecha_hoy AND cs.num_contenedor NOT IN (SELECT num_contenedor FROM contenedor_generador) AND
          		cs.num_contenedor = :num_contenedor AND (id_tipo_mercancia = 2)
            HAVING nombre_comercial_propietario = 'RENFE'
		");

		$query->execute(array(
			':fecha_hoy' => $fecha_hoy,
			':num_contenedor' => $num_contenedor
			//':nombre_comercial_propietario' => $nombre_comercial_propietario
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_control_stock_por_fecha_por_num_contenedor_por_propietario($fecha_hoy, $num_contenedor, $nombre_comercial_propietario)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				cs.id_control_stock,
				cs.num_contenedor,
			  	c.tara_contenedor,
				c.incidencia,
			  	c.id_tipo_contenedor_iso,
			  	tci.longitud_tipo_contenedor,
			  	tci.descripcion_tipo_contenedor,
				cs.id_entrada,
				e.fecha_entrada,
				e.id_tipo_entrada,
				te.tipo_entrada,
				cs.id_salida,
				#IF(DATE(s.fecha_salida) >= :fecha_hoy OR s.fecha_salida = '0000-00-00 00:00:00', NULL, s.fecha_salida) AS fecha_salida2,
				IF(DATE(s.fecha_salida) >= :fecha_hoy, NULL, s.fecha_salida) AS fecha_salida2,
				s.fecha_salida,
				s.id_tipo_salida,
				ts.tipo_salida,
				(CASE
			  	WHEN (te.tipo_entrada) = 'TREN'
						THEN (SELECT cif_propietario FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
						THEN (SELECT cif_propietario FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
						THEN (SELECT cif_propietario_actual FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS cif_propietario_actual,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
						THEN (SELECT nombre_comercial_propietario FROM entrada_vagon_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_vagon_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
						THEN (SELECT nombre_comercial_propietario FROM entrada_camion_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_camion_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
						THEN (SELECT nombre_comercial_propietario FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN propietario ON propietario.cif_propietario = traspaso.cif_propietario_actual WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS nombre_comercial_propietario,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
						THEN (SELECT estado_carga_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
						THEN (SELECT estado_carga_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
						THEN (SELECT estado_carga_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS estado_carga_contenedor,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
			     		THEN (SELECT num_expedicion FROM entrada_tipo_tren WHERE id_entrada = cs.id_entrada)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT num_expedicion FROM entrada_tipo_camion WHERE id_entrada = cs.id_entrada)
				END) AS num_expedicion_entrada,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
			     		THEN (SELECT peso_bruto_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT peso_mercancia_contenedor+c.tara_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
          			WHEN (te.tipo_entrada) = 'TRASPASO'
	 			      THEN (SELECT peso_bruto_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS peso_bruto_contenedor,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
			     		THEN (SELECT peso_bruto_contenedor-c.tara_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT peso_mercancia_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
	 	 			    THEN (SELECT peso_mercancia_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS peso_mercancia_contenedor,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
			     		THEN (SELECT id_tipo_mercancia FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT id_tipo_mercancia FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				   	WHEN (te.tipo_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT id_tipo_mercancia FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS id_tipo_mercancia,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
			     		THEN (SELECT descripcion_mercancia FROM entrada_vagon_contenedor INNER JOIN tipo_mercancia ON tipo_mercancia.id_tipo_mercancia = entrada_vagon_contenedor.id_tipo_mercancia WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT descripcion_mercancia FROM entrada_camion_contenedor INNER JOIN tipo_mercancia ON tipo_mercancia.id_tipo_mercancia = entrada_camion_contenedor.id_tipo_mercancia WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT descripcion_mercancia FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN tipo_mercancia ON tipo_mercancia.id_tipo_mercancia = traspaso.id_tipo_mercancia WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS descripcion_mercancia,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
			     		THEN (SELECT id_destinatario FROM entrada_vagon_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = entrada_vagon_contenedor.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT id_destinatario FROM entrada_camion_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = entrada_camion_contenedor.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT id_destinatario FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS id_destinatario,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
			     		THEN (SELECT nombre_empresa_destino_origen FROM entrada_vagon_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = entrada_vagon_contenedor.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT nombre_empresa_destino_origen FROM entrada_camion_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = entrada_camion_contenedor.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT nombre_empresa_destino_origen FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = traspaso.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS nombre_destinatario,
				(CASE
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT num_booking_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT num_booking_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS num_booking_contenedor,
				(CASE
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT num_precinto_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT num_precinto_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS num_precinto_contenedor,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
			     		THEN (SELECT temperatura_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT temperatura_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT temperatura_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS temperatura_contenedor
			FROM (((((control_stock cs INNER JOIN entrada e ON e.id_entrada = cs.id_entrada)
				LEFT JOIN salida s ON s.id_salida = cs.id_salida)
			    	INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada)
			        	LEFT JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida)
			            	INNER JOIN contenedor c ON c.num_contenedor = cs.num_contenedor)
			                	INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso
                                INNER JOIN tipo_mercancia tm ON tm.id_tipo_mercancia = c.id_tipo_mercancia_actual_contenedor
			WHERE DATE(e.fecha_entrada) <= :fecha_hoy AND cs.num_contenedor NOT IN (SELECT num_contenedor FROM contenedor_generador) AND
          		cs.num_contenedor = :num_contenedor AND (id_tipo_mercancia = 2)
            HAVING nombre_comercial_propietario = :nombre_comercial_propietario
		");

		$query->execute(array(
			':fecha_hoy' => $fecha_hoy,
			':num_contenedor' => $num_contenedor,
			':nombre_comercial_propietario' => $nombre_comercial_propietario
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_control_stock_por_fecha_por_propietario_agrupado($fecha_stock, $nombre_comercial_propietario)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
		SELECT
				fecha_stock,
			    SUM(CASE WHEN (longitud_tipo_contenedor = '20' AND estado_carga_contenedor = 'V') THEN num_contenedores ELSE 0 END) AS num_contenedores_20_v,
			    SUM(CASE WHEN (longitud_tipo_contenedor = '20' AND estado_carga_contenedor = 'C') THEN num_contenedores ELSE 0 END) AS num_contenedores_20_c,
					SUM(CASE WHEN (longitud_tipo_contenedor = '20') THEN num_contenedores ELSE 0 END) AS num_contenedores_20_total,

			    SUM(CASE WHEN (longitud_tipo_contenedor = '40' AND estado_carga_contenedor = 'V') THEN num_contenedores ELSE 0 END) AS num_contenedores_40_v,
			    SUM(CASE WHEN (longitud_tipo_contenedor = '40' AND estado_carga_contenedor = 'C') THEN num_contenedores ELSE 0 END) AS num_contenedores_40_c,
					SUM(CASE WHEN (longitud_tipo_contenedor = '40') THEN num_contenedores ELSE 0 END) AS num_contenedores_40_total,

			    SUM(CASE WHEN (longitud_tipo_contenedor = '45' AND estado_carga_contenedor = 'V') THEN num_contenedores ELSE 0 END) AS num_contenedores_45_v,
			    SUM(CASE WHEN (longitud_tipo_contenedor = '45' AND estado_carga_contenedor = 'C') THEN num_contenedores ELSE 0 END) AS num_contenedores_45_c,
					SUM(CASE WHEN (longitud_tipo_contenedor = '45') THEN num_contenedores ELSE 0 END) AS num_contenedores_45_total
			FROM (
			    SELECT
			        COUNT(*) AS num_contenedores,
			        longitud_tipo_contenedor,
			        estado_carga_contenedor,
			        :fecha_stock AS fecha_stock
			    FROM (
			        SELECT
			            cs.id_control_stock,
			            cs.num_contenedor,
			            c.tara_contenedor,
			            c.id_tipo_contenedor_iso,
			            tci.longitud_tipo_contenedor,
			            tci.descripcion_tipo_contenedor,
			            cs.id_entrada,
			            e.fecha_entrada,
			            e.id_tipo_entrada,
			            te.tipo_entrada,
			            cs.id_salida,
			            IF(DATE(s.fecha_salida) > :fecha_stock, NULL, s.fecha_salida) AS fecha_salida2,
			            s.fecha_salida,
			            s.id_tipo_salida,
			            ts.tipo_salida,
			            (CASE
			                WHEN (te.tipo_entrada) = 'TREN'
			                    THEN (SELECT cif_propietario FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
			                WHEN (te.tipo_entrada) = 'CAMIÓN'
			                    THEN (SELECT cif_propietario FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
			                WHEN (te.tipo_entrada) = 'TRASPASO'
			                    THEN (SELECT cif_propietario_actual FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
			            END) AS cif_propietario_actual,
			            (CASE
			                WHEN (te.tipo_entrada) = 'TREN'
			                    THEN (SELECT nombre_comercial_propietario FROM entrada_vagon_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_vagon_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
			                WHEN (te.tipo_entrada) = 'CAMIÓN'
			                    THEN (SELECT nombre_comercial_propietario FROM entrada_camion_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_camion_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
			                WHEN (te.tipo_entrada) = 'TRASPASO'
			                    THEN (SELECT nombre_comercial_propietario FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN propietario ON propietario.cif_propietario = traspaso.cif_propietario_actual WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
			            END) AS nombre_comercial_propietario,
			            (CASE
			                WHEN (te.tipo_entrada) = 'TREN'
			                    THEN (SELECT estado_carga_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
			                WHEN (te.tipo_entrada) = 'CAMIÓN'
			                    THEN (SELECT estado_carga_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
			                WHEN (te.tipo_entrada) = 'TRASPASO'
			                THEN (SELECT estado_carga_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
			            END) AS estado_carga_contenedor
			        FROM (((((control_stock cs INNER JOIN entrada e ON e.id_entrada = cs.id_entrada)
			            LEFT JOIN salida s ON s.id_salida = cs.id_salida)
			                INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada)
			                    LEFT JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida)
			                        INNER JOIN contenedor c ON c.num_contenedor = cs.num_contenedor)
			                            INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso
			        WHERE DATE(e.fecha_entrada) <= :fecha_stock AND cs.num_contenedor NOT IN (SELECT num_contenedor FROM contenedor_generador)
			        HAVING fecha_salida2 IS NULL AND nombre_comercial_propietario = :nombre_comercial_propietario
			    ) consulta
			    GROUP BY longitud_tipo_contenedor, estado_carga_contenedor
			) consulta2;
		");

		$query->execute(array(
			':fecha_stock' => $fecha_stock,
			':nombre_comercial_propietario' => $nombre_comercial_propietario
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_control_stock_por_fecha_por_propietario_agrupado2($fecha_stock, $nombre_comercial_propietario)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
		SELECT
				fecha_stock,
			    SUM(CASE WHEN (longitud_tipo_contenedor = '20' AND estado_carga_contenedor = 'V') THEN num_contenedores ELSE 0 END) AS num_contenedores_20_v,
			    SUM(CASE WHEN (longitud_tipo_contenedor = '20' AND estado_carga_contenedor = 'C') THEN num_contenedores ELSE 0 END) AS num_contenedores_20_c,
			    SUM(CASE WHEN (longitud_tipo_contenedor = '40' AND estado_carga_contenedor = 'V') THEN num_contenedores ELSE 0 END) AS num_contenedores_40_v,
			    SUM(CASE WHEN (longitud_tipo_contenedor = '40' AND estado_carga_contenedor = 'C') THEN num_contenedores ELSE 0 END) AS num_contenedores_40_c,
			    SUM(CASE WHEN (longitud_tipo_contenedor = '45' AND estado_carga_contenedor = 'V') THEN num_contenedores ELSE 0 END) AS num_contenedores_45_v,
			    SUM(CASE WHEN (longitud_tipo_contenedor = '45' AND estado_carga_contenedor = 'C') THEN num_contenedores ELSE 0 END) AS num_contenedores_45_c
			FROM (
			    SELECT
			        COUNT(*) AS num_contenedores,
			        longitud_tipo_contenedor,
			        estado_carga_contenedor,
			        :fecha_stock AS fecha_stock
			    FROM (
			        SELECT
			            cs.id_control_stock,
			            cs.num_contenedor,
			            c.tara_contenedor,
			            c.id_tipo_contenedor_iso,
			            tci.longitud_tipo_contenedor,
			            tci.descripcion_tipo_contenedor,
			            cs.id_entrada,
			            e.fecha_entrada,
			            e.id_tipo_entrada,
			            te.tipo_entrada,
			            cs.id_salida,
			            IF(DATE(s.fecha_salida) > :fecha_stock, NULL, s.fecha_salida) AS fecha_salida2,
			            s.fecha_salida,
			            s.id_tipo_salida,
			            ts.tipo_salida,
			            (CASE
			                WHEN (te.tipo_entrada) = 'TREN'
			                    THEN (SELECT cif_propietario FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
			                WHEN (te.tipo_entrada) = 'CAMIÓN'
			                    THEN (SELECT cif_propietario FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
			                WHEN (te.tipo_entrada) = 'TRASPASO'
			                    THEN (SELECT cif_propietario_actual FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
			            END) AS cif_propietario_actual,
			            (CASE
			                WHEN (te.tipo_entrada) = 'TREN'
			                    THEN (SELECT nombre_comercial_propietario FROM entrada_vagon_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_vagon_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
			                WHEN (te.tipo_entrada) = 'CAMIÓN'
			                    THEN (SELECT nombre_comercial_propietario FROM entrada_camion_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_camion_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
			                WHEN (te.tipo_entrada) = 'TRASPASO'
			                    THEN (SELECT nombre_comercial_propietario FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN propietario ON propietario.cif_propietario = traspaso.cif_propietario_actual WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
			            END) AS nombre_comercial_propietario,
			            (CASE
			                WHEN (te.tipo_entrada) = 'TREN'
			                    THEN (SELECT estado_carga_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
			                WHEN (te.tipo_entrada) = 'CAMIÓN'
			                    THEN (SELECT estado_carga_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
			                WHEN (te.tipo_entrada) = 'TRASPASO'
			                THEN (SELECT estado_carga_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
			            END) AS estado_carga_contenedor
			        FROM (((((control_stock cs INNER JOIN entrada e ON e.id_entrada = cs.id_entrada)
			            LEFT JOIN salida s ON s.id_salida = cs.id_salida)
			                INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada)
			                    LEFT JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida)
			                        INNER JOIN contenedor c ON c.num_contenedor = cs.num_contenedor)
			                            INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso
			        WHERE DATE(e.fecha_entrada) <= :fecha_stock AND cs.num_contenedor NOT IN (SELECT num_contenedor FROM contenedor_generador)
			        HAVING fecha_salida2 IS NULL AND nombre_comercial_propietario = :nombre_comercial_propietario
			    ) consulta
			    GROUP BY longitud_tipo_contenedor, estado_carga_contenedor
			) consulta2;
		");

		$query->execute(array(
			':fecha_stock' => $fecha_stock,
			':nombre_comercial_propietario' => $nombre_comercial_propietario
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_control_stock_por_fecha_por_cliente_agrupado($fecha_stock, $nombre_comercial_cliente)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			#COGERLO DE LA FUNCIÓN DE ARRIBA Y SUSTITUIR PROPIETARIO Y CLIENTE
		");

		$query->execute(array(
			':fecha_stock' => $fecha_stock,
			':nombre_comercial_cliente' => $nombre_comercial_cliente
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function num_contenedor_tipo_20_propietario($fecha_stock, $nombre_comercial_propietario)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
		SELECT
			fecha_stock,
			SUM(CASE WHEN (longitud_tipo_contenedor = '20' AND estado_carga_contenedor = 'V') THEN num_contenedores ELSE 0 END) AS num_contenedores_20_v,
			SUM(CASE WHEN (longitud_tipo_contenedor = '20' AND estado_carga_contenedor = 'C') THEN num_contenedores ELSE 0 END) AS num_contenedores_20_c
		FROM (
			SELECT
				COUNT(*) AS num_contenedores,
				longitud_tipo_contenedor,
				estado_carga_contenedor,
				:fecha_stock AS fecha_stock
			FROM (
				SELECT
					cs.id_control_stock,
					cs.num_contenedor,
					c.tara_contenedor,
					c.id_tipo_contenedor_iso,
					tci.longitud_tipo_contenedor,
					tci.descripcion_tipo_contenedor,
					cs.id_entrada,
					e.fecha_entrada,
					e.id_tipo_entrada,
					te.tipo_entrada,
					cs.id_salida,
					IF(DATE(s.fecha_salida) > :fecha_stock, NULL, s.fecha_salida) AS fecha_salida2,
					s.fecha_salida,
					s.id_tipo_salida,
					ts.tipo_salida,
					(CASE
						WHEN (te.tipo_entrada) = 'TREN'
							THEN (SELECT cif_propietario FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
						WHEN (te.tipo_entrada) = 'CAMIÓN'
							THEN (SELECT cif_propietario FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
						WHEN (te.tipo_entrada) = 'TRASPASO'
							THEN (SELECT cif_propietario_actual FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					END) AS cif_propietario_actual,
					(CASE
						WHEN (te.tipo_entrada) = 'TREN'
							THEN (SELECT nombre_comercial_propietario FROM entrada_vagon_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_vagon_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
						WHEN (te.tipo_entrada) = 'CAMIÓN'
							THEN (SELECT nombre_comercial_propietario FROM entrada_camion_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_camion_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
						WHEN (te.tipo_entrada) = 'TRASPASO'
							THEN (SELECT nombre_comercial_propietario FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN propietario ON propietario.cif_propietario = traspaso.cif_propietario_actual WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					END) AS nombre_comercial_propietario,
					(CASE
						WHEN (te.tipo_entrada) = 'TREN'
							THEN (SELECT estado_carga_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
						WHEN (te.tipo_entrada) = 'CAMIÓN'
							THEN (SELECT estado_carga_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
						WHEN (te.tipo_entrada) = 'TRASPASO'
						THEN (SELECT estado_carga_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					END) AS estado_carga_contenedor
				FROM (((((control_stock cs INNER JOIN entrada e ON e.id_entrada = cs.id_entrada)
					LEFT JOIN salida s ON s.id_salida = cs.id_salida)
						INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada)
							LEFT JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida)
								INNER JOIN contenedor c ON c.num_contenedor = cs.num_contenedor)
									INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso
				WHERE DATE(e.fecha_entrada) <= :fecha_stock AND cs.num_contenedor NOT IN (SELECT num_contenedor FROM contenedor_generador)
				HAVING fecha_salida2 IS NULL AND nombre_comercial_propietario = :nombre_comercial_propietario
			) consulta
			GROUP BY longitud_tipo_contenedor, estado_carga_contenedor
		) consulta2;
		");

		$query->execute(array(
			':fecha_stock' => $fecha_stock,
			':nombre_comercial_propietario' => $nombre_comercial_propietario
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function num_contenedor_tipo_40_propietario($fecha_stock, $nombre_comercial_propietario)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
		SELECT
			fecha_stock,
			SUM(CASE WHEN (longitud_tipo_contenedor = '20' AND estado_carga_contenedor = 'V') THEN num_contenedores ELSE 0 END) AS num_contenedores_40_v,
			SUM(CASE WHEN (longitud_tipo_contenedor = '20' AND estado_carga_contenedor = 'C') THEN num_contenedores ELSE 0 END) AS num_contenedores_40_c
		FROM (
			SELECT
				COUNT(*) AS num_contenedores,
				longitud_tipo_contenedor,
				estado_carga_contenedor,
				:fecha_stock AS fecha_stock
			FROM (
				SELECT
					cs.id_control_stock,
					cs.num_contenedor,
					c.tara_contenedor,
					c.id_tipo_contenedor_iso,
					tci.longitud_tipo_contenedor,
					tci.descripcion_tipo_contenedor,
					cs.id_entrada,
					e.fecha_entrada,
					e.id_tipo_entrada,
					te.tipo_entrada,
					cs.id_salida,
					IF(DATE(s.fecha_salida) > :fecha_stock, NULL, s.fecha_salida) AS fecha_salida2,
					s.fecha_salida,
					s.id_tipo_salida,
					ts.tipo_salida,
					(CASE
						WHEN (te.tipo_entrada) = 'TREN'
							THEN (SELECT cif_propietario FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
						WHEN (te.tipo_entrada) = 'CAMIÓN'
							THEN (SELECT cif_propietario FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
						WHEN (te.tipo_entrada) = 'TRASPASO'
							THEN (SELECT cif_propietario_actual FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					END) AS cif_propietario_actual,
					(CASE
						WHEN (te.tipo_entrada) = 'TREN'
							THEN (SELECT nombre_comercial_propietario FROM entrada_vagon_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_vagon_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
						WHEN (te.tipo_entrada) = 'CAMIÓN'
							THEN (SELECT nombre_comercial_propietario FROM entrada_camion_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_camion_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
						WHEN (te.tipo_entrada) = 'TRASPASO'
							THEN (SELECT nombre_comercial_propietario FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN propietario ON propietario.cif_propietario = traspaso.cif_propietario_actual WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					END) AS nombre_comercial_propietario,
					(CASE
						WHEN (te.tipo_entrada) = 'TREN'
							THEN (SELECT estado_carga_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
						WHEN (te.tipo_entrada) = 'CAMIÓN'
							THEN (SELECT estado_carga_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
						WHEN (te.tipo_entrada) = 'TRASPASO'
						THEN (SELECT estado_carga_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					END) AS estado_carga_contenedor
				FROM (((((control_stock cs INNER JOIN entrada e ON e.id_entrada = cs.id_entrada)
					LEFT JOIN salida s ON s.id_salida = cs.id_salida)
						INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada)
							LEFT JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida)
								INNER JOIN contenedor c ON c.num_contenedor = cs.num_contenedor)
									INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso
				WHERE DATE(e.fecha_entrada) <= :fecha_stock AND cs.num_contenedor NOT IN (SELECT num_contenedor FROM contenedor_generador)
				HAVING fecha_salida2 IS NULL AND nombre_comercial_propietario = :nombre_comercial_propietario
			) consulta
			GROUP BY longitud_tipo_contenedor, estado_carga_contenedor
		) consulta2;
		");

		$query->execute(array(
			':fecha_stock' => $fecha_stock,
			':nombre_comercial_propietario' => $nombre_comercial_propietario
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function num_contenedor_tipo_45_propietario($fecha_stock, $nombre_comercial_propietario)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
		SELECT
			fecha_stock,
			SUM(CASE WHEN (longitud_tipo_contenedor = '20' AND estado_carga_contenedor = 'V') THEN num_contenedores ELSE 0 END) AS num_contenedores_45_v,
			SUM(CASE WHEN (longitud_tipo_contenedor = '20' AND estado_carga_contenedor = 'C') THEN num_contenedores ELSE 0 END) AS num_contenedores_45_c
		FROM (
			SELECT
				COUNT(*) AS num_contenedores,
				longitud_tipo_contenedor,
				estado_carga_contenedor,
				:fecha_stock AS fecha_stock
			FROM (
				SELECT
					cs.id_control_stock,
					cs.num_contenedor,
					c.tara_contenedor,
					c.id_tipo_contenedor_iso,
					tci.longitud_tipo_contenedor,
					tci.descripcion_tipo_contenedor,
					cs.id_entrada,
					e.fecha_entrada,
					e.id_tipo_entrada,
					te.tipo_entrada,
					cs.id_salida,
					IF(DATE(s.fecha_salida) > :fecha_stock, NULL, s.fecha_salida) AS fecha_salida2,
					s.fecha_salida,
					s.id_tipo_salida,
					ts.tipo_salida,
					(CASE
						WHEN (te.tipo_entrada) = 'TREN'
							THEN (SELECT cif_propietario FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
						WHEN (te.tipo_entrada) = 'CAMIÓN'
							THEN (SELECT cif_propietario FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
						WHEN (te.tipo_entrada) = 'TRASPASO'
							THEN (SELECT cif_propietario_actual FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					END) AS cif_propietario_actual,
					(CASE
						WHEN (te.tipo_entrada) = 'TREN'
							THEN (SELECT nombre_comercial_propietario FROM entrada_vagon_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_vagon_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
						WHEN (te.tipo_entrada) = 'CAMIÓN'
							THEN (SELECT nombre_comercial_propietario FROM entrada_camion_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_camion_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
						WHEN (te.tipo_entrada) = 'TRASPASO'
							THEN (SELECT nombre_comercial_propietario FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN propietario ON propietario.cif_propietario = traspaso.cif_propietario_actual WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					END) AS nombre_comercial_propietario,
					(CASE
						WHEN (te.tipo_entrada) = 'TREN'
							THEN (SELECT estado_carga_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
						WHEN (te.tipo_entrada) = 'CAMIÓN'
							THEN (SELECT estado_carga_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
						WHEN (te.tipo_entrada) = 'TRASPASO'
						THEN (SELECT estado_carga_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					END) AS estado_carga_contenedor
				FROM (((((control_stock cs INNER JOIN entrada e ON e.id_entrada = cs.id_entrada)
					LEFT JOIN salida s ON s.id_salida = cs.id_salida)
						INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada)
							LEFT JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida)
								INNER JOIN contenedor c ON c.num_contenedor = cs.num_contenedor)
									INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso
				WHERE DATE(e.fecha_entrada) <= :fecha_stock AND cs.num_contenedor NOT IN (SELECT num_contenedor FROM contenedor_generador)
				HAVING fecha_salida2 IS NULL AND nombre_comercial_propietario = :nombre_comercial_propietario
			) consulta
			GROUP BY longitud_tipo_contenedor, estado_carga_contenedor
		) consulta2;
		");

		$query->execute(array(
			':fecha_stock' => $fecha_stock,
			':nombre_comercial_propietario' => $nombre_comercial_propietario
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_control_stock_por_id_entrada($id_entrada)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT id_control_stock, num_contenedor, id_ubicacion, id_entrada, id_salida
			FROM control_stock
			WHERE id_entrada = :id_entrada
		");

		$query->execute(array(
			':id_entrada' => $id_entrada
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_control_stock_por_id_salida($id_salida)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT id_control_stock, num_contenedor, id_ubicacion, id_entrada, id_salida
			FROM control_stock
			WHERE id_salida = :id_salida
		");

		$query->execute(array(
			':id_salida' => $id_salida
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function existe_contenedor($num_contenedor)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
				SELECT c.num_contenedor, c.id_tipo_contenedor_iso, tci.longitud_tipo_contenedor, tci.descripcion_tipo_contenedor, c.tara_contenedor,
				(SELECT id_entrada FROM control_stock WHERE num_contenedor = :num_contenedor ORDER BY id_entrada DESC LIMIT 1) AS id_entrada_ultimo,
				(SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = id_entrada_ultimo) AS tipo_entrada_ultimo,
				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = id_entrada_ultimo) = 'TREN' THEN (SELECT cif_propietario FROM entrada_vagon_contenedor WHERE id_entrada = id_entrada_ultimo AND num_contenedor = :num_contenedor)
				  WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = id_entrada_ultimo) = 'CAMIÓN' THEN (SELECT cif_propietario FROM entrada_camion_contenedor WHERE id_entrada = id_entrada_ultimo AND num_contenedor = :num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = id_entrada_ultimo) = 'TRASPASO' THEN (SELECT cif_propietario_actual FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = id_entrada_ultimo AND num_contenedor = :num_contenedor)
				END) AS cif_propietario_actual,
				(SELECT nombre_comercial_propietario FROM propietario WHERE cif_propietario = cif_propietario_actual) AS nombre_comercial_propietario_actual
				FROM (contenedor c INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso)
				WHERE c.num_contenedor = :num_contenedor;
		");

		$query->execute(array(
			':num_contenedor' => $num_contenedor
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_ultima_entrada_salida_control_stock_por_num_contenedor($num_contenedor)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				cs.id_control_stock,
				cs.num_contenedor,
				cs.id_entrada,
				e.fecha_entrada,
				e.id_tipo_entrada,
				te.tipo_entrada,
				cs.id_salida,
				s.fecha_salida,
				s.id_tipo_salida,
				ts.tipo_salida
			FROM (((control_stock cs INNER JOIN entrada e ON e.id_entrada = cs.id_entrada)
				LEFT JOIN salida s ON s.id_salida = cs.id_salida)
			    	INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada)
			        	LEFT JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida
			WHERE cs.num_contenedor = :num_contenedor
			ORDER BY e.fecha_entrada DESC
			LIMIT 1;
		");

		$query->execute(array(
			':num_contenedor' => $num_contenedor
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_propietarios_entrada_tren($id_entrada)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT DISTINCT p.nombre_comercial_propietario AS propietario
			FROM (((entrada_vagon_contenedor evc INNER JOIN entrada_tipo_tren ett ON evc.id_entrada = ett.id_entrada) INNER JOIN entrada e ON ett.id_entrada = e.id_entrada) INNER JOIN propietario p ON evc.cif_propietario = p.cif_propietario) INNER JOIN contenedor c ON evc.num_contenedor = c.num_contenedor
			WHERE ett.id_entrada = :id_entrada
		");

		$query->execute(array(
			':id_entrada' => $id_entrada
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_cantidad_vagones_entrada_tren($id_entrada)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT COUNT(DISTINCT evc.num_vagon) AS cantidad_vagones
			FROM (((entrada_vagon_contenedor evc INNER JOIN entrada_tipo_tren ett ON evc.id_entrada = ett.id_entrada)
				INNER JOIN entrada e ON ett.id_entrada = e.id_entrada)
					LEFT JOIN propietario p ON evc.cif_propietario = p.cif_propietario)
						LEFT JOIN contenedor c ON evc.num_contenedor = c.num_contenedor
			WHERE ett.id_entrada = :id_entrada
		");

		$query->execute(array(
			':id_entrada' => $id_entrada
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_cantidad_vagones_salida_tren($id_salida)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT COUNT(DISTINCT svc.num_vagon) AS cantidad_vagones
			FROM ((salida_vagon_contenedor svc INNER JOIN salida_tipo_tren stt ON svc.id_salida = stt.id_salida)
				INNER JOIN salida s ON stt.id_salida = s.id_salida)
					LEFT JOIN contenedor c ON svc.num_contenedor = c.num_contenedor
			WHERE stt.id_salida = :id_salida
		");

		$query->execute(array(
			':id_salida' => $id_salida
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_cantidad_contenedores_entrada_tren($id_entrada)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT COUNT(evc.num_contenedor) AS cantidad_contenedores
			FROM (((entrada_vagon_contenedor evc INNER JOIN entrada_tipo_tren ett ON evc.id_entrada = ett.id_entrada) INNER JOIN entrada e ON ett.id_entrada = e.id_entrada) INNER JOIN propietario p ON evc.cif_propietario = p.cif_propietario) INNER JOIN contenedor c ON evc.num_contenedor = c.num_contenedor
			WHERE ett.id_entrada = :id_entrada
		");

		$query->execute(array(
			':id_entrada' => $id_entrada
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_cantidad_contenedores_salida_tren($id_salida)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT COUNT(svc.num_contenedor) AS cantidad_contenedores
			FROM ((salida_vagon_contenedor svc INNER JOIN salida_tipo_tren stt ON svc.id_salida = stt.id_salida)
				INNER JOIN salida s ON stt.id_salida = s.id_salida)
						INNER JOIN contenedor c ON svc.num_contenedor = c.num_contenedor
			WHERE stt.id_salida = :id_salida
		");

		$query->execute(array(
			':id_salida' => $id_salida
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_entrada_tren_por_id_entrada($id_entrada)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
			evc.id_entrada,
			ett.num_expedicion,
			e.fecha_entrada,
			evc.num_vagon,
			evc.num_contenedor,
			c.id_tipo_contenedor_iso,
			tci.longitud_tipo_contenedor,
			tci.descripcion_tipo_contenedor,
			evc.pos_vagon,
			evc.pos_contenedor,
			evc.estado_carga_contenedor,
			evc.peso_bruto_contenedor,
			evc.tara_contenedor,
			evc.temperatura_contenedor,
			evc.id_destinatario,
			edo.nombre_empresa_destino_origen AS nombre_destinatario,
			evc.id_tipo_mercancia,
			tm.descripcion_mercancia,
			evc.num_peligro_adr,
			evc.num_onu_adr,
			evc.num_clase_adr,
			evc.cod_grupo_embalaje_adr,
			evc.cif_propietario,
			p.nombre_comercial_propietario
			FROM ((((((entrada_vagon_contenedor evc INNER JOIN entrada_tipo_tren ett ON evc.id_entrada = ett.id_entrada)
				INNER JOIN entrada e ON ett.id_entrada = e.id_entrada)
					LEFT JOIN propietario p ON evc.cif_propietario = p.cif_propietario)
						LEFT JOIN contenedor c ON evc.num_contenedor = c.num_contenedor)
							LEFT JOIN tipo_mercancia tm ON tm.id_tipo_mercancia = evc.id_tipo_mercancia)
								LEFT JOIN tipo_contenedor_iso tci ON c.id_tipo_contenedor_iso = tci.id_tipo_contenedor_iso)
									LEFT JOIN empresa_destino_origen edo ON edo.id_empresa_destino_origen = evc.id_destinatario
			WHERE ett.id_entrada = :id_entrada
			ORDER BY evc.pos_vagon, evc.pos_contenedor;
		");

		$query->execute(array(
			':id_entrada' => $id_entrada
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_salida_tren_por_id_salida($id_salida)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
			  svc.num_vagon,
			  svc.pos_vagon,
			  svc.pos_contenedor,
			  svc.num_contenedor,
			  c.id_tipo_contenedor_iso,
			  c.tara_contenedor,
			  tci.longitud_tipo_contenedor,
			  tci.descripcion_tipo_contenedor,
			  svc.id_salida,
			  stt.num_expedicion,
			  s.fecha_salida,
			  s.id_tipo_salida,
			  cs.id_control_stock,
			  cs.id_entrada,
			  e.fecha_entrada,
			  e.id_tipo_entrada,
			  te.tipo_entrada
			FROM ((((((salida_vagon_contenedor svc INNER JOIN salida_tipo_tren stt ON stt.id_salida = svc.id_salida)
				INNER JOIN salida s ON s.id_salida = stt.id_salida)
			    	LEFT JOIN control_stock cs ON cs.num_contenedor = svc.num_contenedor AND cs.id_salida = :id_salida)
			        	LEFT JOIN entrada e ON cs.id_entrada = e.id_entrada)
			            	LEFT JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada)
			                	LEFT JOIN contenedor c ON c.num_contenedor = cs.num_contenedor)
			                    	LEFT JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso
			WHERE svc.id_salida = :id_salida
			ORDER BY svc.pos_vagon, svc.pos_contenedor;
		");

		$query->execute(array(
			':id_salida' => $id_salida
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_entrada_camion_por_id_entrada($id_entrada)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				e.id_entrada,
				e.fecha_entrada,
				e.id_tipo_entrada,
				te.tipo_entrada,
				etc.num_expedicion,
				etc.cif_empresa_transportista,
				et.nombre_empresa_transportista,
				etc.matricula_tractora,
				etc.matricula_remolque,
				etc.dni_conductor,
				c.nombre_conductor,
				c.apellidos_conductor,
				etc.id_origen,
				ot.nombre_origen,
				etc.id_destino,
				dt.nombre_destino,
				etc.observaciones,
				ecc.num_contenedor,
				con.id_tipo_contenedor_iso,
				con.tara_contenedor,
				tci.longitud_tipo_contenedor,
				tci.descripcion_tipo_contenedor,
				tci.descripcion_tipo_contenedor,
				ecc.cif_propietario,
				p.nombre_propietario,
				p.nombre_comercial_propietario,
				ecc.id_destinatario,
				edo.nombre_empresa_destino_origen AS nombre_destinatario,
				edo.num_tarjeta_teco,
				ecc.estado_carga_contenedor,
				ecc.peso_mercancia_contenedor,
				ecc.num_booking_contenedor,
				ecc.num_precinto_contenedor,
				ecc.temperatura_contenedor,
				ecc.id_tipo_mercancia,
				tm.descripcion_mercancia,
				ecc.num_peligro_adr,
				ap.descripcion_peligro_adr,
				ecc.num_onu_adr,
				ao.descripcion_onu_adr,
				ecc.num_clase_adr,
				ecc.cod_grupo_embalaje_adr,
				ecc.codigo_estacion_ferrocarril
			FROM (((((((((((((entrada e INNER JOIN entrada_tipo_camion etc ON e.id_entrada = etc.id_entrada)
				INNER JOIN entrada_camion_contenedor ecc ON ecc.id_entrada = etc.id_entrada)
					INNER JOIN propietario p ON p.cif_propietario = ecc.cif_propietario)
						INNER JOIN empresa_transportista et ON et.cif_empresa_transportista = etc.cif_empresa_transportista)
							INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada)
								INNER JOIN conductor c ON c.dni_conductor = etc.dni_conductor)
									LEFT JOIN empresa_destino_origen edo ON edo.id_empresa_destino_origen = ecc.id_destinatario)
										INNER JOIN tipo_mercancia tm ON tm.id_tipo_mercancia = ecc.id_tipo_mercancia)
											LEFT JOIN adr_onu ao ON ao.num_onu_adr = ecc.num_onu_adr)
												INNER JOIN contenedor con ON con.num_contenedor = ecc.num_contenedor)
													INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = con.id_tipo_contenedor_iso)
														LEFT JOIN adr_peligro ap ON ap.num_peligro_adr = ecc.num_peligro_adr)
															LEFT JOIN origen_tren ot ON ot.id_origen = etc.id_origen)
																LEFT JOIN destino_tren dt ON dt.id_destino = etc.id_destino
			WHERE e.id_entrada = :id_entrada;
		");

		$query->execute(array(
			':id_entrada' => $id_entrada
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_salida_camion_por_id_salida($id_salida)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
		SELECT
			scc.id_salida,
			s.fecha_salida,
			s.id_tipo_salida,
			stc.num_expedicion AS num_expedicion_salida,
			stc.cif_empresa_transportista,
			et.nombre_empresa_transportista,
			stc.matricula_tractora,
			stc.matricula_remolque,
			stc.dni_conductor,
			cond.nombre_conductor,
			cond.apellidos_conductor,
			stc.id_origen,
			ot.nombre_origen,
			stc.id_destino,
			dt.nombre_destino,
			stc.observaciones,
			scc.num_contenedor,
			(CASE
				WHEN (te.tipo_entrada) = 'TREN'
					THEN (SELECT estado_carga_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				WHEN (te.tipo_entrada) = 'CAMIÓN'
					THEN (SELECT estado_carga_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				WHEN (te.tipo_entrada) = 'TRASPASO'
					THEN (SELECT estado_carga_contenedor FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
			END) AS estado_carga_contenedor,
			c.id_tipo_contenedor_iso,
			c.tara_contenedor,
			tci.longitud_tipo_contenedor,
			tci.descripcion_tipo_contenedor,
			scc.temperatura_contenedor,
			scc.id_destinatario,
			edo.nombre_empresa_destino_origen AS nombre_destinatario,
			edo.num_tarjeta_teco,
			cs.id_control_stock,
		  cs.id_entrada,
		  e.fecha_entrada,
		  e.id_tipo_entrada,
			te.tipo_entrada,
			(CASE
				WHEN (te.tipo_entrada) = 'TREN'
					THEN (SELECT propietario.cif_propietario FROM entrada_vagon_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_vagon_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				WHEN (te.tipo_entrada) = 'CAMIÓN'
					THEN (SELECT propietario.cif_propietario FROM entrada_camion_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_camion_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				WHEN (te.tipo_entrada) = 'TRASPASO'
					THEN (SELECT propietario.cif_propietario FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN propietario ON propietario.cif_propietario = traspaso.cif_propietario_actual WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
			END) AS cif_propietario
		FROM (((((((((((salida_camion_contenedor scc INNER JOIN salida_tipo_camion stc ON stc.id_salida = scc.id_salida)
			INNER JOIN salida s ON s.id_salida = stc.id_salida)
		  	INNER JOIN control_stock cs ON cs.num_contenedor = scc.num_contenedor AND cs.id_salida = :id_salida)
		    	INNER JOIN entrada e ON cs.id_entrada = e.id_entrada)
		      	INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada)
		        	INNER JOIN contenedor c ON c.num_contenedor = cs.num_contenedor)
		          	INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso)
		        			INNER JOIN empresa_transportista et ON et.cif_empresa_transportista = stc.cif_empresa_transportista)
                  	INNER JOIN conductor cond ON cond.dni_conductor = stc.dni_conductor)
											LEFT JOIN empresa_destino_origen edo ON edo.id_empresa_destino_origen = scc.id_destinatario)
												LEFT JOIN origen_tren ot ON ot.id_origen = stc.id_origen)
													LEFT JOIN destino_tren dt ON dt.id_destino = stc.id_destino
					WHERE scc.id_salida = :id_salida;

		");

		$query->execute(array(
			':id_salida' => $id_salida
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_entrada_traspaso_por_id_entrada($id_entrada)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				t.id_traspaso,
				t.fecha_traspaso,
			  t.num_contenedor,
				t.estado_carga_contenedor,
				t.id_tipo_mercancia,
				tm.descripcion_mercancia,
				t.peso_mercancia_contenedor,
				t.temperatura_contenedor,
				t.num_booking_contenedor,
				t.num_precinto_contenedor,
				c.tara_contenedor,
				c.id_tipo_contenedor_iso,
				tci.longitud_tipo_contenedor,
				tci.descripcion_tipo_contenedor,
				t.cif_propietario_anterior,
				(SELECT nombre_comercial_propietario FROM propietario WHERE cif_propietario = t.cif_propietario_anterior) AS nombre_comercial_propietario_anterior,
				t.cif_propietario_actual,
				(SELECT nombre_comercial_propietario FROM propietario WHERE cif_propietario = t.cif_propietario_actual) AS nombre_comercial_propietario_actual,
				stt.id_salida,
				cs.id_entrada,
				e.fecha_entrada,
				e.id_tipo_entrada,
				te.tipo_entrada
			FROM (((((((traspaso t INNER JOIN salida_tipo_traspaso stt ON stt.id_traspaso = t.id_traspaso)
				INNER JOIN entrada_tipo_traspaso ett ON ett.id_traspaso = t.id_traspaso)
					INNER JOIN control_stock cs ON cs.id_salida = stt.id_salida AND cs.num_contenedor = t.num_contenedor)
			    	INNER JOIN entrada e ON cs.id_entrada = e.id_entrada)
			      	INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada)
								INNER JOIN contenedor c ON c.num_contenedor = t.num_contenedor)
									INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso)
										INNER JOIN tipo_mercancia tm ON tm.id_tipo_mercancia = t.id_tipo_mercancia
			WHERE ett.id_entrada = :id_entrada;
		");

		$query->execute(array(
			':id_entrada' => $id_entrada
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_entrada_transbordo_por_id_entrada($id_entrada)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				t.id_transbordo,
				t.fecha_transbordo,
				t.num_contenedor_origen,
				t.num_contenedor_destino,
				stt.id_salida,
				stt.id_transbordo,
				ett.id_entrada,
				ett.id_transbordo,
				e.id_entrada,
				e.fecha_entrada,
				e.fecha_insert,
				e.user_insert,
				e.id_tipo_entrada,
				e.id_cita_descarga,
				te.id_tipo_entrada,
				te.tipo_entrada,
				c.num_contenedor,
				c.id_tipo_contenedor_iso,
				c.tara_contenedor,
				c.estado_carga_contenedor,
				c.peso_bruto_actual_contenedor,
				c.peso_mercancia_actual_contenedor,
				c.num_booking_actual_contenedor,
				c.num_precinto_actual_contenedor,
				c.temperatura_actual_contenedor,
				c.id_tipo_mercancia_actual_contenedor,
				c.num_peligro_adr_actual_contenedor,
				c.num_onu_adr_actual_contenedor,
				c.num_clase_adr_actual_contenedor,
				c.cod_grupo_embalaje_adr_actual_contenedor,
				c.cif_propietario_actual,
				c.codigo_estacion_ferrocarril_actual_contenedor,
				c.id_destinatario_actual,
				c.id_cita_carga_temp,
				c.incidencia,
				tci.id_tipo_contenedor_iso,
				tci.longitud_tipo_contenedor,
				tci.descripcion_tipo_contenedor,
				tci.tara_contenedor
			FROM transbordo t INNER JOIN salida_tipo_transbordo stt ON stt.id_transbordo = t.id_transbordo
				INNER JOIN entrada_tipo_transbordo ett ON ett.id_transbordo = t.id_transbordo
                INNER JOIN control_stock cs ON cs.id_salida = stt.id_salida AND cs.num_contenedor = t.num_contenedor_origen
				INNER JOIN entrada e ON cs.id_entrada = e.id_entrada
				INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada
				INNER JOIN contenedor c ON c.num_contenedor = t.num_contenedor_origen
				INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso
				WHERE ett.id_entrada = :id_entrada;
		");

		$query->execute(array(
			':id_entrada' => $id_entrada
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_salida_transbordo_por_id_salida($id_salida)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				t.id_transbordo,
				t.fecha_transbordo,
				t.num_contenedor_origen,
				t.num_contenedor_destino,
				stt.id_salida,
				stt.id_transbordo,
				ett.id_entrada,
				ett.id_transbordo,
				e.id_entrada,
				e.fecha_entrada,
				e.fecha_insert,
				e.user_insert,
				e.id_tipo_entrada,
				e.id_cita_descarga,
				te.id_tipo_entrada,
				te.tipo_entrada,
				c.num_contenedor,
				c.id_tipo_contenedor_iso,
				c.tara_contenedor,
				c.estado_carga_contenedor,
				c.peso_bruto_actual_contenedor,
				c.peso_mercancia_actual_contenedor,
				c.num_booking_actual_contenedor,
				c.num_precinto_actual_contenedor,
				c.temperatura_actual_contenedor,
				c.id_tipo_mercancia_actual_contenedor,
				c.num_peligro_adr_actual_contenedor,
				c.num_onu_adr_actual_contenedor,
				c.num_clase_adr_actual_contenedor,
				c.cod_grupo_embalaje_adr_actual_contenedor,
				c.cif_propietario_actual,
				c.codigo_estacion_ferrocarril_actual_contenedor,
				c.id_destinatario_actual,
				c.id_cita_carga_temp,
				c.incidencia,
				tci.id_tipo_contenedor_iso,
				tci.longitud_tipo_contenedor,
				tci.descripcion_tipo_contenedor,
				tci.tara_contenedor
			FROM transbordo t INNER JOIN salida_tipo_transbordo stt ON stt.id_transbordo = t.id_transbordo
				INNER JOIN entrada_tipo_transbordo ett ON ett.id_transbordo = t.id_transbordo
                INNER JOIN control_stock cs ON cs.id_salida = stt.id_salida AND cs.num_contenedor = t.num_contenedor_origen
				INNER JOIN entrada e ON cs.id_entrada = e.id_entrada
				INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada
				INNER JOIN contenedor c ON c.num_contenedor = t.num_contenedor_origen
				INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso
				WHERE stt.id_salida = :id_salida;
		");

		$query->execute(array(
			':id_salida' => $id_salida
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_salida_traspaso_por_id_salida($id_salida)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				t.id_traspaso,
				t.fecha_traspaso,
			  	t.num_contenedor,
				c.tara_contenedor,
				c.id_tipo_contenedor_iso,
				tci.longitud_tipo_contenedor,
				tci.descripcion_tipo_contenedor,
				t.cif_propietario_anterior,
				(SELECT nombre_comercial_propietario FROM propietario WHERE cif_propietario = t.cif_propietario_anterior) AS nombre_comercial_propietario_anterior,
				t.cif_propietario_actual,
				(SELECT nombre_comercial_propietario FROM propietario WHERE cif_propietario = t.cif_propietario_actual) AS nombre_comercial_propietario_actual,
				stt.id_salida,
				cs.id_entrada,
				e.fecha_entrada,
				e.id_tipo_entrada,
				te.tipo_entrada
			FROM ((((((traspaso t INNER JOIN salida_tipo_traspaso stt ON stt.id_traspaso = t.id_traspaso)
				INNER JOIN entrada_tipo_traspaso ett ON ett.id_traspaso = t.id_traspaso)
					INNER JOIN control_stock cs ON cs.id_salida = stt.id_salida AND cs.num_contenedor = t.num_contenedor)
			    	INNER JOIN entrada e ON cs.id_entrada = e.id_entrada)
			      	INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada)
								INNER JOIN contenedor c ON c.num_contenedor = t.num_contenedor)
									INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso
			WHERE stt.id_salida = :id_salida;
		");

		$query->execute(array(
			':id_salida' => $id_salida
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_empresas_transportistas_ajax($search)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
		SELECT cif_empresa_transportista, nombre_empresa_transportista
		FROM empresa_transportista
		WHERE nombre_empresa_transportista LIKE :search
		ORDER BY nombre_empresa_transportista
		LIMIT 10;
		");

		$query->execute(array(
			':search' => "%" . $search . "%"
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_empresa_transportista_por_cif($cif_empresa_transportista)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT cif_empresa_transportista, nombre_empresa_transportista, direccion_empresa_transportista
			FROM empresa_transportista
			WHERE cif_empresa_transportista = :cif_empresa_transportista;
		");

		$query->execute(array(
			':cif_empresa_transportista' => $cif_empresa_transportista
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_contenedores_stock_ajax($search)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				cs.num_contenedor,
				c.id_tipo_contenedor_iso,
				cs.id_control_stock,
				cs.id_ubicacion,
				cs.id_entrada,
				cs.id_salida,
				c.tara_contenedor,
				c.estado_carga_contenedor,
				c.peso_bruto_actual_contenedor,
				c.temperatura_actual_contenedor,
				c.id_tipo_mercancia_actual_contenedor,
				tm.descripcion_mercancia,
				c.cif_propietario_actual,
				p.nombre_comercial_propietario,
				c.id_destinatario_actual,
				edo.nombre_empresa_destino_origen,
				edo.num_tarjeta_teco
			FROM (((control_stock cs INNER JOIN contenedor c ON c.num_contenedor = cs.num_contenedor)
			      	INNER JOIN propietario p ON p.cif_propietario = c.cif_propietario_actual)
			        	LEFT JOIN empresa_destino_origen edo ON edo.id_empresa_destino_origen = c.id_destinatario_actual)
			            	INNER JOIN tipo_mercancia tm ON tm.id_tipo_mercancia = c.id_tipo_mercancia_actual_contenedor
			WHERE cs.id_salida IS NULL AND cs.num_contenedor LIKE :search AND cs.num_contenedor NOT IN (SELECT num_contenedor FROM contenedor_generador)
			ORDER BY cs.num_contenedor
			LIMIT 10;
		");

		$query->execute(array(
			':search' => "%" . $search . "%"
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_contenedores_stock_noIncidencia_vacio_ajax($search, $nombre_comercial_propietario)
	{
		$this->result = [];
		$query = $this->conexion->prepare("
			SELECT
				cs.num_contenedor,
				c.id_tipo_contenedor_iso,
				cs.id_control_stock,
				cs.id_ubicacion,
				cs.id_entrada,
				cs.id_salida,
				c.tara_contenedor,
				c.estado_carga_contenedor,
				c.peso_bruto_actual_contenedor,
				c.temperatura_actual_contenedor,
				c.id_tipo_mercancia_actual_contenedor,
				tm.descripcion_mercancia,
				c.cif_propietario_actual,
				p.nombre_comercial_propietario AS nombre_comercial_propietario,
				c.id_destinatario_actual,
				edo.nombre_empresa_destino_origen,
				edo.num_tarjeta_teco
			FROM
				control_stock cs
			INNER JOIN contenedor c ON c.num_contenedor = cs.num_contenedor
			INNER JOIN propietario p ON p.cif_propietario = c.cif_propietario_actual
			LEFT JOIN empresa_destino_origen edo ON edo.id_empresa_destino_origen = c.id_destinatario_actual
			INNER JOIN tipo_mercancia tm ON tm.id_tipo_mercancia = c.id_tipo_mercancia_actual_contenedor
			WHERE cs.id_salida IS NULL
			AND c.estado_carga_contenedor = 'V'
			AND p.nombre_comercial_propietario = :nombre_comercial_propietario
			AND cs.num_contenedor LIKE :search
			AND cs.num_contenedor NOT IN (SELECT num_contenedor FROM contenedor_generador)
			AND cs.num_contenedor NOT IN (SELECT num_contenedor FROM contenedor WHERE incidencia IS NOT NULL)
			ORDER BY cs.num_contenedor
			LIMIT 10;
    ");

		$query->execute([
			':search' => "%" . $search . "%",
			':nombre_comercial_propietario' => $nombre_comercial_propietario
		]);

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		$query = null;
		return $this->result;
	}

	public function get_contenedores_stock_ajax_incidencia($search)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				cs.num_contenedor,
				c.id_tipo_contenedor_iso,
				cs.id_control_stock,
				cs.id_ubicacion,
				cs.id_entrada,
				cs.id_salida,
				c.tara_contenedor,
				c.estado_carga_contenedor,
				c.peso_bruto_actual_contenedor,
				c.temperatura_actual_contenedor,
				c.id_tipo_mercancia_actual_contenedor,
				tm.descripcion_mercancia,
				c.cif_propietario_actual,
				p.nombre_comercial_propietario,
				c.id_destinatario_actual,
				edo.nombre_empresa_destino_origen,
				edo.num_tarjeta_teco
			FROM (((control_stock cs INNER JOIN contenedor c ON c.num_contenedor = cs.num_contenedor)
			      	INNER JOIN propietario p ON p.cif_propietario = c.cif_propietario_actual)
			        	LEFT JOIN empresa_destino_origen edo ON edo.id_empresa_destino_origen = c.id_destinatario_actual)
			            	INNER JOIN tipo_mercancia tm ON tm.id_tipo_mercancia = c.id_tipo_mercancia_actual_contenedor
			WHERE cs.id_salida IS NULL AND cs.num_contenedor LIKE :search
			ORDER BY cs.num_contenedor AND cs.num_contenedor NOT IN (SELECT num_contenedor FROM contenedor_generador UNION SELECT i_c.num_contenedor FROM incidencia_contenedor i_c INNER JOIN incidencia i ON i.id_incidencia = i_c.id_incidencia WHERE i_c.num_contenedor = cs.num_contenedor AND i.id_tipo_incidencia = 3 AND i_c.id_entrada = cs.id_entrada)
			LIMIT 10;
		");

		$query->execute(array(
			':search' => "%" . $search . "%"
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_contenedores_stock_danado_cargado_ajax_incidencia($search)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				cs.num_contenedor,
				c.id_tipo_contenedor_iso,
				cs.id_control_stock,
				cs.id_ubicacion,
				cs.id_entrada,
				cs.id_salida,
				c.tara_contenedor,
				c.estado_carga_contenedor,
				c.peso_bruto_actual_contenedor,
				c.temperatura_actual_contenedor,
				c.id_tipo_mercancia_actual_contenedor,
				tm.descripcion_mercancia,
				c.cif_propietario_actual,
				p.nombre_comercial_propietario,
				c.id_destinatario_actual,
				edo.nombre_empresa_destino_origen,
				edo.num_tarjeta_teco,
				tci.longitud_tipo_contenedor,
				tci.descripcion_tipo_contenedor,
				tci.tara_contenedor
			FROM (((control_stock cs INNER JOIN contenedor c ON c.num_contenedor = cs.num_contenedor)
			      	INNER JOIN propietario p ON p.cif_propietario = c.cif_propietario_actual)
			        	LEFT JOIN empresa_destino_origen edo ON edo.id_empresa_destino_origen = c.id_destinatario_actual)
			            	INNER JOIN tipo_mercancia tm ON tm.id_tipo_mercancia = c.id_tipo_mercancia_actual_contenedor
								INNER JOIN tipo_contenedor_iso tci ON  tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso
									INNER JOIN incidencia_contenedor i_c ON i_c.num_contenedor = cs.num_contenedor
			WHERE cs.id_salida IS NULL AND c.estado_carga_contenedor = 'C' AND cs.num_contenedor LIKE :search
			ORDER BY cs.num_contenedor AND cs.num_contenedor NOT IN (SELECT num_contenedor FROM contenedor_generador)
			LIMIT 10;
		");

		$query->execute(array(
			':search' => "%" . $search . "%"
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_tipos_daños_utis()
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				tdu.id_tipo_daño_uti,
				tdu.tipo_daño_uti
			FROM tipo_daño_uti tdu
			#WHERE tdu.tipo_daño_uti LIKE :search
		");

		$query->execute(array(
			//':search' => "%" . $search . "%"
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_contenedores()
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				c.num_contenedor,
				c.id_tipo_contenedor_iso,
				tci.longitud_tipo_contenedor,
				tci.descripcion_tipo_contenedor,
				c.tara_contenedor,
				c.cif_propietario_actual,
				p.nombre_comercial_propietario
			FROM (contenedor c INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso)
	                INNER JOIN propietario p  ON p.cif_propietario = c.cif_propietario_actual
			ORDER BY c.num_contenedor;
		");

		$query->execute(array());

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_num_contenedores_total_entrada()
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
		SELECT
			SUM(contenedor_tren) AS contenedor_tren,
			SUM(contenedor_camion) AS contenedor_camion,
			SUM(contenedor_tren + contenedor_camion) AS total_contenedores
		FROM (
			SELECT
				COUNT(evc.num_contenedor) AS contenedor_tren,
				0 AS contenedor_camion
			FROM entrada_vagon_contenedor evc
			INNER JOIN entrada e ON e.id_entrada = evc.id_entrada
			WHERE evc.num_contenedor IS NOT NULL AND e.id_entrada IS NOT NULL
			GROUP BY YEAR(e.fecha_entrada), MONTH(e.fecha_entrada)

			UNION ALL

			SELECT
				0 AS contenedor_tren,
				COUNT(ecc.num_contenedor) AS contenedor_camion
			FROM entrada_camion_contenedor ecc
			INNER JOIN entrada e ON e.id_entrada = ecc.id_entrada
			WHERE ecc.num_contenedor IS NOT NULL AND e.id_entrada IS NOT NULL
			GROUP BY YEAR(e.fecha_entrada), MONTH(e.fecha_entrada)
		) AS merged_results;
		");

		$query->execute(array());

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_contenedores_total_entrada_por_fecha_por_propietario($fecha_entrada, $nombre_comercial_propietario)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				:fecha_entrada AS fecha_entrada,
			  IFNULL(SUM(CASE WHEN (longitud_tipo_contenedor = '20') THEN num_contenedores ELSE 0 END), 0) AS num_contenedores_entrada_20,
			  IFNULL(SUM(CASE WHEN (longitud_tipo_contenedor = '40') THEN num_contenedores ELSE 0 END), 0) AS num_contenedores_entrada_40,
			  IFNULL(SUM(CASE WHEN (longitud_tipo_contenedor = '45') THEN num_contenedores ELSE 0 END), 0) AS num_contenedores_entrada_45
			FROM (
				SELECT COUNT(num_contenedor) AS num_contenedores, longitud_tipo_contenedor, DATE(fecha_entrada) AS fecha_entrada, nombre_comercial_propietario
				FROM (
					SELECT cs.num_contenedor,
						cs.id_entrada,
					  e.fecha_entrada,
					  tci.longitud_tipo_contenedor,
		        (CASE
		            WHEN (te.tipo_entrada) = 'TREN'
		                THEN (SELECT nombre_comercial_propietario FROM entrada_vagon_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_vagon_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
		            WHEN (te.tipo_entrada) = 'CAMIÓN'
		                THEN (SELECT nombre_comercial_propietario FROM entrada_camion_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_camion_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
		            WHEN (te.tipo_entrada) = 'TRASPASO'
		                THEN (SELECT nombre_comercial_propietario FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN propietario ON propietario.cif_propietario = traspaso.cif_propietario_actual WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
		        END) AS nombre_comercial_propietario
					FROM (((control_stock cs INNER JOIN entrada e ON cs.id_entrada = e.id_entrada)
						INNER JOIN contenedor c ON c.num_contenedor = cs.num_contenedor)
					    	INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso)
					        	INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada
					WHERE DATE(e.fecha_entrada) = :fecha_entrada AND cs.num_contenedor NOT IN (SELECT num_contenedor FROM contenedor_generador)
					HAVING nombre_comercial_propietario = :nombre_comercial_propietario
				) consulta
				GROUP BY longitud_tipo_contenedor
			) consulta2;
		");

		$query->execute(array(
			':fecha_entrada' => $fecha_entrada,
			':nombre_comercial_propietario' => $nombre_comercial_propietario
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_contenedores_total_salida_por_fecha_por_propietario($fecha_salida, $nombre_comercial_propietario)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				:fecha_salida AS fecha_salida,
				IFNULL(SUM(CASE WHEN (longitud_tipo_contenedor = '20') THEN num_contenedores ELSE 0 END), 0) AS num_contenedores_salida_20,
				IFNULL(SUM(CASE WHEN (longitud_tipo_contenedor = '40') THEN num_contenedores ELSE 0 END), 0) AS num_contenedores_salida_40,
				IFNULL(SUM(CASE WHEN (longitud_tipo_contenedor = '45') THEN num_contenedores ELSE 0 END), 0) AS num_contenedores_salida_45
			FROM (
				SELECT
			    	COUNT(num_contenedor) AS num_contenedores,
			    	longitud_tipo_contenedor,
			    	DATE(fecha_salida) AS fecha_salida,
			    	nombre_comercial_propietario
				FROM (
					SELECT
			    	cs.num_contenedor,
			      cs.id_salida,
			      s.fecha_salida,
			      tci.longitud_tipo_contenedor,
						(CASE
								WHEN (te.tipo_entrada) = 'TREN'
									THEN (SELECT nombre_comercial_propietario FROM entrada_vagon_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_vagon_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
								WHEN (te.tipo_entrada) = 'CAMIÓN'
									THEN (SELECT nombre_comercial_propietario FROM entrada_camion_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_camion_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
								WHEN (te.tipo_entrada) = 'TRASPASO'
									THEN (SELECT nombre_comercial_propietario FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN propietario ON propietario.cif_propietario = traspaso.cif_propietario_actual WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
						END) AS nombre_comercial_propietario
						FROM (((((control_stock cs INNER JOIN entrada e ON e.id_entrada = cs.id_entrada)
							INNER JOIN salida s ON s.id_salida = cs.id_salida)
						    	INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada)
						        	LEFT JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida)
						            	INNER JOIN contenedor c ON c.num_contenedor = cs.num_contenedor)
						                	INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso
			        WHERE DATE(s.fecha_salida) = :fecha_salida AND cs.num_contenedor NOT IN (SELECT num_contenedor FROM contenedor_generador)
			        HAVING nombre_comercial_propietario = :nombre_comercial_propietario
			   ) consulta
			     GROUP BY longitud_tipo_contenedor
			) consulta2;
		");

		$query->execute(array(
			':fecha_salida' => $fecha_salida,
			':nombre_comercial_propietario' => $nombre_comercial_propietario
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_num_contenedores_total_salida()
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
		SELECT
			SUM(contenedor_tren) AS contenedor_tren,
			SUM(contenedor_camion) AS contenedor_camion,
			SUM(contenedor_tren + contenedor_camion) AS total_contenedores
		FROM (
			SELECT
				COUNT(svc.num_contenedor) AS contenedor_tren,
				0 AS contenedor_camion
			FROM salida_vagon_contenedor svc
			INNER JOIN salida s ON s.id_salida = svc.id_salida
			WHERE svc.num_contenedor IS NOT NULL AND s.id_salida IS NOT NULL
			GROUP BY YEAR(s.fecha_salida), MONTH(s.fecha_salida)

			UNION ALL

			SELECT
				0 AS contenedor_tren,
				COUNT(scc.num_contenedor) AS contenedor_camion
			FROM salida_camion_contenedor scc
			INNER JOIN salida s ON s.id_salida = scc.id_salida
			WHERE scc.num_contenedor IS NOT NULL AND s.id_salida IS NOT NULL
			GROUP BY YEAR(s.fecha_salida), MONTH(s.fecha_salida)
		) AS merged_results;
		");

		$query->execute(array());

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_generadores_por_propietario($cif_propietario)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				cg.num_vagon,
			  cg.pos_vagon,
			  cg.pos_contenedor,
			  cg.num_contenedor,
			  c.id_tipo_contenedor_iso AS tipo_contenedor_iso,
			  c.tara_contenedor,
			  c.estado_carga_contenedor AS vacio_cargado_contenedor,
			  c.peso_bruto_actual_contenedor AS peso_bruto_contenedor,
			  c.temperatura_actual_contenedor AS temperatura_contenedor,
			  p.nombre_comercial_propietario AS nombre_comercial_propietario,
			  c.num_peligro_adr_actual_contenedor AS num_peligro_adr,
			  c.num_onu_adr_actual_contenedor AS num_onu_adr,
			  c.num_clase_adr_actual_contenedor AS num_clase_adr,
			  c.cod_grupo_embalaje_adr_actual_contenedor AS cod_grupo_embalaje_adr,
			  '' AS destinatario
			FROM (contenedor_generador cg INNER JOIN contenedor c ON cg.num_contenedor = c.num_contenedor)
				INNER JOIN propietario p ON c.cif_propietario_actual = p.cif_propietario
			WHERE c.cif_propietario_actual = :cif_propietario AND cg.baja = 0
		");

		$query->execute(array(
			':cif_propietario' => $cif_propietario
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_contenedores_total_entrada($year, $month)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
		SELECT
			año,
			mes,
			SUM(contenedor_tren) AS contenedor_tren,
			CONCAT(año, '-', mes) AS año_mes,
			SUM(contenedor_camion) AS contenedor_camion,
			SUM(contenedor_tren + contenedor_camion) AS total_contenedores
		FROM (
			SELECT
				YEAR(e.fecha_entrada) AS año,
				MONTH(e.fecha_entrada) AS mes,
				COUNT(evc.num_contenedor) AS contenedor_tren,
				0 AS contenedor_camion
			FROM entrada_vagon_contenedor evc
			INNER JOIN entrada e ON e.id_entrada = evc.id_entrada
			WHERE evc.num_contenedor IS NOT NULL AND e.id_entrada IS NOT NULL
			GROUP BY YEAR(e.fecha_entrada), MONTH(e.fecha_entrada)

			UNION ALL

			SELECT
				YEAR(e.fecha_entrada) AS año,
				MONTH(e.fecha_entrada) AS mes,
				0 AS contenedor_tren,
				COUNT(ecc.num_contenedor) AS contenedor_camion
			FROM entrada_camion_contenedor ecc
			INNER JOIN entrada e ON e.id_entrada = ecc.id_entrada
			WHERE ecc.num_contenedor IS NOT NULL AND e.id_entrada IS NOT NULL
			GROUP BY YEAR(e.fecha_entrada), MONTH(e.fecha_entrada)
		) AS merged_results
		GROUP BY año, mes
		ORDER BY año, mes;
		");

		$query->execute(array(
			':año' => $year,
			':mes' => $month
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_contenedores_total_salida($year, $month)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
		SELECT
			año,
			mes,
			CONCAT(año, '-', mes) AS año_mes,
			SUM(contenedor_tren) AS contenedor_tren,
			SUM(contenedor_camion) AS contenedor_camion,
			SUM(contenedor_tren + contenedor_camion) AS total_contenedores
		FROM (
			SELECT
				YEAR(s.fecha_salida) AS año,
				MONTH(s.fecha_salida) AS mes,
				COUNT(svc.num_contenedor) AS contenedor_tren,
				0 AS contenedor_camion
			FROM salida_vagon_contenedor svc
			INNER JOIN salida s ON s.id_salida = svc.id_salida
			WHERE svc.num_contenedor IS NOT NULL AND s.id_salida IS NOT NULL
			GROUP BY YEAR(s.fecha_salida), MONTH(s.fecha_salida)

			UNION ALL

			SELECT
				YEAR(s.fecha_salida) AS año,
				MONTH(s.fecha_salida) AS mes,
				0 AS contenedor_tren,
				COUNT(scc.num_contenedor) AS contenedor_camion
			FROM salida_camion_contenedor scc
			INNER JOIN salida s ON s.id_salida = scc.id_salida
			WHERE scc.num_contenedor IS NOT NULL AND s.id_salida IS NOT NULL
			GROUP BY YEAR(s.fecha_salida), MONTH(s.fecha_salida)
		) AS merged_results
		GROUP BY año, mes
		ORDER BY año, mes;
		");

		$query->execute(array(
			':año' => $year,
			':mes' => $month
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_contenedores_total_entrada2()
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
		SELECT
			año,
			mes,
			SUM(contenedor_tren) AS contenedor_tren,
			CONCAT(año, '-', mes) AS año_mes,
			SUM(contenedor_camion) AS contenedor_camion,
			SUM(contenedor_tren + contenedor_camion) AS total_contenedores
		FROM (
			SELECT
				YEAR(e.fecha_entrada) AS año,
				MONTH(e.fecha_entrada) AS mes,
				COUNT(evc.num_contenedor) AS contenedor_tren,
				0 AS contenedor_camion
			FROM entrada_vagon_contenedor evc
			INNER JOIN entrada e ON e.id_entrada = evc.id_entrada
			WHERE evc.num_contenedor IS NOT NULL AND e.id_entrada IS NOT NULL
			GROUP BY YEAR(e.fecha_entrada), MONTH(e.fecha_entrada)

			UNION ALL

			SELECT
				YEAR(e.fecha_entrada) AS año,
				MONTH(e.fecha_entrada) AS mes,
				0 AS contenedor_tren,
				COUNT(ecc.num_contenedor) AS contenedor_camion
			FROM entrada_camion_contenedor ecc
			INNER JOIN entrada e ON e.id_entrada = ecc.id_entrada
			WHERE ecc.num_contenedor IS NOT NULL AND e.id_entrada IS NOT NULL
			GROUP BY YEAR(e.fecha_entrada), MONTH(e.fecha_entrada)
		) AS merged_results
		GROUP BY año, mes
		ORDER BY año, mes;
		");

		$query->execute(array(
			//':año' => $year,
			//':mes' => $month
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_contenedores_total_salida2()
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
		SELECT
			año,
			mes,
			CONCAT(año, '-', mes) AS año_mes,
			SUM(contenedor_tren) AS contenedor_tren,
			SUM(contenedor_camion) AS contenedor_camion,
			SUM(contenedor_tren + contenedor_camion) AS total_contenedores
		FROM (
			SELECT
				YEAR(s.fecha_salida) AS año,
				MONTH(s.fecha_salida) AS mes,
				COUNT(svc.num_contenedor) AS contenedor_tren,
				0 AS contenedor_camion
			FROM salida_vagon_contenedor svc
			INNER JOIN salida s ON s.id_salida = svc.id_salida
			WHERE svc.num_contenedor IS NOT NULL AND s.id_salida IS NOT NULL
			GROUP BY YEAR(s.fecha_salida), MONTH(s.fecha_salida)

			UNION ALL

			SELECT
				YEAR(s.fecha_salida) AS año,
				MONTH(s.fecha_salida) AS mes,
				0 AS contenedor_tren,
				COUNT(scc.num_contenedor) AS contenedor_camion
			FROM salida_camion_contenedor scc
			INNER JOIN salida s ON s.id_salida = scc.id_salida
			WHERE scc.num_contenedor IS NOT NULL AND s.id_salida IS NOT NULL
			GROUP BY YEAR(s.fecha_salida), MONTH(s.fecha_salida)
		) AS merged_results
		GROUP BY año, mes
		ORDER BY año, mes;
		");

		$query->execute(array(
			//':año' => $year,
			//':mes' => $month
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_contenedores_stock()
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				cs.num_contenedor,
				c.id_tipo_contenedor_iso,
				tci.longitud_tipo_contenedor,
				tci.descripcion_tipo_contenedor,
				cs.id_control_stock,
				cs.id_ubicacion,
				cs.id_entrada,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
			     		THEN (SELECT num_expedicion FROM entrada_tipo_tren WHERE id_entrada = cs.id_entrada)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT num_expedicion FROM entrada_tipo_camion WHERE id_entrada = cs.id_entrada)
				END) AS num_expedicion_entrada,
				e.fecha_entrada,
				e.id_tipo_entrada,
				te.tipo_entrada,
				cs.id_salida,
				c.tara_contenedor,
				c.estado_carga_contenedor,
				c.peso_mercancia_actual_contenedor AS peso_mercancia_contenedor,
				c.peso_bruto_actual_contenedor AS peso_bruto_contenedor,
				c.temperatura_actual_contenedor AS temperatura_contenedor,
				c.num_booking_actual_contenedor AS num_booking_contenedor,
				c.num_precinto_actual_contenedor AS num_precinto_contenedor,
				c.incidencia,
				c.id_tipo_mercancia_actual_contenedor,
				tm.descripcion_mercancia,
				c.cif_propietario_actual,
				p.nombre_comercial_propietario,
				c.id_destinatario_actual,
				edo.nombre_empresa_destino_origen AS nombre_destinatario,
				edo.num_tarjeta_teco
			FROM ((((((control_stock cs INNER JOIN contenedor c ON c.num_contenedor = cs.num_contenedor)
				INNER JOIN propietario p ON p.cif_propietario = c.cif_propietario_actual)
			  	LEFT JOIN empresa_destino_origen edo ON edo.id_empresa_destino_origen = c.id_destinatario_actual)
			    	INNER JOIN tipo_mercancia tm ON tm.id_tipo_mercancia = c.id_tipo_mercancia_actual_contenedor)
							INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso)
								INNER JOIN entrada e ON e.id_entrada = cs.id_entrada)
									INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada
			WHERE cs.id_salida IS NULL AND cs.num_contenedor NOT IN (SELECT num_contenedor FROM contenedor_generador)
			ORDER BY cs.num_contenedor
		");

		$query->execute(array());

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_contenedores_stock_por_propietario($cif_propietario)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				cs.num_contenedor,
				c.id_tipo_contenedor_iso,
				tci.longitud_tipo_contenedor,
				tci.descripcion_tipo_contenedor,
				cs.id_control_stock,
				cs.id_ubicacion,
				cs.id_entrada,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
			     		THEN (SELECT num_expedicion FROM entrada_tipo_tren WHERE id_entrada = cs.id_entrada)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT num_expedicion FROM entrada_tipo_camion WHERE id_entrada = cs.id_entrada)
				END) AS num_expedicion_entrada,
				e.fecha_entrada,
				e.id_tipo_entrada,
				te.tipo_entrada,
				cs.id_salida,
				c.tara_contenedor,
				c.estado_carga_contenedor,
				c.peso_mercancia_actual_contenedor AS peso_mercancia_contenedor,
				c.peso_bruto_actual_contenedor AS peso_bruto_contenedor,
				c.temperatura_actual_contenedor AS temperatura_contenedor,
				c.num_booking_actual_contenedor AS num_booking_contenedor,
				c.num_precinto_actual_contenedor AS num_precinto_contenedor,
				c.incidencia,
				c.id_tipo_mercancia_actual_contenedor,
				tm.descripcion_mercancia,
				c.cif_propietario_actual,
				p.nombre_comercial_propietario,
				c.id_destinatario_actual,
				edo.nombre_empresa_destino_origen AS nombre_destinatario,
				edo.num_tarjeta_teco
			FROM ((((((control_stock cs INNER JOIN contenedor c ON c.num_contenedor = cs.num_contenedor)
				INNER JOIN propietario p ON p.cif_propietario = c.cif_propietario_actual)
			  	LEFT JOIN empresa_destino_origen edo ON edo.id_empresa_destino_origen = c.id_destinatario_actual)
			    	INNER JOIN tipo_mercancia tm ON tm.id_tipo_mercancia = c.id_tipo_mercancia_actual_contenedor)
							INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso)
								INNER JOIN entrada e ON e.id_entrada = cs.id_entrada)
									INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada
			WHERE cs.id_salida IS NULL AND c.cif_propietario_actual = :cif_propietario AND cs.num_contenedor NOT IN (SELECT num_contenedor FROM contenedor_generador)
			ORDER BY cs.num_contenedor
		");

		$query->execute(array(
			':cif_propietario' => $cif_propietario
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_contenedores_stock_reefer()
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				cs.num_contenedor,
				c.id_tipo_contenedor_iso,
				tci.longitud_tipo_contenedor,
				tci.descripcion_tipo_contenedor,
				cs.id_control_stock,
				cs.id_ubicacion,
				cs.id_entrada,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
			     		THEN (SELECT num_expedicion FROM entrada_tipo_tren WHERE id_entrada = cs.id_entrada)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT num_expedicion FROM entrada_tipo_camion WHERE id_entrada = cs.id_entrada)
				END) AS num_expedicion_entrada,
				e.fecha_entrada,
				e.id_tipo_entrada,
				te.tipo_entrada,
				cs.id_salida,
				c.tara_contenedor,
				c.estado_carga_contenedor,
				c.peso_mercancia_actual_contenedor AS peso_mercancia_contenedor,
				c.peso_bruto_actual_contenedor AS peso_bruto_contenedor,
				c.temperatura_actual_contenedor AS temperatura_contenedor,
				c.num_booking_actual_contenedor AS num_booking_contenedor,
				c.num_precinto_actual_contenedor AS num_precinto_contenedor,
				c.incidencia,
				c.id_tipo_mercancia_actual_contenedor,
				tm.descripcion_mercancia,
				c.cif_propietario_actual,
				p.nombre_comercial_propietario,
				c.id_destinatario_actual,
				edo.nombre_empresa_destino_origen AS nombre_destinatario,
				edo.num_tarjeta_teco
			FROM control_stock cs INNER JOIN contenedor c ON c.num_contenedor = cs.num_contenedor
				INNER JOIN propietario p ON p.cif_propietario = c.cif_propietario_actual
			  	LEFT JOIN empresa_destino_origen edo ON edo.id_empresa_destino_origen = c.id_destinatario_actual
			    	INNER JOIN tipo_mercancia tm ON tm.id_tipo_mercancia = c.id_tipo_mercancia_actual_contenedor
							INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso
								INNER JOIN entrada e ON e.id_entrada = cs.id_entrada
									INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada
			WHERE cs.id_salida IS NULL AND cs.num_contenedor NOT IN (SELECT num_contenedor FROM contenedor_generador) AND tci.descripcion_tipo_contenedor LIKE 'REEFER%'
			ORDER BY cs.num_contenedor;
		");

		$query->execute(array());

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_contenedores_stock_reefer_incidencia()
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				cs.num_contenedor,
				c.id_tipo_contenedor_iso,
				tci.longitud_tipo_contenedor,
				tci.descripcion_tipo_contenedor,
				cs.id_control_stock,
				cs.id_ubicacion,
				cs.id_entrada,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
			     		THEN (SELECT num_expedicion FROM entrada_tipo_tren WHERE id_entrada = cs.id_entrada)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT num_expedicion FROM entrada_tipo_camion WHERE id_entrada = cs.id_entrada)
				END) AS num_expedicion_entrada,
				e.fecha_entrada,
				e.id_tipo_entrada,
				te.tipo_entrada,
				cs.id_salida,
				c.tara_contenedor,
				c.estado_carga_contenedor,
				c.peso_mercancia_actual_contenedor AS peso_mercancia_contenedor,
				c.peso_bruto_actual_contenedor AS peso_bruto_contenedor,
				c.temperatura_actual_contenedor AS temperatura_contenedor,
				c.num_booking_actual_contenedor AS num_booking_contenedor,
				c.num_precinto_actual_contenedor AS num_precinto_contenedor,
				c.incidencia,
				c.id_tipo_mercancia_actual_contenedor,
				tm.descripcion_mercancia,
				c.cif_propietario_actual,
				p.nombre_comercial_propietario,
				c.id_destinatario_actual,
				edo.nombre_empresa_destino_origen AS nombre_destinatario,
				edo.num_tarjeta_teco
			FROM control_stock cs INNER JOIN contenedor c ON c.num_contenedor = cs.num_contenedor
				INNER JOIN propietario p ON p.cif_propietario = c.cif_propietario_actual
			  	LEFT JOIN empresa_destino_origen edo ON edo.id_empresa_destino_origen = c.id_destinatario_actual
			    	INNER JOIN tipo_mercancia tm ON tm.id_tipo_mercancia = c.id_tipo_mercancia_actual_contenedor
							INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso
								INNER JOIN entrada e ON e.id_entrada = cs.id_entrada
									INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada
			WHERE cs.id_salida IS NULL AND cs.num_contenedor NOT IN (SELECT num_contenedor FROM contenedor_generador UNION SELECT i_c.num_contenedor FROM incidencia_contenedor i_c INNER JOIN incidencia i ON i.id_incidencia = i_c.id_incidencia WHERE i_c.num_contenedor = cs.num_contenedor AND i.id_tipo_incidencia = 1 AND i_c.id_entrada = e.id_entrada) AND tci.descripcion_tipo_contenedor LIKE 'REEFER%'
			ORDER BY cs.num_contenedor
			LIMIT 10;
		");

		$query->execute(array());

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//PRINCIPIO
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//FUNCION RELACIONADA CON LA VISTA       **HISTORICO CONTENEDORES**
	public function get_contenedores_historico()
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				cs.id_control_stock,
				cs.num_contenedor,
				cs.id_ubicacion,
				cs.id_entrada,
				cs.id_salida,
				e.fecha_entrada,
				e.id_tipo_entrada,
				te.tipo_entrada,
				s.fecha_salida,
				s.id_tipo_salida,
				ts.tipo_salida,
				c.id_tipo_contenedor_iso,
				tci.longitud_tipo_contenedor,
				tci.descripcion_tipo_contenedor,
				c.tara_contenedor
			FROM ((((((control_stock cs INNER JOIN entrada e ON e.id_entrada = cs.id_entrada)
				LEFT JOIN salida s ON s.id_salida = cs.id_salida)
					INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada)
						LEFT JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida)
							INNER JOIN contenedor c ON c.num_contenedor = cs.num_contenedor)
								INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso)
		");

		$query->execute(array());

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_contenedor_historico($num_contenedor)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				cs.id_control_stock,
				cs.num_contenedor,
				cs.id_ubicacion,
				cs.id_entrada,
				cs.id_salida,
				e.fecha_entrada,
				e.id_tipo_entrada,
				te.tipo_entrada,
				s.fecha_salida,
				s.id_tipo_salida,
				ts.tipo_salida,
				c.id_tipo_contenedor_iso,
				tci.longitud_tipo_contenedor,
				tci.descripcion_tipo_contenedor,
				c.tara_contenedor,
				c.cif_propietario_actual,
				p.nombre_comercial_propietario
			FROM ((((((control_stock cs INNER JOIN entrada e ON e.id_entrada = cs.id_entrada)
				LEFT JOIN salida s ON s.id_salida = cs.id_salida)
					INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada)
						LEFT JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida)
							INNER JOIN contenedor c ON c.num_contenedor = cs.num_contenedor)
								INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso)
									INNER JOIN propietario p ON p.cif_propietario = c.cif_propietario_actual
			WHERE cs.num_contenedor = :num_contenedor;
		");

		$query->execute(array(
			':num_contenedor' => $num_contenedor
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_contenedor_historico_transbordo($num_contenedor)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				cs.id_control_stock,
				cs.num_contenedor,
				cs.id_ubicacion,
				cs.id_entrada,
				cs.id_salida,
				e.fecha_entrada,
				e.id_tipo_entrada,
				te.tipo_entrada,
				s.fecha_salida,
				s.id_tipo_salida,
				ts.tipo_salida,
				c.id_tipo_contenedor_iso,
				tci.longitud_tipo_contenedor,
				tci.descripcion_tipo_contenedor,
				c.tara_contenedor,
				c.cif_propietario_actual,
				p.nombre_comercial_propietario,
				t.id_transbordo
			FROM ((((((control_stock cs INNER JOIN entrada e ON e.id_entrada = cs.id_entrada)
				LEFT JOIN salida s ON s.id_salida = cs.id_salida)
					INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada)
						LEFT JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida)
							INNER JOIN contenedor c ON c.num_contenedor = cs.num_contenedor)
								INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso)
									INNER JOIN propietario p ON p.cif_propietario = c.cif_propietario_actual
										LEFT JOIN transbordo t ON t.num_contenedor_origen = cs.num_contenedor
			WHERE cs.num_contenedor = :num_contenedor;
		");

		$query->execute(array(
			':num_contenedor' => $num_contenedor
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//FIN
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function get_historico_contenedor($num_contenedor)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				cs.id_control_stock,
				cs.num_contenedor,
				cs.id_ubicacion,
				cs.id_entrada,
				cs.id_salida,
				e.fecha_entrada,
				e.id_tipo_entrada,
				te.tipo_entrada,
				s.fecha_salida,
				s.id_tipo_salida,
				ts.tipo_salida
			FROM (((control_stock cs INNER JOIN entrada e ON e.id_entrada = cs.id_entrada)
				LEFT JOIN salida s ON s.id_salida = cs.id_salida)
					INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada)
						LEFT JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida
			WHERE num_contenedor = :num_contenedor;
		");

		$query->execute(array(
			':num_contenedor' => $num_contenedor
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_conductores_por_dni_ajax($search)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT dni_conductor, nombre_conductor, apellidos_conductor
			FROM conductor
			WHERE dni_conductor LIKE :search
			ORDER BY dni_conductor
			LIMIT 10;
		");

		$query->execute(array(
			':search' => "%" . $search . "%"
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_conductor_por_dni($dni_conductor)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT dni_conductor, nombre_conductor, apellidos_conductor
			FROM conductor
			WHERE dni_conductor = :dni_conductor
		");

		$query->execute(array(
			':dni_conductor' => $dni_conductor
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	function insert_conductor(
		$dni_conductor,
		$nombre_conductor,
		$apellidos_conductor
	) {

		try {
			$query = $this->conexion->prepare("
				INSERT INTO conductor(dni_conductor, nombre_conductor, apellidos_conductor)
				VALUES (:dni_conductor, :nombre_conductor, :apellidos_conductor);
			");

			$result = $query->execute(array(
				':dni_conductor' => $dni_conductor,
				':nombre_conductor' => $nombre_conductor,
				':apellidos_conductor' => $apellidos_conductor
			));

			//cerramos la consulta a la BD
			$query = null;

			return $result;
		} catch (PDOException $e) {
			return "error: " . $e;
		}
	}

	public function get_adr_clases()
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT num_clase_adr
			FROM ard_clase
		");

		$query->execute(array());

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_adr_grupos_embalajes()
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT cod_grupo_embalaje_adr
			FROM adr_grupo_embalaje
		");

		$query->execute(array());

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_adr_num_peligros($search)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT num_peligro_adr, descripcion_peligro_adr
			FROM adr_peligro
			WHERE num_peligro_adr LIKE :search
			LIMIT 10;
		");

		$query->execute(array(
			':search' => "%" . $search . "%"
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_adr_num_peligro_por_codigo($num_peligro_adr)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT num_peligro_adr, descripcion_peligro_adr
			FROM adr_peligro
			WHERE num_peligro_adr = :num_peligro_adr;
		");

		$query->execute(array(
			':num_peligro_adr' => $num_peligro_adr
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_adr_clase_por_codigo($num_clase_adr)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT num_clase_adr
			FROM ard_clase
			WHERE num_clase_adr = :num_clase_adr;
		");

		$query->execute(array(
			':num_clase_adr' => $num_clase_adr
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_adr_grupo_embalaje_por_codigo($cod_grupo_embalaje_adr)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT cod_grupo_embalaje_adr
			FROM adr_grupo_embalaje
			WHERE cod_grupo_embalaje_adr = :cod_grupo_embalaje_adr;
		");

		$query->execute(array(
			':cod_grupo_embalaje_adr' => $cod_grupo_embalaje_adr
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_adr_onus($search)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT num_onu_adr, descripcion_onu_adr
			FROM adr_onu
			WHERE num_onu_adr LIKE :search
			LIMIT 10;
		");

		$query->execute(array(
			':search' => "%" . $search . "%"
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_adr_onu_por_codigo($num_onu_adr)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT num_onu_adr, descripcion_onu_adr
			FROM adr_onu
			WHERE num_onu_adr = :num_onu_adr;
		");

		$query->execute(array(
			':num_onu_adr' => $num_onu_adr
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_empresas_destino_origen($search)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT id_empresa_destino_origen, nombre_empresa_destino_origen
			FROM empresa_destino_origen
			WHERE nombre_empresa_destino_origen LIKE :search
			ORDER BY nombre_empresa_destino_origen
			LIMIT 10;
		");

		$query->execute(array(
			':search' => "%" . $search . "%"
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_empresas_destino_origen_renfe($search)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT id_empresa_destino_origen, nombre_empresa_destino_origen
			FROM empresa_destino_origen
			WHERE nombre_empresa_destino_origen LIKE :search AND num_tarjeta_teco IS NOT NULL
			ORDER BY nombre_empresa_destino_origen
			LIMIT 10;
		");

		$query->execute(array(
			':search' => "%" . $search . "%"
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	function insert_empresa_transportista(
		$cif_empresa_transportista,
		$nombre_empresa_transportista,
		$direccion_empresa_transportista
	) {

		try {
			$query = $this->conexion->prepare("
					INSERT INTO empresa_transportista(cif_empresa_transportista, nombre_empresa_transportista, direccion_empresa_transportista)
					VALUES (:cif_empresa_transportista, :nombre_empresa_transportista, :direccion_empresa_transportista);
				");

			$result = $query->execute(array(
				':cif_empresa_transportista' => $cif_empresa_transportista,
				':nombre_empresa_transportista' => $nombre_empresa_transportista,
				':direccion_empresa_transportista' => $direccion_empresa_transportista
			));

			//cerramos la consulta a la BD
			$query = null;

			return $result;
		} catch (PDOException $e) {
			return "error: " . $e;
		}
	}

	public function get_estaciones_ferrocarril_renfe_ajax($search)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
		SELECT codigo_estacion_ferrocarril, nombre_estacion_ferrocarril
		FROM estacion_ferrocarril_renfe
		WHERE nombre_estacion_ferrocarril LIKE :search
		LIMIT 10;
		");

		$query->execute(array(
			':search' => "%" . $search . "%"
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_estaciones_ferrocarril_renfe()
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT codigo_estacion_ferrocarril, nombre_estacion_ferrocarril
			FROM estacion_ferrocarril_renfe
		");

		$query->execute(array());

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_num_teco($id_empresa_destino_origen)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT id_empresa_destino_origen, nombre_empresa_destino_origen, num_tarjeta_teco
			FROM empresa_destino_origen
			WHERE id_empresa_destino_origen = :id_empresa_destino_origen
		");

		$query->execute(array(
			':id_empresa_destino_origen' => $id_empresa_destino_origen
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_destinatario_por_id($id_empresa_destino_origen)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT id_empresa_destino_origen, nombre_empresa_destino_origen, num_tarjeta_teco
			FROM empresa_destino_origen
			WHERE id_empresa_destino_origen = :id_empresa_destino_origen
		");

		$query->execute(array(
			':id_empresa_destino_origen' => $id_empresa_destino_origen
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_destinatario_por_nombre($nombre_empresa_destino_origen)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT id_empresa_destino_origen, nombre_empresa_destino_origen, num_tarjeta_teco
			FROM empresa_destino_origen
			WHERE nombre_empresa_destino_origen = :nombre_empresa_destino_origen
		");

		$query->execute(array(
			':nombre_empresa_destino_origen' => $nombre_empresa_destino_origen
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function insert_destinatario($nombre_empresa_destino_origen, $num_tarjeta_teco)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			INSERT INTO empresa_destino_origen(nombre_empresa_destino_origen, num_tarjeta_teco)
			VALUES (:nombre_empresa_destino_origen, :num_tarjeta_teco)
    	");

		$this->result[] = $query->execute(array(
			':nombre_empresa_destino_origen' => $nombre_empresa_destino_origen,
			':num_tarjeta_teco' => $num_tarjeta_teco
		));

		//Cerramos la conexion a la BD
		$query = null;

		//Obtenemos el id del registro insertado
		$this->result = $this->conexion->lastInsertId();

		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	/////////////////////////////////////////////////////////////////////////////////////////
	public function get_contenedores_entrada_camion_por_id_entrada($id_entrada)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		/*$query = $this->conexion->prepare("
			SELECT ecc.num_contenedor, c.id_tipo_contenedor_iso
			FROM ((entrada e INNER JOIN entrada_tipo_camion etc ON etc.id_entrada = e.id_entrada) INNER JOIN entrada_camion_contenedor ecc ON ecc.id_entrada = etc.id_entrada) INNER JOIN contenedor c ON c.num_contenedor = ecc.num_contenedor
			WHERE e.id_entrada = :id_entrada
		");*/

		$query = $this->conexion->prepare("
			SELECT
				ecc.num_contenedor,
				c.id_tipo_contenedor_iso,
				COUNT(ecc.num_contenedor) OVER(PARTITION BY e.id_entrada) AS total_contenedores
			FROM
				entrada e
				INNER JOIN entrada_tipo_camion etc ON etc.id_entrada = e.id_entrada
				INNER JOIN entrada_camion_contenedor ecc ON ecc.id_entrada = etc.id_entrada
				INNER JOIN contenedor c ON c.num_contenedor = ecc.num_contenedor
			WHERE
				e.id_entrada = :id_entrada;
		");

		$query->execute(array(
			':id_entrada' => $id_entrada
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_contenedores_salida_camion_por_id_salida($id_salida)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		/*$query = $this->conexion->prepare("
			SELECT scc.num_contenedor, c.id_tipo_contenedor_iso
			FROM ((salida s INNER JOIN salida_tipo_camion stc ON stc.id_salida = s.id_salida)
				INNER JOIN salida_camion_contenedor scc ON scc.id_salida = stc.id_salida)
					INNER JOIN contenedor c ON c.num_contenedor = scc.num_contenedor
			WHERE s.id_salida = :id_salida
		");*/

		$query = $this->conexion->prepare("
		SELECT
			scc.num_contenedor,
			c.id_tipo_contenedor_iso,
			COUNT(scc.num_contenedor) OVER(PARTITION BY s.id_salida) AS total_contenedores
		FROM
			salida s
			INNER JOIN salida_tipo_camion stc ON stc.id_salida = s.id_salida
			INNER JOIN salida_camion_contenedor scc ON scc.id_salida = stc.id_salida
			INNER JOIN contenedor c ON c.num_contenedor = scc.num_contenedor
		WHERE
			s.id_salida = :id_salida;
		");

		$query->execute(array(
			':id_salida' => $id_salida
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_contenedores_entrada_tren_por_id_entrada($id_entrada)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		/*$query = $this->conexion->prepare("
			SELECT evc.num_contenedor, c.id_tipo_contenedor_iso
			FROM ((entrada e INNER JOIN entrada_tipo_tren ett ON ett.id_entrada = e.id_entrada) INNER JOIN entrada_vagon_contenedor evc ON evc.id_entrada = ett.id_entrada) INNER JOIN contenedor c ON c.num_contenedor = evc.num_contenedor
			WHERE e.id_entrada = :id_entrada
		");*/

		$query = $this->conexion->prepare("
			SELECT
				evc.num_contenedor,
				c.id_tipo_contenedor_iso,
				COUNT(evc.num_contenedor) OVER(PARTITION BY e.id_entrada) AS total_contenedores
			FROM
				entrada e
				INNER JOIN entrada_tipo_tren ett ON ett.id_entrada = e.id_entrada
				INNER JOIN entrada_vagon_contenedor evc ON evc.id_entrada = ett.id_entrada
				INNER JOIN contenedor c ON c.num_contenedor = evc.num_contenedor
			WHERE
				e.id_entrada = :id_entrada;
		");

		$query->execute(array(
			':id_entrada' => $id_entrada
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_contenedores_entrada_traspaso_por_id_entrada($id_entrada)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		/*$query = $this->conexion->prepare("
			SELECT t.num_contenedor, c.id_tipo_contenedor_iso
			FROM ((entrada e INNER JOIN entrada_tipo_traspaso ett ON ett.id_entrada = e.id_entrada)
				INNER JOIN traspaso t ON t.id_traspaso = ett.id_traspaso)
					INNER JOIN contenedor c ON c.num_contenedor = t.num_contenedor
			WHERE e.id_entrada = :id_entrada
		");*/

		$query = $this->conexion->prepare("
		SELECT
			t.num_contenedor,
			c.id_tipo_contenedor_iso,
			COUNT(t.num_contenedor) OVER(PARTITION BY e.id_entrada) AS total_contenedores
		FROM
			entrada e
			INNER JOIN entrada_tipo_traspaso ett ON ett.id_entrada = e.id_entrada
			INNER JOIN traspaso t ON t.id_traspaso = ett.id_traspaso
			INNER JOIN contenedor c ON c.num_contenedor = t.num_contenedor
		WHERE
			e.id_entrada = :id_entrada;

		");

		$query->execute(array(
			':id_entrada' => $id_entrada
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_contenedores_entrada_transbordo_por_id_entrada($id_entrada)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
		SELECT
			t.num_contenedor_origen as num_contenedor_origen,
			t.num_contenedor_destino as num_contenedor_destino,
			c.id_tipo_contenedor_iso,
			COUNT(t.num_contenedor_origen) OVER(PARTITION BY e.id_entrada) + COUNT(t.num_contenedor_destino) OVER(PARTITION BY e.id_entrada)AS total_contenedores
		FROM entrada e
			INNER JOIN entrada_tipo_transbordo ett ON ett.id_entrada = e.id_entrada
			INNER JOIN transbordo t ON t.id_transbordo = ett.id_transbordo
			INNER JOIN contenedor c ON c.num_contenedor = t.num_contenedor_origen
		WHERE
			e.id_entrada = :id_entrada;
		");

		$query->execute(array(
			':id_entrada' => $id_entrada
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_contenedores_salida_transbordo_por_id_salida($id_salida)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
		SELECT
			t.num_contenedor_origen as num_contenedor_origen,
			t.num_contenedor_destino as num_contenedor_destino,
			c.id_tipo_contenedor_iso,
			COUNT(t.num_contenedor_destino) OVER(PARTITION BY s.id_salida) AS total_contenedores
		FROM salida s
			INNER JOIN salida_tipo_transbordo stt ON stt.id_salida = s.id_salida
			INNER JOIN transbordo t ON t.id_transbordo = stt.id_transbordo
			INNER JOIN contenedor c ON c.num_contenedor = t.num_contenedor_origen
		WHERE
			s.id_salida = :id_salida;
		");

		$query->execute(array(
			':id_salida' => $id_salida
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_contenedores_salida_tren_por_id_salida($id_salida)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		/*$query = $this->conexion->prepare("
			SELECT svc.num_contenedor, c.id_tipo_contenedor_iso
			FROM ((salida s INNER JOIN salida_tipo_tren stt ON stt.id_salida = s.id_salida) INNER JOIN salida_vagon_contenedor svc ON svc.id_salida = stt.id_salida) INNER JOIN contenedor c ON c.num_contenedor = svc.num_contenedor
			WHERE s.id_salida = :id_salida
		");*/

		$query = $this->conexion->prepare("
		SELECT
			svc.num_contenedor,
			c.id_tipo_contenedor_iso,
			COUNT(svc.num_contenedor) OVER(PARTITION BY s.id_salida) AS total_contenedores
		FROM
			salida s
			INNER JOIN salida_tipo_tren stt ON stt.id_salida = s.id_salida
			INNER JOIN salida_vagon_contenedor svc ON svc.id_salida = stt.id_salida
			INNER JOIN contenedor c ON c.num_contenedor = svc.num_contenedor
		WHERE
			s.id_salida = :id_salida;

		");

		$query->execute(array(
			':id_salida' => $id_salida
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_contenedores_salida_traspaso_por_id_salida($id_salida)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		/*$query = $this->conexion->prepare("
			SELECT t.num_contenedor, c.id_tipo_contenedor_iso
			FROM ((salida s INNER JOIN salida_tipo_traspaso stt ON stt.id_salida = s.id_salida)
				INNER JOIN traspaso t ON t.id_traspaso = stt.id_traspaso)
					INNER JOIN contenedor c ON c.num_contenedor = t.num_contenedor
			WHERE s.id_salida = :id_salida
		");*/

		$query = $this->conexion->prepare("
		SELECT
			t.num_contenedor,
			c.id_tipo_contenedor_iso,
			COUNT(t.num_contenedor) OVER(PARTITION BY s.id_salida) AS total_contenedores
		FROM
			salida s
			INNER JOIN salida_tipo_traspaso stt ON stt.id_salida = s.id_salida
			INNER JOIN traspaso t ON t.id_traspaso = stt.id_traspaso
			INNER JOIN contenedor c ON c.num_contenedor = t.num_contenedor
		WHERE
			s.id_salida = :id_salida;
		");

		$query->execute(array(
			':id_salida' => $id_salida
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_num_expedicion_entrada_camion($id_entrada)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT etc.num_expedicion, ecc.cif_propietario, p.nombre_comercial_propietario
			FROM ((entrada e INNER JOIN entrada_tipo_camion etc ON etc.id_entrada = e.id_entrada)
				INNER JOIN entrada_camion_contenedor ecc ON ecc.id_entrada = etc.id_entrada)
			  	INNER JOIN propietario p ON p.cif_propietario = ecc.cif_propietario
			WHERE e.id_entrada = :id_entrada
		");

		$query->execute(array(
			':id_entrada' => $id_entrada
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_num_expedicion_salida_camion($id_salida)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				stc.num_expedicion,
				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
						THEN (SELECT cif_propietario FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
						THEN (SELECT cif_propietario FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
						THEN (SELECT cif_propietario_actual FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS cif_propietario_actual,
			(CASE
				WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
					THEN (SELECT nombre_comercial_propietario FROM entrada_vagon_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_vagon_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
					THEN (SELECT nombre_comercial_propietario FROM entrada_camion_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_camion_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
					THEN (SELECT nombre_comercial_propietario FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN propietario ON propietario.cif_propietario = traspaso.cif_propietario_actual WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
			END) AS nombre_comercial_propietario
			FROM ((salida s INNER JOIN salida_tipo_camion stc ON stc.id_salida = s.id_salida)
				INNER JOIN salida_camion_contenedor scc ON scc.id_salida = stc.id_salida)
					INNER JOIN control_stock cs ON cs.id_salida = s.id_salida
			WHERE s.id_salida = :id_salida
		");

		$query->execute(array(
			':id_salida' => $id_salida
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_num_expedicion_entrada_tren($id_entrada)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT DISTINCT ett.num_expedicion, evc.cif_propietario, p.nombre_comercial_propietario
			FROM ((entrada e INNER JOIN entrada_tipo_tren ett ON ett.id_entrada = e.id_entrada)
		   	INNER JOIN entrada_vagon_contenedor evc ON evc.id_entrada = ett.id_entrada)
		     	INNER JOIN propietario p ON p.cif_propietario = evc.cif_propietario
			WHERE e.id_entrada = :id_entrada
		");

		$query->execute(array(
			':id_entrada' => $id_entrada
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_num_expedicion_entrada_traspaso($id_entrada)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				ett.id_traspaso AS num_expedicion,
			  t.cif_propietario_anterior,
			  (SELECT nombre_comercial_propietario FROM propietario WHERE cif_propietario = t.cif_propietario_anterior) AS nombre_comercial_propietario_anterior,
			  t.cif_propietario_actual,
			  (SELECT nombre_comercial_propietario FROM propietario WHERE cif_propietario = t.cif_propietario_actual) AS nombre_comercial_propietario_actual
			FROM (entrada e INNER JOIN entrada_tipo_traspaso ett ON ett.id_entrada = e.id_entrada)
				INNER JOIN traspaso t ON t.id_traspaso = ett.id_traspaso
			WHERE e.id_entrada = :id_entrada;
		");

		$query->execute(array(
			':id_entrada' => $id_entrada
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_num_expedicion_entrada_transbordo($id_entrada)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				e.id_entrada AS num_expedicion,
				e.fecha_entrada,
				e.fecha_insert,
				e.user_insert,
				e.id_tipo_entrada,
				e.id_cita_descarga,
				ett.id_transbordo,
				t.fecha_transbordo,
				t.num_contenedor_origen as num_contenedor_origen,
				t.num_contenedor_destino as num_contenedor_destino,
				c.num_contenedor as num_contenedor_origeen,
				p.nombre_comercial_propietario,
				COUNT(t.num_contenedor_origen) OVER(PARTITION BY e.id_entrada) AS total_contenedores
			FROM entrada e INNER JOIN entrada_tipo_transbordo ett ON ett.id_entrada = e.id_entrada
				INNER JOIN transbordo t ON t.id_transbordo = ett.id_transbordo
				INNER JOIN contenedor c ON c.num_contenedor = num_contenedor_origen
				INNER JOIN propietario p ON p.cif_propietario = c.cif_propietario_actual
			WHERE e.id_entrada = :id_entrada
		");

		$query->execute(array(
			':id_entrada' => $id_entrada
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_num_expedicion_salida_transbordo($id_salida)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				s.id_salida AS num_expedicion,
				s.fecha_salida,
				s.fecha_insert,
				s.user_insert,
				s.id_tipo_salida,
				s.id_cita_carga,
				stt.id_transbordo,
				t.fecha_transbordo,
				t.num_contenedor_origen as num_contenedor_origen,
				t.num_contenedor_destino as num_contenedor_destino,
				c.num_contenedor as num_contenedor_origeen,
				p.nombre_comercial_propietario,
				COUNT(t.num_contenedor_origen) OVER(PARTITION BY s.id_salida) AS total_contenedores
			FROM salida s INNER JOIN salida_tipo_transbordo stt ON stt.id_salida = s.id_salida
				INNER JOIN transbordo t ON t.id_transbordo = stt.id_transbordo
				INNER JOIN contenedor c ON c.num_contenedor = num_contenedor_origen
				INNER JOIN propietario p ON p.cif_propietario = c.cif_propietario_actual
			WHERE s.id_salida = :id_salida
		");

		$query->execute(array(
			':id_salida' => $id_salida
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_num_expedicion_salida_tren($id_salida)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT DISTINCT
				stt.num_expedicion,
				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
						THEN (SELECT cif_propietario FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
						THEN (SELECT cif_propietario FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
						THEN (SELECT cif_propietario_actual FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS cif_propietario_actual,
			(CASE
				WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
					THEN (SELECT nombre_comercial_propietario FROM entrada_vagon_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_vagon_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
					THEN (SELECT nombre_comercial_propietario FROM entrada_camion_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_camion_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
					THEN (SELECT nombre_comercial_propietario FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN propietario ON propietario.cif_propietario = traspaso.cif_propietario_actual WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
			END) AS nombre_comercial_propietario
			FROM ((salida s INNER JOIN salida_tipo_tren stt ON stt.id_salida = s.id_salida)
				INNER JOIN salida_vagon_contenedor svc ON svc.id_salida = stt.id_salida)
					INNER JOIN control_stock cs ON cs.id_salida = s.id_salida
			WHERE s.id_salida = :id_salida
		");

		$query->execute(array(
			':id_salida' => $id_salida
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_num_expedicion_salida_traspaso($id_salida)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				stt.id_traspaso AS num_expedicion,
			  t.cif_propietario_anterior,
			  (SELECT nombre_comercial_propietario FROM propietario WHERE cif_propietario = t.cif_propietario_anterior) AS nombre_comercial_propietario_anterior,
			  t.cif_propietario_actual,
			  (SELECT nombre_comercial_propietario FROM propietario WHERE cif_propietario = t.cif_propietario_actual) AS nombre_comercial_propietario_actual
			FROM (salida s INNER JOIN salida_tipo_traspaso stt ON stt.id_salida = s.id_salida)
				INNER JOIN traspaso t ON t.id_traspaso = stt.id_traspaso
			WHERE s.id_salida = :id_salida;
		");

		$query->execute(array(
			':id_salida' => $id_salida
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//FUNCIONES RELACIONADAS CON EL LISTRADO DE ENTRADAS

	public function get_entradas_por_year($year)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT e.id_entrada, e.fecha_entrada, e.id_tipo_entrada, te.tipo_entrada, e.id_cita_descarga
			FROM entrada e INNER JOIN tipo_entrada te ON e.id_tipo_entrada = te.id_tipo_entrada
			WHERE YEAR(fecha_entrada) = :year
		");

		$query->execute(array(
			':year' => $year
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_salidas_por_year($year)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT s.id_salida, s.fecha_salida, s.id_tipo_salida, ts.tipo_salida, s.id_cita_carga
			FROM salida s INNER JOIN tipo_salida ts ON s.id_tipo_salida = ts.id_tipo_salida
			WHERE YEAR(fecha_salida) = :year
		");

		$query->execute(array(
			':year' => $year
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_entradas_validadas() {}

	public function get_entradas_by_num_contenedor($id_producto)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
				SELECT DISTINCT cd.id, cd.num_packing, cd.tipo_descarga, cd.fecha, cd.hora, cd.observaciones, cd.id_almacen, cd.id_origen
				FROM (((producto p INNER JOIN palet_linea pl ON p.id_producto = pl.id_producto) INNER JOIN palet_mercancia pm ON pm.id_palet = pl.id_palet) INNER JOIN entrada_mercancia em ON pm.id_entrada_mercancia = em.id) INNER JOIN cita_descarga cd ON em.id_cita_descarga = cd.id
				WHERE pl.id_producto = :id_producto;
			");

		$query->execute(array(
			':id_producto' => $id_producto
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_contenedores_by_num_contenedor_entrada($num_contenedor) //get_palets_by_num_packing_entradas
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT pm.id_palet, pm.id_tipo_palet, pm.usar_palet, pm.id_ubicacion, pm.id_entrada_mercancia, pm.manipulation, pm.retractilado, pl.cantidad, pl.id_producto, p.nombre, p.color, p.unidades_caja, pl.id_tipo_paquete, cd.num_packing, u.codigo AS codigo_ubicacion
			FROM ((((palet_mercancia pm INNER JOIN palet_linea pl ON pm.id_palet = pl.id_palet) INNER JOIN entrada_mercancia em ON pm.id_entrada_mercancia = em.id) INNER JOIN cita_descarga cd ON em.id_cita_descarga = cd.id) INNER JOIN producto p ON pl.id_producto = p.id_producto) INNER JOIN ubicaciones u ON pm.id_ubicacion = u.id_ubicacion
			WHERE cd.num_packing = :num_packing;
		");

		/*
		* SELECT pm.id_palet, pm.id_tipo_palet, pm.usar_palet, pm.id_ubicacion, pm.id_entrada_mercancia, pm.manipulation, pm.retractilado, pl.cantidad, pl.id_producto, p.nombre, p.color, p.unidades_caja, pl.id_tipo_paquete, cd.num_packing, u.codigo AS codigo_ubicacion
		* FROM ((((palet_mercancia pm INNER JOIN palet_linea pl ON pm.id_palet = pl.id_palet) INNER JOIN entrada_mercancia em ON pm.id_entrada_mercancia = em.id) INNER JOIN cita_descarga cd ON em.id_cita_descarga = cd.id) INNER JOIN producto p ON pl.id_producto = p.id_producto) INNER JOIN ubicaciones u ON pm.id_ubicacion = u.id_ubicacion
		* WHERE cd.num_packing = :num_packing;
		*/

		$query->execute(array(
			':num_contenedor' => $num_contenedor
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_historico_movimientos_entrada_por_fecha($fecha_inicio, $fecha_fin)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				cs.num_contenedor,
				c.id_tipo_contenedor_iso,
				c.tara_contenedor,
				tci.longitud_tipo_contenedor,
				tci.descripcion_tipo_contenedor,
				cs.id_entrada AS id,
				e.fecha_entrada AS fecha,
				e.id_tipo_entrada,
				'ENTRADA' AS tipo,
		    CONCAT ('ENTRADA', ' ', te.tipo_entrada) AS tipo_movimiento,

				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT cif_propietario FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT cif_propietario FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
	         		WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 			      THEN (SELECT cif_propietario_actual FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS cif_propietario_actual,

				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT nombre_comercial_propietario FROM entrada_vagon_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_vagon_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT nombre_comercial_propietario FROM entrada_camion_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_camion_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
	         		WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 			      THEN (SELECT nombre_comercial_propietario FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN propietario ON propietario.cif_propietario = traspaso.cif_propietario_actual WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS nombre_comercial_propietario,

				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT num_expedicion FROM entrada_tipo_tren WHERE id_entrada = cs.id_entrada)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT num_expedicion FROM entrada_tipo_camion WHERE id_entrada = cs.id_entrada)
				END) AS num_expedicion,

				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT num_expedicion FROM entrada_tipo_tren WHERE id_entrada = cs.id_entrada)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT CONCAT(matricula_tractora, ' / ', matricula_remolque) FROM entrada_tipo_camion WHERE id_entrada = cs.id_entrada)
				END) AS num_expedicion2,
				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT peso_bruto_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT peso_mercancia_contenedor+c.tara_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
           			WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 			      THEN (SELECT peso_bruto_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS peso_bruto,

				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT peso_bruto_contenedor-c.tara_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT peso_mercancia_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 			    THEN (SELECT peso_mercancia_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS peso_mercancia,

				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT estado_carga_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT estado_carga_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
	         		WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 	 		    THEN (SELECT estado_carga_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS estado_carga_contenedor,
				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT id_tipo_mercancia FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT id_tipo_mercancia FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				   	WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT id_tipo_mercancia FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS id_tipo_mercancia,
				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT descripcion_mercancia FROM entrada_vagon_contenedor INNER JOIN tipo_mercancia ON tipo_mercancia.id_tipo_mercancia = entrada_vagon_contenedor.id_tipo_mercancia WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT descripcion_mercancia FROM entrada_camion_contenedor INNER JOIN tipo_mercancia ON tipo_mercancia.id_tipo_mercancia = entrada_camion_contenedor.id_tipo_mercancia WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT descripcion_mercancia FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN tipo_mercancia ON tipo_mercancia.id_tipo_mercancia = traspaso.id_tipo_mercancia WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS descripcion_mercancia,
				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT id_destinatario FROM entrada_vagon_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = entrada_vagon_contenedor.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT id_destinatario FROM entrada_camion_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = entrada_camion_contenedor.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT id_destinatario FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS id_destinatario,
				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT nombre_empresa_destino_origen FROM entrada_vagon_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = entrada_vagon_contenedor.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT nombre_empresa_destino_origen FROM entrada_camion_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = entrada_camion_contenedor.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT nombre_empresa_destino_origen FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = traspaso.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS nombre_destinatario,
				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT num_booking_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT num_booking_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS num_booking_contenedor,
				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT num_precinto_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT num_precinto_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS num_precinto_contenedor,
				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT temperatura_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT temperatura_contenedor  FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT temperatura_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS temperatura_contenedor

			FROM (((control_stock cs INNER JOIN entrada e ON e.id_entrada = cs.id_entrada)
				INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada)
			    	INNER JOIN contenedor c ON c.num_contenedor = cs.num_contenedor)
			        	INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso
			WHERE DATE(e.fecha_entrada) BETWEEN :fecha_inicio AND :fecha_fin AND cs.num_contenedor NOT IN (SELECT num_contenedor FROM contenedor_generador)
			ORDER BY e.fecha_entrada;
		");

		$query->execute(array(
			':fecha_inicio' => $fecha_inicio,
			':fecha_fin' => $fecha_fin
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_historico_movimientos_entrada_por_fecha_propietario($fecha_inicio, $fecha_fin, $cif_propietario)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				cs.num_contenedor,
				c.id_tipo_contenedor_iso,
				c.tara_contenedor,
				tci.longitud_tipo_contenedor,
				tci.descripcion_tipo_contenedor,
				cs.id_entrada AS id,
				e.fecha_entrada AS fecha,
				e.id_tipo_entrada,
				'ENTRADA' AS tipo,
		    CONCAT ('ENTRADA', ' ', te.tipo_entrada) AS tipo_movimiento,

				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT cif_propietario FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT cif_propietario FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
	         		WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 			      THEN (SELECT cif_propietario_actual FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS cif_propietario_actual,

				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT nombre_comercial_propietario FROM entrada_vagon_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_vagon_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT nombre_comercial_propietario FROM entrada_camion_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_camion_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
	         		WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 			      THEN (SELECT nombre_comercial_propietario FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN propietario ON propietario.cif_propietario = traspaso.cif_propietario_actual WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS nombre_comercial_propietario,

				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT num_expedicion FROM entrada_tipo_tren WHERE id_entrada = cs.id_entrada)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT num_expedicion FROM entrada_tipo_camion WHERE id_entrada = cs.id_entrada)
				END) AS num_expedicion,

				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT num_expedicion FROM entrada_tipo_tren WHERE id_entrada = cs.id_entrada)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT CONCAT(matricula_tractora, ' / ', matricula_remolque) FROM entrada_tipo_camion WHERE id_entrada = cs.id_entrada)
				END) AS num_expedicion2,

				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT matricula_tractora FROM entrada_tipo_camion WHERE id_entrada = cs.id_entrada)
				END) AS matricula_tractora,

				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT peso_bruto_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT peso_mercancia_contenedor+c.tara_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
           			WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 			      THEN (SELECT peso_bruto_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS peso_bruto,

				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT peso_bruto_contenedor-c.tara_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT peso_mercancia_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 			    THEN (SELECT peso_mercancia_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS peso_mercancia,

				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT estado_carga_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT estado_carga_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
	        WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 	 		    THEN (SELECT estado_carga_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS estado_carga_contenedor,
				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT id_tipo_mercancia FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT id_tipo_mercancia FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				   	WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT id_tipo_mercancia FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS id_tipo_mercancia,
				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT descripcion_mercancia FROM entrada_vagon_contenedor INNER JOIN tipo_mercancia ON tipo_mercancia.id_tipo_mercancia = entrada_vagon_contenedor.id_tipo_mercancia WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT descripcion_mercancia FROM entrada_camion_contenedor INNER JOIN tipo_mercancia ON tipo_mercancia.id_tipo_mercancia = entrada_camion_contenedor.id_tipo_mercancia WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT descripcion_mercancia FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN tipo_mercancia ON tipo_mercancia.id_tipo_mercancia = traspaso.id_tipo_mercancia WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS descripcion_mercancia,

				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT num_peligro_adr FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT num_peligro_adr FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
	        WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 	 		    THEN (SELECT num_peligro_adr FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS num_peligro_adr,

				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT num_onu_adr FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT num_onu_adr FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
	        WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 	 		    THEN (SELECT num_onu_adr FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS num_onu_adr,

				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT id_destinatario FROM entrada_vagon_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = entrada_vagon_contenedor.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT id_destinatario FROM entrada_camion_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = entrada_camion_contenedor.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT id_destinatario FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS id_destinatario,

				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT nombre_empresa_destino_origen FROM entrada_vagon_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = entrada_vagon_contenedor.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT nombre_empresa_destino_origen FROM entrada_camion_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = entrada_camion_contenedor.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT nombre_empresa_destino_origen FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = traspaso.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS nombre_destinatario,

				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT num_tarjeta_teco FROM entrada_vagon_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = entrada_vagon_contenedor.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT num_tarjeta_teco FROM entrada_camion_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = entrada_camion_contenedor.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT num_tarjeta_teco FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = traspaso.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS num_tarjeta_teco,

				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT nombre_estacion_ferrocarril FROM entrada_camion_contenedor INNER JOIN estacion_ferrocarril_renfe ON estacion_ferrocarril_renfe.codigo_estacion_ferrocarril = entrada_camion_contenedor.codigo_estacion_ferrocarril WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS nombre_estacion_ferrocarril,

				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT num_booking_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT num_booking_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS num_booking_contenedor,

				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT num_precinto_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT num_precinto_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS num_precinto_contenedor,

				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT temperatura_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT temperatura_contenedor  FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT temperatura_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS temperatura_contenedor,

				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
						THEN (SELECT materia_peligrosa FROM contenedor_materia_peligrosa WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor GROUP BY num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
						THEN (SELECT materia_peligrosa FROM contenedor_materia_peligrosa WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor GROUP BY num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
						THEN (SELECT materia_peligrosa FROM contenedor_materia_peligrosa WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor GROUP BY num_contenedor)
				END) AS materia_peligrosa

			FROM (((control_stock cs INNER JOIN entrada e ON e.id_entrada = cs.id_entrada)
				INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada)
			    	INNER JOIN contenedor c ON c.num_contenedor = cs.num_contenedor)
			        	INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso
			WHERE DATE(e.fecha_entrada) BETWEEN :fecha_inicio AND :fecha_fin AND cs.num_contenedor NOT IN (SELECT num_contenedor FROM contenedor_generador)
			HAVING (cif_propietario_actual = :cif_propietario)
			ORDER BY e.fecha_entrada;

		");

		$query->execute(array(
			':fecha_inicio' => $fecha_inicio,
			':fecha_fin' => $fecha_fin,
			':cif_propietario' => $cif_propietario
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_historico_movimientos_salida_por_fecha($fecha_inicio, $fecha_fin)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				cs.num_contenedor,
				c.id_tipo_contenedor_iso,
				c.tara_contenedor,
				tci.longitud_tipo_contenedor,
				tci.descripcion_tipo_contenedor,
				cs.id_entrada,
				cs.id_salida AS id,
				s.fecha_salida AS fecha,
				s.id_tipo_salida,
				'SALIDA' AS tipo,
			  CONCAT ('SALIDA', ' ', ts.tipo_salida) AS tipo_movimiento,
				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT cif_propietario FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT cif_propietario FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 			   		THEN (SELECT cif_propietario_actual FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS cif_propietario_actual,
				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT nombre_comercial_propietario FROM entrada_vagon_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_vagon_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT nombre_comercial_propietario FROM entrada_camion_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_camion_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
           			WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 			    THEN (SELECT nombre_comercial_propietario FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN propietario ON propietario.cif_propietario = traspaso.cif_propietario_actual WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS nombre_comercial_propietario,
				(CASE
			    	WHEN (SELECT tipo_salida FROM salida INNER JOIN tipo_salida ON tipo_salida.id_tipo_salida = salida.id_tipo_salida WHERE id_salida = cs.id_salida) = 'TREN'
			        	THEN (SELECT num_expedicion FROM salida_tipo_tren WHERE id_salida = cs.id_salida)
			        WHEN (SELECT tipo_salida FROM salida INNER JOIN tipo_salida ON tipo_salida.id_tipo_salida = salida.id_tipo_salida WHERE id_salida = cs.id_salida) = 'CAMIÓN'
			            THEN (SELECT num_expedicion FROM salida_tipo_camion WHERE id_salida = cs.id_salida)
			  	END) AS num_expedicion,
				(CASE
			    	WHEN (SELECT tipo_salida FROM salida INNER JOIN tipo_salida ON tipo_salida.id_tipo_salida = salida.id_tipo_salida WHERE id_salida = cs.id_salida) = 'TREN'
			        	THEN (SELECT num_expedicion FROM salida_tipo_tren WHERE id_salida = cs.id_salida)
			        WHEN (SELECT tipo_salida FROM salida INNER JOIN tipo_salida ON tipo_salida.id_tipo_salida = salida.id_tipo_salida WHERE id_salida = cs.id_salida) = 'CAMIÓN'
			            THEN (SELECT CONCAT(matricula_tractora, ' / ', matricula_remolque) FROM salida_tipo_camion WHERE id_salida = cs.id_salida)
			  	END) AS num_expedicion2,
				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
				  		THEN (SELECT peso_bruto_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				  	WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
						  THEN (SELECT peso_mercancia_contenedor+c.tara_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 					THEN (SELECT peso_bruto_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS peso_bruto,

				(CASE
 					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
 				  		THEN (SELECT peso_bruto_contenedor-c.tara_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
 				  	WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
 					   	THEN (SELECT peso_mercancia_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
 	 	 			    THEN (SELECT peso_mercancia_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
 				END) AS peso_mercancia,

				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
						THEN (SELECT estado_carga_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
						THEN (SELECT estado_carga_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
 	 	 		    THEN (SELECT estado_carga_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS estado_carga_contenedor,
				(CASE
			    	WHEN (SELECT tipo_salida FROM salida INNER JOIN tipo_salida ON tipo_salida.id_tipo_salida = salida.id_tipo_salida WHERE id_salida = cs.id_salida) = 'TREN'
			        	THEN
									(CASE
										WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
											THEN (SELECT id_destinatario FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
										WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
											THEN (SELECT id_destinatario FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
									END)
						WHEN (SELECT tipo_salida FROM salida INNER JOIN tipo_salida ON tipo_salida.id_tipo_salida = salida.id_tipo_salida WHERE id_salida = cs.id_salida) = 'CAMIÓN'
			            THEN (SELECT id_destinatario FROM salida_camion_contenedor WHERE id_salida = cs.id_salida)
			   	END) AS id_destinatario,

				(CASE
 			    	WHEN (SELECT tipo_salida FROM salida INNER JOIN tipo_salida ON tipo_salida.id_tipo_salida = salida.id_tipo_salida WHERE id_salida = cs.id_salida) = 'TREN'
 			        	THEN
 									(CASE
 										WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
 											THEN (SELECT nombre_empresa_destino_origen  FROM entrada_vagon_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = entrada_vagon_contenedor.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
 										WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
 											THEN (SELECT nombre_empresa_destino_origen  FROM entrada_camion_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = entrada_camion_contenedor.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
 									END)
 						WHEN (SELECT tipo_salida FROM salida INNER JOIN tipo_salida ON tipo_salida.id_tipo_salida = salida.id_tipo_salida WHERE id_salida = cs.id_salida) = 'CAMIÓN'
 			            THEN (SELECT nombre_empresa_destino_origen  FROM salida_camion_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = salida_camion_contenedor.id_destinatario WHERE id_salida = cs.id_salida)
 			   	END) AS nombre_destinatario,

				(CASE
 					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
 						THEN (SELECT num_booking_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
 	 	 	 	    THEN (SELECT num_booking_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
 				END) AS num_booking_contenedor,

				(CASE
				WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
					THEN (SELECT num_precinto_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
  	 	 	   		THEN (SELECT num_precinto_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
			 	END) AS num_precinto_contenedor,
			 	(CASE
				 	WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
						THEN (SELECT id_tipo_mercancia FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				 	WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
					 	THEN (SELECT id_tipo_mercancia FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				 	WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 	 	   		THEN (SELECT id_tipo_mercancia FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
			 	END) AS id_tipo_mercancia,
			 	(CASE
				 	WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
					 	THEN (SELECT descripcion_mercancia FROM entrada_vagon_contenedor INNER JOIN tipo_mercancia ON tipo_mercancia.id_tipo_mercancia = entrada_vagon_contenedor.id_tipo_mercancia WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				 	WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
					 	THEN (SELECT descripcion_mercancia FROM entrada_camion_contenedor INNER JOIN tipo_mercancia ON tipo_mercancia.id_tipo_mercancia = entrada_camion_contenedor.id_tipo_mercancia WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				 	WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
  	 	 	   			THEN (SELECT descripcion_mercancia FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN tipo_mercancia ON tipo_mercancia.id_tipo_mercancia = traspaso.id_tipo_mercancia WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
			 	END) AS descripcion_mercancia,

			 	(CASE
					WHEN (SELECT tipo_salida FROM salida INNER JOIN tipo_salida ON tipo_salida.id_tipo_salida = salida.id_tipo_salida WHERE id_salida = cs.id_salida) = 'TREN'
							 THEN
								 (CASE
									 WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
										 THEN (SELECT temperatura_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
									 WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
										 THEN (SELECT temperatura_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
								 END)
					 WHEN (SELECT tipo_salida FROM salida INNER JOIN tipo_salida ON tipo_salida.id_tipo_salida = salida.id_tipo_salida WHERE id_salida = cs.id_salida) = 'CAMIÓN'
								 THEN (SELECT temperatura_contenedor FROM salida_camion_contenedor WHERE id_salida = cs.id_salida)
				END) AS temperatura_contenedor


			FROM ((((control_stock cs INNER JOIN salida s ON s.id_salida = cs.id_salida)
				INNER JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida)
			    	INNER JOIN contenedor c ON c.num_contenedor = cs.num_contenedor)
			        	INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso)
			            	INNER JOIN entrada e ON e.id_entrada = cs.id_entrada
			WHERE DATE(s.fecha_salida) BETWEEN :fecha_inicio AND :fecha_fin AND cs.num_contenedor NOT IN (SELECT num_contenedor FROM contenedor_generador)
			ORDER BY s.fecha_salida;

		");

		$query->execute(array(
			':fecha_inicio' => $fecha_inicio,
			':fecha_fin' => $fecha_fin
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_historico_movimientos_salida_por_fecha_propietario($fecha_inicio, $fecha_fin, $cif_propietario)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				cs.num_contenedor,
				c.id_tipo_contenedor_iso,
				c.tara_contenedor,
				tci.longitud_tipo_contenedor,
				tci.descripcion_tipo_contenedor,
				cs.id_entrada,
				cs.id_salida AS id,
				s.fecha_salida AS fecha,
				s.id_tipo_salida,
				'SALIDA' AS tipo,
			  CONCAT ('SALIDA', ' ', ts.tipo_salida) AS tipo_movimiento,
				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT cif_propietario FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					 WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT cif_propietario FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					 WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 			   		THEN (SELECT cif_propietario_actual FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS cif_propietario_actual,
				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT nombre_comercial_propietario FROM entrada_vagon_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_vagon_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT nombre_comercial_propietario FROM entrada_camion_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_camion_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
           			WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 			    THEN (SELECT nombre_comercial_propietario FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN propietario ON propietario.cif_propietario = traspaso.cif_propietario_actual WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS nombre_comercial_propietario,

				(CASE
			    	WHEN (SELECT tipo_salida FROM salida INNER JOIN tipo_salida ON tipo_salida.id_tipo_salida = salida.id_tipo_salida WHERE id_salida = cs.id_salida) = 'TREN'
			        	THEN (SELECT num_expedicion FROM salida_tipo_tren WHERE id_salida = cs.id_salida)
			        WHEN (SELECT tipo_salida FROM salida INNER JOIN tipo_salida ON tipo_salida.id_tipo_salida = salida.id_tipo_salida WHERE id_salida = cs.id_salida) = 'CAMIÓN'
			            THEN (SELECT num_expedicion FROM salida_tipo_camion WHERE id_salida = cs.id_salida)
			  END) AS num_expedicion,

				(CASE
			    	WHEN (SELECT tipo_salida FROM salida INNER JOIN tipo_salida ON tipo_salida.id_tipo_salida = salida.id_tipo_salida WHERE id_salida = cs.id_salida) = 'TREN'
			        	THEN (SELECT num_expedicion FROM salida_tipo_tren WHERE id_salida = cs.id_salida)
			        WHEN (SELECT tipo_salida FROM salida INNER JOIN tipo_salida ON tipo_salida.id_tipo_salida = salida.id_tipo_salida WHERE id_salida = cs.id_salida) = 'CAMIÓN'
			            THEN (SELECT CONCAT(matricula_tractora, ' / ', matricula_remolque) FROM salida_tipo_camion WHERE id_salida = cs.id_salida)
			  END) AS num_expedicion2,

				(CASE
			     WHEN (SELECT tipo_salida FROM salida INNER JOIN tipo_salida ON tipo_salida.id_tipo_salida = salida.id_tipo_salida WHERE id_salida = cs.id_salida) = 'CAMIÓN'
			     THEN (SELECT matricula_tractora FROM salida_tipo_camion WHERE id_salida = cs.id_salida)
			  END) AS matricula_tractora,

				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
				  		THEN (SELECT peso_bruto_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				  	WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
					    THEN (SELECT peso_mercancia_contenedor+c.tara_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 				THEN (SELECT peso_bruto_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				 END) AS peso_bruto,

				 (CASE
 					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
 				  		THEN (SELECT peso_bruto_contenedor-c.tara_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
 				  WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
 						  THEN (SELECT peso_mercancia_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 	 				THEN (SELECT peso_mercancia_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
 				 END) AS peso_mercancia,

				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
						THEN (SELECT estado_carga_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
						THEN (SELECT estado_carga_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
 	 	 	 			THEN (SELECT estado_carga_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS estado_carga_contenedor,

				(CASE
			    	WHEN (SELECT tipo_salida FROM salida INNER JOIN tipo_salida ON tipo_salida.id_tipo_salida = salida.id_tipo_salida WHERE id_salida = cs.id_salida) = 'TREN'
			        	THEN
									(CASE
										WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
											THEN (SELECT id_destinatario FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
										WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
											THEN (SELECT id_destinatario FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
									END)
						WHEN (SELECT tipo_salida FROM salida INNER JOIN tipo_salida ON tipo_salida.id_tipo_salida = salida.id_tipo_salida WHERE id_salida = cs.id_salida) = 'CAMIÓN'
			            THEN (SELECT id_destinatario FROM salida_camion_contenedor WHERE id_salida = cs.id_salida)
			   	END) AS id_destinatario,

				(CASE
 			    	WHEN (SELECT tipo_salida FROM salida INNER JOIN tipo_salida ON tipo_salida.id_tipo_salida = salida.id_tipo_salida WHERE id_salida = cs.id_salida) = 'TREN'
 			        	THEN
 									(CASE
 										WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
 											THEN (SELECT nombre_empresa_destino_origen  FROM entrada_vagon_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = entrada_vagon_contenedor.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
 										WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
 											THEN (SELECT nombre_empresa_destino_origen  FROM entrada_camion_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = entrada_camion_contenedor.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
 									END)
 						WHEN (SELECT tipo_salida FROM salida INNER JOIN tipo_salida ON tipo_salida.id_tipo_salida = salida.id_tipo_salida WHERE id_salida = cs.id_salida) = 'CAMIÓN'
 			            THEN (SELECT nombre_empresa_destino_origen  FROM salida_camion_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = salida_camion_contenedor.id_destinatario WHERE id_salida = cs.id_salida)
 			   	END) AS nombre_destinatario,

					(CASE
	 			    	WHEN (SELECT tipo_salida FROM salida INNER JOIN tipo_salida ON tipo_salida.id_tipo_salida = salida.id_tipo_salida WHERE id_salida = cs.id_salida) = 'TREN'
	 			        	THEN
	 									(CASE
	 										WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
	 											THEN (SELECT num_tarjeta_teco FROM entrada_vagon_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = entrada_vagon_contenedor.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
	 										WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
	 											THEN (SELECT num_tarjeta_teco FROM entrada_camion_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = entrada_camion_contenedor.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
	 									END)
	 						WHEN (SELECT tipo_salida FROM salida INNER JOIN tipo_salida ON tipo_salida.id_tipo_salida = salida.id_tipo_salida WHERE id_salida = cs.id_salida) = 'CAMIÓN'
	 			            THEN (SELECT num_tarjeta_teco FROM salida_camion_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = salida_camion_contenedor.id_destinatario WHERE id_salida = cs.id_salida)
	 			   	END) AS num_tarjeta_teco,

				(CASE
 					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
 						THEN (SELECT num_booking_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
 	 	 	 	 	  THEN (SELECT num_booking_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
 				END) AS num_booking_contenedor,

				(CASE
				 WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
					 THEN (SELECT num_precinto_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				 WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 	 	   THEN (SELECT num_precinto_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
			 	END) AS num_precinto_contenedor,

				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
					 	THEN (SELECT id_tipo_mercancia FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				 	WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
					 	THEN (SELECT id_tipo_mercancia FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				 	WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 	 	   		THEN (SELECT id_tipo_mercancia FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
			 	END) AS id_tipo_mercancia,
			 	(CASE
				 	WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
					 	THEN (SELECT descripcion_mercancia FROM entrada_vagon_contenedor INNER JOIN tipo_mercancia ON tipo_mercancia.id_tipo_mercancia = entrada_vagon_contenedor.id_tipo_mercancia WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				 	WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
					 	THEN (SELECT descripcion_mercancia FROM entrada_camion_contenedor INNER JOIN tipo_mercancia ON tipo_mercancia.id_tipo_mercancia = entrada_camion_contenedor.id_tipo_mercancia WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				 	WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 	 	 		THEN (SELECT descripcion_mercancia FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN tipo_mercancia ON tipo_mercancia.id_tipo_mercancia = traspaso.id_tipo_mercancia WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
			 	END) AS descripcion_mercancia,
			 	(CASE
					WHEN (SELECT tipo_salida FROM salida INNER JOIN tipo_salida ON tipo_salida.id_tipo_salida = salida.id_tipo_salida WHERE id_salida = cs.id_salida) = 'TREN'
							 THEN
								 (CASE
									 WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
										 THEN (SELECT temperatura_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
									 WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
										 THEN (SELECT temperatura_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
								 END)
					WHEN (SELECT tipo_salida FROM salida INNER JOIN tipo_salida ON tipo_salida.id_tipo_salida = salida.id_tipo_salida WHERE id_salida = cs.id_salida) = 'CAMIÓN'
								 THEN (SELECT temperatura_contenedor FROM salida_camion_contenedor WHERE id_salida = cs.id_salida)
				END) AS temperatura_contenedor,
				(CASE
					WHEN (SELECT tipo_salida FROM salida INNER JOIN tipo_salida ON tipo_salida.id_tipo_salida = salida.id_tipo_salida WHERE id_salida = cs.id_salida) = 'TREN'
						THEN (SELECT materia_peligrosa FROM contenedor_materia_peligrosa WHERE id_salida = cs.id_salida AND num_contenedor = cs.num_contenedor GROUP BY num_contenedor)
					WHEN (SELECT tipo_salida FROM salida INNER JOIN tipo_salida ON tipo_salida.id_tipo_salida = salida.id_tipo_salida WHERE id_salida = cs.id_salida) = 'CAMIÓN'
						THEN (SELECT materia_peligrosa FROM contenedor_materia_peligrosa WHERE id_salida = cs.id_salida AND num_contenedor = cs.num_contenedor GROUP BY num_contenedor)
					WHEN (SELECT tipo_salida FROM salida INNER JOIN tipo_salida ON tipo_salida.id_tipo_salida = salida.id_tipo_salida WHERE id_salida = cs.id_salida) = 'TRASPASO'
						THEN (SELECT materia_peligrosa FROM contenedor_materia_peligrosa WHERE id_salida = cs.id_salida AND num_contenedor = cs.num_contenedor GROUP BY num_contenedor)
				END) AS materia_peligrosa

			FROM ((((control_stock cs INNER JOIN salida s ON s.id_salida = cs.id_salida)
				INNER JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida)
			  	INNER JOIN contenedor c ON c.num_contenedor = cs.num_contenedor)
			    	INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso)
			      	INNER JOIN entrada e ON e.id_entrada = cs.id_entrada
			WHERE DATE(s.fecha_salida) BETWEEN :fecha_inicio AND :fecha_fin AND cs.num_contenedor NOT IN (SELECT num_contenedor FROM contenedor_generador)
			HAVING (cif_propietario_actual = :cif_propietario)
			ORDER BY s.fecha_salida;
		");

		$query->execute(array(
			':fecha_inicio' => $fecha_inicio,
			':fecha_fin' => $fecha_fin,
			':cif_propietario' => $cif_propietario
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_traspaso_por_id_salida($id_salida)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
		SELECT
			t.id_traspaso,
			t.fecha_traspaso,
			t.num_contenedor,
			t.cif_propietario_anterior,
			(SELECT nombre_comercial_propietario FROM propietario WHERE cif_propietario = t.cif_propietario_anterior) AS nombre_comercial_propietario_anterior,
			t.cif_propietario_actual,
			(SELECT nombre_comercial_propietario FROM propietario WHERE cif_propietario = t.cif_propietario_actual) AS nombre_comercial_propietario_actual,
			stt.id_salida,
			ett.id_entrada
		FROM (traspaso t INNER JOIN salida_tipo_traspaso stt ON stt.id_traspaso = t.id_traspaso) INNER JOIN entrada_tipo_traspaso ett ON ett.id_traspaso = t.id_traspaso
		WHERE stt.id_salida = :id_salida;
		");

		$query->execute(array(
			':id_salida' => $id_salida
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_traspaso_por_id_entrada($id_entrada)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
		SELECT
			t.id_traspaso,
		    t.fecha_traspaso,
			t.num_contenedor,
		    t.cif_propietario_anterior,
		    (SELECT nombre_comercial_propietario FROM propietario WHERE cif_propietario = t.cif_propietario_anterior) AS nombre_comercial_propietario_anterior,
		    t.cif_propietario_actual,
		    (SELECT nombre_comercial_propietario FROM propietario WHERE cif_propietario = t.cif_propietario_actual) AS nombre_comercial_propietario_actual,
		    stt.id_salida,
		    ett.id_entrada
		FROM (traspaso t INNER JOIN salida_tipo_traspaso stt ON stt.id_traspaso = t.id_traspaso) INNER JOIN entrada_tipo_traspaso ett ON ett.id_traspaso = t.id_traspaso
		WHERE stt.id_entrada = :id_entrada;
		");

		$query->execute(array(
			':id_entrada' => $id_entrada
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	/////////////////////////////////////////////FICHEROS///////////////////////////////////////////////////////////////////////////////////////

	public function get_fichero($id_fichero)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
			  f.id_fichero,
			  f.ruta_fichero,
			  UPPER(substring_index(f.ruta_fichero,'.',-1)) AS extension,
			  f.fecha_insert,
			  f.user_insert,
			  f.id_tipo_fichero,
			  tf.tipo_fichero
			FROM fichero f INNER JOIN tipo_fichero tf ON tf.id_tipo_fichero = f.id_tipo_fichero
			WHERE id_fichero = :id_fichero
		");

		$query->execute(array(
			':id_fichero' => $id_fichero
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_fotos_parte_trabajo($id_parte_trabajo)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				f.id_fichero,
			  f.ruta_fichero,
			  f.fecha_insert,
			  f.user_insert,
			  f.id_tipo_fichero,
			  tf.tipo_fichero
			FROM (fichero f INNER JOIN tipo_fichero tf ON tf.id_tipo_fichero = f.id_tipo_fichero)
				INNER JOIN fichero_parte_trabajo fpt ON fpt.id_fichero = f.id_fichero
			WHERE fpt.id_parte_trabajo = :id_parte_trabajo
		");

		$query->execute(array(
			':id_parte_trabajo' => $id_parte_trabajo
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function existe_tipo_fichero_incidencia_evento($id_evento, $id_tipo_fichero)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				f.id_fichero,
				f.ruta_fichero,
				f.fecha_insert,
				f.user_insert,
				f.id_tipo_fichero,
				tf.tipo_fichero,
				fie.id_evento
			FROM (fichero f INNER JOIN fichero_incidencia_evento fie ON fie.id_fichero = f.id_fichero)
				INNER JOIN tipo_fichero tf ON tf.id_tipo_fichero = f.id_tipo_fichero
			WHERE fe.id_entrada = :id_entrada AND f.id_tipo_fichero = :id_tipo_fichero;
		");

		$query->execute(array(
			':id_evento' => $id_evento,
			':id_tipo_fichero' => $id_tipo_fichero
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function existe_tipo_fichero_entrada($id_entrada, $id_tipo_fichero)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				f.id_fichero,
				f.ruta_fichero,
				f.fecha_insert,
				f.user_insert,
				f.id_tipo_fichero,
				tf.tipo_fichero,
				fe.id_entrada
			FROM (fichero f INNER JOIN fichero_entrada fe ON fe.id_fichero = f.id_fichero)
				INNER JOIN tipo_fichero tf ON tf.id_tipo_fichero = f.id_tipo_fichero
			WHERE fe.id_entrada = :id_entrada AND f.id_tipo_fichero = :id_tipo_fichero;
		");

		$query->execute(array(
			':id_entrada' => $id_entrada,
			':id_tipo_fichero' => $id_tipo_fichero
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function existe_tipo_fichero_salida($id_salida, $id_tipo_fichero)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				f.id_fichero,
				f.ruta_fichero,
				f.fecha_insert,
				f.user_insert,
				f.id_tipo_fichero,
				tf.tipo_fichero,
				fs.id_salida
			FROM (fichero f INNER JOIN fichero_salida fs ON fs.id_fichero = f.id_fichero)
				INNER JOIN tipo_fichero tf ON tf.id_tipo_fichero = f.id_tipo_fichero
			WHERE fs.id_salida = :id_salida AND f.id_tipo_fichero = :id_tipo_fichero;
		");

		$query->execute(array(
			':id_salida' => $id_salida,
			':id_tipo_fichero' => $id_tipo_fichero
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_ficheros_por_id_entrada($id_entrada)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT f.id_fichero, f.ruta_fichero, UPPER(substring_index(f.ruta_fichero,'.',-1)) AS extension, tf.tipo_fichero, e.id_entrada
			FROM ((fichero f INNER JOIN tipo_fichero tf ON f.id_tipo_fichero = tf.id_tipo_fichero)
				INNER JOIN fichero_entrada fe ON f.id_fichero = fe.id_fichero)
					INNER JOIN entrada e ON fe.id_entrada = e.id_entrada
			WHERE e.id_entrada = :id_entrada;
		");

		$query->execute(array(
			':id_entrada' => $id_entrada
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_ficheros_por_id_salida($id_salida)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT f.id_fichero, f.ruta_fichero, UPPER(substring_index(f.ruta_fichero,'.',-1)) AS extension, tf.tipo_fichero, s.id_salida
			FROM ((fichero f INNER JOIN tipo_fichero tf ON f.id_tipo_fichero = tf.id_tipo_fichero)
				INNER JOIN fichero_salida fs ON f.id_fichero = fs.id_fichero)
					INNER JOIN salida s ON fs.id_salida = s.id_salida
			WHERE s.id_salida = :id_salida;
		");

		$query->execute(array(
			':id_salida' => $id_salida
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_ficheros_por_id_fichero_por_id_evento($id_incidencia)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
		SELECT
			i_e.id_evento,
			i_e.fecha_evento,
			i_e.nombre_evento,
			i_e.id_incidencia,
			fie.id_fichero,
			f.id_fichero,
			f.ruta_fichero,
			SUBSTRING_INDEX(f.ruta_fichero, '/', -1) AS nombre_fichero,
			UPPER(SUBSTRING_INDEX(f.ruta_fichero, '.', -1)) AS extension,
			f.id_tipo_fichero,
			tf.tipo_fichero
		FROM
			incidencia_evento i_e
			INNER JOIN fichero_incidencia_evento fie ON fie.id_evento = i_e.id_evento
			LEFT JOIN fichero f ON f.id_fichero = fie.id_fichero
			LEFT JOIN tipo_fichero tf ON tf.id_tipo_fichero = f.id_tipo_fichero
		WHERE
			i_e.id_incidencia = :id_incidencia
		ORDER BY
			i_e.fecha_evento;

		");

		$query->execute(array(
			':id_incidencia' => $id_incidencia
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_ficheros_por_id_evento($id_evento)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT f.id_fichero, f.ruta_fichero, substring_index(f.ruta_fichero, '/', -1) AS nombre_fichero, UPPER(substring_index(f.ruta_fichero,'.',-1)) AS extension, f.id_tipo_fichero, tf.tipo_fichero
			FROM ((fichero f INNER JOIN tipo_fichero tf ON f.id_tipo_fichero = tf.id_tipo_fichero)
				INNER JOIN fichero_incidencia_evento fie ON f.id_fichero = fie.id_fichero)
			WHERE fie.id_evento = :id_evento;
		");

		$query->execute(array(
			':id_evento' => $id_evento
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function insert_fichero($ruta_fichero, $user_insert, $id_tipo_fichero)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		$query = $this->conexion->prepare("
			INSERT INTO fichero(ruta_fichero, fecha_insert, user_insert, id_tipo_fichero)
			VALUES (:ruta_fichero, NOW(), :user_insert, :id_tipo_fichero);
		");

		$query->execute(array(
			':ruta_fichero' => $ruta_fichero,
			':user_insert' => $user_insert,
			':id_tipo_fichero' => $id_tipo_fichero
		));

		//cerramos la conexion a la BD
		$query = null;

		//obtenemos el id del registro insertado
		$this->result = $this->conexion->lastInsertId();

		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function insert_fichero_parte_trabajo($id_parte_trabajo, $id_fichero)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		$query = $this->conexion->prepare("
			INSERT INTO fichero_parte_trabajo(id_parte_trabajo, id_fichero)
			VALUES (:id_parte_trabajo, :id_fichero);
		");

		$query->execute(array(
			':id_parte_trabajo' => $id_parte_trabajo,
			':id_fichero' => $id_fichero
		));

		//cerramos la conexion a la BD
		$query = null;

		//obtenemos el id del registro insertado
		$this->result = $this->conexion->lastInsertId();

		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function delete_entrada_fichero($id_fichero)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		$query = $this->conexion->prepare("
			DELETE FROM fichero_entrada
			WHERE id_fichero = :id_fichero
		");

		$query->execute(array(
			':id_fichero' => $id_fichero
		));

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function delete_salida_fichero($id_fichero)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		$query = $this->conexion->prepare("
			DELETE FROM fichero_salida
			WHERE id_fichero = :id_fichero
		");

		$query->execute(array(
			':id_fichero' => $id_fichero
		));

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function delete_parte_trabajo_fichero($id_fichero)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		$query = $this->conexion->prepare("
			DELETE FROM fichero_parte_trabajo
			WHERE id_fichero = :id_fichero
		");

		$query->execute(array(
			':id_fichero' => $id_fichero
		));

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function delete_incidencia_evento_fichero($id_fichero)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		$query = $this->conexion->prepare("
			DELETE FROM fichero_incidencia_evento
			WHERE id_fichero = :id_fichero
		");

		$query->execute(array(
			':id_fichero' => $id_fichero
		));

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function delete_fichero($id_fichero)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		$query = $this->conexion->prepare("
			DELETE FROM fichero
			WHERE id_fichero = :id_fichero
		");

		$query->execute(array(
			':id_fichero' => $id_fichero
		));

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_tipos_ficheros()
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT id_tipo_fichero, tipo_fichero
			FROM tipo_fichero
			WHERE tipo_fichero != 'FOTO'
			ORDER BY tipo_fichero
		");

		$query->execute(array());

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function insert_entrada_fichero($id_entrada, $id_fichero)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		$query = $this->conexion->prepare("
			INSERT INTO fichero_entrada(id_entrada, id_fichero)
			VALUES (:id_entrada, :id_fichero)
		");

		$query->execute(array(
			':id_entrada' => $id_entrada,
			':id_fichero' => $id_fichero
		));

		//cerramos la conexion a la BD
		$query = null;

		//obtenemos el id del registro insertado
		$this->result = $this->conexion->lastInsertId();

		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function insert_salida_fichero($id_salida, $id_fichero)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		$query = $this->conexion->prepare("
			INSERT INTO fichero_salida(id_salida, id_fichero)
			VALUES (:id_salida, :id_fichero)
		");

		$query->execute(array(
			':id_salida' => $id_salida,
			':id_fichero' => $id_fichero
		));

		//cerramos la conexion a la BD
		$query = null;

		//obtenemos el id del registro insertado
		$this->result = $this->conexion->lastInsertId();

		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function insert_incidencia_evento_fichero($id_evento, $id_fichero)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		$query = $this->conexion->prepare("
			INSERT INTO fichero_incidencia_evento (id_fichero, id_evento)
			VALUES (:id_fichero, :id_evento)
		");

		$query->execute(array(
			':id_evento' => $id_evento,
			':id_fichero' => $id_fichero
		));

		//cerramos la conexion a la BD
		$query = null;

		//obtenemos el id del registro insertado
		$this->result = $this->conexion->lastInsertId();

		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	//////////////////////////////////////////////// ESTADISTICAS TIEMPO ESPERA //////////////////////////////////////////////////////////////////////////////////////

	public function get_time_stats()
	{

		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				year,
				month,
				t_max_espera_camion_en_cola,
				t_max_acceso_camion_ttm,
				(t_max_espera_camion_en_cola + t_max_acceso_camion_ttm) AS suma,
				t_medio_camion_tci,
				t_max_carga_descarga_tren
			FROM time_stats
		");

		$query->execute(array(
			//':fecha_max' => $fecha_max
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_time_stat($year, $month)
	{

		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				year,
				month,
				t_max_espera_camion_en_cola,
				t_max_acceso_camion_ttm,
				(t_max_espera_camion_en_cola + t_max_acceso_camion_ttm) AS suma,
				t_medio_camion_tci,
				t_max_carga_descarga_tren
			FROM time_stats
			WHERE year = :year AND month = :month;

		");

		$query->execute(array(
			':year' => $year,
			':month' => $month
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function insert_time_stat($year, $month, $t_max_espera_camion_en_cola, $t_max_acceso_camion_ttm, $t_medio_camion_tci, $t_max_carga_descarga_tren)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		$query = $this->conexion->prepare("
			INSERT INTO time_stats(year, month, t_max_espera_camion_en_cola, t_max_acceso_camion_ttm, t_medio_camion_tci, t_max_carga_descarga_tren)
			VALUES (:year, :month, :t_max_espera_camion_en_cola, :t_max_acceso_camion_ttm, :t_medio_camion_tci, :t_max_carga_descarga_tren);
		");

		$query->execute(array(
			':year' => $year,
			':month' => $month,
			':t_max_espera_camion_en_cola' => $t_max_espera_camion_en_cola,
			':t_max_acceso_camion_ttm' => $t_max_acceso_camion_ttm,
			':t_medio_camion_tci' => $t_medio_camion_tci,
			':t_max_carga_descarga_tren' => $t_max_carga_descarga_tren
		));

		//cerramos la conexion a la BD
		$query = null;

		//obtenemos el id del registro insertado
		$this->result = $this->conexion->lastInsertId();

		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_time_medio_camion()
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT ROUND(SUM(estancia)/COUNT(id_movimiento), 2) AS t_medio_camion_tci
			FROM
			(
			SELECT
				subconsulta.id_entrada AS id_movimiento,
				'ENTRADA' AS tipo_movimiento,
				subconsulta.fecha_entrada AS fecha_inicio_movimiento,
				subconsulta.fecha_fin_movimiento,
				TIMESTAMPDIFF(MINUTE, subconsulta.fecha_entrada, subconsulta.fecha_fin_movimiento) AS estancia,
				subconsulta.tipo_entrada AS tipo
			FROM (
				SELECT
					e.id_entrada,
					e.fecha_entrada,
					DATE_ADD(e.fecha_entrada, INTERVAL (FLOOR(RAND() * (15 - 10 + 1)) + 10) MINUTE) AS fecha_fin_movimiento,
					te.tipo_entrada
				FROM entrada e
				INNER JOIN tipo_entrada te ON e.id_tipo_entrada = te.id_tipo_entrada
				WHERE te.tipo_entrada = 'CAMIÓN'
			)AS subconsulta
			UNION
			SELECT
				subconsulta.id_salida AS id_movimiento,
				'SALIDA' AS tipo_movimiento,
				subconsulta.fecha_salida AS fecha_inicio_movimiento,
				subconsulta.fecha_fin_movimiento,
				TIMESTAMPDIFF(MINUTE, subconsulta.fecha_salida, subconsulta.fecha_fin_movimiento) AS estancia,
				subconsulta.tipo_salida AS tipo
			FROM (
				SELECT
					s.id_salida,
					s.fecha_salida,
					DATE_ADD(s.fecha_salida, INTERVAL (FLOOR(RAND() * (15 - 10 + 1)) + 10) MINUTE) AS fecha_fin_movimiento,
					ts.tipo_salida
				FROM salida s
				INNER JOIN tipo_salida ts ON s.id_tipo_salida = ts.id_tipo_salida
				WHERE ts.tipo_salida = 'CAMIÓN'
			)AS subconsulta
			) agrupado;
		");

		$query->execute(array());

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}
	//////////////////////////////////////////////// FIN ESTADISTICAS TIEMPO ESPERA //////////////////////////////////////////////////////////////////////////////////////

	////////////////////////////////////////////////FACTURACION//////////////////////////////////////////////////////////////////////////////////////
	public function get_facturacion_by_year_by_cliente($year, $id_cliente)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				f.id,
				f.year,
				f.month,
				f.importe_manipulacion_utis,
				f.importe_almacenaje,
				f.importe_conexionado_electrico,
				f.importe_control_temperatura,
				f.importe_limpieza,
				f.importe_horas_extras,
				f.importe_maniobra_terminal,
				f.importe_maniobra_generadores,
				f.importe_servicios_especiales,
				f.id_cliente,
				CONCAT(f.year, '-', f.month) AS fecha_año_mes,
				ROUND(
					(
						f.importe_manipulacion_utis +
						f.importe_almacenaje +
						f.importe_conexionado_electrico +
						f.importe_control_temperatura +
						f.importe_limpieza +
						f.importe_horas_extras +
						f.importe_maniobra_terminal +
						f.importe_maniobra_generadores +
						f.importe_servicios_especiales
					),
					2
				) AS importe_total,
				c.nombre_comercial_cliente,
				c.id_cliente
			FROM facturacion f INNER JOIN cliente c ON c.id_cliente = f.id_cliente
			WHERE f.year = :year AND f.id_cliente = :id_cliente
			ORDER BY year ASC;
		");

		$query->execute(array(
			':year' => $year,
			':id_cliente' => $id_cliente
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_facturacion_by_year_by_month_by_cliente($year, $month, $id_cliente)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				*,
				CONCAT(year,'-',month) AS fecha_año_mes,
				ROUND((importe_manipulacion_utis +
										importe_almacenaje +
										importe_conexionado_electrico +
										importe_control_temperatura +
										importe_limpieza + importe_horas_extras +
										importe_maniobra_terminal +
										importe_maniobra_generadores +
										importe_servicios_especiales), 2) AS importe_total
				FROM facturacion
			WHERE year = :year AND month = :month AND id_cliente = :id_cliente
			ORDER BY month ASC
		");

		$query->execute(array(
			':year' => $year,
			':month' => $month,
			':id_cliente' => $id_cliente
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function update_facturacion_mensual(
		$year,
		$month,
		$importe_manipulacion_utis,
		$importe_almacenaje,
		$importe_conexionado_electrico,
		$importe_control_temperatura,
		$importe_limpieza,
		$importe_horas_extras,
		$importe_maniobra_terminal,
		$importe_maniobra_generadores,
		$importe_servicios_especiales,
		$id_cliente
	) {
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		$query = $this->conexion->prepare("
			UPDATE facturacion
			SET
				importe_manipulacion_utis = :importe_manipulacion_utis,
				importe_almacenaje = :importe_almacenaje,
			  importe_conexionado_electrico = :importe_conexionado_electrico,
			  importe_control_temperatura = :importe_control_temperatura,
			  importe_limpieza = :importe_limpieza,
			  importe_horas_extras = :importe_horas_extras,
			  importe_maniobra_terminal = :importe_maniobra_terminal,
				importe_maniobra_generadores = :importe_maniobra_generadores,
			  importe_servicios_especiales = :importe_servicios_especiales
			WHERE year = :year AND month = :month AND id_cliente = :id_cliente;
		");

		$query->execute(array(
			':year' => $year,
			':month' => $month,
			':importe_manipulacion_utis' => $importe_manipulacion_utis,
			':importe_almacenaje' => $importe_almacenaje,
			':importe_conexionado_electrico' => $importe_conexionado_electrico,
			':importe_control_temperatura' => $importe_control_temperatura,
			':importe_limpieza' => $importe_limpieza,
			':importe_horas_extras' => $importe_horas_extras,
			':importe_maniobra_terminal' => $importe_maniobra_terminal,
			'importe_maniobra_generadores' => $importe_maniobra_generadores,
			':importe_servicios_especiales' => $importe_servicios_especiales,
			':id_cliente' => $id_cliente
		));

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function insert_facturacion_mensual(
		$year,
		$month,
		$importe_manipulacion_utis,
		$importe_almacenaje,
		$importe_conexionado_electrico,
		$importe_control_temperatura,
		$importe_limpieza,
		$importe_horas_extras,
		$importe_maniobra_terminal,
		$importe_maniobra_generadores,
		$importe_servicios_especiales,
		$id_cliente
	) {
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		$query = $this->conexion->prepare("
			INSERT INTO facturacion
				(year,
				month,
				importe_manipulacion_utis,
				importe_almacenaje,
				importe_conexionado_electrico,
				importe_control_temperatura,
				importe_limpieza,
				importe_horas_extras,
				importe_maniobra_terminal,
				importe_maniobra_generadores,
				importe_servicios_especiales,
				id_cliente)
			VALUES (:year, :month, :importe_manipulacion_utis,
					:importe_almacenaje, :importe_conexionado_electrico, :importe_control_temperatura,
					:importe_limpieza, :importe_horas_extras, :importe_maniobra_terminal, :importe_maniobra_generadores,
					:importe_servicios_especiales, :id_cliente);
		");

		$query->execute(array(
			':year' => $year,
			':month' => $month,
			':importe_manipulacion_utis' => $importe_manipulacion_utis,
			':importe_almacenaje' => $importe_almacenaje,
			':importe_conexionado_electrico' => $importe_conexionado_electrico,
			':importe_control_temperatura' => $importe_control_temperatura,
			':importe_limpieza' => $importe_limpieza,
			':importe_horas_extras' => $importe_horas_extras,
			':importe_maniobra_terminal' => $importe_maniobra_terminal,
			':importe_maniobra_generadores' => $importe_maniobra_generadores,
			':importe_servicios_especiales' => $importe_servicios_especiales,
			':id_cliente' => $id_cliente
		));

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_id_cliente_por_nombre($nombre_comercial_cliente)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
		SELECT
			id_cliente,
			cif_cliente,
			nombre_cliente,
			nombre_comercial_cliente,
			direccion_cliente,
			persona_contacto,
			email_contacto
		FROM cliente
		WHERE nombre_comercial_cliente = :nombre_comercial_cliente
		");

		$query->execute(array(
			':nombre_comercial_cliente' => $nombre_comercial_cliente
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_id_propietario_por_nombre($nombre_comercial_propietario)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				cif_propietario,
				nombre_propietario,
				nombre_comercial_propietario,
				direccion_propietario,
				persona_contacto,
				email_contacto,
				id_cliente
			FROM propietario
			WHERE nombre_comercial_propietario = :nombre_comercial_propietario
		");

		$query->execute(array(
			':nombre_comercial_propietario' => $nombre_comercial_propietario
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function manipulacion_uti_por_fecha_por_cliente($fecha_inicio, $fecha_fin, $nombre_comercial_cliente)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				cs.num_contenedor,
				c.id_tipo_contenedor_iso,
				tci.longitud_tipo_contenedor,
				DATE(e.fecha_entrada) AS fecha_entrada,
				te.tipo_entrada,
				DATE(s.fecha_salida) AS fecha_salida,
				ts.tipo_salida,
				DATEDIFF(DATE(s.fecha_salida), DATE(e.fecha_entrada))+1 AS total_dias,
				(CASE
						WHEN (te.tipo_entrada) = 'TREN'
							THEN (SELECT nombre_comercial_cliente FROM entrada_vagon_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_vagon_contenedor.cif_propietario INNER JOIN cliente ON cliente.cif_cliente = propietario.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
						WHEN (te.tipo_entrada) = 'CAMIÓN'
							THEN (SELECT nombre_comercial_cliente FROM entrada_camion_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_camion_contenedor.cif_propietario INNER JOIN cliente ON cliente.cif_cliente = propietario.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
						WHEN (te.tipo_entrada) = 'TRASPASO'
							THEN (SELECT nombre_comercial_cliente FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN propietario ON propietario.cif_propietario = traspaso.cif_propietario_actual INNER JOIN cliente ON cliente.cif_cliente = propietario.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS nombre_comercial_cliente

			FROM control_stock cs INNER JOIN entrada e ON e.id_entrada = cs.id_entrada
				INNER JOIN salida s ON s.id_salida = cs.id_salida
				INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada
				INNER JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida
				INNER JOIN contenedor c ON c.num_contenedor = cs.num_contenedor
				INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso
			WHERE (DATE(fecha_salida) BETWEEN :fecha_inicio AND :fecha_fin) AND
						(cs.num_contenedor NOT IN (SELECT num_contenedor FROM contenedor_generador))
			HAVING nombre_comercial_cliente = :nombre_comercial_cliente;
		");

		$query->execute(array(
			':fecha_inicio' => $fecha_inicio,
			':fecha_fin' => $fecha_fin,
			':nombre_comercial_cliente' => $nombre_comercial_cliente
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function manipulacion_uti_por_fecha_por_cliente_renfe($fecha_inicio, $fecha_fin, $nombre_comercial_cliente)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
				SELECT
					cs.num_contenedor,
					c.id_tipo_contenedor_iso,
					tci.longitud_tipo_contenedor,
					DATE(e.fecha_entrada) AS fecha_entrada,
					te.tipo_entrada,
					(CASE
							WHEN DATE(s.fecha_salida) > :fecha_fin
								THEN ''
							WHEN DATE(s.fecha_salida) <= :fecha_fin
								THEN DATE(s.fecha_salida)
					END) AS fecha_salida,
					(CASE
							WHEN DATE(s.fecha_salida) > :fecha_fin
								THEN ''
							WHEN DATE(s.fecha_salida) <= :fecha_fin
								THEN ts.tipo_salida
					END) AS tipo_salida,
					(CASE
							WHEN (te.tipo_entrada) = 'TREN'
								THEN (SELECT nombre_comercial_cliente FROM entrada_vagon_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_vagon_contenedor.cif_propietario INNER JOIN cliente ON cliente.cif_cliente = propietario.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
							WHEN (te.tipo_entrada) = 'CAMIÓN'
								THEN (SELECT nombre_comercial_cliente FROM entrada_camion_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_camion_contenedor.cif_propietario INNER JOIN cliente ON cliente.cif_cliente = propietario.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
							WHEN (te.tipo_entrada) = 'TRASPASO'
								THEN (SELECT nombre_comercial_cliente FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN propietario ON propietario.cif_propietario = traspaso.cif_propietario_actual INNER JOIN cliente ON cliente.cif_cliente = propietario.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					END) AS nombre_comercial_cliente

				FROM control_stock cs INNER JOIN entrada e ON e.id_entrada = cs.id_entrada
					LEFT JOIN salida s ON s.id_salida = cs.id_salida
					INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada
					LEFT JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida
					INNER JOIN contenedor c ON c.num_contenedor = cs.num_contenedor
					INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso

				WHERE
					(
						DATE(s.fecha_salida) BETWEEN :fecha_inicio AND :fecha_fin
		      	OR s.fecha_salida IS NULL
		        OR DATE(s.fecha_salida) > :fecha_fin
					) AND (DATE(e.fecha_entrada) <= :fecha_fin)
				HAVING nombre_comercial_cliente = :nombre_comercial_cliente;
		");

		$query->execute(array(
			':fecha_inicio' => $fecha_inicio,
			':fecha_fin' => $fecha_fin,
			':nombre_comercial_cliente' => $nombre_comercial_cliente
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function conexionado_control_temperatura_cliente($fecha_inicio, $fecha_fin, $nombre_comercial_cliente)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				cs.id_control_stock,
				cs.num_contenedor,
			  	c.id_tipo_contenedor_iso,
			  	tci.longitud_tipo_contenedor,
			  	tci.descripcion_tipo_contenedor,
				e.id_entrada,
			  	te.tipo_entrada,
				DATE(e.fecha_entrada) AS fecha_conexion,
				e.id_tipo_entrada,
				s.id_salida,
			  	ts.tipo_salida,
				DATE(s.fecha_salida) AS fecha_desconexion,
				s.id_tipo_salida,
			  	DATEDIFF(DATE(s.fecha_salida), DATE(e.fecha_entrada))+1 AS total_dias,
				ecc.estado_carga_contenedor,
				ecc.temperatura_contenedor,
			  	cl.cif_cliente,
			  	cl.nombre_comercial_cliente
			FROM control_stock cs INNER JOIN entrada e ON cs.id_entrada = e.id_entrada
				INNER JOIN entrada_tipo_camion etc ON etc.id_entrada = e.id_entrada
			    INNER JOIN entrada_camion_contenedor ecc ON ecc.id_entrada = etc.id_entrada
			    INNER JOIN salida s ON s.id_salida = cs.id_salida
			    INNER JOIN contenedor c ON c.num_contenedor = cs.num_contenedor
			    INNER JOIN tipo_contenedor_iso tci On tci.id_tipo_contenedor_iso  = c.id_tipo_contenedor_iso
			    INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada
			    INNER JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida
			    INNER JOIN propietario p ON ecc.cif_propietario = p.cif_propietario
			    INNER JOIN cliente cl ON cl.cif_cliente = p.cif_propietario
			WHERE ecc.temperatura_contenedor IS NOT NULL AND
				  (s.id_tipo_salida = 1 OR s.id_tipo_salida = 2) AND
				  cl.nombre_comercial_cliente = :nombre_comercial_cliente
			HAVING fecha_desconexion BETWEEN :fecha_inicio AND :fecha_fin;
		");

		$query->execute(array(
			':fecha_inicio' => $fecha_inicio,
			':fecha_fin' => $fecha_fin,
			':nombre_comercial_cliente' => $nombre_comercial_cliente
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function conexionado_control_temperatura_limpieza_cliente($fecha_inicio, $fecha_fin, $nombre_comercial_cliente)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				cs.id_control_stock,
				cs.num_contenedor,
			  	c.id_tipo_contenedor_iso,
			  	tci.longitud_tipo_contenedor,
			  	tci.descripcion_tipo_contenedor,
				e.id_entrada,
			  	te.tipo_entrada,
				DATE(e.fecha_entrada) AS fecha_conexion,
				e.id_tipo_entrada,
				s.id_salida,
			  	ts.tipo_salida,
				DATE(s.fecha_salida) AS fecha_desconexion,
				s.id_tipo_salida,
			  	DATEDIFF(DATE(s.fecha_salida), DATE(e.fecha_entrada))+1 AS total_dias,
				ecc.estado_carga_contenedor,
				ecc.temperatura_contenedor,
			  	cl.cif_cliente,
			  	cl.nombre_comercial_cliente,

				(
					SELECT DISTINCT pt.num_contenedor
					FROM parte_trabajo pt INNER JOIN parte_trabajo_linea ptl ON pt.id_parte_trabajo = ptl.id_parte_trabajo
						INNER JOIN propietario p ON p.cif_propietario = pt.cif_propietario
						INNER JOIN cliente c ON c.cif_cliente = p.cif_propietario
					WHERE
						ptl.id_tipo_trabajo = 1
					  AND ((MONTH(pt.fecha_parte_trabajo) = MONTH(:fecha_fin)) OR (MONTH(pt.fecha_parte_trabajo) = MONTH(:fecha_fin)-1))
						AND pt.num_contenedor = cs.num_contenedor
					  AND c.nombre_comercial_cliente = :nombre_comercial_cliente
				) AS limpieza_bool

			FROM control_stock cs INNER JOIN entrada e ON cs.id_entrada = e.id_entrada
				INNER JOIN entrada_tipo_camion etc ON etc.id_entrada = e.id_entrada
			    INNER JOIN entrada_camion_contenedor ecc ON ecc.id_entrada = etc.id_entrada
			    INNER JOIN salida s ON s.id_salida = cs.id_salida
			    INNER JOIN contenedor c ON c.num_contenedor = cs.num_contenedor
			    INNER JOIN tipo_contenedor_iso tci On tci.id_tipo_contenedor_iso  = c.id_tipo_contenedor_iso
			    INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada
			    INNER JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida
			    INNER JOIN propietario p ON ecc.cif_propietario = p.cif_propietario
			    INNER JOIN cliente cl ON cl.cif_cliente = p.cif_propietario

			WHERE ecc.temperatura_contenedor IS NOT NULL AND
				  (s.id_tipo_salida = 1 OR s.id_tipo_salida = 2) AND
				  (cl.nombre_comercial_cliente = :nombre_comercial_cliente)
			HAVING fecha_desconexion BETWEEN :fecha_inicio AND :fecha_fin
		");

		$query->execute(array(
			':fecha_inicio' => $fecha_inicio,
			':fecha_fin' => $fecha_fin,
			':nombre_comercial_cliente' => $nombre_comercial_cliente
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function maniobras_continental_rail($fecha_inicio, $fecha_fin)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				e.id_entrada AS id,
				DATE(e.fecha_entrada) AS fecha_tren,
				'ENTRADA' AS tipo_movimiento,
				e.id_tipo_entrada AS id_tipo,
				te.tipo_entrada AS tipo,
				cd.id_origen,
				ot.nombre_origen,
				cd.id_destino,
				dt.nombre_destino,
				cd.cif_propietario,
				1 AS maniobra,
				CASE WHEN (cd.cif_propietario = 'A60389624') THEN 1 ELSE 0 END AS generadores
			FROM entrada e INNER JOIN entrada_tipo_tren ett ON e.id_entrada = ett.id_entrada
				INNER JOIN cita_descarga cd ON cd.id_cita_descarga = e.id_cita_descarga
				INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada
			    INNER JOIN origen_tren ot ON ot.id_origen = cd.id_origen
			    INNER JOIN destino_tren dt ON dt.id_destino = cd.id_destino
			WHERE
				(e.fecha_entrada BETWEEN :fecha_inicio AND :fecha_fin)
				AND (cd.cif_propietario = 'A60389624' OR cd.cif_propietario = 'A96764097')
			UNION
			SELECT
				s.id_salida AS id,
				DATE(s.fecha_salida) AS fecha_tren,
				'SALIDA' AS tipo_movimiento,
				s.id_tipo_salida AS id_tipo,
				ts.tipo_salida AS tipo,
				cc.id_origen,
				ot.nombre_origen,
				cc.id_destino,
				dt.nombre_destino,
				cc.cif_propietario,
				1 AS maniobra,
				CASE WHEN (cc.cif_propietario = 'A60389624') THEN 1 ELSE 0 END AS generadores
			FROM salida s INNER JOIN salida_tipo_tren stt ON stt.id_salida = s.id_salida
				INNER JOIN cita_carga cc ON cc.id_cita_carga = s.id_cita_carga
			    INNER JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida
			    INNER JOIN origen_tren ot ON ot.id_origen = cc.id_origen
			    INNER JOIN destino_tren dt ON dt.id_destino = cc.id_destino
			WHERE
				(s.fecha_salida BETWEEN :fecha_inicio AND :fecha_fin)
				AND (cc.cif_propietario = 'A60389624' OR cc.cif_propietario = 'A96764097')
			ORDER BY tipo_movimiento, fecha_tren ASC
		");

		$query->execute(array(
			':fecha_inicio' => $fecha_inicio,
			':fecha_fin' => $fecha_fin
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function maniobras_gmf_railway($fecha_inicio, $fecha_fin)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
		SELECT
			CASE
				WHEN cd.fecha IS NOT NULL THEN cd.fecha
				WHEN cc.fecha IS NOT NULL THEN cc.fecha
				#ELSE 'N/A'
			END AS 'Fecha de Tren',
			CASE
				WHEN te.tipo_entrada IS NOT NULL THEN 'Entrada'
				WHEN ts.tipo_salida IS NOT NULL THEN 'Salida'
				#ELSE 'N/A'
			END AS 'Tipo de Movimiento',
			CASE
				WHEN ett.num_expedicion IS NOT NULL THEN ett.num_expedicion
				WHEN stt.num_expedicion IS NOT NULL THEN stt.num_expedicion
				#ELSE 'N/A'
			END AS 'Número de Expedición',
			CONCAT(ot.nombre_origen, ' - ',dt.nombre_destino) AS 'Origen-Destino'
		FROM
			(SELECT
				ett.id_entrada AS id,
				cd.fecha,
				te.tipo_entrada,
				ett.num_expedicion
			FROM entrada_tipo_tren ett INNER JOIN entrada e ON  e.id_entrada = ett.id_entrada
				INNER JOIN cita_descarga cd ON cd.id_cita_descarga = e.id_cita_descarga
				INNER JOIN tipo_entrada te ON e.id_tipo_entrada = te.id_tipo_entrada
			UNION
			SELECT
				stt.id_salida AS id,
				cc.fecha,
				ts.tipo_salida,
				stt.num_expedicion
			FROM salida_tipo_tren stt INNER JOIN salida s ON s.id_salida = stt.id_salida
				INNER JOIN cita_carga cc ON cc.id_cita_carga = s.id_cita_carga
				INNER JOIN tipo_salida ts ON s.id_tipo_salida = ts.id_tipo_salida) AS es

				LEFT JOIN entrada_tipo_tren ett ON es.id = ett.id_entrada
				LEFT JOIN entrada e ON ett.id_entrada = e.id_entrada
				LEFT JOIN tipo_entrada te ON e.id_tipo_entrada = te.id_tipo_entrada
				LEFT JOIN cita_descarga cd ON ett.id_entrada = cd.id_origen OR ett.id_entrada = cd.id_destino

				LEFT JOIN salida_tipo_tren stt ON es.id = stt.id_salida
				LEFT JOIN salida s ON stt.id_salida = s.id_salida
				LEFT JOIN tipo_salida ts ON s.id_tipo_salida = ts.id_tipo_salida
				LEFT JOIN cita_carga cc ON stt.id_salida = cc.id_origen OR stt.id_salida = cc.id_destino

				LEFT JOIN origen_tren ot ON cd.id_origen = ot.id_origen OR cc.id_origen = ot.id_origen
				LEFT JOIN destino_tren dt ON cd.id_destino = dt.id_destino OR cc.id_destino = dt.id_destino
				#WHERE cd.fecha = :fecha_inicio OR cc.fecha = :fecha_fin;
		");

		$query->execute(array(
			':fecha_inicio' => $fecha_inicio,
			':fecha_fin' => $fecha_fin
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_tarifas_by_year($year, $nombre_comercial_cliente)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				*
			FROM tarifas INNER JOIN cliente cl ON cl.cif_cliente = tarifas.cif_cliente
			WHERE year = :year AND cl.nombre_comercial_cliente = :nombre_comercial_cliente
			ORDER BY year ASC;
		");

		$query->execute(array(
			':year' => $year,
			':nombre_comercial_cliente' => $nombre_comercial_cliente
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	/////////////////////////////////////////////////////////////FIN FACTURACION////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////CODECO//////////////////////////////////////////////////////////////////////////

	public function insert_codeco_entrada($id_entrada, $num_contenedor, $user_insert)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		$query = $this->conexion->prepare("
			INSERT INTO codeco(id_entrada, num_contenedor, fecha_insert, user_insert)
			VALUES (:id_entrada, :num_contenedor, NOW(), :user_insert);
		");

		$query->execute(array(
			':id_entrada' => $id_entrada,
			':num_contenedor' => $num_contenedor,
			':user_insert' => $user_insert
		));

		//cerramos la conexion a la BD
		$query = null;

		//obtenemos el id del registro insertado
		$this->result = $this->conexion->lastInsertId();

		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function insert_codeco_salida($id_salida, $num_contenedor, $user_insert)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		$query = $this->conexion->prepare("
			INSERT INTO codeco(id_salida, num_contenedor, fecha_insert, user_insert)
			VALUES (:id_salida, :num_contenedor, NOW(), :user_insert);
		");

		$query->execute(array(
			':id_salida' => $id_salida,
			':num_contenedor' => $num_contenedor,
			':user_insert' => $user_insert
		));

		//cerramos la conexion a la BD
		$query = null;

		//obtenemos el id del registro insertado
		$this->result = $this->conexion->lastInsertId();

		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function update_codeco_txt($id_codeco, $txt_codeco)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		$query = $this->conexion->prepare("
			UPDATE codeco
			SET txt_codeco = :txt_codeco
			WHERE id_codeco = :id_codeco
		");

		$query->execute(array(
			':id_codeco' => $id_codeco,
			':txt_codeco' => $txt_codeco
		));

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function update_codeco_envio($id_codeco, $check_envio, $error_envio)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		$query = $this->conexion->prepare("
			UPDATE codeco
			SET check_envio = :check_envio,
					error_envio = :error_envio
			WHERE id_codeco = :id_codeco
		");

		$query->execute(array(
			':id_codeco' => $id_codeco,
			':check_envio' => $check_envio,
			':error_envio' => $error_envio
		));

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_codeco_entrada_por_id_entrada_por_num_contenedor($id_entrada, $num_contenedor)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				id_codeco,
				txt_codeco,
				id_entrada,
				id_parte_trabajo,
				num_contenedor,
				fecha_insert,
				user_insert,
				check_envio,
				error_envio
			FROM codeco
			WHERE id_entrada = :id_entrada AND num_contenedor = :num_contenedor AND num_contenedor NOT IN (SELECT num_contenedor FROM contenedor_generador)
		");

		$query->execute(array(
			':id_entrada' => $id_entrada,
			':num_contenedor' => $num_contenedor
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_codeco_parte_trabajo($num_contenedor, $id_parte_trabajo)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				c.id_codeco,
				c.txt_codeco,
				c.id_entrada,
				c.id_salida,
	      c.id_parte_trabajo,
				c.num_contenedor,
				c.fecha_insert,
				c.user_insert,
				c.check_envio,
				c.error_envio
			FROM codeco c
			WHERE c.id_parte_trabajo = :id_parte_trabajo AND c.num_contenedor = :num_contenedor
		");

		$query->execute(array(
			':num_contenedor' => $num_contenedor,
			':id_parte_trabajo' => $id_parte_trabajo
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_codeco_salida_por_id_salida_por_num_contenedor($id_salida, $num_contenedor)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				id_codeco,
				txt_codeco,
				id_salida,
				num_contenedor,
				fecha_insert,
				user_insert,
				check_envio,
				error_envio
			FROM codeco
			WHERE id_salida = :id_salida AND num_contenedor = :num_contenedor AND num_contenedor NOT IN (SELECT num_contenedor FROM contenedor_generador)
		");

		$query->execute(array(
			':id_salida' => $id_salida,
			':num_contenedor' => $num_contenedor
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_codeco_por_id_codeco($id_codeco)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				id_codeco,
				txt_codeco,
				id_entrada,
				id_salida,
				id_parte_trabajo,
				num_contenedor,
				fecha_insert,
				user_insert,
				check_envio,
				error_envio
			FROM codeco
			WHERE id_codeco = :id_codeco AND num_contenedor NOT IN (SELECT num_contenedor FROM contenedor_generador)
		");

		$query->execute(array(
			':id_codeco' => $id_codeco
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function update_codeco_incidencia($id_codeco, $id_parte_trabajo)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		$query = $this->conexion->prepare("
			UPDATE codeco
			SET id_parte_trabajo = :id_parte_trabajo
			WHERE id_codeco = :id_codeco
		");

		$query->execute(array(
			':id_codeco' => $id_codeco,
			':id_parte_trabajo' => $id_parte_trabajo
		));

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	//////////////////////////////////////////////////////////// FIN CODECO /////////////////////////////////////////////////////////////////////////////////

	//////////////////////////////////////////////////////////// UPDATE CAMPO OBSERVACIONES /////////////////////////////////////////////////////////////////////////////////
	public function update_campo_observaciones_entrada_camion(
		$id_entrada,
		$observaciones
	) {
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		$query = $this->conexion->prepare("
			UPDATE entrada_tipo_camion
			SET observaciones = :observaciones
			WHERE id_entrada = :id_entrada
		");

		$query->execute(array(
			':id_entrada' => $id_entrada,
			':observaciones' => $observaciones
		));

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function update_campo_observaciones_salida_camion(
		$id_salida,
		$observaciones
	) {
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		$query = $this->conexion->prepare("
			UPDATE salida_tipo_camion
			SET observaciones = :observaciones
			WHERE id_salida = :id_salida
		");

		$query->execute(array(
			':id_salida' => $id_salida,
			':observaciones' => $observaciones
		));

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_new_observacion_entrada_camion($id_entrada)
	{

		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				*
			FROM entrada_tipo_camion
			WHERE id_entrada = :id_entrada
		");

		$query->execute(array(
			':id_entrada' => $id_entrada
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_new_observacion_salida_camion($id_salida)
	{

		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				*
			FROM salida_tipo_camion
			WHERE id_salida = :id_salida
		");

		$query->execute(array(
			':id_salida' => $id_salida
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function update_campo_observaciones_incidencia(
		$id_incidencia,
		$observaciones
	) {
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		$query = $this->conexion->prepare("
			UPDATE incidencia
			SET observaciones = :observaciones
			WHERE id_incidencia  = :id_incidencia
		");

		$query->execute(array(
			':id_incidencia' => $id_incidencia,
			':observaciones' => $observaciones
		));

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_new_incidencia($id_incidencia)
	{

		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				id_incidencia,
				num_incidencia,
				fecha_incidencia,
				id_tipo_incidencia,
				estado_incidencia,
				user_insert,
				fecha_insert,
				observaciones
			FROM incidencia
			WHERE id_incidencia = :id_incidencia
		");

		$query->execute(array(
			':id_incidencia' => $id_incidencia
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function update_campo_estado_incidencia($id_incidencia, $estado_incidencia)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		$query = $this->conexion->prepare("
			UPDATE incidencia
			SET estado_incidencia = :estado_incidencia
			WHERE id_incidencia  = :id_incidencia
		");

		$query->execute(array(
			':id_incidencia' => $id_incidencia,
			':estado_incidencia' => $estado_incidencia
		));

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}
	//////////////////////////////////////////////////////////// FIN UPDATE CAMPO OBSERVACIONES /////////////////////////////////////////////////////////////////////////////////

	//////////////////////////////////////////////////////////// INCIDENCIAS /////////////////////////////////////////////////////////////////////////////////
	public function get_incidencias($year)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
		SELECT
			i.id_incidencia,
			i.num_incidencia,
			i.fecha_incidencia,
			i.id_tipo_incidencia,
			i.estado_incidencia,
			i.user_insert,
			i.fecha_insert,
			i.observaciones,
			ti.tipo_incidencia,
			ic.num_contenedor
		FROM incidencia i INNER JOIN tipo_incidencia ti ON ti.id_tipo_incidencia = i.id_tipo_incidencia
			LEFT JOIN incidencia_contenedor ic ON ic.id_incidencia = i.id_incidencia
		WHERE YEAR(i.fecha_incidencia) = :year;
		");

		$query->execute(array(
			':year' => $year
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_incidencias_por_tipo($year)
	{
		$query = $this->conexion->prepare("
        SELECT 
            ti.tipo_incidencia,
            COUNT(i.id_incidencia) AS total
        FROM incidencia i
        INNER JOIN tipo_incidencia ti ON ti.id_tipo_incidencia = i.id_tipo_incidencia
        WHERE YEAR(i.fecha_incidencia) = :year
        GROUP BY i.id_tipo_incidencia, ti.tipo_incidencia
    ");
		$query->execute(array(':year' => $year));
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}


	public function get_incidencias_id_entrada($id_entrada)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
		SELECT
			i.id_incidencia,
			i.num_incidencia,
			i.fecha_incidencia,
			i.id_tipo_incidencia,
			i.estado_incidencia,
			i.user_insert,
			i.fecha_insert,
			i.observaciones,
			ti.tipo_incidencia,
			i_e.id_entrada
		FROM incidencia i INNER JOIN tipo_incidencia ti ON ti.id_tipo_incidencia = i.id_tipo_incidencia
		INNER JOIN incidencia_entrada i_e ON i_e.id_incidencia = i.id_incidencia
		WHERE i_e.id_entrada = :id_entrada
		");

		$query->execute(array(
			':id_entrada' => $id_entrada
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}


	public function get_incidencias_id_salida($id_salida)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				i.id_incidencia,
				i.num_incidencia,
				i.fecha_incidencia,
				i.id_tipo_incidencia,
				i.estado_incidencia,
				i.user_insert,
				i.fecha_insert,
				i.observaciones,
				ti.tipo_incidencia,
				i_s.id_salida
			FROM incidencia i INNER JOIN tipo_incidencia ti ON ti.id_tipo_incidencia = i.id_tipo_incidencia
			INNER JOIN incidencia_salida i_s ON i_s.id_incidencia = i.id_incidencia
			WHERE i_s.id_salida = :id_salida;
		");

		$query->execute(array(
			':id_salida' => $id_salida
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}


	public function get_incidencias_num_contenedor($num_contenedor)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
		SELECT
			i.id_incidencia,
			i.num_incidencia,
			i.fecha_incidencia,
			i.id_tipo_incidencia,
			i.estado_incidencia,
			i.user_insert,
			i.fecha_insert,
			i.observaciones,
			ti.tipo_incidencia,
			i_c.num_contenedor,
			i_c.estado_carga_contenedor,
			i_c.cif_propietario,
			i_c.id_entrada,
			i_c.id_salida,
			i_c.id_transbordo
		FROM incidencia i INNER JOIN tipo_incidencia ti ON ti.id_tipo_incidencia = i.id_tipo_incidencia
		INNER JOIN incidencia_contenedor i_c ON i_c.id_incidencia = i.id_incidencia
		WHERE i_c.num_contenedor = :num_contenedor
		");

		$query->execute(array(
			':num_contenedor' => $num_contenedor
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_incidencias_num_contenedor_id_salida($id_salida, $num_contenedor)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
		SELECT
			i.id_incidencia,
			i.num_incidencia,
			i.fecha_incidencia,
			i.id_tipo_incidencia,
			i.estado_incidencia,
			i.user_insert,
			i.fecha_insert,
			i.observaciones,
			ti.tipo_incidencia,
			i_c.num_contenedor,
			i_c.estado_carga_contenedor,
			i_c.cif_propietario,
			i_c.id_entrada,
			i_c.id_salida,
			i_c.id_transbordo
		FROM incidencia i INNER JOIN tipo_incidencia ti ON ti.id_tipo_incidencia = i.id_tipo_incidencia
		INNER JOIN incidencia_contenedor i_c ON i_c.id_incidencia = i.id_incidencia
		WHERE i_c.num_contenedor = :num_contenedor AND i_c.id_salida = :id_salida
		");

		$query->execute(array(
			':num_contenedor' => $num_contenedor,
			':id_salida' => $id_salida
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_incidencias_num_contenedor_id_incidencia($id_incidencia, $num_contenedor)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
		SELECT
			i.id_incidencia,
			i.num_incidencia,
			i.fecha_incidencia,
			i.id_tipo_incidencia,
			i.estado_incidencia,
			i.user_insert,
			i.fecha_insert,
			i.observaciones,
			ti.tipo_incidencia,
			i_c.num_contenedor,
			i_c.estado_carga_contenedor,
			i_c.cif_propietario,
			i_c.id_entrada,
			i_c.id_salida,
			i_c.id_transbordo
		FROM incidencia i INNER JOIN tipo_incidencia ti ON ti.id_tipo_incidencia = i.id_tipo_incidencia
		INNER JOIN incidencia_contenedor i_c ON i_c.id_incidencia = i.id_incidencia
		WHERE i_c.num_contenedor = :num_contenedor AND i.id_incidencia = :id_incidencia
		");

		$query->execute(array(
			':num_contenedor' => $num_contenedor,
			':id_incidencia' => $id_incidencia
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_pdf_incidencia_evento_fichero($id_incidencia)
	{
		// Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		try {
			$this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exception handling

			$query = $this->conexion->prepare("
				SELECT
					i.id_incidencia,
					i.num_incidencia,
					i.fecha_incidencia,
					i.id_tipo_incidencia,
					i.estado_incidencia,
					i.user_insert,
					i.fecha_insert,
					i.observaciones,

					ti.id_tipo_incidencia,
					ti.tipo_incidencia,

					ic.id_incidencia,
					ic.num_contenedor,
					ic.estado_carga_contenedor,
					ic.cif_propietario,
					ic.id_entrada,
					ic.id_salida,
					ic.id_transbordo,

					ie.id_incidencia,
					ie.id_entrada,

					i_s.id_incidencia,
					i_s.id_salida,

					i_e.id_evento,
					i_e.fecha_evento,
					i_e.nombre_evento,
					i_e.id_incidencia,

					fie.id_fichero,
					fie.id_evento,

					f.id_fichero,
					f.ruta_fichero,
					f.fecha_insert,
					f.user_insert,
					f.id_tipo_fichero,

					tf.id_tipo_fichero,
					tf.tipo_fichero
					FROM incidencia i
					INNER JOIN tipo_incidencia ti ON ti.id_tipo_incidencia = i.id_tipo_incidencia
					LEFT JOIN incidencia_contenedor ic ON ic.id_incidencia = i.id_incidencia
					LEFT JOIN incidencia_entrada ie ON ie.id_incidencia = i.id_incidencia
					LEFT JOIN incidencia_salida i_s ON i_s.id_incidencia = i.id_incidencia
					LEFT JOIN incidencia_evento i_e ON i_e.id_incidencia = i.id_incidencia
					LEFT JOIN fichero_incidencia_evento fie ON fie.id_evento = i_e.id_evento
					LEFT JOIN fichero f ON f.id_fichero = fie.id_fichero
					LEFT JOIN tipo_fichero tf ON tf.id_tipo_fichero = f.id_tipo_fichero
					WHERE i.id_incidencia = :id_incidencia;
        	");

			$query->execute(array(
				':id_incidencia' => $id_incidencia
			));

			while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
				$this->result[] = $filas;
			}

			// Cerramos la conexion a la BD
			$query = null;
		} catch (PDOException $e) {
			// Manejar errores de la base de datos
			echo "Error: " . $e->getMessage();
		}

		// Devolvemos array con el resultado de la consulta
		return $this->result;
	}


	public function get_incidencia($id_incidencia)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
			i.id_incidencia,
			i.num_incidencia,
			i.fecha_incidencia,
			i.id_tipo_incidencia,
			i.estado_incidencia,
			i.user_insert,
			i.fecha_insert,
			i.observaciones,
			ti.tipo_incidencia
		FROM incidencia i INNER JOIN tipo_incidencia ti ON ti.id_tipo_incidencia = i.id_tipo_incidencia
			WHERE id_incidencia = :id_incidencia

		");

		$query->execute(array(
			':id_incidencia' => $id_incidencia
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_incidencia_contenedor($id_incidencia)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				ic.id_incidencia,
				ic.num_contenedor,
				ic.estado_carga_contenedor,
				ic.cif_propietario,
				ic.id_entrada,
				e.fecha_entrada,
				e.id_tipo_entrada,
				ic.id_salida,
				s.fecha_salida,
				s.id_tipo_salida,
				ic.id_transbordo,
				tb.fecha_transbordo,
				tb.num_contenedor_destino AS num_contenedor_transbordo,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
			     		THEN (SELECT num_expedicion FROM entrada_tipo_tren WHERE id_entrada = ic.id_entrada)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
			     		THEN (SELECT num_expedicion FROM entrada_tipo_camion WHERE id_entrada = ic.id_entrada)
				END) AS num_expedicion_entrada,
				(CASE
					WHEN (ts.tipo_salida) = 'TREN'
			     		THEN (SELECT num_expedicion FROM salida_tipo_tren WHERE id_salida = ic.id_salida)
					WHEN (ts.tipo_salida) = 'CAMIÓN'
			     		THEN (SELECT num_expedicion FROM salida_tipo_camion WHERE id_salida = ic.id_salida)
				END) AS num_expedicion_salida,
				te.tipo_entrada,
				ts.tipo_salida,
				p.nombre_comercial_propietario
			FROM incidencia_contenedor ic
				INNER JOIN entrada e ON e.id_entrada = ic.id_entrada
				INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada
				LEFT JOIN salida s ON s.id_salida = ic.id_salida
				LEFT JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida
				LEFT JOIN transbordo tb ON tb.id_transbordo = ic.id_transbordo
				INNER JOIN propietario p ON p.cif_propietario = ic.cif_propietario
			WHERE id_incidencia = :id_incidencia;
		");

		$query->execute(array(
			':id_incidencia' => $id_incidencia
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_incidencia_retraso_camion($id_incidencia)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				ie.id_incidencia,
				ie.id_entrada ,
				e.fecha_entrada,
				e.id_tipo_entrada,
				etc.num_expedicion AS num_expedicion_entrada,
				ecc.num_contenedor,
				ecc.cif_propietario,
				te.tipo_entrada,
				p.nombre_comercial_propietario
			FROM incidencia_entrada ie INNER JOIN entrada e ON e.id_entrada = ie.id_entrada
				INNER JOIN entrada_tipo_camion etc ON etc.id_entrada = e.id_entrada
				INNER JOIN entrada_camion_contenedor ecc ON ecc.id_entrada = etc.id_entrada
				INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada
				INNER JOIN propietario p ON p.cif_propietario = ecc.cif_propietario


			WHERE ie.id_incidencia = :id_incidencia
		");

		$query->execute(array(
			':id_incidencia' => $id_incidencia
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_incidencia_frenado($id_incidencia)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				i_s.id_incidencia,
				i_s.id_salida,
				s.fecha_salida,
				s.id_tipo_salida,
				stt.num_expedicion AS num_expedecion_salida,
				s.id_cita_carga,
				cc.num_expedicion AS num_expedecion_salida,
				cc.cif_propietario,
				p.nombre_comercial_propietario,
				ts.tipo_salida
			FROM incidencia_salida i_s INNER JOIN salida s ON s.id_salida = i_s.id_salida
			INNER JOIN salida_tipo_tren stt ON stt.id_salida = s.id_salida
			INNER JOIN cita_carga cc ON cc.id_cita_carga = s.id_cita_carga
			INNER JOIN propietario p ON p.cif_propietario = cc.cif_propietario
			INNER JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida
			WHERE i_s.id_incidencia = :id_incidencia
		");

		$query->execute(array(
			':id_incidencia' => $id_incidencia
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_incidencia_retraso_tren($id_incidencia)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				i_s.id_incidencia,
				i_s.id_salida,
				s.fecha_salida,
				s.id_tipo_salida,
				stt.num_expedicion AS num_expedicion_salida,
				s.id_cita_carga,
				cc.cif_propietario,
				ts.tipo_salida,
				p.nombre_comercial_propietario
			FROM incidencia_salida i_s INNER JOIN salida s ON s.id_salida = i_s.id_salida
			INNER JOIN salida_tipo_tren stt ON stt.id_salida = s.id_salida
			INNER JOIN cita_carga cc ON cc.id_cita_carga = s.id_cita_carga
			INNER JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida
			INNER JOIN propietario p ON p.cif_propietario = cc.cif_propietario

			WHERE i_s.id_incidencia = :id_incidencia
		");

		$query->execute(array(
			':id_incidencia' => $id_incidencia
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_incidencia_retraso_tren_entrada($id_incidencia)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				i_e.id_incidencia,
				i_e.id_entrada,
				e.fecha_entrada,
				e.id_tipo_entrada,
				ett.num_expedicion AS num_expedicion_entrada,
				e.id_cita_descarga,
				cd.cif_propietario,
				te.tipo_entrada,
				p.nombre_comercial_propietario
			FROM incidencia_entrada i_e INNER JOIN entrada e ON e.id_entrada = i_e.id_entrada
				INNER JOIN entrada_tipo_tren ett ON ett.id_entrada = e.id_entrada
				INNER JOIN cita_descarga cd ON cd.id_cita_descarga = e.id_cita_descarga
				INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada
				INNER JOIN propietario p ON p.cif_propietario = cd.cif_propietario

			WHERE i_e.id_incidencia = :id_incidencia
		");

		$query->execute(array(
			':id_incidencia' => $id_incidencia
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_incidencia_demora_mmpp($id_incidencia, $num_contenedor)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				i_c.id_incidencia,
				i_c.id_salida,
				i_c.id_entrada,
				s.fecha_salida,
				s.id_tipo_salida,
				ts.tipo_salida,
				s.id_cita_carga,
				cc.num_expedicion AS num_expedicion_salida,
				cs.num_contenedor,
				cs.id_entrada,
				cs.id_salida,
				e.fecha_entrada,
				e.id_tipo_entrada,
				e.id_cita_descarga,
				cd.num_expedicion AS num_expedicion_entrada,
				te.tipo_entrada,
				ecc.estado_carga_contenedor,
				ecc.id_tipo_mercancia,
				evc.estado_carga_contenedor,
				evc.id_tipo_mercancia,
				tm.id_tipo_mercancia,
				tm.descripcion_mercancia,
				DATEDIFF(s.fecha_salida, e.fecha_entrada) AS dias_estancia,
				etc.num_expedicion as entrada_camion,
				stc.num_expedicion as salida_camion,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
						THEN (SELECT nombre_comercial_propietario FROM entrada_vagon_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_vagon_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
						THEN (SELECT nombre_comercial_propietario FROM entrada_camion_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_camion_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
						THEN (SELECT nombre_comercial_propietario FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN propietario ON propietario.cif_propietario = traspaso.cif_propietario_actual WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS nombre_comercial_propietario
			FROM incidencia_contenedor i_c
			INNER JOIN salida s ON s.id_salida = i_c.id_salida
			INNER JOIN control_stock cs ON cs.id_salida = s.id_salida
			INNER JOIN entrada e ON e.id_entrada = cs.id_entrada
			LEFT JOIN entrada_camion_contenedor ecc ON ecc.id_entrada = e.id_entrada
			LEFT JOIN entrada_vagon_contenedor evc ON evc.id_entrada = e.id_entrada
			INNER JOIN tipo_mercancia tm ON tm.id_tipo_mercancia = ecc.id_tipo_mercancia OR tm.id_tipo_mercancia = evc.id_tipo_mercancia
			INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada
			INNER JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida
			LEFT JOIN cita_carga cc ON cc.id_cita_carga = s.id_cita_carga
			LEFT JOIN cita_descarga cd ON cd.id_cita_descarga = e.id_cita_descarga
			LEFT JOIN entrada_tipo_camion etc ON etc.id_entrada = e.id_entrada
			LEFT JOIN salida_tipo_camion stc ON stc.id_salida = s.id_salida
			WHERE i_c.id_incidencia = :id_incidencia AND (tm.id_tipo_mercancia = 2) AND cs.num_contenedor = :num_contenedor
			GROUP BY cs.num_contenedor
			HAVING dias_estancia >= 3
		");

		$query->execute(array(
			':id_incidencia' => $id_incidencia,
			':num_contenedor' => $num_contenedor
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_incidencia_demora_mmpp2($id_incidencia)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				i_c.id_incidencia,
				i_c.id_entrada,
				i_c.id_salida,
				s.fecha_salida,
				s.id_tipo_salida,
				ts.tipo_salida,
				s.id_cita_carga,
				cc.num_expedicion AS num_expedecion_salida,
				cs.num_contenedor,
				cs.id_entrada,
				cs.id_salida,
				e.fecha_entrada,
				e.id_tipo_entrada,
				e.id_cita_descarga,
				cd.num_expedicion AS num_expedicion_entrada,
				te.tipo_entrada,
                ecc.estado_carga_contenedor,
                ecc.id_tipo_mercancia,
                evc.estado_carga_contenedor,
                evc.id_tipo_mercancia,
                tm.id_tipo_mercancia,
                tm.descripcion_mercancia,
				DATEDIFF(s.fecha_salida, e.fecha_entrada) AS dias_estancia,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
					THEN (SELECT nombre_comercial_propietario FROM entrada_vagon_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_vagon_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
					THEN (SELECT nombre_comercial_propietario FROM entrada_camion_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_camion_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
					THEN (SELECT nombre_comercial_propietario FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN propietario ON propietario.cif_propietario = traspaso.cif_propietario_actual WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS nombre_comercial_propietario,
				(CASE
					WHEN (te.tipo_entrada) = 'TREN'
					THEN (SELECT nombre_comercial_propietario FROM entrada_vagon_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_vagon_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'CAMIÓN'
					THEN (SELECT nombre_comercial_propietario FROM entrada_camion_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_camion_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (te.tipo_entrada) = 'TRASPASO'
					THEN (SELECT nombre_comercial_propietario FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN propietario ON propietario.cif_propietario = traspaso.cif_propietario_actual WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS expedicion_entrada_camion
			FROM incidencia_contenedor i_c INNER JOIN salida s ON s.id_salida = i_c.id_salida
				INNER JOIN control_stock cs ON cs.id_salida = s.id_salida
				INNER JOIN entrada e ON e.id_entrada = cs.id_entrada
                LEFT JOIN entrada_camion_contenedor ecc ON ecc.id_entrada = e.id_entrada
                LEFT JOIN entrada_vagon_contenedor evc ON evc.id_entrada = e.id_entrada
                INNER JOIN tipo_mercancia tm ON tm.id_tipo_mercancia = ecc.id_tipo_mercancia OR tm.id_tipo_mercancia = evc.id_tipo_mercancia
				INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada
				INNER JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida
                LEFT JOIN cita_carga cc ON cc.id_cita_carga = s.id_cita_carga
				LEFT JOIN cita_descarga cd ON cd.id_cita_descarga = e.id_cita_descarga
				LEFT JOIN entrada_tipo_camion etc ON  etc.id_entrada = e.id_entrada
				LEFT JOIN salida_tipo_camion stc ON stc.id_salida = s.id_salida
				WHERE i_c.id_incidencia = :id_incidencia AND tm.id_tipo_mercancia = 2
			HAVING dias_estancia >= 3;
		");

		$query->execute(array(
			':id_incidencia' => $id_incidencia
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_estancia_contenedor_mmpp()
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				ecc.num_contenedor,
				ecc.estado_carga_contenedor,
				ecc.id_tipo_mercancia,
				etc.num_expedicion,
				e.id_entrada,
				e.fecha_entrada,
				e.id_tipo_entrada,
				te.tipo_entrada,
				cs.id_control_stock,
				cs.id_salida,
				IF(s.fecha_salida IS NULL, NOW(), s.fecha_salida) AS fecha_salida,
				s.id_tipo_salida,
				ts.tipo_salida,
				datediff(IF(s.fecha_salida IS NULL, NOW(), s.fecha_salida), e.fecha_entrada) AS dias_estancia,
				p.nombre_comercial_propietario,
				stc.num_expedicion as num_expedicion_salida
			FROM entrada_camion_contenedor ecc INNER JOIN entrada_tipo_camion etc ON etc.id_entrada = ecc.id_entrada
				INNER JOIN entrada e ON e.id_entrada = etc.id_entrada
					INNER JOIN control_stock cs ON cs.num_contenedor = ecc.num_contenedor AND cs.id_entrada = e.id_entrada
						LEFT JOIN salida s ON s.id_salida = cs.id_salida
							INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada
								LEFT JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida
									INNER JOIN propietario p ON p.cif_propietario = ecc.cif_propietario
										INNER JOIN salida_tipo_camion stc ON stc.id_salida = s.id_salida
			WHERE ecc.id_tipo_mercancia = 2 AND ecc.num_contenedor NOT IN (
				SELECT i_c.num_contenedor
				FROM incidencia_contenedor i_c INNER JOIN incidencia i ON i.id_incidencia = i_c.id_incidencia
				WHERE i_c.num_contenedor = ecc.num_contenedor AND i.id_tipo_incidencia = 6 AND i_c.id_entrada = e.id_entrada)
			HAVING dias_estancia >= 3

			UNION

			SELECT
				evc.num_contenedor,
				evc.estado_carga_contenedor,
				evc.id_tipo_mercancia,
				ett.num_expedicion,
				e.id_entrada,
				e.fecha_entrada,
				e.id_tipo_entrada,
				te.tipo_entrada,
				cs.id_control_stock,
				cs.id_salida,
				IF(s.fecha_salida IS NULL, NOW(), s.fecha_salida) AS fecha_salida,
				s.id_tipo_salida, ts.tipo_salida, datediff(IF(s.fecha_salida IS NULL, NOW(), s.fecha_salida), e.fecha_entrada) AS dias_estancia,
				p.nombre_comercial_propietario,
				stt.num_expedicion as num_expedicion_salida
			FROM entrada_vagon_contenedor evc INNER JOIN entrada_tipo_tren ett ON ett.id_entrada = evc.id_entrada
				INNER JOIN entrada e ON e.id_entrada = ett.id_entrada
					INNER JOIN control_stock cs ON cs.num_contenedor = evc.num_contenedor AND cs.id_entrada = e.id_entrada
						LEFT JOIN salida s ON s.id_salida = cs.id_salida
							INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada
								LEFT JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida
									INNER JOIN propietario p ON p.cif_propietario = evc.cif_propietario
										INNER JOIN salida_tipo_tren stt ON stt.id_salida = s.id_salida
			WHERE evc.id_tipo_mercancia = 2 AND evc.num_contenedor NOT IN (
				SELECT i_c.num_contenedor FROM incidencia_contenedor i_c INNER JOIN incidencia i ON i.id_incidencia = i_c.id_incidencia
				WHERE i_c.num_contenedor = evc.num_contenedor AND i.id_tipo_incidencia = 6 AND i_c.id_entrada = e.id_entrada)
			HAVING dias_estancia >= 3
		");

		$query->execute(array(
			//':num_contenedor' => $num_contenedor
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//Cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_fotos_incidencia($id_incidencia)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
			  f.id_fichero,
			  f.ruta_fichero,
			  f.fecha_insert,
			  f.user_insert,
			  f.id_tipo_fichero,
			  tf.tipo_fichero
			FROM (fichero f INNER JOIN tipo_fichero tf ON tf.id_tipo_fichero = f.id_tipo_fichero)
				INNER JOIN fichero_incidencia fpt ON fpt.id_fichero = f.id_fichero
			WHERE fpt.id_incidencia = :id_incidencia
		");

		$query->execute(array(
			':id_incidencia' => $id_incidencia
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_tipo_incidencia()
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				id_tipo_incidencia,
				tipo_incidencia
			FROM tipo_incidencia
			WHERE id_tipo_incidencia NOT IN (1, 3);

		");

		$query->execute(array());

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_tipos_incidencia($id_tipo_incidencia)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				id_tipo_incidencia,
				tipo_incidencia
			FROM tipo_incidencia
			WHERE id_tipo_incidencia = :id_tipo_incidencia
		");

		$query->execute(array(
			':id_tipo_incidencia' => $id_tipo_incidencia
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_entrada_camion()
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				ecc.id_entrada,
				ecc.num_contenedor,
				ecc.estado_carga_contenedor,
				ecc.id_tipo_mercancia,
				ecc.num_peligro_adr,
				ecc.num_onu_adr,
				ecc.num_clase_adr,
				ecc.cod_grupo_embalaje_adr,
				ecc.peso_mercancia_contenedor,
				ecc.num_booking_contenedor,
				ecc.num_precinto_contenedor,
				ecc.temperatura_contenedor,
				ecc.cif_propietario ,
				ecc.codigo_estacion_ferrocarril,
				ecc.id_destinatario,
				p.nombre_comercial_propietario
			FROM entrada_camion_contenedor ecc
				INNER JOIN propietario p ON p.cif_propietario = ecc.cif_propietario
				LIMIT 10;
		");

		$query->execute(array(
			//':id_entrada' => $id_entrada
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_entrada_camion_incidencia()
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				ecc.id_entrada,
				ecc.num_contenedor,
				ecc.estado_carga_contenedor,
				ecc.id_tipo_mercancia,
				ecc.num_peligro_adr,
				ecc.num_onu_adr,
				ecc.num_clase_adr,
				ecc.cod_grupo_embalaje_adr,
				ecc.peso_mercancia_contenedor,
				ecc.num_booking_contenedor,
				ecc.num_precinto_contenedor,
				ecc.temperatura_contenedor,
				ecc.cif_propietario ,
				ecc.codigo_estacion_ferrocarril,
				ecc.id_destinatario,
				p.nombre_comercial_propietario
			FROM entrada_camion_contenedor ecc
				INNER JOIN propietario p ON p.cif_propietario = ecc.cif_propietario
            WHERE ecc.id_entrada NOT IN (SELECT i_e.id_entrada FROM incidencia_entrada i_e INNER JOIN entrada e ON i_e.id_entrada = e.id_entrada INNER JOIN incidencia i ON i.id_incidencia = i_e.id_incidencia WHERE i_e.id_entrada = e.id_entrada AND i.id_tipo_incidencia = 2)
				LIMIT 10;
		");

		$query->execute(array(
			//':id_entrada' => $id_entrada
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_entrada_tren()
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				evc.id_entrada_vagon_contenedor,
				evc.id_entrada,
				evc.num_vagon,
				evc.pos_vagon,
				evc.pos_contenedor,
				evc.num_contenedor,
				evc.estado_carga_contenedor,
				evc.id_tipo_mercancia,
				evc.num_peligro_adr,
				evc.num_onu_adr,
				evc.num_clase_adr ,
				evc.cod_grupo_embalaje_adr,
				evc.tara_contenedor,
				evc.peso_bruto_contenedor,
				evc.temperatura_contenedor,
				evc.cif_propietario,
				evc.id_destinatario,
				p.nombre_comercial_propietario,
				ett.num_expedicion
			FROM entrada_vagon_contenedor evc INNER JOIN entrada_tipo_tren ett ON ett.id_entrada = evc.id_entrada
				INNER JOIN propietario p ON p.cif_propietario = evc.cif_propietario
			GROUP BY id_entrada
			LIMIT 10;
		");

		$query->execute(array(
			//':id_entrada' => $id_entrada
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_entrada_tren_incidencia()
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				evc.id_entrada_vagon_contenedor,
				evc.id_entrada,
				evc.num_vagon,
				evc.pos_vagon,
				evc.pos_contenedor,
				evc.num_contenedor,
				evc.estado_carga_contenedor,
				evc.id_tipo_mercancia,
				evc.num_peligro_adr,
				evc.num_onu_adr,
				evc.num_clase_adr ,
				evc.cod_grupo_embalaje_adr,
				evc.tara_contenedor,
				evc.peso_bruto_contenedor,
				evc.temperatura_contenedor,
				evc.cif_propietario,
				evc.id_destinatario,
				p.nombre_comercial_propietario,
				ett.num_expedicion
			FROM entrada_vagon_contenedor evc INNER JOIN entrada_tipo_tren ett ON ett.id_entrada = evc.id_entrada
				INNER JOIN propietario p ON p.cif_propietario = evc.cif_propietario
				WHERE evc.id_entrada NOT IN (SELECT i_e.id_entrada FROM incidencia_entrada i_e INNER JOIN entrada e ON i_e.id_entrada = e.id_entrada INNER JOIN incidencia i ON i.id_incidencia = i_e.id_incidencia WHERE i_e.id_entrada = e.id_entrada AND i.id_tipo_incidencia = 5)
			GROUP BY id_entrada
			LIMIT 10;
		");

		$query->execute(array(
			//':id_entrada' => $id_entrada
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_salida_tren()
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				svc.id_salida_vagon_contenedor,
				svc.id_salida,
				svc.num_vagon,
				svc.pos_vagon,
				svc.pos_contenedor,
				svc.num_contenedor,
                stt.num_expedicion,
                c.cif_propietario_actual,
                p.nombre_comercial_propietario
			FROM salida_vagon_contenedor svc INNER JOIN salida_tipo_tren stt ON stt.id_salida = svc.id_salida
            INNER JOIN contenedor c ON c.num_contenedor = svc.num_contenedor
            INNER JOIN propietario p ON p.cif_propietario = c.cif_propietario_actual
			GROUP BY id_salida
			LIMIT 10;
		");

		$query->execute(array(
			//':id_entrada' => $id_entrada
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_salida_tren_incidencia()
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				svc.id_salida_vagon_contenedor,
				svc.id_salida,
				svc.num_vagon,
				svc.pos_vagon,
				svc.pos_contenedor,
				svc.num_contenedor,
                stt.num_expedicion,
                c.cif_propietario_actual,
                p.nombre_comercial_propietario
			FROM salida_vagon_contenedor svc INNER JOIN salida_tipo_tren stt ON stt.id_salida = svc.id_salida
            INNER JOIN contenedor c ON c.num_contenedor = svc.num_contenedor
            INNER JOIN propietario p ON p.cif_propietario = c.cif_propietario_actual
			WHERE svc.id_salida NOT IN (SELECT i_s.id_salida FROM incidencia_salida i_s INNER JOIN salida s ON i_s.id_salida = s.id_salida INNER JOIN incidencia i ON i.id_incidencia = i_s.id_incidencia WHERE i_s.id_salida = s.id_salida AND i.id_tipo_incidencia = 4 ORDER BY fecha_salida ASC)
			GROUP BY id_salida
			ORDER BY id_salida DESC
		");

		$query->execute(array(
			//':id_entrada' => $id_entrada
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_incidencias_total()
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT *
			FROM incidencia i LEFT JOIN incidencia_entrada i_e ON i_e.id_incidencia = i.id_incidencia
			LEFT JOIN incidencia_salida i_s ON i_s.id_incidencia = i.id_incidencia
			LEFT JOIN incidencia_contenedor i_c ON i_c.id_incidencia = i.id_incidencia;
		");

		$query->execute(array(
			//':id_entrada' => $id_entrada
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function check_id_transbordo_existe($num_contenedor)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT
				id_incidencia,
				num_contenedor,
				estado_carga_contenedor,
				cif_propietario,
				id_entrada,
				id_salida,
				id_transbordo
			FROM incidencia_contenedor
			WHERE num_contenedor = :num_contenedor;
		");

		$query->execute(array(
			//':year_serie_search' => $year_serie . "/%"
			':num_contenedor' => $num_contenedor
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_ultimo_num_incidencia_por_serie($year_serie)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT num_incidencia
			FROM incidencia
			WHERE num_incidencia LIKE :year_serie_search
			ORDER BY num_incidencia DESC
			LIMIT 1;
		");

		$query->execute(array(
			':year_serie_search' => $year_serie . "/%"
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_num_incidencia_por_num_incidencia($num_incidencia)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();
		//En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		$query = $this->conexion->prepare("
			SELECT *
			FROM incidencia
			WHERE num_incidencia = :num_incidencia;
		");

		$query->execute(array(
			':num_incidencia' => $num_incidencia
		));

		//Mientras halla registros en la consulta realizada
		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			//vamos metiendo dichas filas en el array
			$this->result[] = $filas;
		}
		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function insert_incidencia(
		$fecha_incidencia,
		$id_tipo_incidencia,
		$estado_incidencia,
		$user_insert,
		$observaciones,
		$num_incidencia
	) {
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			INSERT INTO incidencia (
				fecha_incidencia,
				id_tipo_incidencia,
				estado_incidencia,
				user_insert,
				fecha_insert,
				observaciones,
				num_incidencia
			)
			VALUES (
				:fecha_incidencia,
				:id_tipo_incidencia,
				:estado_incidencia,
				:user_insert,
				NOW(),
				:observaciones,
				:num_incidencia
			);
    	");

		$this->result[] = $query->execute(array(
			':fecha_incidencia' => $fecha_incidencia,
			':id_tipo_incidencia' => $id_tipo_incidencia,
			':estado_incidencia' => $estado_incidencia,
			':user_insert' => $user_insert,
			':observaciones' => $observaciones,
			':num_incidencia' => $num_incidencia
		));

		//Cerramos la conexion a la BD
		$query = null;

		//Obtenemos el id del registro insertado
		$this->result = $this->conexion->lastInsertId();

		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function insert_incidencia_entrada($id_incidencia, $id_entrada)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			INSERT INTO incidencia_entrada (
				id_incidencia,
				id_entrada
			)
			VALUES (
				:id_incidencia,
				:id_entrada
			);
    ");

		$this->result[] = $query->execute(array(
			':id_incidencia' => $id_incidencia,
			':id_entrada' => $id_entrada
		));

		//Cerramos la conexion a la BD
		$query = null;

		//Obtenemos el id del registro insertado
		$this->result = $this->conexion->lastInsertId();

		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function insert_incidencia_salida($id_incidencia, $id_salida)
	{
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			INSERT INTO incidencia_salida (
				id_incidencia,
				id_salida
			)
			VALUES (
			:id_incidencia,
				:id_salida
			);
    ");

		$this->result[] = $query->execute(array(
			':id_incidencia' => $id_incidencia,
			':id_salida' => $id_salida
		));

		//Cerramos la conexion a la BD
		$query = null;

		//Obtenemos el id del registro insertado
		$this->result = $this->conexion->lastInsertId();

		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function insert_incidencia_contenedor(
		$id_incidencia,
		$num_contenedor,
		$estado_carga_contenedor,
		$cif_propietario,
		$id_entrada,
		$id_salida,
		$id_transbordo
	) {
		//Borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			INSERT INTO incidencia_contenedor (
			id_incidencia,
			num_contenedor,
			estado_carga_contenedor,
			cif_propietario,
			id_entrada,
			id_salida,
			id_transbordo)
			VALUES (:id_incidencia,
			:num_contenedor,
			:estado_carga_contenedor,
			:cif_propietario,
			:id_entrada,
			:id_salida,
			:id_transbordo);
    		");

		$this->result[] = $query->execute(array(
			':id_incidencia' => $id_incidencia,
			':num_contenedor' => $num_contenedor,
			':estado_carga_contenedor' => $estado_carga_contenedor,
			':cif_propietario' => $cif_propietario,
			':id_entrada' => $id_entrada,
			':id_salida' => $id_salida,
			':id_transbordo' => $id_transbordo
		));

		//Cerramos la conexion a la BD
		$query = null;

		//Obtenemos el id del registro insertado
		$this->result = $this->conexion->lastInsertId();

		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function insert_incidencia_averia_reefer_transbordo($fecha_transbordo, $num_contenedor_origen, $num_contenedor_destino)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			INSERT INTO incidencia_evento(fecha_transbordo, num_contenedor_origen, num_contenedor_destino)
			VALUES (:fecha_transbordo, :num_contenedor_origen, :num_contenedor_destino);
		");

		$query->execute(array(
			':fecha_transbordo' => $fecha_transbordo,
			':num_contenedor_origen' => $num_contenedor_origen,
			':num_contenedor_destino' => $num_contenedor_destino
		));

		//Cerramos la conexion a la BD
		$query = null;

		//Obtenemos el id del registro insertado
		$this->result = $this->conexion->lastInsertId();

		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_movimientos()
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				cs.num_contenedor,
				c.id_tipo_contenedor_iso,
				c.tara_contenedor,
				tci.longitud_tipo_contenedor,
				tci.descripcion_tipo_contenedor,
				cs.id_entrada AS id,
				e.fecha_entrada,
				e.id_tipo_entrada,
				'ENTRADA' AS tipo,
		    CONCAT ('ENTRADA', ' ', te.tipo_entrada) AS tipo_movimiento,

				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT cif_propietario FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT cif_propietario FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
	         		WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 			      THEN (SELECT cif_propietario_actual FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS cif_propietario_actual,

				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT nombre_comercial_propietario FROM entrada_vagon_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_vagon_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT nombre_comercial_propietario FROM entrada_camion_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_camion_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
	         		WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 			      THEN (SELECT nombre_comercial_propietario FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN propietario ON propietario.cif_propietario = traspaso.cif_propietario_actual WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS nombre_comercial_propietario,

				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT num_expedicion FROM entrada_tipo_tren WHERE id_entrada = cs.id_entrada)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT num_expedicion FROM entrada_tipo_camion WHERE id_entrada = cs.id_entrada)
				END) AS num_expedicion,

				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT num_expedicion FROM entrada_tipo_tren WHERE id_entrada = cs.id_entrada)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT CONCAT(matricula_tractora, ' / ', matricula_remolque) FROM entrada_tipo_camion WHERE id_entrada = cs.id_entrada)
				END) AS num_expedicion2,
				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT peso_bruto_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT peso_mercancia_contenedor+c.tara_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
           			WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 			      THEN (SELECT peso_bruto_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS peso_bruto,

				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT peso_bruto_contenedor-c.tara_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT peso_mercancia_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 			    THEN (SELECT peso_mercancia_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS peso_mercancia,

				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT estado_carga_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT estado_carga_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
	         		WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 	 		    THEN (SELECT estado_carga_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS estado_carga_contenedor,
				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT id_tipo_mercancia FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT id_tipo_mercancia FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				   	WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT id_tipo_mercancia FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS id_tipo_mercancia,
				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT descripcion_mercancia FROM entrada_vagon_contenedor INNER JOIN tipo_mercancia ON tipo_mercancia.id_tipo_mercancia = entrada_vagon_contenedor.id_tipo_mercancia WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT descripcion_mercancia FROM entrada_camion_contenedor INNER JOIN tipo_mercancia ON tipo_mercancia.id_tipo_mercancia = entrada_camion_contenedor.id_tipo_mercancia WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT descripcion_mercancia FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN tipo_mercancia ON tipo_mercancia.id_tipo_mercancia = traspaso.id_tipo_mercancia WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS descripcion_mercancia,
				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT id_destinatario FROM entrada_vagon_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = entrada_vagon_contenedor.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT id_destinatario FROM entrada_camion_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = entrada_camion_contenedor.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT id_destinatario FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS id_destinatario,
				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT nombre_empresa_destino_origen FROM entrada_vagon_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = entrada_vagon_contenedor.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT nombre_empresa_destino_origen FROM entrada_camion_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = entrada_camion_contenedor.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT nombre_empresa_destino_origen FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = traspaso.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS nombre_destinatario,
				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT num_booking_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT num_booking_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS num_booking_contenedor,
				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT num_precinto_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT num_precinto_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS num_precinto_contenedor,
				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT temperatura_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT temperatura_contenedor  FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 	 	 	    THEN (SELECT temperatura_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS temperatura_contenedor

			FROM (((control_stock cs INNER JOIN entrada e ON e.id_entrada = cs.id_entrada)
				INNER JOIN tipo_entrada te ON te.id_tipo_entrada = e.id_tipo_entrada)
			    	INNER JOIN contenedor c ON c.num_contenedor = cs.num_contenedor)
			        	INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso
			HAVING cs.num_contenedor NOT IN (SELECT num_contenedor FROM contenedor_generador) AND id_tipo_mercancia = 2
			ORDER BY e.fecha_entrada;

			UNION

			SELECT
				cs.num_contenedor,
				c.id_tipo_contenedor_iso,
				c.tara_contenedor,
				tci.longitud_tipo_contenedor,
				tci.descripcion_tipo_contenedor,
				cs.id_entrada,
				cs.id_salida AS id,
				s.fecha_salida,
				s.id_tipo_salida,
				'SALIDA' AS tipo,
			  CONCAT ('SALIDA', ' ', ts.tipo_salida) AS tipo_movimiento,
				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT cif_propietario FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT cif_propietario FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 			   		THEN (SELECT cif_propietario_actual FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS cif_propietario_actual,
				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
			     		THEN (SELECT nombre_comercial_propietario FROM entrada_vagon_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_vagon_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
			     		THEN (SELECT nombre_comercial_propietario FROM entrada_camion_contenedor INNER JOIN propietario ON propietario.cif_propietario = entrada_camion_contenedor.cif_propietario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
           			WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 			    THEN (SELECT nombre_comercial_propietario FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN propietario ON propietario.cif_propietario = traspaso.cif_propietario_actual WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS nombre_comercial_propietario,
				(CASE
			    	WHEN (SELECT tipo_salida FROM salida INNER JOIN tipo_salida ON tipo_salida.id_tipo_salida = salida.id_tipo_salida WHERE id_salida = cs.id_salida) = 'TREN'
			        	THEN (SELECT num_expedicion FROM salida_tipo_tren WHERE id_salida = cs.id_salida)
			        WHEN (SELECT tipo_salida FROM salida INNER JOIN tipo_salida ON tipo_salida.id_tipo_salida = salida.id_tipo_salida WHERE id_salida = cs.id_salida) = 'CAMIÓN'
			            THEN (SELECT num_expedicion FROM salida_tipo_camion WHERE id_salida = cs.id_salida)
			  	END) AS num_expedicion,
				(CASE
			    	WHEN (SELECT tipo_salida FROM salida INNER JOIN tipo_salida ON tipo_salida.id_tipo_salida = salida.id_tipo_salida WHERE id_salida = cs.id_salida) = 'TREN'
			        	THEN (SELECT num_expedicion FROM salida_tipo_tren WHERE id_salida = cs.id_salida)
			        WHEN (SELECT tipo_salida FROM salida INNER JOIN tipo_salida ON tipo_salida.id_tipo_salida = salida.id_tipo_salida WHERE id_salida = cs.id_salida) = 'CAMIÓN'
			            THEN (SELECT CONCAT(matricula_tractora, ' / ', matricula_remolque) FROM salida_tipo_camion WHERE id_salida = cs.id_salida)
			  	END) AS num_expedicion2,
				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
				  		THEN (SELECT peso_bruto_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				  	WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
						  THEN (SELECT peso_mercancia_contenedor+c.tara_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 					THEN (SELECT peso_bruto_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS peso_bruto,

				(CASE
 					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
 				  		THEN (SELECT peso_bruto_contenedor-c.tara_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
 				  	WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
 					   	THEN (SELECT peso_mercancia_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
 	 	 			    THEN (SELECT peso_mercancia_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
 				END) AS peso_mercancia,

				(CASE
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
						THEN (SELECT estado_carga_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
						THEN (SELECT estado_carga_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
 	 	 		    THEN (SELECT estado_carga_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				END) AS estado_carga_contenedor,
				(CASE
			    	WHEN (SELECT tipo_salida FROM salida INNER JOIN tipo_salida ON tipo_salida.id_tipo_salida = salida.id_tipo_salida WHERE id_salida = cs.id_salida) = 'TREN'
			        	THEN
									(CASE
										WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
											THEN (SELECT id_destinatario FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
										WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
											THEN (SELECT id_destinatario FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
									END)
						WHEN (SELECT tipo_salida FROM salida INNER JOIN tipo_salida ON tipo_salida.id_tipo_salida = salida.id_tipo_salida WHERE id_salida = cs.id_salida) = 'CAMIÓN'
			            THEN (SELECT id_destinatario FROM salida_camion_contenedor WHERE id_salida = cs.id_salida)
			   	END) AS id_destinatario,

				(CASE
 			    	WHEN (SELECT tipo_salida FROM salida INNER JOIN tipo_salida ON tipo_salida.id_tipo_salida = salida.id_tipo_salida WHERE id_salida = cs.id_salida) = 'TREN'
 			        	THEN
 									(CASE
 										WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
 											THEN (SELECT nombre_empresa_destino_origen  FROM entrada_vagon_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = entrada_vagon_contenedor.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
 										WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
 											THEN (SELECT nombre_empresa_destino_origen  FROM entrada_camion_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = entrada_camion_contenedor.id_destinatario WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
 									END)
 						WHEN (SELECT tipo_salida FROM salida INNER JOIN tipo_salida ON tipo_salida.id_tipo_salida = salida.id_tipo_salida WHERE id_salida = cs.id_salida) = 'CAMIÓN'
 			            THEN (SELECT nombre_empresa_destino_origen  FROM salida_camion_contenedor INNER JOIN empresa_destino_origen ON empresa_destino_origen.id_empresa_destino_origen = salida_camion_contenedor.id_destinatario WHERE id_salida = cs.id_salida)
 			   	END) AS nombre_destinatario,

				(CASE
 					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
 						THEN (SELECT num_booking_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
					WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
 	 	 	 	    THEN (SELECT num_booking_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
 				END) AS num_booking_contenedor,

				(CASE
				WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
					THEN (SELECT num_precinto_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
  	 	 	   		THEN (SELECT num_precinto_contenedor FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
			 	END) AS num_precinto_contenedor,
			 	(CASE
				 	WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
						THEN (SELECT id_tipo_mercancia FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				 	WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
					 	THEN (SELECT id_tipo_mercancia FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				 	WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
	 	 	 	   		THEN (SELECT id_tipo_mercancia FROM traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
			 	END) AS id_tipo_mercancia,
			 	(CASE
				 	WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
					 	THEN (SELECT descripcion_mercancia FROM entrada_vagon_contenedor INNER JOIN tipo_mercancia ON tipo_mercancia.id_tipo_mercancia = entrada_vagon_contenedor.id_tipo_mercancia WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				 	WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
					 	THEN (SELECT descripcion_mercancia FROM entrada_camion_contenedor INNER JOIN tipo_mercancia ON tipo_mercancia.id_tipo_mercancia = entrada_camion_contenedor.id_tipo_mercancia WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
				 	WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TRASPASO'
  	 	 	   			THEN (SELECT descripcion_mercancia FROM (traspaso INNER JOIN entrada_tipo_traspaso ON entrada_tipo_traspaso.id_traspaso = traspaso.id_traspaso) INNER JOIN tipo_mercancia ON tipo_mercancia.id_tipo_mercancia = traspaso.id_tipo_mercancia WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
			 	END) AS descripcion_mercancia,

			 	(CASE
					WHEN (SELECT tipo_salida FROM salida INNER JOIN tipo_salida ON tipo_salida.id_tipo_salida = salida.id_tipo_salida WHERE id_salida = cs.id_salida) = 'TREN'
							 THEN
								 (CASE
									 WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'TREN'
										 THEN (SELECT temperatura_contenedor FROM entrada_vagon_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
									 WHEN (SELECT tipo_entrada FROM entrada INNER JOIN tipo_entrada ON tipo_entrada.id_tipo_entrada = entrada.id_tipo_entrada WHERE id_entrada = cs.id_entrada) = 'CAMIÓN'
										 THEN (SELECT temperatura_contenedor FROM entrada_camion_contenedor WHERE id_entrada = cs.id_entrada AND num_contenedor = cs.num_contenedor)
								 END)
					 WHEN (SELECT tipo_salida FROM salida INNER JOIN tipo_salida ON tipo_salida.id_tipo_salida = salida.id_tipo_salida WHERE id_salida = cs.id_salida) = 'CAMIÓN'
								 THEN (SELECT temperatura_contenedor FROM salida_camion_contenedor WHERE id_salida = cs.id_salida)
				END) AS temperatura_contenedor


			FROM ((((control_stock cs INNER JOIN salida s ON s.id_salida = cs.id_salida)
				INNER JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida)
			    	INNER JOIN contenedor c ON c.num_contenedor = cs.num_contenedor)
			        	INNER JOIN tipo_contenedor_iso tci ON tci.id_tipo_contenedor_iso = c.id_tipo_contenedor_iso)
			            	INNER JOIN entrada e ON e.id_entrada = cs.id_entrada
			HAVING cs.num_contenedor NOT IN (SELECT num_contenedor FROM contenedor_generador) AND id_tipo_mercancia = 2

		");

		$query->execute(array());

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}
	//////////////////////////////////////////////////////////// FIN INCIDENCIAS /////////////////////////////////////////////////////////////////////////////////

	//////////////////////////////////////////////////////////// MATERIA PELIGROSA /////////////////////////////////////////////////////////////////////////////////
	public function insert_materia_peligrosa_entrada($id_entrada, $num_contenedor, $materia_peligrosa_checkbox)
	{
		// Limpiamos el resultado de consultas anteriores
		$this->result = array();

		// Preparamos la consulta
		$query = $this->conexion->prepare("
        INSERT INTO contenedor_materia_peligrosa (id_entrada, id_salida, num_contenedor, materia_peligrosa)
        VALUES (:id_entrada, NULL, :num_contenedor, :materia_peligrosa);
    ");

		// Ejecutamos la consulta
		$query->execute(array(
			':id_entrada' => $id_entrada,
			':num_contenedor' => $num_contenedor,
			':materia_peligrosa' => $materia_peligrosa_checkbox
		));

		// Cerramos la consulta
		$query = null;

		// Obtenemos el último ID insertado
		$this->result = $this->conexion->lastInsertId();

		// Devolvemos el resultado
		return $this->result;
	}

	public function insert_materia_peligrosa_salida($id_salida, $num_contenedor, $materia_peligrosa_checkbox)
	{
		// Limpiamos el resultado de consultas anteriores
		$this->result = array();

		// Preparamos la consulta
		$query = $this->conexion->prepare("
        INSERT INTO contenedor_materia_peligrosa (id_entrada, id_salida, num_contenedor, materia_peligrosa)
        VALUES (NULL, :id_salida, :num_contenedor, :materia_peligrosa);
    ");

		// Ejecutamos la consulta
		$query->execute(array(
			':id_salida' => $id_salida,
			':num_contenedor' => $num_contenedor,
			':materia_peligrosa' => $materia_peligrosa_checkbox
		));

		// Cerramos la consulta
		$query = null;

		// Obtenemos el último ID insertado
		$this->result = $this->conexion->lastInsertId();

		// Devolvemos el resultado
		return $this->result;
	}


	public function get_contenedor_materia_peligrosa($num_contenedor)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				id_entrada,
				id_salida,
				num_contenedor,
				materia_peligrosa
			FROM contenedor_materia_peligrosa
			WHERE num_contenedor = :num_contenedor
		");

		$query->execute(array(
			'num_contenedor' => $num_contenedor
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}
	//////////////////////////////////////////////////////////// FIN MATERIA PELIGROSA /////////////////////////////////////////////////////////////////////////////////

	//////////////////////////////////////////////////////////// TRANSBORDOS /////////////////////////////////////////////////////////////////////////////////
	public function get_transbordos($id_transbordo)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				t.id_transbordo,
				t.fecha_transbordo,
				t.num_contenedor_origen,
				t.estado_carga_contenedor_origen,
				t.peso_mercancia_actual_contenedor_origen,
				t.num_booking_actual_contenedor_origen,
				t.num_precinto_actual_contenedor_origen,
				t.temperatura_actual_contenedor_origen,
				t.id_tipo_mercancia_actual_contenedor_origen,
				t.num_peligro_adr_actual_contenedor_origen,
				t.num_onu_adr_actual_contenedor_origen,
				t.num_clase_adr_actual_contenedor_origen,
				t.cod_grupo_embalaje_adr_actual_contenedor_origen,
				t.codigo_estacion_ferrocarril_actual_contenedor_origen,
				t.id_destinatario_actual_origen,
				t.num_contenedor_destino,
				t.estado_carga_contenedor_destino,
				t.peso_mercancia_actual_contenedor_destino,
				t.num_booking_actual_contenedor_destino,
				t.num_precinto_actual_contenedor_destino,
				t.temperatura_actual_contenedor_destino,
				t.id_tipo_mercancia_actual_contenedor_destino,
				t.num_peligro_adr_actual_contenedor_destino,
				t.num_onu_adr_actual_contenedor_destino,
				t.num_clase_adr_actual_contenedor_destino,
				t.cod_grupo_embalaje_adr_actual_contenedor_destino,
				t.codigo_estacion_ferrocarril_actual_contenedor_destino,
				t.id_destinatario_actual_destino,
				tm_origen.descripcion_mercancia AS descripcion_mercancia_origen,
				tm_destino.descripcion_mercancia AS descripcion_mercancia_destino
			FROM transbordo t
			INNER JOIN tipo_mercancia tm_origen
				ON tm_origen.id_tipo_mercancia = t.id_tipo_mercancia_actual_contenedor_origen
			INNER JOIN tipo_mercancia tm_destino
				ON tm_destino.id_tipo_mercancia = t.id_tipo_mercancia_actual_contenedor_destino
			WHERE id_transbordo = :id_transbordo;
		");

		$query->execute(array(
			'id_transbordo' => $id_transbordo
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_transbordos_por_year($year)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				id_transbordo,
				COUNT(id_transbordo) as total,
				fecha_transbordo,
				num_contenedor_origen,
				estado_carga_contenedor_origen,
				peso_mercancia_actual_contenedor_origen,
				num_booking_actual_contenedor_origen,
				num_precinto_actual_contenedor_origen,
				temperatura_actual_contenedor_origen,
				id_tipo_mercancia_actual_contenedor_origen,
				num_peligro_adr_actual_contenedor_origen,
				num_onu_adr_actual_contenedor_origen,
				num_clase_adr_actual_contenedor_origen,
				cod_grupo_embalaje_adr_actual_contenedor_origen,
				codigo_estacion_ferrocarril_actual_contenedor_origen,
				id_destinatario_actual_origen,
				num_contenedor_destino,
				estado_carga_contenedor_destino,
				peso_mercancia_actual_contenedor_destino,
				num_booking_actual_contenedor_destino,
				num_precinto_actual_contenedor_destino,
				temperatura_actual_contenedor_destino,
				id_tipo_mercancia_actual_contenedor_destino,
				num_peligro_adr_actual_contenedor_destino,
				num_onu_adr_actual_contenedor_destino,
				num_clase_adr_actual_contenedor_destino,
				cod_grupo_embalaje_adr_actual_contenedor_destino,
				codigo_estacion_ferrocarril_actual_contenedor_destino,
				id_destinatario_actual_destino
			FROM transbordo
			WHERE YEAR(fecha_transbordo) = :year
		");

		$query->execute(array(
			':year' => $year
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function get_transbordos_por_num_contenedor($num_contenedor)
	{
		//borramos resultados de consulta anterior si la hubiera
		$this->result = array();

		$query = $this->conexion->prepare("
			SELECT
				id_transbordo,
				fecha_transbordo,
				num_contenedor_origen,
				estado_carga_contenedor_origen,
				peso_mercancia_actual_contenedor_origen,
				num_booking_actual_contenedor_origen,
				num_precinto_actual_contenedor_origen,
				temperatura_actual_contenedor_origen,
				id_tipo_mercancia_actual_contenedor_origen,
				num_peligro_adr_actual_contenedor_origen,
				num_onu_adr_actual_contenedor_origen,
				num_clase_adr_actual_contenedor_origen,
				cod_grupo_embalaje_adr_actual_contenedor_origen,
				codigo_estacion_ferrocarril_actual_contenedor_origen,
				id_destinatario_actual_origen,
				num_contenedor_destino,
				estado_carga_contenedor_destino,
				peso_mercancia_actual_contenedor_destino,
				num_booking_actual_contenedor_destino,
				num_precinto_actual_contenedor_destino,
				temperatura_actual_contenedor_destino,
				id_tipo_mercancia_actual_contenedor_destino,
				num_peligro_adr_actual_contenedor_destino,
				num_onu_adr_actual_contenedor_destino,
				num_clase_adr_actual_contenedor_destino,
				cod_grupo_embalaje_adr_actual_contenedor_destino,
				codigo_estacion_ferrocarril_actual_contenedor_destino,
				id_destinatario_actual_destino
			FROM transbordo
			WHERE num_contenedor_origen = :num_contenedor
		");

		$query->execute(array(
			':num_contenedor' => $num_contenedor
		));

		while ($filas = $query->fetch(PDO::FETCH_ASSOC)) {
			$this->result[] = $filas;
		}

		//cerramos la conexion a la BD
		$query = null;
		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	public function insert_transbordo(
		$fecha_transbordo,
		$num_contenedor_origen,
		$estado_carga_contenedor_origen,
		$peso_mercancia_actual_contenedor_origen,
		$num_booking_actual_contenedor_origen,
		$num_precinto_actual_contenedor_origen,
		$temperatura_actual_contenedor_origen,
		$id_tipo_mercancia_actual_contenedor_origen,
		$num_peligro_adr_actual_contenedor_origen,
		$num_onu_adr_actual_contenedor_origen,
		$num_clase_adr_actual_contenedor_origen,
		$cod_grupo_embalaje_adr_actual_contenedor_origen,
		$codigo_estacion_ferrocarril_actual_contenedor_origen,
		$id_destinatario_actual_origen,
		$num_contenedor_destino,
		$estado_carga_contenedor_destino,
		$peso_mercancia_actual_contenedor_destino,
		$num_booking_actual_contenedor_destino,
		$num_precinto_actual_contenedor_destino,
		$temperatura_actual_contenedor_destino,
		$id_tipo_mercancia_actual_contenedor_destino,
		$num_peligro_adr_actual_contenedor_destino,
		$num_onu_adr_actual_contenedor_destino,
		$num_clase_adr_actual_contenedor_destino,
		$cod_grupo_embalaje_adr_actual_contenedor_destino,
		$codigo_estacion_ferrocarril_actual_contenedor_destino,
		$id_destinatario_actual_destino
	) {
		//BORRAMOS RESULTADOS DE CONSULTA ANTERIOR
		$this->result = array();

		$query = $this->conexion->prepare("
			INSERT INTO transbordo(
				fecha_transbordo,
				num_contenedor_origen,
				estado_carga_contenedor_origen,
				peso_mercancia_actual_contenedor_origen,
				num_booking_actual_contenedor_origen,
				num_precinto_actual_contenedor_origen,
				temperatura_actual_contenedor_origen,
				id_tipo_mercancia_actual_contenedor_origen,
				num_peligro_adr_actual_contenedor_origen,
				num_onu_adr_actual_contenedor_origen,
				num_clase_adr_actual_contenedor_origen,
				cod_grupo_embalaje_adr_actual_contenedor_origen,
				codigo_estacion_ferrocarril_actual_contenedor_origen,
				id_destinatario_actual_origen,
				num_contenedor_destino,
				estado_carga_contenedor_destino,
				peso_mercancia_actual_contenedor_destino,
				num_booking_actual_contenedor_destino,
				num_precinto_actual_contenedor_destino,
				temperatura_actual_contenedor_destino,
				id_tipo_mercancia_actual_contenedor_destino,
				num_peligro_adr_actual_contenedor_destino,
				num_onu_adr_actual_contenedor_destino,
				num_clase_adr_actual_contenedor_destino,
				cod_grupo_embalaje_adr_actual_contenedor_destino,
				codigo_estacion_ferrocarril_actual_contenedor_destino,
				id_destinatario_actual_destino
			)
			VALUES (
				:fecha_transbordo,
				:num_contenedor_origen,
				:estado_carga_contenedor_origen,
				:peso_mercancia_actual_contenedor_origen,
				:num_booking_actual_contenedor_origen,
				:num_precinto_actual_contenedor_origen,
				:temperatura_actual_contenedor_origen,
				:id_tipo_mercancia_actual_contenedor_origen,
				:num_peligro_adr_actual_contenedor_origen,
				:num_onu_adr_actual_contenedor_origen,
				:num_clase_adr_actual_contenedor_origen,
				:cod_grupo_embalaje_adr_actual_contenedor_origen,
				:codigo_estacion_ferrocarril_actual_contenedor_origen,
				:id_destinatario_actual_origen,
				:num_contenedor_destino,
				:estado_carga_contenedor_destino,
				:peso_mercancia_actual_contenedor_destino,
				:num_booking_actual_contenedor_destino,
				:num_precinto_actual_contenedor_destino,
				:temperatura_actual_contenedor_destino,
				:id_tipo_mercancia_actual_contenedor_destino,
				:num_peligro_adr_actual_contenedor_destino,
				:num_onu_adr_actual_contenedor_destino,
				:num_clase_adr_actual_contenedor_destino,
				:cod_grupo_embalaje_adr_actual_contenedor_destino,
				:codigo_estacion_ferrocarril_actual_contenedor_destino,
				:id_destinatario_actual_destino
			)
		");

		$this->result[] = $query->execute(array(
			':fecha_transbordo' => $fecha_transbordo,
			':num_contenedor_origen' => $num_contenedor_origen,
			':estado_carga_contenedor_origen' => $estado_carga_contenedor_origen,
			':peso_mercancia_actual_contenedor_origen' => $peso_mercancia_actual_contenedor_origen,
			':num_booking_actual_contenedor_origen' => $num_booking_actual_contenedor_origen,
			':num_precinto_actual_contenedor_origen' => $num_precinto_actual_contenedor_origen,
			':temperatura_actual_contenedor_origen' => $temperatura_actual_contenedor_origen,
			':id_tipo_mercancia_actual_contenedor_origen' => $id_tipo_mercancia_actual_contenedor_origen,
			':num_peligro_adr_actual_contenedor_origen' => $num_peligro_adr_actual_contenedor_origen,
			':num_onu_adr_actual_contenedor_origen' => $num_onu_adr_actual_contenedor_origen,
			':num_clase_adr_actual_contenedor_origen' => $num_clase_adr_actual_contenedor_origen,
			':cod_grupo_embalaje_adr_actual_contenedor_origen' => $cod_grupo_embalaje_adr_actual_contenedor_origen,
			':codigo_estacion_ferrocarril_actual_contenedor_origen' => $codigo_estacion_ferrocarril_actual_contenedor_origen,
			':id_destinatario_actual_origen' => $id_destinatario_actual_origen,
			':num_contenedor_destino' => $num_contenedor_destino,
			':estado_carga_contenedor_destino' => $estado_carga_contenedor_destino,
			':peso_mercancia_actual_contenedor_destino' => $peso_mercancia_actual_contenedor_destino,
			':num_booking_actual_contenedor_destino' => $num_booking_actual_contenedor_destino,
			':num_precinto_actual_contenedor_destino' => $num_precinto_actual_contenedor_destino,
			':temperatura_actual_contenedor_destino' => $temperatura_actual_contenedor_destino,
			':id_tipo_mercancia_actual_contenedor_destino' => $id_tipo_mercancia_actual_contenedor_destino,
			':num_peligro_adr_actual_contenedor_destino' => $num_peligro_adr_actual_contenedor_destino,
			':num_onu_adr_actual_contenedor_destino' => $num_onu_adr_actual_contenedor_destino,
			':num_clase_adr_actual_contenedor_destino' => $num_clase_adr_actual_contenedor_destino,
			':cod_grupo_embalaje_adr_actual_contenedor_destino' => $cod_grupo_embalaje_adr_actual_contenedor_destino,
			':codigo_estacion_ferrocarril_actual_contenedor_destino' => $codigo_estacion_ferrocarril_actual_contenedor_destino,
			':id_destinatario_actual_destino' => $id_destinatario_actual_destino,
		));

		//Cerramos la conexion a la BD
		$query = null;

		//Obtenemos el id del registro insertado
		$this->result = $this->conexion->lastInsertId();

		//Devolvemos array con el resultado de la consulta
		return $this->result;
	}

	function update_transbordo_incidencia_contenedor($id_transbordo, $num_contenedor)
	{
		try {
			$query = $this->conexion->prepare("
				UPDATE incidencia_contenedor
				SET id_transbordo = :id_transbordo
				WHERE num_contenedor = :num_contenedor
			");

			$result = $query->execute(array(
				':id_transbordo' => $id_transbordo,
				':num_contenedor' => $num_contenedor
			));

			//cerramos la consulta a la BD
			$query = null;

			//obtenemos el id del registro insertado
			$this->result = $this->conexion->lastInsertId();

			return $result;
		} catch (PDOException $e) {
			return "Error: " . $e;
		}
	}

	function update_datos_contenedor_destino(
		$num_contenedor,
		$estado_carga_contenedor,
		$peso_mercancia_actual_contenedor,
		$num_booking_actual_contenedor,
		$num_precinto_actual_contenedor,
		$temperatura_actual_contenedor,
		$id_tipo_mercancia_actual_contenedor,
		$num_peligro_adr_actual_contenedor,
		$num_onu_adr_actual_contenedor,
		$num_clase_adr_actual_contenedor,
		$cod_grupo_embalaje_adr_actual_contenedor,
		$codigo_estacion_ferrocarril_actual_contenedor,
		$id_destinatario_actual
	) {
		try {
			$query = $this->conexion->prepare("
				UPDATE contenedor
				SET estado_carga_contenedor = :estado_carga_contenedor,
					peso_mercancia_actual_contenedor = :peso_mercancia_actual_contenedor,
					peso_bruto_actual_contenedor = :peso_mercancia_actual_contenedor + (SELECT tara_contenedor FROM contenedor WHERE num_contenedor = :num_contenedor),
					num_booking_actual_contenedor = :num_booking_actual_contenedor,
					num_precinto_actual_contenedor = :num_precinto_actual_contenedor,
					temperatura_actual_contenedor = :temperatura_actual_contenedor,
					id_tipo_mercancia_actual_contenedor = :id_tipo_mercancia_actual_contenedor,
					num_peligro_adr_actual_contenedor = :num_peligro_adr_actual_contenedor,
					num_onu_adr_actual_contenedor = :num_onu_adr_actual_contenedor,
					num_clase_adr_actual_contenedor = :num_clase_adr_actual_contenedor,
					cod_grupo_embalaje_adr_actual_contenedor  = :cod_grupo_embalaje_adr_actual_contenedor,
					codigo_estacion_ferrocarril_actual_contenedor = :codigo_estacion_ferrocarril_actual_contenedor,
					id_destinatario_actual = :id_destinatario_actual
				WHERE num_contenedor = :num_contenedor;
			");

			$result = $query->execute(array(
				':num_contenedor' => $num_contenedor,
				':estado_carga_contenedor' => $estado_carga_contenedor,
				':peso_mercancia_actual_contenedor' => $peso_mercancia_actual_contenedor,
				':num_booking_actual_contenedor' => $num_booking_actual_contenedor,
				':num_precinto_actual_contenedor' => $num_precinto_actual_contenedor,
				':temperatura_actual_contenedor' => $temperatura_actual_contenedor,
				':id_tipo_mercancia_actual_contenedor' => $id_tipo_mercancia_actual_contenedor,
				':num_peligro_adr_actual_contenedor' => $num_peligro_adr_actual_contenedor,
				':num_onu_adr_actual_contenedor' => $num_onu_adr_actual_contenedor,
				':num_clase_adr_actual_contenedor' => $num_clase_adr_actual_contenedor,
				':cod_grupo_embalaje_adr_actual_contenedor' => $cod_grupo_embalaje_adr_actual_contenedor,
				':codigo_estacion_ferrocarril_actual_contenedor' => $codigo_estacion_ferrocarril_actual_contenedor,
				':id_destinatario_actual' => $id_destinatario_actual
			));

			//cerramos la consulta a la BD
			$query = null;

			//obtenemos el id del registro insertado
			$this->result = $this->conexion->lastInsertId();

			return $result;
		} catch (PDOException $e) {
			return "Error: " . $e;
		}
	}

	function update_datos_contenedor_origen($num_contenedor)
	{
		try {
			// Preparar la consulta SQL
			$query = $this->conexion->prepare("
				UPDATE contenedor
				SET
					estado_carga_contenedor = 'V',
					peso_mercancia_actual_contenedor = 0,
					peso_bruto_actual_contenedor = (SELECT tara_contenedor FROM contenedor WHERE num_contenedor = :num_contenedor),
					num_booking_actual_contenedor = NULL,
					num_precinto_actual_contenedor = NULL,
					temperatura_actual_contenedor = NULL,
					id_tipo_mercancia_actual_contenedor = 3,
					num_peligro_adr_actual_contenedor = NULL,
					num_onu_adr_actual_contenedor = NULL,
					num_clase_adr_actual_contenedor = NULL,
					cod_grupo_embalaje_adr_actual_contenedor  = NULL,
					codigo_estacion_ferrocarril_actual_contenedor = NULL,
					id_destinatario_actual = NULL,
					id_cita_carga_temp  = NULL
				WHERE num_contenedor = :num_contenedor;
			");

			// Ejecutar la consulta con el parámetro
			$result = $query->execute([
				':num_contenedor' => $num_contenedor
			]);

			// Liberar la consulta
			$query = null;

			return $result;
		} catch (PDOException $e) {
			return "Error: " . $e->getMessage();
		}
	}


	//////////////////////////////////////////////////////////// FIN TRANSBORDOS /////////////////////////////////////////////////////////////////////////////////
}
