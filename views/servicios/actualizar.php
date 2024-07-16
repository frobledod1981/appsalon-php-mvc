<h1 class="nombre-pagina">Actualizar Servicio</h1>
<p class="descripcion-pagina">Modifica los valores del Formulario</p>

<?php
  include_once __DIR__ . '/../templates/barra.php';
  include_once __DIR__ . '/../templates/alertas.php';
?>


<form class="formulario" method="POST"><!--quitamos el action para que lo mande a la misma url para respetar el id sino pierde referencia-->
   <?php include_once __DIR__ . '/formulario.php'?>

  <input class="boton" type="submit" value="Actualizar">
</form>