//var firstflavorimagen = 0;

if(document.getElementById('codigo_baegel')){

    function databaegel(){
        //firstflavorimagen = 0;

        let codigo = document.getElementById('codigo_baegel').value;
        let url = "/databaegel/"+codigo;

        axios.get(url).then(response => {

            document.getElementById("nombre").value = `${response.data[0].nombre}`;
            document.getElementById("codigo").value = `${response.data[0].codigo}`;
            document.getElementById("category").innerHTML = ``;
            document.getElementById("status").innerHTML = ``;
            document.getElementById("current_price").value = `${response.data[0].precio_actual}`;
            document.getElementById("presentation").value = `${response.data[0].presentacion}`;

            let url_flavor = "/allflavors";
            axios.get(url_flavor).then(resp => {
                let array = resp.data;
                for (let i=0; i < array.length; i++) {

                    let selected = "";
                    if(response.data[0].flavor_id === array[i].id){
                        selected = "selected";
                    }
                    document.getElementById("flavors").innerHTML += `<option ${selected} value="${array[i].codigo}">${array[i].nombre}</option>`;
                }

            });

            let url_category = "/datacategorybaegel";
            axios.get(url_category).then(resp => {
                let array = resp.data;
                for (let i=0; i < array.length; i++) {

                    let selected = "";
                    if(response.data[0].category_id === array[i].id){
                        selected = "selected";
                    }
                    document.getElementById("category").innerHTML += `<option ${selected} value="${array[i].codigo}">${array[i].nombre}</option>`;
                }
            });

            let url_statuses = "/datastatus";
            axios.get(url_statuses).then(resp => {
                let array = resp.data;
                for (let i=0; i < array.length; i++) {

                    let selected = "";
                    if(response.data[0].activo === array[i].id){
                        selected = "selected";
                    }
                    document.getElementById("status").innerHTML += `<option ${selected} value="${array[i].id}">${array[i].nombre}</option>`;
                }
            });

            let url = "/dataflavorid/"+response.data[0].flavor_id;
            axios.get(url).then(resp => {

                document.getElementById("descripcion_web").value = `${resp.data[0].descripcion_web}`;
                document.getElementById("descripcion_web_adic").value = `${resp.data[0].descripcion_web_adic}`;

                let url_subcategory = "/datasubcategory";
                axios.get(url_subcategory).then(resp1 => {
                    let array = resp1.data;
                    for (let i=0; i < array.length; i++) {

                        let selected = "";
                        if(resp.data[0].subcategory.codigo === array[i].codigo){
                            selected = "selected";
                        }
                        document.getElementById("subcategory").innerHTML += `<option ${selected} value="${array[i].codigo}">${array[i].nombre}</option>`;
                    }

                });


                let url_allingredients = "/allingredients";
                axios.get(url_allingredients).then(resp2 => {

                    let flavor_ingredient = resp.data[0].ingredient;
                    let array = resp2.data;
                    let selected = "";

                    for (let i=0; i < array.length; i++) {

                        for (let j=0; j < flavor_ingredient.length; j++) {
                            if(array[i].codigo === flavor_ingredient[j].codigo){
                                selected = "selected";
                            }
                        }

                        document.getElementById("ingredients").innerHTML += `<option ${selected} value="${array[i].id}">${array[i].nombre}</option>`;
                        selected = "";
                    }

                });


                let url_imagenflavor = "/dataimagenflavorid/"+response.data[0].flavor_id;
                axios.get(url_imagenflavor).then(res3 => {
                    let array = res3.data;
                    for (let i=0; i < array.length; i++) {

                        if(array[i].orden === 1){
                            document.getElementById("imagen1").innerHTML = `<a href="${array[i].ruta}" data-toggle="lightbox" data-title="imagen 1" data-gallery="gallery">
                                                                        <img src="${array[i].ruta}" class="img-fluid mb-2" alt="imagen 1"/>
                                                                    </a>`;
                        }
                        if(array[i].orden === 2){
                            document.getElementById("imagen2").innerHTML = `<a href="${array[i].ruta}" data-toggle="lightbox" data-title="imagen 2" data-gallery="gallery">
                                                                        <img src="${array[i].ruta}" class="img-fluid mb-2" alt="imagen 2"/>
                                                                    </a>`;
                        }
                        if(array[i].orden === 3){
                            document.getElementById("imagen3").innerHTML = `<a href="${array[i].ruta}" data-toggle="lightbox" data-title="imagen 3" data-gallery="gallery">
                                                                        <img src="${array[i].ruta}" class="img-fluid mb-2" alt="imagen 3"/>
                                                                    </a>`;
                        }
                        if(array[i].orden === 4){
                            document.getElementById("imagen4").innerHTML = `<a href="${array[i].ruta}" data-toggle="lightbox" data-title="imagen 4" data-gallery="gallery">
                                                                        <img src="${array[i].ruta}" class="img-fluid mb-2" alt="imagen 4"/>
                                                                    </a>`;
                        }
                    }

                });

            });

        });


    }

    databaegel();

    function baegel_update(e){
        e.preventDefault();

        swal({
            //title: "Are you sure?",
            text: "Desea actualizar los datos del baegel?",
            icon: "warning",
            buttons: { go: "¡Sí!", cancel: "No!" }
        }).then(value => {
            switch (value) {
                case "go": {
                    let codigo_antiguo = document.getElementById('codigo_baegel').value;
                    let flavor = document.getElementById("flavors").value;
                    let nombre = document.getElementById("nombre").value;
                    let codigo = document.getElementById("codigo").value;
                    let category = document.getElementById("category").value;
                    let status = document.getElementById("status").value;
                    let current_price = document.getElementById("current_price").value;
                    let presentation = document.getElementById("presentation").value;

                    if(codigo.length<=0){
                        swal({
                            //title: "Are you sure?",
                            text: "Debe ingresar un código. ",
                            icon: "error",
                        });
                    }
                    else{
                        if(codigo_antiguo.toUpperCase() === codigo.toUpperCase() ){
                            //console.log('igual');
                            if (flavor == 0) {
                                swal({
                                    //title: "Are you sure?",
                                    text: "Debe elegir un sabor. ",
                                    icon: "error",
                                });
                            }
                            else {
                                if (current_price) {

                                    let isValid = /^(\d+)$|^(\d+\.{1}\d{2})$/;
                                    if (!isValid.test(current_price)) {
                                        swal({
                                            //title: "Are you sure?",
                                            text: "Precio con formato inválido. ",
                                            icon: "error",
                                        });
                                    } else {
                                        datos = new FormData();
                                        datos.set("codigo_antiguo", codigo_antiguo);
                                        datos.set("nombre", nombre);
                                        datos.set("codigo", codigo);
                                        datos.set("flavor", flavor);
                                        datos.set("category", category);
                                        datos.set("status", status);
                                        datos.set("presentation", presentation);
                                        datos.set("current_price", current_price);

                                        //console.log(status);
                                        let url = '/updatebaegel/' + codigo_antiguo;

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
                                                                location.href = "/baegel/edit/" + codigo;
                                                                break;
                                                            default:
                                                                location.href = "/baegel/edit/" + codigo;
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
                                else {
                                    swal({
                                        //title: "Are you sure?",
                                        text: "Debe ingresar el precio del baegel. ",
                                        icon: "error",
                                    })

                                }
                            }
                        }
                        else{
                            //console.log('diferente');
                            let url_checkcodebaegel = "/checkcodebaegel/"+document.getElementById("codigo").value;
                            axios.get(url_checkcodebaegel).then(respuesta => {

                                if (respuesta.data === 1) {
                                    swal({
                                        //title: "Are you sure?",
                                        text: "El código ya existe. ",
                                        icon: "error",
                                    });
                                }
                                else {
                                    if (flavor == 0) {
                                        swal({
                                            //title: "Are you sure?",
                                            text: "Debe elegir un sabor. ",
                                            icon: "error",
                                        });
                                    }
                                    else {
                                        if (current_price) {

                                            let isValid = /^(\d+)$|^(\d+\.{1}\d{2})$/;
                                            if (!isValid.test(current_price)) {
                                                swal({
                                                    //title: "Are you sure?",
                                                    text: "Precio con formato inválido. ",
                                                    icon: "error",
                                                });
                                            } else {
                                                datos = new FormData();
                                                datos.set("codigo_antiguo", codigo_antiguo);
                                                datos.set("nombre", nombre);
                                                datos.set("codigo", codigo);
                                                datos.set("flavor", flavor);
                                                datos.set("category", category);
                                                datos.set("status", status);
                                                datos.set("presentation", presentation);
                                                datos.set("current_price", current_price);

                                                //console.log(status);
                                                let url = '/updatebaegel/' + codigo_antiguo;

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
                                                                        location.href = "/baegel/edit/" + codigo;
                                                                        break;
                                                                    default:
                                                                        location.href = "/baegel/edit/" + codigo;
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
                                        else {
                                            swal({
                                                //title: "Are you sure?",
                                                text: "Debe ingresar el precio del baegel. ",
                                                icon: "error",
                                            })

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

    function flavors(){
        let url_flavors = "/allflavors";
        axios.get(url_flavors).then(resp => {
            let flavors = resp.data;
            Object.values(flavors).forEach(function(flavor) {
                document.getElementById("flavors").innerHTML += `<option value="${flavor.codigo}">${flavor.nombre}</option>`;
            });
        });
    }

    flavors();

    function categories(){
        let url_category = "/datacategorybaegel";
        axios.get(url_category).then(resp => {
            let categories = resp.data;
            Object.values(categories).forEach(function(category) {
                document.getElementById("category").innerHTML += `<option value="${category.codigo}">${category.nombre}</option>`;
            });
        });
    }

    categories();


    function statuses(){
        let url_allstatuses = "/datastatus";
        axios.get(url_allstatuses).then(resp => {
            let statuses = resp.data;
            Object.values(statuses).forEach(function(status) {
                document.getElementById("status").innerHTML += `<option value="${status.id}">${status.nombre}</option>`;
            });

        });
    }

    statuses();

    function baegel_create(e){
        e.preventDefault();

        swal({
            //title: "Are you sure?",
            text: "Desea crear el baegel?",
            icon: "warning",
            buttons: { go: "¡Sí!", cancel: "No!" }
        }).then(value => {
            switch (value) {
                case "go": {
                    let flavor = document.getElementById("flavors").value;
                    let nombre = document.getElementById("nombre").value;
                    let codigo = document.getElementById("codigo").value;
                    let category = document.getElementById("category").value;
                    let status = document.getElementById("status").value;
                    let current_price = document.getElementById("current_price").value;
                    let presentation = document.getElementById("presentation").value;

                    if(codigo.length<=0){
                        swal({
                            //title: "Are you sure?",
                            text: "Debe ingresar un código. ",
                            icon: "error",
                        });
                    }
                    else{
                        let url_checkcodebaegel = "/checkcodebaegel/"+document.getElementById("codigo").value;
                        axios.get(url_checkcodebaegel).then(respuesta => {
                            if(respuesta.data === 1){
                                swal({
                                    //title: "Are you sure?",
                                    text: "El código ya existe. ",
                                    icon: "error",
                                });
                            }
                            else{
                                if (flavor == 0) {
                                    swal({
                                        //title: "Are you sure?",
                                        text: "Debe elegir un sabor. ",
                                        icon: "error",
                                    });
                                }
                                else{

                                    if (current_price) {

                                        let isValid = /^(\d+)$|^(\d+\.{1}\d{2})$/;
                                        if (!isValid.test(current_price)) {
                                            swal({
                                                //title: "Are you sure?",
                                                text: "Precio con formato inválido. ",
                                                icon: "error",
                                            });
                                        } else {
                                            datos = new FormData();
                                            datos.set("codigo", codigo);
                                            datos.set("nombre", nombre);
                                            datos.set("flavor", flavor);
                                            datos.set("category", category);
                                            datos.set("status", status);
                                            datos.set("presentation", presentation);
                                            datos.set("current_price", current_price);

                                            let url = '/createbaegel';

                                            axios.post(url, datos)
                                                .then(response => {
                                                    if (response.data === 1) {
                                                        swal({
                                                            //title: "Good job!",
                                                            text: "Los datos se registraron correctamente!",
                                                            icon: "success",
                                                            //button: "Aww yiss!"

                                                        }).then(value => {
                                                            switch (value) {
                                                                case "go":
                                                                    location.href = "/baegel/edit/"+codigo;
                                                                    break;
                                                                default:
                                                                    location.href = "/baegel/edit/"+codigo;
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
                                    else{
                                        swal({
                                            //title: "Are you sure?",
                                            text: "Debe ingresar el precio del baegel. ",
                                            icon: "error",
                                        })

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

function baegel_delete(e,codigo){
    e.preventDefault();
    swal({
        //title: "Are you sure?",
        text: "Desea eliminar el baegel?",
        icon: "warning",
        buttons: { go: "¡Sí!", cancel: "No!" }
    }).then(value => {
        switch (value) {
            case "go": {
                // datos = new FormData();
                // datos.set("nombre", nombre);

                let url = '/deletebaegel/'+codigo;

                axios.get(url)
                    .then(response => {
                        if (response.data === 1){
                            swal({
                                //title: "Good job!",
                                text: "El baegel se eliminó correctamente!",
                                icon: "success",
                                //button: "Aww yiss!"
                            }).then(value => {
                                switch (value) {
                                    case "go":
                                        location.href = "/baegel";
                                        break;
                                    default:
                                        location.href = "/baegel";
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

function showFlavor(codigo) {

    let codigo_flavor = codigo.options[codigo.selectedIndex].value;

    //document.getElementById("flavor").value = `0`;
    document.getElementById("descripcion_web").value = ``;
    document.getElementById("descripcion_web_adic").value = ``;
    document.getElementById("subcategory").innerHTML = ``;
    document.getElementById("ingredients").innerHTML = ``;
    document.getElementById("current_price").innerHTML = ``;
    document.getElementById("imagen1").innerHTML = ``;
    document.getElementById("imagen2").innerHTML = ``;
    document.getElementById("imagen3").innerHTML = ``;
    document.getElementById("imagen4").innerHTML = ``;

    if(codigo_flavor != 0) {

        let url = "/dataflavor/"+codigo_flavor;

        axios.get(url).then(response => {


            document.getElementById("descripcion_web").value = `${response.data[0].descripcion_web}`;
            document.getElementById("descripcion_web_adic").value = `${response.data[0].descripcion_web_adic}`;

            let url_subcategory = "/datasubcategory";
            axios.get(url_subcategory).then(resp => {
                let array = resp.data;
                for (let i=0; i < array.length; i++) {

                    let selected = "";
                    if(response.data[0].subcategory.codigo === array[i].codigo){
                        selected = "selected";
                    }

                    document.getElementById("subcategory").innerHTML += `<option ${selected} value="${array[i].codigo}">${array[i].nombre}</option>`;
                }

            });


            let url_allingredients = "/allingredients";
            axios.get(url_allingredients).then(resp => {

                let flavor_ingredient = response.data[0].ingredient;
                let array = resp.data;
                let selected = "";

                for (let i=0; i < array.length; i++) {

                    for (let j=0; j < flavor_ingredient.length; j++) {
                        if(array[i].codigo === flavor_ingredient[j].codigo){
                            selected = "selected";
                        }
                    }

                    document.getElementById("ingredients").innerHTML += `<option ${selected} value="${array[i].id}">${array[i].nombre}</option>`;
                    selected = "";
                }

            });


            let url_imagenflavor = "/dataimagenflavor/"+codigo_flavor;

            axios.get(url_imagenflavor).then(res => {
                let array = res.data;
                for (let i=0; i < array.length; i++) {

                    if(array[i].orden === 1){
                        document.getElementById("imagen1").innerHTML = `<a href="${array[i].ruta}" data-toggle="lightbox" data-title="imagen 1" data-gallery="gallery">
                                                                        <img src="${array[i].ruta}" class="img-fluid mb-2" alt="imagen 1"/>
                                                                    </a>`;
                    }
                    if(array[i].orden === 2){
                        document.getElementById("imagen2").innerHTML = `<a href="${array[i].ruta}" data-toggle="lightbox" data-title="imagen 2" data-gallery="gallery">
                                                                        <img src="${array[i].ruta}" class="img-fluid mb-2" alt="imagen 2"/>
                                                                    </a>`;
                    }
                    if(array[i].orden === 3){
                        document.getElementById("imagen3").innerHTML = `<a href="${array[i].ruta}" data-toggle="lightbox" data-title="imagen 3" data-gallery="gallery">
                                                                        <img src="${array[i].ruta}" class="img-fluid mb-2" alt="imagen 3"/>
                                                                    </a>`;
                    }
                    if(array[i].orden === 4){
                        document.getElementById("imagen4").innerHTML = `<a href="${array[i].ruta}" data-toggle="lightbox" data-title="imagen 4" data-gallery="gallery">
                                                                        <img src="${array[i].ruta}" class="img-fluid mb-2" alt="imagen 4"/>
                                                                    </a>`;
                    }
                }

            });

        });
    }{
        document.getElementById("descripcion_web").value = ``;
        document.getElementById("descripcion_web_adic").value = ``;
        document.getElementById("subcategory").innerHTML = ``;
        document.getElementById("ingredients").innerHTML = ``;
        document.getElementById("current_price").innerHTML = ``;
        document.getElementById("imagen1").innerHTML = ``;
        document.getElementById("imagen2").innerHTML = ``;
        document.getElementById("imagen3").innerHTML = ``;
        document.getElementById("imagen4").innerHTML = ``;
    }

}

