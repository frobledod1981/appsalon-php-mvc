<h1 class="nombre-pagina">Crear nueva Cita</h1>
<p class="descripcion-pagina">Elige tus servicios y coloca tus datos</p>

<?php include_once __DIR__ .  '/../templates/barra.php' ?>

<div id="app">

    <nav class="tabs">
        <button class="actual" type="button" data-paso="1">Servicios</button><!--con data- (podemos crear propios atriburos en html) enlazamos a id paso-1 -->
        <button type="button" data-paso="2">Informacion Cita</button><!--con data- (podemos crear propios atriburos en html) enlazamos a id paso-2 -->
        <button type="button" data-paso="3">Resumen</button><!--con data- (podemos crear propios atriburos en html) enlazamos a id paso-3 -->
    </nav>

    <div class="seccion" id="paso-1">
        <h2>Servicios</h2>
        <p class="text-center">Elige tus servicios a continuación</p>
        <div class="listado-servicios" id="servicios"></div>
    </div>
    <div class="seccion" id="paso-2">
        <h2>Tus Datos y Cita</h2>
        <p class="text-center">Coloca tus Datos y Fecha de Cita</p>

        <form class="formulario"><!--no tiene post ni action guardara todo en objeto JS-->
            <input type="hidden" id="id" value="<?php echo $id; ?>">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" placeholder="Tu Nombre" value=<?php echo $nombre ?> disabled>
            </div>

            <div class="campo">
                <label for="fecha">Fecha</label>
                <input type="date" id="fecha" min="<?php echo date('Y-m-d',strtotime('+1 day'));//con esto limito fechas anteriores ?>">
            </div>

            
            <div class="campo">
                <label for="fecha">Hora</label>
                <input type="time" id="hora">
            </div>
        </form>
    </div>
    <div class="seccion contenido-resumen" id="paso-3">
        <h2>Resumen</h2>
        <p class="text-center">Verifica que la informacion sea correcta</p>
    </div>

    <div class="paginacion">
        <button class="boton" id="anterior">&laquo; Anterior</button>
        <button class="boton" id="siguiente">Siguiente &raquo; </button>
    </div>
</div>

<?php 
    $script = "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='build/js/app.js'></script>
    ";
?>