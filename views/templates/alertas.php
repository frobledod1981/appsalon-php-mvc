
<?php
foreach($alertas as $key => $mensajes)://este arreglo es para identificar la llave
//   debuguear($mensaje);
   foreach($mensajes as $mensaje)://iteramos sobre los mensajes
?>
   <div class="alerta <?php echo $key; ?>">
      <?php echo $mensaje;  ?>
   </div>
<?php
   endforeach;
endforeach;
?>

