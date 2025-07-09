<?php
class conexion_users_db
{
    public static function conectar()
    {
        $database = "control_usuarios_apps";
        //$host = "control.usuarios.apps.enriqueandresvaleroguillen.com";
        $host = "localhost:3306";
        $user = "control_usuarios_apps";
        $pass = "e%Q0l^Fq0ezEesk2";

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
