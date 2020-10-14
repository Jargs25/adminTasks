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
                // console.log(response);

                if (response.respuesta === 'Correcto') {
                    if (response.tipo === 'crear') { //Si se crear un registro.
                        swal({
                            type: 'success',
                            title: 'Usuario creado',
                            text: 'Se ha creado su usuario correctamente',
                        })
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