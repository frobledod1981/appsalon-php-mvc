// alert('desde buscador');
//Aca esta la parte de admin
document.addEventListener('DOMContentLoaded',()=>{
    iniciarApp();
})

const iniciarApp = () => {
    buscarPorFecha();
    confirmDelete();
    confirmDeleteServicio();
}

const buscarPorFecha = () => {
    // console.log('desde buscar por fecha');
    const fechaInput = document.querySelector('#fecha');
    fechaInput.addEventListener('input', (e) =>{
        // console.log('nueva fecha');
        const fechaSeleccionada = e.target.value;
        // console.log(fechaSeleccionada);
        //eviamos por GET al controlador por query string y la podremos leer en el backend
        window.location = `?fecha=${fechaSeleccionada}`;
    })
}

function confirmDelete(){
    const eliminarCita = document.querySelector('#eliminar-cita');
    eliminarCita.addEventListener('click', e =>{
        e.preventDefault();
        Swal.fire({
            title:'Confirmacion',
            text: 'Estas seguro de que deseas eliminar este registro/cita',
            icon:'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, eliminar',
            cancelButtonText: 'Cancelar',
            padding: "4rem"
        })
        .then((result) => {
            if(result.isConfirmed){
                document.querySelector("#formEliminarCita").submit();
            }});
    })
}

function confirmDeleteServicio(){
    const eliminarServicio = document.querySelector('#eliminar-servicio');
    eliminarServicio.addEventListener('click', e =>{
        e.preventDefault();
        Swal.fire({
            title:'Confirmacion',
            text: 'Estas seguro de que deseas eliminar este servicio',
            icon:'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, eliminar',
            cancelButtonText: 'Cancelar',
            padding: "4rem"
        })
        .then((result) => {
            if(result.isConfirmed){
                document.querySelector("#formEliminarServicio").submit();
            }});
    })
}