


function addclosed(e){
    e.preventDefault();

    let fecha_closed = document.getElementById('fecha_closed');

    if(fecha_closed.value.length>0){
        swal({
            //title: "Are you sure?",
            text: "Desea deshabilitar la fecha?",
            icon: "warning",
            buttons: { go: "¡Sí!", cancel: "No!" }
        }).then(value => {
            switch (value) {
                case "go": {
                    datos = new FormData();
                    datos.set("fecha", fecha_closed.value);

                    let url = '/addclosed';

                    axios.post(url, datos)
                        .then(response => {
                            if (response.data === 1){
                                swal({
                                    //title: "Good job!",
                                    text: "Fecha deshabilitada correctamente!",
                                    icon: "success",
                                    //button: "Aww yiss!"
                                }).then((value) => {location.href = "/closed"});
                            }else if (response.data === 3){
                                swal({
                                    //title: "Good job!",
                                    text: "Fecha ya se encuentra deshabilitada",
                                    icon: "success",
                                    //button: "Aww yiss!"
                                });
                            }else{
                                swal({
                                    //title: "Good job!",
                                    text: "No se realizó la deshabilitación correctamente!",
                                    icon: "error",
                                    //button: "Aww yiss!"
                                }).then((value) => {location.href = "/closed"});
                            }
                        });
                }
                default:
                    break;
            }
        });
    }else{
        swal({
            //title: "Are you sure?",
            text: "Por favor, seleccione una fecha",
            icon: "warning",
        });
    }
}

function deleteclosed(e,id){
    e.preventDefault();

        swal({
            //title: "Are you sure?",
            text: "Desea habilitar la fecha?",
            icon: "warning",
            buttons: { go: "¡Sí!", cancel: "No!" }
        }).then(value => {
            switch (value) {
                case "go": {
                    datos = new FormData();
                    datos.set("id", id);

                    let url = '/deleteclosed';

                    axios.post(url, datos)
                        .then(response => {
                            if (response.data === 1){
                                swal({
                                    //title: "Good job!",
                                    text: "Fecha habilitada correctamente!",
                                    icon: "success",
                                    //button: "Aww yiss!"
                                }).then((value) => {location.href = "/closed"});
                            }else{
                                swal({
                                    //title: "Good job!",
                                    text: "No se realizó la habilitación correctamente!",
                                    icon: "error",
                                    //button: "Aww yiss!"
                                }).then((value) => {location.href = "/closed"});
                            }
                        });
                }
                default:
                    break;
            }
        });

}

