
if(document.getElementById('codigo_ingrediente')){
function dataingredient(){
    let codigo = document.getElementById('codigo_ingrediente').value;
    let url = "/dataingredient/"+codigo;
    axios.get(url).then(response => {
        document.getElementById("nombre").value = `${response.data[0].nombre}`;
        document.getElementById("codigo").value = `${response.data[0].codigo}`;
        document.getElementById("imagen").innerHTML = `<a href="${response.data[0].ruta}" data-toggle="lightbox" data-title="${response.data[0].nombre}" data-gallery="gallery">
                                                                <img src="${response.data[0].ruta}" class="img-fluid mb-2" alt="${response.data[0].nombre}"/>
                                                            </a>`;
    });
}

dataingredient();


function ingredient_update(e){
    e.preventDefault();

    swal({
        //title: "Are you sure?",
        text: "Desea actualizar el registro?",
        icon: "warning",
        buttons: { go: "¡Sí!", cancel: "No!" }
    }).then(value => {
        switch (value) {
            case "go": {
                let codigo_antiguo = document.getElementById('codigo_ingrediente').value;
                let nombre = document.getElementById("nombre").value;
                let codigo = document.getElementById("codigo").value;
                let file = document.getElementById("file").files;


                datos = new FormData();
                datos.set("codigo_antiguo", codigo_antiguo);
                datos.set("nombre", nombre);
                datos.set("codigo", codigo);
                datos.set("file", file[0]);

                if(nombre.length<=0){
                    swal({
                        //title: "Are you sure?",
                        text: "Debe ingresar un nombre. ",
                        icon: "error",
                    });
                }
                else{
                    let url = '/updateingredient/'+codigo_antiguo;

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
                                            location.href = "/ingredient/edit/"+codigo;
                                            break;
                                        default:
                                            location.href = "/ingredient/edit/"+codigo;
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

function ingredient_create(e){
    e.preventDefault();

    swal({
        //title: "Are you sure?",
        text: "Desea realizar el registro?",
        icon: "warning",
        buttons: { go: "¡Sí!", cancel: "No!" }
    }).then(value => {
        switch (value) {
            case "go": {
                let nombre = document.getElementById("nombre").value;
                let codigo = document.getElementById("codigo").value;
                let file = document.getElementById("file").files;

                datos = new FormData();
                datos.set("nombre", nombre);
                datos.set("codigo", codigo);
                datos.set("file", file[0]);

                if(nombre.length<=0){
                    swal({
                        //title: "Are you sure?",
                        text: "Debe ingresar un nombre. ",
                        icon: "error",
                    });
                }else if (file.length === 0) {
                    swal({
                        //title: "Are you sure?",
                        text: "Debe elegir al menos la primera imagen. ",
                        icon: "error",
                    })
                }else{
                    let url = '/createingredient';

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
                                            location.href = "/ingredient/edit/"+codigo;
                                            break;
                                        default:
                                            location.href = "/ingredient/edit/"+codigo;
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

function ingredient_delete(e,codigo){
    e.preventDefault();
    swal({
        //title: "Are you sure?",
        text: "Desea eliminar el ingrediente?",
        icon: "warning",
        buttons: { go: "¡Sí!", cancel: "No!" }
    }).then(value => {
        switch (value) {
            case "go": {
                // datos = new FormData();
                // datos.set("nombre", nombre);

                let url = '/deleteingredient/'+codigo;

                axios.get(url)
                    .then(response => {
                        if (response.data === 1){
                            swal({
                                //title: "Good job!",
                                text: "El ingrediente se eliminó correctamente!",
                                icon: "success",
                                //button: "Aww yiss!"
                            }).then(value => {
                                switch (value) {
                                    case "go":
                                        location.href = "/ingredients";
                                        break;
                                    default:
                                        location.href = "/ingredients";
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
                        if (response.data === 3){
                            swal({
                                //title: "Good job!",
                                text: "No se puede eliminar el ingrediente. Ingrediente pertenece a un sabor!",
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

function slug(){
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

    document.getElementById("codigo").value = str;
}
// var a = document.getElementById("slug-source").value;
//
// var b = a.toLowerCase().replace(/ /g, '-')
//     .replace(/[^\w-]+/g, '');
//
// document.getElementById("slug-target").value = b;
