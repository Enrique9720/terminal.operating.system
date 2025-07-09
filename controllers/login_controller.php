<?php
///////////////////////*CARGA DE MODELOS*////////////////////////////////////////////
require_once("../models/login_model.php");
/////////////////////////////////////////////////////////////////////////////////////
?>

<?php
//iniciamos sesion
session_start();

define("NOMBRE_APP", "TERMINAL-OPERATING-SYSTEM");

//si venimos de establecer las variables del form
if (isset($_POST['email']) && isset($_POST['password'])) {

    //recogemos las variables
    $email = strtolower(strip_tags(trim($_POST['email'])));
    $password = strip_tags(trim($_POST['password']));
    $id_empresa = strip_tags(trim($_POST['empresa']));

    //instanciamos el modelo para acceso a la BD de usuarios
    $login_model = new login_model();
    $usuarios_list = $login_model->check_usuario($email);

    //extraemos el hash del usuario si lo hubiese
    if (count($usuarios_list) > 0) {
        $hash = $usuarios_list[0]['password'];
    } else { //si el usuario no existe entonces no hay hash
        $hash = '';
    }

    //Si el usuario es valido, comprobar que tiene permisos sobre la APP
    if (password_verify($password, $hash)) {

        $roles_list = $login_model->get_roles_by_user_by_app($email, NOMBRE_APP);

        //echo "<pre>";
        //print_r("ROLES: ".json_encode($roles_list));
        //echo "</pre>";

        if (sizeof($roles_list) > 0) {

            //destruimos la sesion para cerciorarnos que no haya variables de sesion previas
            session_destroy();
            //iniciamos sesion
            session_start();

            $_SESSION['roles_array'] = $roles_list;

            $app_data = $login_model->get_app(NOMBRE_APP);

            $_SESSION['db_url'] =  $app_data['db_url'];
            $_SESSION['db_name'] = $app_data['db_name'];
            $_SESSION['db_user'] = $app_data['db_user'];
            $_SESSION['db_pass'] = $app_data['db_pass'];

            //variable de sesion con el nombre de usuario
            $_SESSION['email'] = $email;
            $username = explode("@", $email);
            $_SESSION['username'] = $username[0];

            //variable de sesion con el año actual
            $_SESSION['year'] = date("Y");;

            //echo "<pre>";
            //print_r($_SESSION);
            //echo "</pre>";

            //finalmente lo mandamos al dashboard de la intranet
            header("Location: ./plan_semanal_controller.php");
        } else {
            //en caso conrario error
            $_SESSION['error_login'] = "Usuario o Contraseña no válidos.";
            header("Location: ../controllers/login_controller.php");
        }
    } else { //en caso conrario error
        $_SESSION['error_login'] = "Usuario o Contraseña no válidos.";
        header("Location: ../controllers/login_controller.php");
    }
} else { //en caso contrario monstramos la vista de login

    //cargamos la vista de login
    require_once('../views/login_view.php');

    //destruimos la sesion para cerciorarnos que no haya variables de sesion previas
    session_destroy();
}
?>
