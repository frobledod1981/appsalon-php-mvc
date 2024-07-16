<?php 

require_once __DIR__ . '/../includes/app.php';//'/../includes/app.php'

use Controllers\AdminController;
use Controllers\APIController;
use Controllers\CitaController;
use Controllers\LoginController;
use Controllers\ServicioController;
use MVC\Router;


$router = new Router();

//?Iniciar sesion
$router->get('/',[LoginController::class,'login']);
$router->post('/',[LoginController::class,'login']);
$router->get('/logout',[LoginController::class,'logout']);

//?Recuperar password
$router->get('/olvide',[LoginController::class,'olvide']);
$router->post('/olvide',[LoginController::class,'olvide']);
$router->get('/recuperar',[LoginController::class,'recuperar']);//valida que sea la persona la que pide la contrasena
$router->post('/recuperar',[LoginController::class,'recuperar']);//permite agregar una nueva contrasena

//?Crear cuenta
$router->get('/crear-cuenta',[LoginController::class,'crear']);
$router->post('/crear-cuenta',[LoginController::class,'crear']);

//?Confirmar cuenta
$router->get('/confirmar-cuenta',[LoginController::class,'confirmar']);
$router->get('/mensaje',[LoginController::class,'mensaje']);

//?Area Privada
$router->get('/cita',[CitaController::class,'index']);
$router->get('/admin',[AdminController::class,'index']);

//?Api de citas
$router->get('/api/servicios',[APIController::class,'index']);
$router->post('/api/citas',[APIController::class,'guardar']);
$router->post('/api/eliminar',[APIController::class,'eliminar']);//no es delete por que http por si solo no lo soporta

//?CRUD Servicios
$router->get('/servicios',[ServicioController::class,'index']);
//OJO tiene 2 niveles de profundidad en layout asegurate de poner / tu link css para que cargue estilos sino no los cargara en api no es necesario no carga estilos
$router->get('/servicios/crear',[ServicioController::class,'crear']);//muestra
$router->post('/servicios/crear',[ServicioController::class,'crear']);//crea
$router->get('/servicios/actualizar',[ServicioController::class,'actualizar']);//muestra
$router->post('/servicios/actualizar',[ServicioController::class,'actualizar']);//actualiza
$router->post('/servicios/eliminar',[ServicioController::class,'eliminar']);//actualiza


//? Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();