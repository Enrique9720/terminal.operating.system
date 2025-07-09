<?php
if(!defined('ROOTPATH')){
	define('ROOTPATH', __DIR__);
}

class login_model{
	
		//variable para recoger la conexion a la BD
		private $conexion;
		//variable para recoger el resultado de la consulta
		private $result;
	
		//funcion constructora de la clase
		public function __construct(){
			//Importamos el fichero con la clase conectar para poder establecer la conexion a la BD
			require_once(ROOTPATH."/conexion_users_db.php");
			
			//Realizamos la conexion a la BD a traves del metodo estatico "conexion()" de la clase "conectar",
			//esta conexion la guardamos en la variable conexion de la clase en la que estamos.
			$this->conexion = conexion_users_db::conectar();

			//Establecemos que la variable productos de la clase en la que estamos es un array
			$this->result = array();
		}
		
		public function check_usuario($email){
            //borramos resultados de consulta anterior si la hubiera
            $this->result=array();
			$query = $this->conexion->prepare("
				SELECT password 
				FROM usuario 
				WHERE email = :email
			");
			
			$query->execute(array(':email'=> $email));

			while($filas = $query->fetch(PDO::FETCH_ASSOC)){
				$this->result[] = $filas;
			}
			
			//cerramos la conexion a la BD
			$query = null;
			//Devolvemos array con el resultado de la consulta
			return $this->result;
		}	
		
		/**
		 * Devuelve los datos asociados a una aplicacion
		 * @return array
		 */
		public function get_app($nombre_app){
		    //borramos resultados de consulta anterior si la hubiera
		    $this->result=array();
		    //En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		    $query = $this->conexion->prepare("
				SELECT *
				FROM app
                WHERE nombre = :nombre
			");
		    
		    $query->execute(array(':nombre'=> $nombre_app));
		    
		    //Mientras halla registros en la consulta realizada
		    if ($filas = $query->fetch(PDO::FETCH_ASSOC)){
		        //vamos metiendo dichas filas en el array
		        $this->result = $filas;
		    }
		    //cerramos la conexion a la BD
		    $query = null;
		    //Devolvemos array con el resultado de la consulta
		    return $this->result;
		}
		
		public function get_roles_by_user_by_app($email, $nombre_app){
		    //borramos resultados de consulta anterior si la hubiera
		    $this->result=array();
		    $query = $this->conexion->prepare("
				SELECT nombre_rol
				FROM usuario_rol_app
                WHERE email_usuario = :email AND (nombre_app = :nombre_app OR nombre_app = 'TODAS')
			");
		    
		    $query->execute(array(':email'=> $email, ':nombre_app'=> $nombre_app));
		    
		    while($filas = $query->fetch(PDO::FETCH_ASSOC)){
		        $this->result[] = $filas;
		    }
		    
		    //cerramos la conexion a la BD
		    $query = null;
		    //Devolvemos array con el resultado de la consulta
		    return $this->result;
		}
		
		public function get_rol_by_user($email){
		    //borramos resultados de consulta anterior si la hubiera
		    $this->result=array();
		    $query = $this->conexion->prepare("
				SELECT u.email, r.id_rol, r.create_record, r.read_record, r.update_record, r.delete_record
				FROM (usuarios u INNER JOIN usuarios_roles ur ON u.email = ur.id_usuario) INNER JOIN roles r ON r.id_rol = ur.id_rol
				WHERE ur.id_usuario = :email
			");
		    
		    $query->execute(array(':email'=> $email));
		    
		    while($filas = $query->fetch(PDO::FETCH_ASSOC)){
		        $this->result[] = $filas;
		    }
		    
		    //cerramos la conexion a la BD
		    $query = null;
		    //Devolvemos array con el resultado de la consulta
		    return $this->result;
		}	
		
		public function get_empresas(){
		    //borramos resultados de consulta anterior si la hubiera
		    $this->result=array();
		    //En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		    $query = $this->conexion->prepare("
				SELECT id_empresa, nombre_empresa
				FROM empresas
			");
		    
		    $query->execute();
		    
		    //Mientras halla registros en la consulta realizada
		    while($filas = $query->fetch(PDO::FETCH_ASSOC)){
		        //vamos metiendo dichas filas en el array
		        $this->result[] = $filas;
		    }
		    //cerramos la conexion a la BD
		    $query = null;
		    //Devolvemos array con el resultado de la consulta
		    return $this->result;
		}
		
		public function get_empresa_by_id($id_empresa){
		    //borramos resultados de consulta anterior si la hubiera
		    $this->result=array();
		    //En la variable consulta almacenamos los registros procedentes de la funcion query del objeto conexion
		    $query = $this->conexion->prepare("
				SELECT id_empresa, nombre_empresa, cif_empresa, logo_empresa, pais, woo_url, woo_ck, woo_cs, wp_db_url, wp_db_name, wp_db_user, wp_db_pass
				FROM empresas
				WHERE id_empresa = :id_empresa
			");
		    
		    $query->execute(array(':id_empresa'=> $id_empresa));
		    
		    //Mientras halla registros en la consulta realizada
		    while($filas = $query->fetch(PDO::FETCH_ASSOC)){
		        //vamos metiendo dichas filas en el array
		        $this->result[] = $filas;
		    }
		    //cerramos la conexion a la BD
		    $query = null;
		    //Devolvemos array con el resultado de la consulta
		    return $this->result;
		}		
		
}
?>