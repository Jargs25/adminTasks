//Lista de Proyectos.
var listaProyectos = document.querySelector('ul#proyectos');

eventListeners();

function eventListeners() {
    document.querySelector('.boton.menu').addEventListener('click', openMenu);
    document.querySelector('.crear-proyecto a').addEventListener('click', nuevoProyecto);
    if (document.querySelector('.avance')) {
        //Document Ready
        document.addEventListener('DOMContentLoaded', function() {
            actualizarProgreso();
        });
        document.querySelector('.nueva-tarea').addEventListener('click', agregarTarea);
        document.querySelector('.acciones-proyecto .acciones').addEventListener('click', accionesProyecto);
        //Delegation
        document.querySelector('.listado-pendientes').addEventListener('click', accionesTareas);
    }
    document.querySelector('.barra a').addEventListener('click', logout);
}

function openMenu(e) {
    if (e.target.classList.contains("open")) {
        e.target.classList.remove("open");
        document.querySelector('.contenedor-proyectos').classList.remove("open");
    } else {
        e.target.classList.add("open");
        document.querySelector('.contenedor-proyectos').classList.add("open");
    }

}

function nuevoProyecto(e) {
    e.preventDefault();
    debugger;
    if (e.target.classList.contains("disabled")) {
        e.target.classList.remove("disabled");
        document.querySelector("#btnText").textContent = "Nuevo Proyecto";
        document.querySelector("#nuevo-proyecto").parentNode.remove();
        return false;
    }
    // console.log("Nuevo Proyecto");

    //Crear <input> para el nombre.
    var newProyect = document.createElement('li');
    newProyect.innerHTML = `<div class="new-proyect">
                                <input type="text" id="nuevo-proyecto">
                                <div class="boton">
                                    <i class="far fa-plus-square"></i>
                                </div>
                            </div>`;
    listaProyectos.appendChild(newProyect);

    // seleccionar el ID del nuevo input (Proyecto);
    var inputNewProyect = document.querySelector("#nuevo-proyecto");
    var id = e.target.id;
    inputNewProyect.focus();
    inputNewProyect.addEventListener('keypress', function(e) {
        var tecla = e.which || e.keycode;
        if (tecla === 13) {
            if (inputNewProyect.value.length > 4) {
                saveProyectDB(inputNewProyect.value, id);
                listaProyectos.removeChild(newProyect);
            } else {
                swal({
                    type: 'warning',
                    title: '¡Atención!',
                    text: `Ingrese un nombre válido`,
                });
            }
        }
    });
    document.querySelector(".new-proyect .boton").addEventListener('click', function() {
        if (inputNewProyect.value.length > 4) {
            saveProyectDB(inputNewProyect.value, id);
            listaProyectos.removeChild(newProyect);
        } else {
            swal({
                type: 'warning',
                title: '¡Atención!',
                text: `Ingrese un nombre válido`,
            });
            inputNewProyect.focus();
        }
    });
    e.target.classList.add("disabled");
    document.querySelector("#btnText").textContent = "Cancelar";
}

function saveProyectDB(name, userId) {
    debugger;
    // console.log(name);
    var datos = new FormData();
    datos.append('proyecto', name);
    datos.append('usuarioId', userId);
    datos.append('action', 'crear');

    var xhr = new XMLHttpRequest(); // Crear ajax.
    //Abrir conexión.
    xhr.open('POST', 'includes/models/model-project.php', true);
    //Establecer cargar.
    xhr.onload = function() {
            if (this.status === 200) {
                // console.log(xhr.response);
                var response = JSON.parse(xhr.responseText);
                var proyecto = response.nombre_proyecto,
                    id_proyecto = response.id_proyecto,
                    accion = response.accion,
                    resultado = response.respuesta;

                if (resultado === 'Correcto') {
                    if (accion === 'crear') {
                        var newProyect = document.createElement('li');
                        //templates o stringsLiterals de ECMAScript 6.
                        newProyect.innerHTML = `
                            <a href="index.php?id_proyecto=${id_proyecto}" id="proyecto:${id_proyecto}">
                                ${name}
                            </a>
                        `;
                        listaProyectos.appendChild(newProyect);

                        swal({
                            type: 'success',
                            title: '¡Proyecto Creado!',
                            text: `El proyecto ${name} se creó correctamente.`,
                        }).then(result => { //Arror function
                            if (result.value) {
                                //Redireccionar al nuevo proyecto.
                                window.location.href = 'index.php?id_proyecto=' + id_proyecto;
                            }
                        })
                    } else {

                    }
                } else {
                    swal({
                        type: 'error',
                        title: 'Error!',
                        text: 'Hubo un error',
                    })
                }
            }
        }
        //Enviar Request
    xhr.send(datos);
}

function agregarTarea(e) {
    e.preventDefault();
    // console.log('Enviar');
    var nombre = document.querySelector('.nombre-tarea').value;
    if (nombre === '') {
        swal({
            type: 'error',
            title: 'Error!',
            text: 'La tarea no puede estar sin nombre',
        })
    } else {
        var id_proyecto = document.querySelector("#id_proyecto").value;
        var datos = new FormData();
        datos.append('tarea', nombre);
        datos.append('action', 'crear');
        datos.append('id_proyecto', id_proyecto);

        var xhr = new XMLHttpRequest();

        xhr.open('POST', 'includes/models/model-tareas.php', true);

        xhr.onload = function() {
            if (this.status === 200) {
                var response = JSON.parse(xhr.responseText);

                var respuesta = response.respuesta,
                    tarea = response.tarea,
                    id_insertado = response.id_insertado,
                    tipo = response.accion;

                if (respuesta === 'Correcto') {
                    if (tipo === 'crear') {
                        //Seleccionar "Lista-Vacia".
                        var listaVacia = document.querySelectorAll('.lista-vacia');
                        if (listaVacia.length > 0) {
                            document.querySelector('.lista-vacia').remove();
                        }

                        var newTask = document.createElement('li');

                        newTask.id = 'tarea:' + id_insertado;
                        newTask.classList.add('tarea');
                        newTask.innerHTML = `
                            <p>${tarea}</p>
                            <div class="acciones">
                                <i class="far fa-check-circle"></i>
                                <i class="fas fa-trash"></i>
                            </div>
                        `;
                        var listadoTareas = document.querySelector(".listado-pendientes ul");
                        listadoTareas.appendChild(newTask);

                        //Resetear el Form
                        document.querySelector(".agregar-tarea").reset();
                        //Actualiza la barra de avance.
                        actualizarProgreso();
                        swal({
                            type: 'success',
                            title: 'Tarea Creada!',
                            text: `La tarea "${tarea}" se creó correctamente.`,
                        });
                    } else {

                    }
                } else {
                    swal({
                        type: 'error',
                        title: 'Error!',
                        text: 'Hubo un error',
                    })
                }
            }
        };

        xhr.send(datos);
    }
}

// Cambia el estado de las tareas o las elimina.
function accionesTareas(e) {
    e.preventDefault();
    //Delegation.
    if (e.target.classList.contains('fa-check-circle')) {
        if (e.target.classList.contains('completo')) {
            e.target.classList.remove('completo');
            cambiarEstado(e.target, 0);
        } else {
            e.target.classList.add('completo');
            cambiarEstado(e.target, 1);
        }
    }
    if (e.target.classList.contains('fa-trash')) {
        swal({
            type: 'warning',
            title: '¿Desea Continuar?',
            text: 'Esta acción no se puede deshacer',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, continuar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.value) {
                var taskDelete = e.target.parentElement.parentElement;
                //Borrar de BD
                elimiarTarea(taskDelete);

                //Borrar de DOM
                taskDelete.remove();
                swal({
                    type: 'success',
                    title: '¡Eliminado!',
                    text: 'Tarea eliminada correctamente',
                })
            }
        })
    }
}

//Cambia el estado
function cambiarEstado(tarea, estado) {
    var id = tarea.parentElement.parentElement.id.split(':');
    // console.log(id);

    var datos = new FormData();
    datos.append('id', id[1]);
    datos.append('action', 'actualizar');
    datos.append('estado', estado);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'includes/models/model-tareas.php', true);
    xhr.onload = function() {
        if (this.status === 200) {
            actualizarProgreso();
            // console.log(JSON.parse(xhr.responseText));
        }
    };
    xhr.send(datos);
}
//Elimina de la BD
function elimiarTarea(tarea) {
    var id = tarea.id.split(':');
    // console.log(id);

    var datos = new FormData();
    datos.append('id', id[1]);
    datos.append('action', 'eliminar');

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'includes/models/model-tareas.php', true);
    xhr.onload = function() {
        if (this.status === 200) {
            // console.log(JSON.parse(xhr.responseText));
            // Verificar tareas
            //Seleccionar "Lista-Vacia".
            var listaTareas = document.querySelectorAll('li.tarea');
            if (listaTareas.length === 0) {
                document.querySelector('.listado-pendientes ul').innerHTML = "<p class='lista-vacia'>No hay tareas agregadas.</p>";
            }
            actualizarProgreso();
        }
    };
    xhr.send(datos);
}
//Actualiza el avance del proyecto.
function actualizarProgreso() {

    //Obtener tareas
    const tareas = document.querySelectorAll('li.tarea');
    //Completadas.
    const completadas = document.querySelectorAll('i.completo');
    const avance = Math.round((completadas.length / tareas.length) * 100);
    //Asignación.
    const fondo = document.querySelector("#fondo");
    fondo.style.width = avance + '%';
    const porcentaje = document.querySelector("#porcentaje");
    porcentaje.textContent = (avance >= 0 ? avance : 0) + '%';
    // console.log(avance + '%');

    //Mostrar alerta
    if (avance === 100) {
        swal({
            type: 'success',
            title: 'Proyecto Terminado',
            text: 'No quedan tareas pendientes',
        });
    }
}

function accionesProyecto(e) {
    e.preventDefault();
    // for (proyecto of proyectos) {
    //     debugger;
    //     console.log(proyecto.children[0].id);
    // }

    //Delegation.
    if (e.target.classList.contains('fa-edit')) {
        editarProyecto();
    }
    if (e.target.classList.contains('fa-trash')) {
        swal({
            type: 'warning',
            title: '¿Desea Continuar?',
            text: 'Esta acción elimina el proyecto y no se puede deshacer',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, continuar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.value) {
                var taskDelete = e.target.parentElement.parentElement;
                //Borrar de BD
                eliminarProyecto(taskDelete);

                //Borrar de DOM
                taskDelete.remove();
                swal({
                    type: 'success',
                    title: '¡Eliminado!',
                    text: 'El proyecto ha sido eliminado',
                }).then(result => {
                    if (result.value) {
                        window.location.href = 'index.php';
                    }
                })
                setTimeout(() => {
                    window.location.href = 'index.php';
                }, 3000);
            }
        })
    }
}

function editarProyecto() {
    var nombre = document.querySelector(".acciones-proyecto input").value;
    var id = document.querySelector("#idProyecto").value;

    var datos = new FormData();
    datos.append("id", id);
    datos.append("proyecto", nombre);
    datos.append("action", 'actualizar');

    var xhr = new XMLHttpRequest();

    xhr.open('POST', 'includes/models/model-project.php', true);

    xhr.onload = function() {
        if (this.status === 200) {
            // console.log(JSON.parse(xhr.responseText));
            swal({
                type: 'success',
                title: '¡Actualizado!',
                text: 'El proyecto ha sido renombrado',
            });

            document.querySelector(".contenido-principal span").textContent = nombre;

            var proyectos = document.querySelector("#proyectos").children;

            for (proyecto of proyectos) {
                // console.log(proyecto.children[0].id);
                if (proyecto.children[0].id === `proyecto:${id}`) {
                    proyecto.children[0].innerText = nombre;
                }
            }
            // document.querySelector("#proyectos").children[0].children[0].id == `proyecto:${id}`;
            // document.querySelector("#proyectos").children[0].innerText = nombre;
        }
    }

    xhr.send(datos);
}

function eliminarProyecto() {
    var id = document.querySelector("#idProyecto").value;

    var datos = new FormData();
    datos.append("id", id);
    datos.append("action", 'eliminar');

    var xhr = new XMLHttpRequest();

    xhr.open('POST', 'includes/models/model-project.php', true);

    xhr.onload = function() {
        if (this.status === 200) {
            // console.log(JSON.parse(xhr.responseText));
            var proyectos = document.querySelector("#proyectos").children;

            for (proyecto of proyectos) {
                // console.log(proyecto.children[0].id);
                if (proyecto.children[0].id === `proyecto:${id}`) {
                    proyecto.remove();
                }
            }
            // document.querySelector("#proyectos").children[0].children[0].id == `proyecto:${id}`;
            // document.querySelector("#proyectos").children[0].innerText = nombre;
        }
    }

    xhr.send(datos);
}

function logout(e) {
    e.preventDefault();
    let datos = new FormData();
    datos.append('action', 'logout');
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'includes/models/model-admin.php', true);
    xhr.onload = function() {
        if (this.status === 200) {
            // console.log(JSON.parse(xhr.responseText));
            let response = JSON.parse(xhr.responseText);
            if (response.respuesta == 'correcto') {
                window.location.href = e.target.getAttribute('href');
            }
        }
    }
    xhr.send(datos);
}