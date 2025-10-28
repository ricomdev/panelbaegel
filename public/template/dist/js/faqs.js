
if(document.getElementById('id_faqs')){
function datafaq(){
    let id_faqs = document.getElementById('id_faqs').value;
    let url = "/datafaq/"+id_faqs;
    axios.get(url).then(response => {
        document.getElementById("pregunta").value = `${response.data[0].pregunta}`;
        document.getElementById("respuesta").value = `${response.data[0].respuesta}`;

        let url_faqstype = "/datafaqstypes";
        axios.get(url_faqstype).then(resp => {
            let array = resp.data;
            for (let i=0; i < array.length; i++) {
                let selected = "";
                if(response.data[0].faqs_type_id === array[i].id){
                    selected = "selected";
                }
                document.getElementById("faqstypes").innerHTML += `<option ${selected} value="${array[i].id}">${array[i].nombre}</option>`;
            }
        });

    });
}
    datafaq();


function faqs_update(e){
    e.preventDefault();

    swal({
        //title: "Are you sure?",
        text: "Desea actualizar el registro?",
        icon: "warning",
        buttons: { go: "¡Sí!", cancel: "No!" }
    }).then(value => {
        switch (value) {
            case "go": {
                let id_antiguo = document.getElementById('id_faqs').value;
                let pregunta = document.getElementById("pregunta").value;
                let respuesta = document.getElementById("respuesta").value;
                let faqstypes = document.getElementById("faqstypes").value;

                console.log(faqstypes);

                datos = new FormData();
                datos.set("id_antiguo", id_antiguo);
                datos.set("pregunta", pregunta);
                datos.set("respuesta", respuesta);
                datos.set("faqstypes", faqstypes);

                if(pregunta.length<=0){
                    swal({
                        //title: "Are you sure?",
                        text: "Debe ingresar una pregunta. ",
                        icon: "error",
                    });
                }else if(respuesta.length<=0){
                    swal({
                        //title: "Are you sure?",
                        text: "Debe ingresar una respuesta. ",
                        icon: "error",
                    });
                }
                else{
                    let url = '/updatefaq/'+id_antiguo;

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
                                            location.href = "/faqs/edit/"+id_antiguo;
                                            break;
                                        default:
                                            location.href = "/faqs/edit/"+id_antiguo;
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
    function faq_create(e){
        e.preventDefault();

        swal({
            //title: "Are you sure?",
            text: "Desea realizar el registro?",
            icon: "warning",
            buttons: { go: "¡Sí!", cancel: "No!" }
        }).then(value => {
            switch (value) {
                case "go": {
                    let pregunta = document.getElementById("pregunta").value;
                    let respuesta = document.getElementById("respuesta").value;
                    let faqstypes = document.getElementById("faqstypes").value;

                    datos = new FormData();
                    datos.set("pregunta", pregunta);
                    datos.set("respuesta", respuesta);
                    datos.set("faqstypes", faqstypes);

                    if(pregunta.length<=0){
                        swal({
                            //title: "Are you sure?",
                            text: "Debe ingresar una pregunta. ",
                            icon: "error",
                        });
                    }else if (respuesta.length<=0){
                        swal({
                            //title: "Are you sure?",
                            text: "Debe ingresar una respuesta. ",
                            icon: "error",
                        })
                    }else{
                        let url = '/createfaq';

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
                                                location.href = "/faqs";
                                                break;
                                            default:
                                                location.href = "/faqs";
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

    function faqs_types(){
        let url_faqstypes = "/datafaqstypes";
        axios.get(url_faqstypes).then(resp => {
            let faqstypes = resp.data;
            Object.values(faqstypes).forEach(function(faqstype) {
                document.getElementById("faqstypes").innerHTML += `<option value="${faqstype.id}">${faqstype.nombre}</option>`;
            });
        });
    }

    faqs_types();

}


function faqs_delete(e,id){
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

                let url = '/deletefaq/'+id;

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
                                        location.href = "/faqs";
                                        break;
                                    default:
                                        location.href = "/faqs";
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
