<h1 class="nombre-pagina">Servicios</h1>
<p class="descripcion-pagina">Adminstracion de servicios</p>

<?php
  include_once __DIR__ . '/../templates/barra.php';
?>

    <ul class="servicios">
       <?php foreach($servicios as $servicio):?>
          <li>
              <p>Nombre: <span><?php echo $servicio->nombre; ?></span></p>
              <p>Precio: <span>$<?php echo $servicio->precio; ?></span></p>

              <div class="acciones">
                 <a class="boton" href="/servicios/actualizar?id=<?php echo $servicio->id; ?>">Actualizar</a>

                 <form id="formEliminarServicio" action="/servicios/eliminar" method="POST">
                    <input type="hidden" name="id" value="<?php echo $servicio->id; ?>">
                    <input class="boton-eliminar" id="eliminar-servicio" type="submit" value="Eliminar" onclick="confirmDeleteServicio(event)">
                 </form>
              </div>
          </li>
       <?php endforeach; ?>
    </ul>

    <?php 
    $script = "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='build/js/buscador.js'></script>
    ";
?>