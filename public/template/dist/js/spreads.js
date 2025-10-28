var firstproductimagen = 0;

if(document.getElementById('codigo_spreads')){

    function dataspreads(){
        firstproductimagen = 0;

        let codigo = document.getElementById('codigo_spreads').value;
        let url = "/dataspreads/"+codigo;

        axios.get(url).then(response => {

            document.getElementById("codigo").value = `${response.data[0].codigo}`;
            document.getElementById("nombre").value = `${response.data[0].nombre}`;
            document.getElementById("category").innerHTML = ``;
            document.getElementById("status").innerHTML = ``;
            document.getElementById("current_price").value = `${response.data[0].precio_actual}`;
            document.getElementById("presentation").value = `${response.data[0].presentacion}`;
            document.getElementById("descripcion_web").value = `${response.data[0].descripcion_corta}`;
            document.getElementById("descripcion_web_adic").value = `${response.data[0].descripcion_larga}`;


            let url_category = "/datacategoryspreads";
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

            let url_subcategory = "/datasubcategory";
            axios.get(url_subcategory).then(resp => {
                let array = resp.data;
                for (let i=0; i < array.length; i++) {

                    let selected = "";
                    if(response.data[0].subcategory_id === array[i].id){
                        selected = "selected";
                    }

                    document.getElementById("subcategory").innerHTML += `<option ${selected} value="${array[i].codigo}">${array[i].nombre}</option>`;
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

            let url_imagenflavor = "/dataimagenproduct/"+response.data[0].codigo;

            axios.get(url_imagenflavor).then(res => {
                let array = res.data;
                for (let i=0; i < array.length; i++) {

                    if(array[i].orden === 1){
                        firstproductimagen = 1;
                        document.getElementById("imagen1").innerHTML = `<a href="${array[i].ruta}" data-toggle="lightbox" data-title="imagen 1" data-gallery="gallery">
                                                                    <img src="${array[i].ruta}" class="img-fluid mb-2" alt="imagen 1"/>
                                                                </a>`;
                    }
                    if(array[i].orden === 2){
                        document.getElementById("imagen2").innerHTML = `<a href="" onclick="deleteimagenproduct(event,${array[i].id})">
                                  <span class="delete-img" style="position: absolute;right: 15px;top: 3px;font-size: 30px;color: #333333;"><i class="nav-icon fas fa-window-close"></i></span>
                                </a><a href="${array[i].ruta}" data-toggle="lightbox" data-title="imagen 2" data-gallery="gallery">
                                                                    <img src="${array[i].ruta}" class="img-fluid mb-2" alt="imagen 2"/>
                                                                </a>`;
                    }
                    if(array[i].orden === 3){
                        document.getElementById("imagen3").innerHTML = `<a href="" onclick="deleteimagenproduct(event,${array[i].id})">
                                  <span class="delete-img" style="position: absolute;right: 15px;top: 3px;font-size: 30px;color: #333333;"><i class="nav-icon fas fa-window-close"></i></span>
                                </a><a href="${array[i].ruta}" data-toggle="lightbox" data-title="imagen 3" data-gallery="gallery">
                                                                    <img src="${array[i].ruta}" class="img-fluid mb-2" alt="imagen 3"/>
                                                                </a>`;
                    }
                    if(array[i].orden === 4){
                        document.getElementById("imagen4").innerHTML = `<a href="" onclick="deleteimagenproduct(event,${array[i].id})">
                                  <span class="delete-img" style="position: absolute;right: 15px;top: 3px;font-size: 30px;color: #333333;"><i class="nav-icon fas fa-window-close"></i></span>
                                </a><a href="${array[i].ruta}" data-toggle="lightbox" data-title="imagen 4" data-gallery="gallery">
                                                                    <img src="${array[i].ruta}" class="img-fluid mb-2" alt="imagen 4"/>
                                                                </a>`;
                    }
                }

            });


        });

    }

    dataspreads();

    function spreads_update(e){
        e.preventDefault();

        swal({
            //title: "Are you sure?",
            text: "Desea actualizar los datos del spreads?",
            icon: "warning",
            buttons: { go: "¡Sí!", cancel: "No!" }
        }).then(value => {
            switch (value) {
                case "go": {
                    let codigo_antiguo = document.getElementById('codigo_spreads').value;
                    let codigo = document.getElementById("codigo").value;
                    let nombre = document.getElementById("nombre").value;
                    let category = document.getElementById("category").value;
                    let subcategory = document.getElementById("subcategory").value;
                    let status = document.getElementById("status").value;
                    let current_price = document.getElementById("current_price").value;
                    let presentation = document.getElementById("presentation").value;
                    let descripcion_corta = document.getElementById("descripcion_web").value;
                    let descripcion_larga = document.getElementById("descripcion_web_adic").value;

                    let file1 = document.getElementById("file1").files;
                    let file2 = document.getElementById("file2").files;
                    let file3 = document.getElementById("file3").files;
                    let file4 = document.getElementById("file4").files;

                    if(codigo.length<=0){
                        swal({
                            //title: "Are you sure?",
                            text: "Debe ingresar un código. ",
                            icon: "error",
                        });
                    }
                    else{
                        if(file1.length === 0 && firstproductimagen===0){
                            swal({
                                //title: "Are you sure?",
                                text: "Debe elegir al menos la primera imagen. ",
                                icon: "error",
                            })
                        }
                        else{
                            if(codigo_antiguo.toUpperCase() === codigo.toUpperCase() ){

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
                                        datos.set("codigo", codigo);
                                        datos.set("nombre", nombre);
                                        datos.set("category", category);
                                        datos.set("subcategory", subcategory);
                                        datos.set("status", status);
                                        datos.set("presentation", presentation);
                                        datos.set("current_price", current_price);
                                        datos.set("descripcion_corta", descripcion_corta);
                                        datos.set("descripcion_larga", descripcion_larga);

                                        datos.set("file1", file1[0]);
                                        datos.set("file2", file2[0]);
                                        datos.set("file3", file3[0]);
                                        datos.set("file4", file4[0]);

                                        let url = '/updatespreads/' + codigo_antiguo;

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
                                                                location.href = "/spreads/edit/" + codigo;
                                                                break;
                                                            default:
                                                                location.href = "/spreads/edit/" + codigo;
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
                                        text: "Debe ingresar el precio del spreads. ",
                                        icon: "error",
                                    })

                                }
                            }
                            else{

                                let url_checkcodespreads = "/checkcodespreads/"+document.getElementById("codigo").value;
                                axios.get(url_checkcodespreads).then(respuesta => {

                                    if (respuesta.data === 1) {
                                        swal({
                                            //title: "Are you sure?",
                                            text: "El código ya existe. ",
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
                                                datos.set("codigo", codigo);
                                                datos.set("nombre", nombre);
                                                datos.set("category", category);
                                                datos.set("subcategory", subcategory);
                                                datos.set("status", status);
                                                datos.set("presentation", presentation);
                                                datos.set("current_price", current_price);
                                                datos.set("descripcion_corta", descripcion_corta);
                                                datos.set("descripcion_larga", descripcion_larga);

                                                datos.set("file1", file1[0]);
                                                datos.set("file2", file2[0]);
                                                datos.set("file3", file3[0]);
                                                datos.set("file4", file4[0]);

                                                let url = '/updatespreads/' + codigo_antiguo;

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
                                                                        location.href = "/spreads/edit/" + codigo;
                                                                        break;
                                                                    default:
                                                                        location.href = "/spreads/edit/" + codigo;
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
                                                text: "Debe ingresar el precio del spreads. ",
                                                icon: "error",
                                            })

                                        }
                                    }

                                });
                            }

                        }
                    }

                }
                default:
                    break;
            }
        });

    }

    function deleteimagenproduct(e,id){
        e.preventDefault();
        swal({
            //title: "Are you sure?",
            text: "¿Desea eliminar la imagen?",
            icon: "warning",
            buttons: { go: "¡Sí!", cancel: "No!" }
        }).then(value => {
            let codigo = document.getElementById('codigo_spreads').value;
            let url_deleteimagenproduct = "/deleteimagenproduct/"+id;
            axios.get(url_deleteimagenproduct).then(resp => {
                if (resp.data === 1) {
                    swal({
                        //title: "Good job!",
                        text: "La imagen se eliminó correctamente!",
                        icon: "success",
                        //button: "Aww yiss!"

                    }).then(value => {
                        switch (value) {
                            case "go":
                                location.href = "/spreads/edit/"+codigo;
                                break;
                            default:
                                location.href = "/spreads/edit/"+codigo;
                        }
                    });

                } else {
                    swal({
                        //title: "Good job!",
                        text: "No se eliminó la imagen correctamente!",
                        icon: "error",
                        //button: "Aww yiss!"
                    });
                }
            });
        });
    }

}
else{

    function categories(){
        let url_category = "/datacategoryspreads";
        axios.get(url_category).then(resp => {
            let categories = resp.data;
            Object.values(categories).forEach(function(category) {
                document.getElementById("category").innerHTML += `<option value="${category.codigo}">${category.nombre}</option>`;
            });
        });
    }

    categories();

    function subcategories(){
        let url_subcategory = "/datasubcategory";
        axios.get(url_subcategory).then(resp => {
            let subcategories = resp.data;
            Object.values(subcategories).forEach(function(subcategory) {
                document.getElementById("subcategory").innerHTML += `<option value="${subcategory.codigo}">${subcategory.nombre}</option>`;
            });
        });
    }

    subcategories();

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

    function spreads_create(e){
        e.preventDefault();

        swal({
            //title: "Are you sure?",
            text: "Desea crear el spreads?",
            icon: "warning",
            buttons: { go: "¡Sí!", cancel: "No!" }
        }).then(value => {
            switch (value) {
                case "go": {
                    let codigo = document.getElementById("codigo").value;
                    let nombre = document.getElementById("nombre").value;
                    let category = document.getElementById("category").value;
                    let subcategory = document.getElementById("subcategory").value;
                    let status = document.getElementById("status").value;
                    let current_price = document.getElementById("current_price").value;
                    let presentation = document.getElementById("presentation").value;
                    let descripcion_corta = document.getElementById("descripcion_web").value;
                    let descripcion_larga = document.getElementById("descripcion_web_adic").value;

                    let file1 = document.getElementById("file1").files;
                    let file2 = document.getElementById("file2").files;
                    let file3 = document.getElementById("file3").files;
                    let file4 = document.getElementById("file4").files;

                    if(codigo.length<=0){
                        swal({
                            //title: "Are you sure?",
                            text: "Debe ingresar un código. ",
                            icon: "error",
                        });
                    }
                    else{
                        if(file1.length === 0 && firstproductimagen===0){
                            swal({
                                //title: "Are you sure?",
                                text: "Debe elegir al menos la primera imagen. ",
                                icon: "error",
                            })
                        }
                        else{
                            let url_checkcodespreads = "/checkcodespreads/"+document.getElementById("codigo").value;
                            axios.get(url_checkcodespreads).then(respuesta => {

                                if (respuesta.data === 1) {
                                    swal({
                                        //title: "Are you sure?",
                                        text: "El código ya existe. ",
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
                                            datos.set("codigo", codigo);
                                            datos.set("nombre", nombre);
                                            datos.set("category", category);
                                            datos.set("subcategory", subcategory);
                                            datos.set("status", status);
                                            datos.set("presentation", presentation);
                                            datos.set("current_price", current_price);
                                            datos.set("descripcion_corta", descripcion_corta);
                                            datos.set("descripcion_larga", descripcion_larga);

                                            datos.set("file1", file1[0]);
                                            datos.set("file2", file2[0]);
                                            datos.set("file3", file3[0]);
                                            datos.set("file4", file4[0]);

                                            let url = '/createspreads';

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
                                                                    location.href = "/spreads/edit/" + codigo;
                                                                    break;
                                                                default:
                                                                    location.href = "/spreads/edit/" + codigo;
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
                                    else {
                                        swal({
                                            //title: "Are you sure?",
                                            text: "Debe ingresar el precio del spreads. ",
                                            icon: "error",
                                        })

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

function spread_delete(e,codigo){
    e.preventDefault();
    swal({
        //title: "Are you sure?",
        text: "Desea eliminar el spread?",
        icon: "warning",
        buttons: { go: "¡Sí!", cancel: "No!" }
    }).then(value => {
        switch (value) {
            case "go": {
                // datos = new FormData();
                // datos.set("nombre", nombre);

                let url = '/deletespread/'+codigo;

                axios.get(url)
                    .then(response => {
                        if (response.data === 1){
                            swal({
                                //title: "Good job!",
                                text: "El spread se eliminó correctamente!",
                                icon: "success",
                                //button: "Aww yiss!"
                            }).then(value => {
                                switch (value) {
                                    case "go":
                                        location.href = "/spreads";
                                        break;
                                    default:
                                        location.href = "/spreads";
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

