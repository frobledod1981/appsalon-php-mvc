<?php

namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController{

    public static function index(Router $router) {

        session_start();

        isAdmin();//protege administracion

        // debuguear($_GET);
        $fecha = $_GET['fecha'] ?? date('Y-m-d');//sino genera fecha del servidor la de hoy

        $fechas = explode('-', $fecha);//[0]=anio,[1]=mes,[2]=dia'evitamos que nos inyecten fechas que no correspondas'
        // debuguear($fecha);

        if(!checkdate($fechas[1],$fechas[2],$fechas[0])){//dia-mes-anio
            header('Location: /404');
        }

        // debuguear($fecha);
        /** QUERY
         * 
         * select usuarios.id, citas.hora,concat(usuarios.nombre,' ',usuarios.apellido) as cliente,usuarios.email,usuarios.telefono ,servicios.nombre as servicio,servicios.precio
         *from citas 
         *left outer join usuarios
         *on citas.usuarioId = usuarios.id
         *left outer join citasservicios
         *on citasservicios.citaId = citas.id
         *left outer join servicios 
         *on servicios.id = citasservicios.servicioId;
         */

        //consultar la BD
        $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuarioId=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citasServicios ";
        $consulta .= " ON citasServicios.citaId=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citasServicios.servicioId ";
        $consulta .= " WHERE fecha =  '{$fecha}' ";

        $citas = AdminCita::SQL($consulta);
        // debuguear($citas);

        $router->render('admin/index',[
            'nombre' => $_SESSION['nombre'],
            'citas' => $citas,
            'fecha' => $fecha
        ]);
    }

}