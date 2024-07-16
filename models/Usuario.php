<?php
namespace Model;

class Usuario extends ActiveRecord{
//Active record crea una referencia en memoria,crea un objeto que es igual a lo que tenemos en la BD

   //?Base de datos  
   protected static $tabla = 'usuarios';
   //deben ser igual a nuestras columnas 'Un espejo'
   protected static $columnasDB = ['id','nombre','apellido','email','password','telefono','admin','confirmado','token'];



   public $id;
   public $nombre;
   public $apellido;
   public $email;
   public $password;
   public $telefono;
   public $admin;
   public $confirmado;
   public $token;

   //agregamos atributos a constructor
         public function __construct($args = []){
             $this->id = $args['id'] ?? null;
             $this->nombre = $args['nombre'] ?? '';
             $this->apellido = $args['apellido'] ?? '';
             $this->email = $args['email'] ?? '';
             $this->password = $args['password'] ?? '';
             $this->telefono = $args['telefono'] ?? '';
             $this->admin = $args['admin'] ?? '0';
             $this->confirmado = $args['confirmado'] ?? '0';//si no esta confirmado es 0 por defecto
             $this->token = $args['token'] ?? '';

         }

         //?Mensajes de validacion para la creacion de una cuenta
        public function validarNuevaCuenta(){
            if(!$this->nombre){//1ero tipo de mensaje y el segundo es el error
                self::$alertas['error'][] = 'El Nombre es obligatorio';
            }

            if(!$this->apellido){
                self::$alertas['error'][] = 'El apellido es obligatorio';
            }

            if(!$this->telefono){
                self::$alertas['error'][] = 'El telefono es obligatorio';
            }

            if(!$this->email){
                self::$alertas['error'][] = 'El Email es obligatorio';
            }

            if(!$this->password){
                self::$alertas['error'][] = 'El password es obligatorio';
            }

            if(strlen($this->password) < 6){
                self::$alertas['error'][] = 'El password debe contener al menos 6 caracteres';
            }
            return self::$alertas;
        }

        //?Validar Login
        public function validarLogin(){
            if(!$this->email){
                self::$alertas['error'][] = 'El Email es obligatorio';
            }

            if(!$this->password){
                self::$alertas['error'][] = 'El password es obligatorio';
            }
            return self::$alertas;
        }
        
        //?Validar Email
        public function validarEmail(){
            if(!$this->email){
                self::$alertas['error'][] = 'El Email es obligatorio';
            }
            return self::$alertas;
        }

        public function validarPassword(){
            if(!$this->password){
                self::$alertas['error'][] = 'El password es obligatorio';
            }
            if(strlen($this->password) < 6){
                self::$alertas['error'][] = 'El password debe contener al menos 6 caracteres';
            }
            return self::$alertas;
        }

        //?Revisa si el usuario ya existe
        public function existeUsuario(){
            $query = " SELECT * FROM " . self::$tabla . " WHERE email= '" . $this->email . "' LIMIT 1";
            $resultado = self::$db->query($query);
            if($resultado->num_rows){
                self::$alertas['error'][] = 'El usuario ya esta registrado';
            }
            return $resultado;
        }

        //?Hashear password
        public function hashPassword(){
            $this->password = password_hash($this->password,PASSWORD_BCRYPT);//lee y encripta password que le demos
        }

        //?Crear token
        public function crearToken(){
            $this->token = uniqid();
        }

        //?Comprobar password y verificar
        public function comprobarPasswordAndVerificado($password){
            //el objeto actual ejm en controlador uso el objeto como tal $usuario->comprobarPasswordAndVerificado(), aca en su clase es $this
            // debuguear($this);
            $resultado = password_verify($password,$this->password);
            // debuguear($this);
            if(!$resultado || !$this->confirmado){
                // debuguear('El usuario no esta confirmado');
                self::$alertas['error'][] = 'Password incorrecto o tu cuenta no a sido confirmada';
            }else{
                // debuguear('El usuario ya esta confirmado');
                return true;
            }

        }

    
}