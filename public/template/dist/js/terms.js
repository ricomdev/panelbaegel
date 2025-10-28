
if(document.getElementById('id_terms')){
    function dataterm(){
        let id_terms = document.getElementById('id_terms').value;
        let url = "/dataterm/"+id_terms;
        axios.get(url).then(response => {
            document.getElementById("titulo").value = `${response.data[0].titulo}`;
            document.getElementById("descripcion").value = `${response.data[0].descripcion}`;
        });
    }
    dataterm();

    function term_update(e){
        e.preventDefault();
        swal({
            //title: "Are you sure?",
            text: "Desea actualizar el registro?",
            icon: "warning",
            buttons: { go: "¡Sí!", cancel: "No!" }
        }).then(value => {
            switch (value) {
                case "go": {
                    let id_antiguo = document.getElementById('id_terms').value;
                    let titulo = document.getElementById("titulo").value;
                    let descripcion = document.getElementById("descripcion").value;

                    datos = new FormData();
                    datos.set("id_antiguo", id_antiguo);
                    datos.set("titulo", titulo);
                    datos.set("descripcion", descripcion);

                    if(titulo.length<=0){
                        swal({
                            //title: "Are you sure?",
                            text: "Debe ingresar una pregunta. ",
                            icon: "error",
                        });
                    }else if(descripcion.length<=0){
                        swal({
                            //title: "Are you sure?",
                            text: "Debe ingresar una respuesta. ",
                            icon: "error",
                        });
                    }
                    else{
                        let url = '/updateterm/'+id_antiguo;

                        axios.post(url, datos)
                            .then(response => {
                                if (response.data === 1){
                                    swal({
                                        //title: "Good job!",
                                        text: "Los datos se actualizaron correctamente!",
                                        icon: "success",
                                        //button: "Aww yiss!"
                                    }).then(value => {
                                        switch (value) {
                                            case "go":
                                                location.href = "/terms/edit/"+id_antiguo;
                                                break;
                                            default:
                                                location.href = "/terms/edit/"+id_antiguo;
                                        }
                                    });
                                }else{
                                    swal({
                                        //title: "Good job!",
                                        text: "No se realizó la actualización correctamente!",
                                        icon: "error",
                                        //button: "Aww yiss!"
                                    });
                                }
                                //console.log(response.data);
                                //document.getElementById('codigo_ingrediente').value = codigo;
                                //dataingredient();
                            });
                    }
                }
                default:
                    break;
            }
        });

    }


}
else{

    function term_create(e){
        e.preventDefault();
        swal({
            //title: "Are you sure?",
            text: "Desea realizar el registro?",
            icon: "warning",
            buttons: { go: "¡Sí!", cancel: "No!" }
        }).then(value => {
            switch (value) {
                case "go": {
                    let titulo = document.getElementById("titulo").value;
                    let descripcion = document.getElementById("descripcion").value;

                    datos = new FormData();
                    datos.set("titulo", titulo);
                    datos.set("descripcion", descripcion);

                    if(titulo.length<=0){
                        swal({
                            //title: "Are you sure?",
                            text: "Debe ingresar una titulo. ",
                            icon: "error",
                        });
                    }else if (descripcion.length<=0){
                        swal({
                            //title: "Are you sure?",
                            text: "Debe ingresar una descripcion. ",
                            icon: "error",
                        })
                    }else{
                        let url = '/createterm';

                        axios.post(url, datos)
                            .then(response => {
                                if (response.data === 1){
                                    swal({
                                        //title: "Good job!",
                                        text: "Los datos se registraron correctamente!",
                                        icon: "success",
                                        //button: "Aww yiss!"
                                    }).then(value => {
                                        switch (value) {
                                            case "go":
                                                location.href = "/terms";
                                                break;
                                            default:
                                                location.href = "/terms";
                                        }
                                    });

                                }else{
                                    swal({
                                        //title: "Good job!",
                                        text: "No se realizó el registro correctamente!",
                                        icon: "error",
                                        //button: "Aww yiss!"
                                    });
                                }
                            });
                    }

                }
                default:
                    break;
            }
        });
    }

    function terms_delete(e,id){
        e.preventDefault();
        swal({
            //title: "Are you sure?",
            text: "Desea eliminar el registro?",
            icon: "warning",
            buttons: { go: "¡Sí!", cancel: "No!" }
        }).then(value => {
            switch (value) {
                case "go": {
                    // datos = new FormData();
                    // datos.set("nombre", nombre);

                    let url = '/deleteterm/'+id;

                    axios.get(url)
                        .then(response => {
                            if (response.data === 1){
                                swal({
                                    //title: "Good job!",
                                    text: "El registro se eliminó correctamente!",
                                    icon: "success",
                                    //button: "Aww yiss!"
                                }).then(value => {
                                    switch (value) {
                                        case "go":
                                            location.href = "/terms";
                                            break;
                                        default:
                                            location.href = "/terms";
                                    }
                                });

                            }
                            if (response.data === 2){
                                swal({
                                    //title: "Good job!",
                                    text: "No se realizó la eliminación correctamente!",
                                    icon: "error",
                                    //button: "Aww yiss!"
                                });
                            }
                        });

                }
                default:
                    break;
            }
        });
    }

}
