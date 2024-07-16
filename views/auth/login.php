
<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia Sesion con tus datos</p>

<?php 
  include_once __DIR__ . '/../templates/alertas.php';
?>

<form class="formulario" method="POST" action="/"><!--url registrada en el index post login-->
   <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Tu Email"><!--name permite leerlo con post-->
   </div>

   <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Tu Password"><!--name permite leerlo con post-->
   </div>

   <input class="boton" type="submit" value="Iniciar Sesion">
</form>

<div class="acciones">
    <a href="/crear-cuenta">¿Aun no tienes una cuenta? crear una</a>
    <a href="/olvide">¿Olvidaste tu Password?</a>
</div>