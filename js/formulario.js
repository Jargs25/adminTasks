eventListeners();

function eventListeners() {
    document.querySelector('#formulario').addEventListener('submit', validarRegistro);
}

function validarRegistro(e) {
    e.preventDefault();

    var usuario = document.querySelector('#usuario').value,
        password = document.querySelector('#password').value,
        tipo = document.querySelector('#tipo').value;

    // console.log(`${usuario} ${password}`);
    if (usuario === '' || password === '') {
        swal({
            type: 'error',
            title: 'Error!',
            text: 'Ambos campos son obligatorios',
        })
    } else if (usuario.lenght < 5 || password < 5 && tipo !== 'login') {
        swal({
            type: 'error',
            title: 'Error!',
            text: 'Usuario o contraseña debe tener un mínimo de 5 caracteres',
        })
    } else {
        // swal({
        //     type: 'success',
        //     title: 'Correcto',
        //     text: 'Datos correctos',
        // })
        var datos = new FormData();

        datos.append('usuario', usuario);
        datos.append('password', password);
        datos.append('action', tipo);

        // console.log(datos.get('usuario'));
        var xhr = new XMLHttpRequest();
        //Abrir conexion.
        xhr.open('POST', 'includes/models/model-admin.php', true); //True = Asincrono.
        //Retorno de datos.
        xhr.onload = function() {
            if (this.status === 200) { //Respuesta Exitosa!
                // console.log(xhr.response);
                // console.log(JSON.parse(xhr.responseText));
                var response = JSON.parse(xhr.responseText);
                console.log(response);

                if (response.respuesta === 'Correcto') {
                    if (response.tipo === 'crear') { //Si se crear un registro.
                        swal({
                            type: 'success',
                            title: 'Usuario creado',
                            text: 'Se ha creado su usuario correctamente',
                        })
                        document.querySelector("#formulario").reset();
                        setTimeout(() => {
                            window.location.href = 'index.php';
                        }, 2000);
                    } else if (response.tipo === 'login') {
                        swal({
                            type: 'success',
                            title: 'Bienvenido',
                            text: 'Presiona OK para continuar'
                        }).then(result => { //Arror function
                            if (result.value) {
                                window.location.href = 'index.php';
                            }
                        })
                    } else {
                        swal({
                            type: 'error',
                            title: 'Error',
                            text: 'Hubo un error, intente más tarde',
                        })
                    }
                } else if (response.respuesta === 'Incorrecto') {
                    if (response.tipo === 'crear') {
                        if (response.error.includes("Duplicate")) {
                            swal({
                                type: 'warning',
                                title: 'Ooops',
                                text: 'El usuario "' + usuario + '" ya está en uso, pruebe con otro',
                            });
                        } else {
                            swal({
                                type: 'error',
                                title: 'Error',
                                text: 'Hubo un error, intente más tarde',
                            })
                        }
                    } else {
                        swal({
                            type: 'error',
                            title: 'Error',
                            text: 'Credenciales no válidas',
                        });
                    }
                } else { // Hubo un error.
                    swal({
                        type: 'error',
                        title: 'Error',
                        text: 'Hubo un error, intente más tarde',
                    })
                }
            }
        }
        xhr.send(datos);
    }
}