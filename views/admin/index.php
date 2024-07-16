
<h1 class="nombre-pagina">Panel de Administracion</h1>

<?php include_once __DIR__ .  '/../templates/barra.php' ?>

<h2>Buscar Citas</h2>

<div class="busqueda">
    <form class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input id="fecha" name="fecha" type="date" value="<?php echo $fecha;?>">
        </div>
    </form>
</div>

<?php 
    if(count($citas) === 0){
        echo "<h2>No hay Citas para esta fecha</h2>";
    }
?>

<div id="citas-admin">
    <ul class="citas">
        <?php 
        $idCita = 0;
        foreach($citas as $key => $cita){     //es la cita actual igual a la anterior asi leo abajo
            // debuguear($key);//posicion del registro pero en el arreglo es diferente del id OJO parte en 0
            if($idCita !== $cita->id){//cunado estemos en una cita diferente a $idCita ejecuta este codigo evita repeticiones  
                $total = 0;     
        ?>
            <li>
               <p>ID:<span><?php echo $cita->id; ?></span></p>
               <p>Hora:<span><?php echo $cita->hora; ?></span></p>
               <p>Cliente:<span><?php echo $cita->cliente; ?></span></p>
               <p>Email:<span><?php echo $cita->email; ?></span></p>
               <p>Telefono:<span><?php echo $cita->telefono; ?></span></p>

               <h3>Servicios</h3>
        <?php 
                $idCita = $cita->id;
           }//FIn de IF
                $total += $cita->precio;// es aca para que sume todos los servicios y no solo uno
           ?>
            <p class="servicio"><?php echo $cita->servicio . " " . $cita->precio; ?></p>
          <!-- </li> lo quitamos sino el primero siempre queda en otro margen y html lo formatea automaticamente -->
           <?php
               $registroActual = $cita->id;//retorna id en que nos encontramos
               $proximoElemento = $citas[$key + 1]->id ?? 0;//indice en el arreglo en la BD empieza en 0

            //    echo "<hr>";
            //    echo $registroActual;
            //    echo "<hr>";
            //    echo $proximoElemento;
                  if(esUltimo($registroActual,$proximoElemento)){?>
                <p class="total">Total:<span><?php echo $total; ?></span></p>

                <!-- <form action="/api/eliminar" method="POST">
                    <input type="hidden" name="id" value="<?php echo $cita->id; ?>">
                    <input class="boton-eliminar" type="submit" value="Eliminar">
                </form> -->
                <!--Prueba de alerta-->
                <!-- <form action="/api/eliminar" method="POST" onsubmit="return confirmDelete()"> 
                    <input type="hidden" name="id" value="<?php echo $cita->id; ?>"> 
                    <input type="submit" class="boton-eliminar" value="Eliminar"> 
                </form> 
                <script> function confirmDelete() { return confirm("¿Estás seguro de que deseas eliminar este registro/cita?"); } </script> -->
               
                <form id="formEliminarCita" action="/api/eliminar" method="POST">                 
                    <input type="hidden" name="id" value="<?php echo $cita->id; ?>">                  
                    <input class="boton-eliminar" id="eliminar-cita" type="submit" value="Eliminar" onclick="confirmDelete(event)">              
                    </form>
                
            <?php }
        }//Fin FOREACH?>
    </ul>
</div>

<?php 
    $script = "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='build/js/buscador.js'></script>
    ";
?>