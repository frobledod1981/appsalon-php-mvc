<h1 class="nombre-pagina">Olvide Password</h1>
<p class="descripcion-pagina">Restablece tu password escribiendo tu email a continuación</p>

<?php 
  include_once __DIR__ . '/../templates/alertas.php';
?>

<form class="formulario" method="POST" action="/olvide" >
    <div class="campo">
        <label for="email">Tu E-mail</label>
        <input type="email" id="email" name="email" placeholder="Tu E-mail">
    </div>

    <input class="boton" type="submit" value="Enviar Instrucciones">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia sesion</a>
    <a href="/crear-cuenta">¿Aun no tienes una cuenta? Crear una</a>
</div>