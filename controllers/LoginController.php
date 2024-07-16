<?php

namespace Controllers;
use MVC\Router;
use Model\Usuario;
use Classes\Email;
class LoginController{

    public static function login(Router $router){
    //   echo 'desde login';
      $alertas = [];
      //no es bueno mandar el usuario para mantener datos en el login por temas de seguridad
      if($_SERVER['REQUEST_METHOD'] === 'POST'){
        // echo 'desde POST';
        $auth = new Usuario($_POST);
        $alertas = $auth->validarLogin();
        // debuguear($auth);
        if(empty($alertas)){
          //comprobamos que exista el usuario
          $usuario = Usuario::where('email',$auth->email);
            // debuguear($usuario);
            if($usuario){
              //verificar el password
              //  debuguear($usuario);
                if($usuario->comprobarPasswordAndVerificado($auth->password)){//nos retorno un true
                   //Autenticar el usuario
                   session_start();

                   $_SESSION['id'] = $usuario->id;
                   $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                   $_SESSION['email'] = $usuario->email; 
                   $_SESSION['login'] = true; 

                       //Redireccionamiento
                       //  debuguear($usuario->admin);
                      if($usuario->admin === '1'){
                          // debuguear('Es admin');
                          $_SESSION['admin'] = $usuario->admin ?? null;
                          header('Location: /admin');
                      }else{
                          // debuguear('Es cliente');
                          header('Location: /cita');
                      }
                       //  debuguear($_SESSION);
                }
            }else{
              Usuario::setAlerta('error','Usuario no encontrado');
            }
         }
      }

      $alertas = Usuario::getAlertas();
      $router->render('auth/login',[
         'alertas' => $alertas
         
      ]);

    }

    public static function logout(){
        // echo 'desde logout';
        session_start();
        // debuguear($_SESSION);
        $_SESSION = [];
        // debuguear($_SESSION);
        header('Location: /');
        
    }

    public static function olvide(Router $router){
     // echo 'desde olvide';

     $alertas = [];

     if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $auth = new Usuario($_POST);
        $alertas = $auth->validarEmail();
        // debuguear($auth);
        if(empty($alertas)){
           $usuario = Usuario::where('email',$auth->email);
          //  debuguear($usuario);
            if($usuario && $usuario->confirmado === "1"){//retorne un suario y este confirmado
              // debuguear('Si existe y esta confirmado');
              //Generar un token
               $usuario->crearToken();
              // debuguear($usuario);
               $usuario->guardar();//lo actualizamos

               //Enviar el email
               $email = new Email($usuario->nombre,$usuario->email,$usuario->token);
               $email->enviarInstrucciones();

               Usuario::setAlerta('exito','Revisa tu email');
            }else{
              // debuguear('No existe o no esta confirmado');
              Usuario::setAlerta('error','El usuario no existe o no esta confirmado');
              
            }
        }
     }
      $alertas = Usuario::getAlertas();
      $router->render('auth/olvide-password',[
        'alertas' => $alertas
      ]);
    }

    public static function recuperar(Router $router){
        // echo 'desde recuperar';
        $alertas = [];
        $error = false;//esconde formulario
        // $token = s($_GET['token']);
        $token = s($_GET['token'] ?? "");
        // debuguear($token);
        // if(!$token) {
        //   Usuario::setAlerta("error", "Token no valido");
        //   $error = true;
        // }
        //Buscar usuario por su token
        $usuario = Usuario::where('token',$token);//?usuario que contiene la informacion

        // if(empty($usuario)){
        if(empty($usuario) || !$token){
            Usuario::setAlerta("error", "Token no valido");
            $error = true;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
          //Leer el nuevo password y guardarlo
          $password = new Usuario($_POST);//?aca lee lo que el usuario escribio
          // debuguear($password);
          $alertas = $password->validarPassword();

          if(empty($alertas)){
            $usuario->password = null;//limpiar password
            // debuguear($password);
            $usuario->password = $password->password;//?tomo de la instancia de password y se lo asigno al usuario
            $usuario->hashPassword();
            $usuario->token = null;
            $resultado = $usuario->guardar();

            if($resultado){
              header('Location: /');
            }
            // debuguear($usuario);
          }

        }
        // debuguear($usuario);

        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar-password',[
          'alertas' => $alertas,
          'error' => $error
          
        ]);
    }

    public static function crear(Router $router){
        // echo 'desde crear';

        $usuario = new Usuario;//lo coloco fuera del post (haci estara vacio) para que el formulario llene los datos que estan bien
        // debuguear($usuario);
        //Alertas Vacias
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //  echo 'Enviaste el formulario';
            $usuario->sincronizar($_POST);//sincroniza el objeto vacio en este punto con los datos nuevos que enviamos
            $alertas = $usuario->validarNuevaCuenta();//validacion
            if(empty($alertas)){//revisar que alertas este vacio
              //verificar que el usuario no este registrado
              $resultado = $usuario->existeUsuario();
              if($resultado->num_rows){//si es 1
                  $alertas = Usuario::getAlertas();//al modelo que es Usuario
              }else{
                
                // debuguear('no esta registrado');
                //no esta registrado creamos un nuevo usuario 
                //?Hasheo el password
                $usuario->hashPassword();
                // debuguear($usuario);
                //?Generar Token unico
                $usuario->crearToken();
                // debuguear($usuario);
                //?Enviar el email
                $email = new Email($usuario->nombre,$usuario->email,$usuario->token);
                $email->enviarConfirmacion();
                // debuguear($email);
                // debuguear($usuario);

                //?Crear el usuario
                $resultado = $usuario->guardar();
                if($resultado){
                  //  echo 'Guardado correctamente';
                  header('Location: /mensaje');
                }
              }
           }
        }

        $router->render('auth/crear-cuenta',[
            'usuario' => $usuario,
            'alertas' => $alertas
          
          ]);
    }

    public static function mensaje(Router $router){
      $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router){
      $alertas = [];
      $token = s($_GET['token']);//lee token de url
      // debuguear($token);
      $usuario = Usuario::where('token',$token);
      // debuguear($usuario);
      if(empty($usuario)){
        //mostrar mensaje de error
        Usuario::setAlerta('error','Token No Valido.');//la clase error esta en src/scss/components/alertas
      }else{
        //modificamos a usuario confirmado
        // debuguear($usuario);
        $usuario->confirmado = "1";
        $usuario->token = null;//borramos el token
        //  debuguear($usuario);
        $usuario->guardar();
        Usuario::setAlerta('exito','Cuenta comprobada Correctamente');
      }

      $alertas = Usuario::getAlertas();//para que se leean poco antes de renderizar la vista
      $router->render('auth/confirmar-cuenta',[
          'alertas' => $alertas
      ]);
    }

}