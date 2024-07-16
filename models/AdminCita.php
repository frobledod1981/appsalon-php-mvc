<?php

namespace Model;
class AdminCita extends ActiveRecord{

    //COnsulta  a 4 tablas para ver citas y sus usuarios esta tabla como tal no existe es 
    //lo que necesitamos y Active record hara espejo
    //aca esta la mayoria de la info
    protected static $tabla = 'citasservicios';
    protected static $columnasDB = ['id','hora','cliente','email','telefono','servicio','precio'];


    public $id;
    public $hora;
    public $cliente;
    public $email;
    public $telefono;
    public $servicio;
    public $precio;

    public function __construct() {
        $this->id = $args['id'] ?? null;
        $this->hora = $args['hora'] ?? '';
        $this->cliente = $args['cliente'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->servicio = $args['servicio'] ?? '';
        $this->precio = $args['precio'] ?? '';
     }


}