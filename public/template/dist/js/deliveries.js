
if(document.getElementById('codigo_delivery')){

    function datadelivery(){
        let codigo = document.getElementById('codigo_delivery').value;
        let url = "/datadelivery/"+codigo;
        axios.get(url).then(response => {
            document.getElementById("nombre").value = `${response.data[0].nombre}`;
            document.getElementById("slug").value = `${response.data[0].slug}`;
            document.getElementById("zona").value = `${response.data[0].zona}`;
            //console.log('dd'+response.data[0].deliveries[0]);
            if(response.data[0].deliveries[0]){
                document.getElementById("precio").value = `${response.data[0].deliveries[0].precio}`;
            }else{
                document.getElementById("precio").value = 0;
            }

        });
    }
    datadelivery();

    function delivery_update(e){
        e.preventDefault();

        swal({
            //title: "Are you sure?",
            text: "¿Desea actualizar los datos del distrito?",
            icon: "warning",
            buttons: { go: "¡Sí!", cancel: "No!" }
        }).then(value => {
            switch (value) {
                case "go": {
                    let codigo_antiguo = document.getElementById('codigo_delivery').value;
                    let nombre = document.getElementById("nombre").value;
                    let slug = document.getElementById("slug").value;
                    let zona = document.getElementById("zona").value;
                    let precio = document.getElementById("precio").value;

                    if(nombre.length<=0){
                        swal({
                            //title: "Are you sure?",
                            text: "Debe ingresar un nombre. ",
                            icon: "error",
                        });
                    }else if(zona.length<=0){
                        swal({
                            //title: "Are you sure?",
                            text: "Debe ingresar una zona. ",
                            icon: "error",
                        });
                    }else if(precio.length<=0){
                        swal({
                            //title: "Are you sure?",
                            text: "Debe ingresar un precio. ",
                            icon: "error",
                        });
                    }
                    else{
                        if(codigo_antiguo.toUpperCase() === slug.toUpperCase() ){
                            if (precio) {
                                let isValid = /^(\d+)$|^(\d+\.{1}\d{2})$/;
                                if (!isValid.test(precio)) {
                                    swal({
                                        //title: "Are you sure?",
                                        text: "Precio con formato inválido. ",
                                        icon: "error",
                                    });
                                }else {
                                    datos = new FormData();
                                    datos.set("codigo_antiguo", codigo_antiguo);
                                    datos.set("nombre", nombre);
                                    datos.set("slug", slug);
                                    datos.set("zona", zona);
                                    datos.set("precio", precio);

                                    let url = '/updatedelivery/' + codigo_antiguo;

                                    axios.post(url, datos)
                                        .then(response => {
                                            if (response.data === 1) {
                                                swal({
                                                    //title: "Good job!",
                                                    text: "Los datos se actualizaron correctamente!",
                                                    icon: "success",
                                                    //button: "Aww yiss!"

                                                }).then(value => {
                                                    switch (value) {
                                                        case "go":
                                                            location.href = "/delivery/edit/" + slug;
                                                            break;
                                                        default:
                                                            location.href = "/delivery/edit/" + slug;
                                                    }
                                                });

                                            } else {
                                                swal({
                                                    //title: "Good job!",
                                                    text: "No se realizó la actualización correctamente!",
                                                    icon: "error",
                                                    //button: "Aww yiss!"
                                                });
                                            }
                                        });
                                }
                            }
                        }
                        else{
                            //console.log('diferente');
                            let url_checkcodedelivery = "/checkcodedelivery/"+document.getElementById("slug").value;
                            axios.get(url_checkcodedelivery).then(respuesta => {

                                if (respuesta.data === 1) {
                                    swal({
                                        //title: "Are you sure?",
                                        text: "El distrito ya existe. ",
                                        icon: "error",
                                    });
                                }
                                else {
                                    if (precio) {
                                        let isValid = /^(\d+)$|^(\d+\.{1}\d{2})$/;
                                        if (!isValid.test(precio)) {
                                            swal({
                                                //title: "Are you sure?",
                                                text: "Precio con formato inválido. ",
                                                icon: "error",
                                            });
                                        }else {
                                            datos = new FormData();
                                            datos.set("codigo_antiguo", codigo_antiguo);
                                            datos.set("nombre", nombre);
                                            datos.set("slug", slug);
                                            datos.set("zona", zona);
                                            datos.set("precio", precio);

                                            let url = '/updatedelivery/' + codigo_antiguo;

                                            axios.post(url, datos)
                                                .then(response => {
                                                    if (response.data === 1) {
                                                        swal({
                                                            //title: "Good job!",
                                                            text: "Los datos se actualizaron correctamente!",
                                                            icon: "success",
                                                            //button: "Aww yiss!"

                                                        }).then(value => {
                                                            switch (value) {
                                                                case "go":
                                                                    location.href = "/delivery/edit/" + slug;
                                                                    break;
                                                                default:
                                                                    location.href = "/delivery/edit/" + slug;
                                                            }
                                                        });

                                                    } else {
                                                        swal({
                                                            //title: "Good job!",
                                                            text: "No se realizó la actualización correctamente!",
                                                            icon: "error",
                                                            //button: "Aww yiss!"
                                                        });
                                                    }
                                                });
                                        }
                                    }
                                }

                            });
                        }

                    }
                }
                default:
                    break;
            }
        });

    }

}
else{
    function delivery_create(e){
        e.preventDefault();

        swal({
            //title: "Are you sure?",
            text: "¿Desea crear el distrito?",
            icon: "warning",
            buttons: { go: "¡Sí!", cancel: "No!" }
        }).then(value => {
            switch (value) {
                case "go": {
                    let nombre = document.getElementById("nombre").value;
                    let slug = document.getElementById("slug").value;
                    let zona = document.getElementById("zona").value;
                    let precio = document.getElementById("precio").value;

                    if(nombre.length<=0){
                        swal({
                            //title: "Are you sure?",
                            text: "Debe ingresar un nombre. ",
                            icon: "error",
                        });
                    }else if(zona.length<=0){
                        swal({
                            //title: "Are you sure?",
                            text: "Debe ingresar una zona. ",
                            icon: "error",
                        });
                    }else if(precio.length<=0){
                        swal({
                            //title: "Are you sure?",
                            text: "Debe ingresar un precio. ",
                            icon: "error",
                        });
                    }
                    else{
                        let url_checkcodedelivery = "/checkcodedelivery/"+document.getElementById("slug").value;
                        axios.get(url_checkcodedelivery).then(respuesta => {

                            if (respuesta.data === 1) {
                                swal({
                                    //title: "Are you sure?",
                                    text: "El distrito ya existe. ",
                                    icon: "error",
                                });
                            }
                            else{
                                if (precio) {
                                    let isValid = /^(\d+)$|^(\d+\.{1}\d{2})$/;
                                    if (!isValid.test(precio)) {
                                        swal({
                                            //title: "Are you sure?",
                                            text: "Precio con formato inválido. ",
                                            icon: "error",
                                        });
                                    }else {
                                        datos = new FormData();
                                        datos.set("nombre", nombre);
                                        datos.set("slug", slug);
                                        datos.set("zona", zona);
                                        datos.set("precio", precio);

                                        let url = '/createdeliveries';

                                        axios.post(url, datos)
                                            .then(response => {
                                                if (response.data === 1) {
                                                    swal({
                                                        //title: "Good job!",
                                                        text: "El distrito se creó correctamente!",
                                                        icon: "success",
                                                        //button: "Aww yiss!"

                                                    }).then(value => {
                                                        switch (value) {
                                                            case "go":
                                                                location.href = "/delivery/edit/" + slug;
                                                                break;
                                                            default:
                                                                location.href = "/delivery/edit/" + slug;
                                                        }
                                                    });

                                                } else {
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
                            }


                        });
                    }
                }
                default:
                    break;
            }
        });

    }

}

function delivery_delete(e,codigo){
    e.preventDefault();
    swal({
        //title: "Are you sure?",
        text: "Desea eliminar el distrito?",
        icon: "warning",
        buttons: { go: "¡Sí!", cancel: "No!" }
    }).then(value => {
        switch (value) {
            case "go": {
                // datos = new FormData();
                // datos.set("nombre", nombre);

                let url = '/deletedelivery/'+codigo;

                axios.get(url)
                    .then(response => {
                        if (response.data === 1){
                            swal({
                                //title: "Good job!",
                                text: "El distrito se eliminó correctamente!",
                                icon: "success",
                                //button: "Aww yiss!"
                            }).then(value => {
                                switch (value) {
                                    case "go":
                                        location.href = "/deliveries";
                                        break;
                                    default:
                                        location.href = "/deliveries";
                                }
                            });

                        }
                        if (response.data === 2){
                            swal({
                                //title: "Good job!",
                                text: "La eliminación no se realizó correctamente!",
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

function slug_codigo(){
    str = document.getElementById("nombre").value;

    str = str.replace(/^\s+|\s+$/g, '');

    // Make the string lowercase
    str = str.toLowerCase();

    // Remove accents, swap ñ for n, etc
    var from = "ÁÄÂÀÃÅČÇĆĎÉĚËÈÊẼĔȆÍÌÎÏŇÑÓÖÒÔÕØŘŔŠŤÚŮÜÙÛÝŸŽáäâàãåčçćďéěëèêẽĕȇíìîïňñóöòôõøðřŕšťúůüùûýÿžþÞĐđßÆa·/_,:;";
    var to   = "AAAAAACCCDEEEEEEEEIIIINNOOOOOORRSTUUUUUYYZaaaaaacccdeeeeeeeeiiiinnooooooorrstuuuuuyyzbBDdBAa------";
    for (var i=0, l=from.length ; i<l ; i++) {
        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }

    // Remove invalid chars
    str = str.replace(/[^a-z0-9 -]/g, '')
        // Collapse whitespace and replace by -
        .replace(/\s+/g, '-')
        // Collapse dashes
        .replace(/-+/g, '-');

    document.getElementById("slug").value = str;
}
