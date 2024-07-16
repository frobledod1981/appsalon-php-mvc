
let paso = 1;//podria ser 2 o 3 segun sea la seccion que queramos que cargue
const pasoInicial = 1;
const pasoFinal = 3;

//Objetos de cita
const cita = {//const por que los objetos en JS funcionan como un let
    id: '',//lo colocamos casi al final de appsalon por si aca cuando habia que guardar cita con fetch
    nombre: '',
    fecha: '',
    hora: '', 
    servicios: []//objeto que tiene la info de la cita
}

//Estos numeros son el calculo ejm 500 resultados lo dividimos entre 15 eso daria el paso final

//inicializar proyecto
document.addEventListener('DOMContentLoaded',()=>{
    iniciarApp();
})

const iniciarApp = () => {
    mostrarSeccion();//Muestra y oculta la secciones
    tabs();//Cambia la seccion cuando se presionen los tabs
    botonesPaginador();//Agrega o quita los botones del paginador
    paginaAnterior();
    paginaSiguiente();

    consultarAPI();//Consulta la API en el backend

    idCliente();
    nombreCliente();//Anade el nombre del cliente al objeto de cita
    seleccionarFecha();//Anade fecha de la cita en el objeto
    seleccionarHora();//Anade hora de la cita en el objeto

    mostrarResumen();//Muestra el resumen de la cita
}

const mostrarSeccion = () => {
    // console.log('desde mostrar seccion');

    //ocultar la seccion que tenga la clase de mostrar
    const seccionAnterior = document.querySelector('.mostrar');//!el punto solo va cuando queremos seleccionar clases o id
    if(seccionAnterior){
        seccionAnterior.classList.remove('mostrar');
    }
    
    //Seleccionar la seccion con el paso
    const pasoSelector = `#paso-${paso}`;
    const seccion = document.querySelector(pasoSelector);
    seccion.classList.add('mostrar');//esa clase esta en cita

    //Quita la clase de actual al tab anterior
    const tabAnterior = document.querySelector('.actual');
    if(tabAnterior){
        tabAnterior.classList.remove('actual')
    }

    //Resalta el tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);//[] = selector de atributo
    tab.classList.add('actual');
}

const tabs = () => {
    const botones = document.querySelectorAll('.tabs button')
    // console.log(botones);
    botones.forEach((boton) => {//se hace de esta forma por que son varios botones uso en los querySelectorAll
        boton.addEventListener('click', (e)=>{
            // console.log('diste click');
            // console.log(parseInt(e.target.dataset.paso));//con dataset accedo a los atributos que YO cree en mi html
            paso = parseInt(e.target.dataset.paso);
            mostrarSeccion();
            botonesPaginador();
        })
    })
}

const botonesPaginador = () => {
    //Registrar botones
    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');

    if(paso === 1){
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }else if(paso === 3){
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');
        mostrarResumen();

    }else{
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }

    mostrarSeccion();
}

const paginaAnterior = ()=>{
    const paginaAnterior = document.querySelector('#anterior');
    paginaAnterior.addEventListener('click',()=>{

        if(paso <= pasoInicial) return;
        paso--;
        // console.log(paso);
        botonesPaginador();
    });
}

const paginaSiguiente = ()=>{
    const paginaSiguiente = document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click',()=>{
        if(paso >= pasoFinal) return;
        paso++;
        botonesPaginador();

    })
}


//! Con una api no consultamos nuestra BD directamente pero lo usamos mediante una capa de 
//! Abstraccion con nuestro json que es un lenguaje de transporte
 const consultarAPI = async ()=>{

    try {
        // const url = 'http://localhost:3000/api/servicios';//solo postman
        const url = '/api/servicios';//solo postman
        // const url = `${location.origin}/api/servicios`;//location.origin: lo colocas en el navegador y te da tu localhost
        // const url = 'http://127.0.0.1:3000/api/servicios';//para trabajar con complemento thunder en vs code y postman
        const resultado = await fetch(url);//permite consumir ese servicio,await espera a que de ejecute toda esta linea y pasa a la siguiente
        const servicios = await resultado.json();
        // console.log(servicios);
        mostrarServicios(servicios);
    } catch (error) {
        // console.log(error);
    }
}

const mostrarServicios = (servicios) => {
    // console.log(servicios);
    servicios.forEach(servicio => {
        const{id,nombre,precio} = servicio;//hacemos destructuring extrae valor y te crea variable al mismo tiempo
        // console.log(precio);

        //?Usaremos scripting es mas tardado para nosotros ,pero gana en performance y es mas seguro
        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;
        // console.log(nombreServicio);

        const precioServicio = document.createElement('P')
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `$ ${precio}`;
        // console.log(precioServicio);

        //Creando los contenedores que contegan estos servicios
        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;//dataset atributo html personalizado
        servicioDiv.onclick = function(){
            seleccionarServicio(servicio);//pasar data de una fx a otra cuando lo hacemos con scripting
        };
        // console.log(servicioDiv);
        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);
        // console.log(servicioDiv);

        //Injectar al index de cita
        document.querySelector('#servicios').appendChild(servicioDiv);
    });
}

const seleccionarServicio = (servicio) => {//servicio es que selecciono  ejm cuando hago click
    // console.log(servicio);
    const {id} = servicio;
    const {servicios} = cita;//extraigo el arreglo de servicios

    //Identificar al elemento al que se le da click
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);
    

    //Comprobar si un servicio fue agregado o quitarlo
    // console.log(servicios);
     if(servicios.some(agregado => agregado.id === id)){//devuelve true o false si esta en el arreglo,el id viene del click que hacemos al servicio
        //  console.log('YA ESTA AGREGADO');
        //?Eliminarlo
        /**
         * En el código que mencionas, servicios es un arreglo de objetos y se está utilizando el método filter 
         * para crear un nuevo arreglo llamado cita.servicios que excluye el objeto cuyo id coincide con el valor de
         *  la variable id.

         La expresión agregado.id !== id es una comparación que se realiza para cada elemento del arreglo servicios.
          La función filter se ejecuta para cada elemento del arreglo y devuelve un nuevo arreglo con los elementos 
          para los cuales la expresión es evaluada como true.

       En este caso, la expresión agregado.id !== id se evalúa para cada objeto agregado en servicios. Si el id del objeto
      agregado es distinto al id proporcionado, se incluye en el nuevo arreglo cita.servicios. De lo contrario, si el id
       coincide, se excluye del nuevo arreglo.
         **/
        cita.servicios = servicios.filter( agregado => agregado.id !== id);
        divServicio.classList.remove('seleccionado');
     }else{
        // console.log('Articulo nuevo,NO estaba agregado');
        //?Agregarlo
        cita.servicios = [...servicios,servicio];//tomo copia de servicios y le agrego el nuevo
        divServicio.classList.add('seleccionado');
     }
    // console.log(cita);
}

const idCliente = () => {
    cita.id = document.querySelector('#id').value;
}

const nombreCliente = () => {
    // console.log(cita);
    cita.nombre = document.querySelector('#nombre').value;
    // console.log(nombre);
}

const seleccionarFecha = () => {
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input',(e) => {
        // console.log(e.target.value);
        const dia = new Date(e.target.value).getUTCDay();//fecha que usuario selecciono
        // console.log(dia); prevenimos que elija sabado o domingo dias no laborales
        if([6,0].includes(dia)){
            e.target.value = '';//con esto no muestra fecha a usuario
            // console.log('Sabados y domingos no abrimos');
            mostrarAlerta('Fines de semana no permitidos','error','.formulario');
        }else{
            // console.log('correcto');
            cita.fecha = e.target.value;
        }

    })
}

const seleccionarHora = () => {
   const inputHora = document.querySelector('#hora');
   inputHora.addEventListener('input',(e) => {
        // console.log(e.target.value);

        const horaCita = e.target.value;
        const hora = horaCita.split(":");//separa la hora en arreglo de dos posiciones
        // console.log(hora[0]);
        if(hora[0] < 10 || hora[0] > 18){
            // console.log('Horas no validas');
            e.target.value = '';//con esto no muestra hora a usuario
            mostrarAlerta('Hora no valida','error','.formulario')
        }else{
            // console.log('hora valida');
            cita.hora = e.target.value;
            // console.log(cita);
        }
   })
}


const mostrarAlerta = (mensaje,tipo,elemento,desaparece = true) => {
    //Prevenir que salga mas de una alerta
    const alertaPrevia = document.querySelector('.alerta');
    if(alertaPrevia){
        alertaPrevia.remove();
    } 

    //Scripting para crear la alerta
    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);
    // console.log(alerta);
    const referencia = document.querySelector(elemento);

    //Eliminamos la alerta
    referencia.appendChild(alerta);

    if(desaparece){
        setTimeout(() => {
            alerta.remove();
        },3000)
    }
}

const mostrarResumen = () => {
    const resumen = document.querySelector('.contenido-resumen');
    // console.log(Object.values(cita));//me muestra los atributos de cita
    // console.log(cita.servicios.length);//largo del arreglo

    //Limpiar el contenido de resumen
    while(resumen.firstChild){
        resumen.removeChild(resumen.firstChild);
    }

    if(Object.values(cita).includes('') || cita.servicios.length === 0){
        // console.log('Hacen falta datos o servicios');
        mostrarAlerta('Faltan datos de Servicios, Fecha u Hora','error','.contenido-resumen',false)//.contenido-resumen: donde colocamos la alerta
        return;
    }

    //Formatear el div de resumen
    const{nombre,fecha,hora,servicios} = cita;
  
   //Heading para servicios en Resumen
   const headingServicios = document.createElement('H3');
   headingServicios.textContent = 'Resumen de Servicios';
   resumen.appendChild(headingServicios);

   //Iterar y mostrando los servicios
    servicios.forEach(servicio => {
        const {id,precio,nombre} = servicio;
        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('contenedor-servicio');

        const textoServicio = document.createElement('P');
        textoServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio:</span> $${precio}`;

        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);

        //Agregamos al resumen
        resumen.appendChild(contenedorServicio);
    });

   //Heading para Cita en Resumen
   const headingCita = document.createElement('H3');
   headingCita.textContent = 'Resumen de Cita';
   resumen.appendChild(headingCita);

    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;

    //Formatear Fecha
    const fechaObj = new Date(fecha);
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate() + 2;//se agrega 2 por que es un dia menos y lo ocupamos 2 veces
    const year = fechaObj.getUTCFullYear();

    const fechaUTC = new Date(Date.UTC(year,mes,dia));

    const opciones = {weekday: 'long',year: 'numeric',month: 'long',day: 'numeric'};
    const fechaFormateada = fechaUTC.toLocaleDateString('es-CL',opciones);
    // console.log(fechaFormateada);
    
    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;

    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora:</span> ${hora} Horas`;

    //Boton para crear una cita
    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = 'Reservar Cita';
    //!Al asociar un evento de esta forma no poner parentesis por que manda a llamar la funcion
    //! y si quieres pasar un parametro es mejor crear un callback
    // botonReservar.onclick = function(){
    //     reservarCita(id)
    // }
    botonReservar.onclick = reservarCita;

    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);
    // console.log(nombreCliente);
    resumen.appendChild(botonReservar);

    async function reservarCita(){
        // console.log('Reservando cita');
        // const {nombre,fecha,hora,servicios} = cita;
        const {nombre,fecha,hora,servicios,id} = cita;

        //id basta para saber nombre y precio de los servicios por que estan en mi BD
        const idServicios = servicios.map(servicio=> servicio.id);
        // console.log(idServicios);
        // return;
        //?Usando FETCH API
        const datos = new FormData();//actua como el submit en un formulario
        // datos.append('nombre',nombre);
        datos.append('fecha',fecha);
        datos.append('hora',hora);
        datos.append('usuarioId',id);
        datos.append('servicios',idServicios);
        // console.log([...datos]);
        // return;

        //!OJO Truco para ver lo que enviamos si no NO se puede ver el FormData,toma copia del FormData 
        //!y lo formateara dentro de este arreglo
        // console.log([...datos]);

        try {
              //Peticion hacia la API
            // const url = 'http://localhost:3000/api/citas';
            const url = '/api/citas';
            // const url = 'http://localhost:3000/a';
            //Usamos metodo post hacia esa URL,de esa forma se conecta con el controlador definido o API
            const respuesta = await fetch(url,{
            method: 'POST',
            body: datos//Cuerpo de peticion a enviar, pasamos esta instancia de FormData a la url :'http://localhost:3000/api/citas';
            });
            // console.log(respuesta);

            const resultado = await respuesta.json();//lo que tenemos de respuesta en el APIController
            // console.log(resultado.resultado);//es como lo retornamos en active record resultado de la consulta y como accedemos a la llave es resultado

            if(resultado.resultado){
            //libreria que pegamos en index de cita
               Swal.fire({
                 icon: "success",
                 title: "Cita Creada",
                 text: "Tu cita fue creada correctamente",
                 button: '0K'
              }).then(() => {
                setTimeout(() => {
                    window.location.reload();//recarga la pagina
                },3000);
            })
        }
        } catch (error) {
                Swal.fire({
                  icon: "error",
                  title: "Error",
                  text: "Hubo un error al guardar la cita",
              });
        } 
   }
}


