<?php

namespace Controllers;
use MVC\Router;
class CitaController{

    public static function index(Router $router){

        session_start();//arrancara sesion de nuevo con sus datos de inocio de sesion nombre y password
        // debuguear($_SESSION);

        isAuth();//ejecutara esta funcion antes de renderizar esta en funciones.php

        $router->render('cita/index',[
            'nombre' => $_SESSION['nombre'],//paamos nombre y id a la vista
            'id' => $_SESSION['id']
        ]);
    }
}

