
<h1 class="nombre-pagina">Recuperar Password</h1>
<p class="descripcion-pagina">Coloca tu nuevo password a continuación</p>

<?php 
  include_once __DIR__ . '/../templates/alertas.php';
?>

<?php if($error) return ?>
<form class="formulario" method="POST"><!--le quito el action por que si no eliminara el token,de esta forma no lo manda a ningun lado lo procesa aqui-->
    <div class="campo">
        <label for="pasword">Password</label>
        <input type="password" id="password" name="password" placeholder="Tu Nuevo Password">
    </div>
    <input class="boton" type="submit" value="Guardar Nuevo Password">
</form>

<div class="acciones">
<a href="/">¿Ya tienes cuenta? Iniciar Sesion</a>
<a href="/crear-cuenta">¿Aun no tienes cuenta? Obtener una</a>
</div>