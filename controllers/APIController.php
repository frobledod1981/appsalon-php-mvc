<?php

namespace Controllers;
use Model\Servicio;
use Model\Cita;
use Model\CitaServicio;
class APIController{

    //!No requiere el Router esta separado el back con el front
    public static function index(){
        // echo 'desde api/index';
        $servicios = Servicio::all();
        // debuguear($servicios);
        echo json_encode($servicios);
    }

    public static function guardar(){
        
        //Almacena la cita y devuelve el ID
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();

        $id = $resultado['id'];
        
        //Almacena los Servicios con el ID de la cita
        $idServicios = explode(",",$_POST['servicios']);//generara arreglo separado por comas

        foreach($idServicios as $idServicio){
            $args = [
                'citaId' => $id,
                'servicioId' => $idServicio
            ];
            $citaServicio = new CitaServicio($args);//Creara nueva instancia de citaServicio
            $citaServicio->guardar();//Ira guardando cada uno de los servicios con la referencia de la cita
        }

        //Retornamos una respuesta

        echo json_encode(['resultado' => $resultado]);
    }

    public static function eliminar(){
        // echo 'desde eliminar';
        // debuguear( $_POST);
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];
            // debuguear($id);
            $cita = Cita::find($id);
            // debuguear($cita);Tendremos la instancia
            $cita->eliminar();

            header('Location:' . $_SERVER['HTTP_REFERER']);//redirige a la misma pagina
        }

    }
}