var firstflavorimagen = 0;



if(document.getElementById('codigo_sabor')){
    function dataflavor(){

        firstflavorimagen = 0;

        let codigo = document.getElementById('codigo_sabor').value;
        let url = "/dataflavor/"+codigo;

        axios.get(url).then(response => {

            document.getElementById("nombre").value = `${response.data[0].nombre}`;
            document.getElementById("codigo").value = `${response.data[0].codigo}`;
            document.getElementById("descripcion_web").value = `${response.data[0].descripcion_web}`;
            document.getElementById("descripcion_web_adic").value = `${response.data[0].descripcion_web_adic}`;

            document.getElementById("subcategory").innerHTML = ``;
            document.getElementById("ingredientes").innerHTML = ``;

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

            let url_imagenflavor = "/dataimagenflavor/"+response.data[0].codigo;

            axios.get(url_imagenflavor).then(res => {
                let array = res.data;
                for (let i=0; i < array.length; i++) {

                    if(array[i].orden === 1){
                        firstflavorimagen = 1;
                        document.getElementById("imagen1").innerHTML = `<a href="${array[i].ruta}" data-toggle="lightbox" data-title="imagen 1" data-gallery="gallery">
                                                                    <img src="${array[i].ruta}" class="img-fluid mb-2" alt="imagen 1"/>
                                                                </a>`;
                    }
                    if(array[i].orden === 2){
                        document.getElementById("imagen2").innerHTML = `<a href="" onclick="deleteflavor(event,${array[i].id})">
                                  <span class="delete-img" style="position: absolute;right: 15px;top: 3px;font-size: 30px;color: #333333;"><i class="nav-icon fas fa-window-close"></i></span>
                                </a><a href="${array[i].ruta}" data-toggle="lightbox" data-title="imagen 2" data-gallery="gallery">
                                                                    <img src="${array[i].ruta}" class="img-fluid mb-2" alt="imagen 2"/>
                                                                </a>`;
                    }
                    if(array[i].orden === 3){
                        document.getElementById("imagen3").innerHTML = `<a href="" onclick="deleteflavor(event,${array[i].id})">
                                  <span class="delete-img" style="position: absolute;right: 15px;top: 3px;font-size: 30px;color: #333333;"><i class="nav-icon fas fa-window-close"></i></span>
                                </a><a href="${array[i].ruta}" data-toggle="lightbox" data-title="imagen 3" data-gallery="gallery">
                                                                    <img src="${array[i].ruta}" class="img-fluid mb-2" alt="imagen 3"/>
                                                                </a>`;
                    }
                    if(array[i].orden === 4){
                        document.getElementById("imagen4").innerHTML = `<a href="" onclick="deleteflavor(event,${array[i].id})">
                                  <span class="delete-img" style="position: absolute;right: 15px;top: 3px;font-size: 30px;color: #333333;"><i class="nav-icon fas fa-window-close"></i></span>
                                </a><a href="${array[i].ruta}" data-toggle="lightbox" data-title="imagen 4" data-gallery="gallery">
                                                                    <img src="${array[i].ruta}" class="img-fluid mb-2" alt="imagen 4"/>
                                                                </a>`;
                    }
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

                    document.getElementById("ingredientes").innerHTML += `<option ${selected} value="${array[i].id}">${array[i].nombre}</option>`;
                    selected = "";
                }

            });



        });


    }

    dataflavor();

    function flavor_update(e){
        e.preventDefault();

        swal({
            //title: "Are you sure?",
            text: "Desea actualizar el sabor?",
            icon: "warning",
            buttons: { go: "¡Sí!", cancel: "No!" }
        }).then(value => {
            switch (value) {
                case "go": {
                    let codigo_antiguo = document.getElementById('codigo_sabor').value;
                    let nombre = document.getElementById("nombre").value;
                    let codigo = document.getElementById("codigo").value;
                    let status = document.getElementById("status").value;
                    let descripcion_web = document.getElementById("descripcion_web").value;
                    let descripcion_web_adic = document.getElementById("descripcion_web_adic").value;
                    let subcategory = document.getElementById("subcategory").value;

                    let file1 = document.getElementById("file1").files;
                    let file2 = document.getElementById("file2").files;
                    let file3 = document.getElementById("file3").files;
                    let file4 = document.getElementById("file4").files;

                    let ingredientes = $("#ingredientes").val();

                    //console.log(JSON.stringify(ingredientes))
                    //console.log(file1.length);

                    if(nombre.length<=0){
                        swal({
                            //title: "Are you sure?",
                            text: "Debe ingresar un nombre. ",
                            icon: "error",
                        });
                    }
                    else{

                        if (file1.length === 0 && firstflavorimagen===0) {
                            swal({
                                //title: "Are you sure?",
                                text: "Debe elegir al menos la primera imagen. ",
                                icon: "error",
                            })
                        }
                        else{
                            datos = new FormData();
                            datos.set("codigo_antiguo", codigo_antiguo);
                            datos.set("nombre", nombre);
                            datos.set("codigo", codigo);
                            datos.set("status", status);
                            datos.set("descripcion_web", descripcion_web);
                            datos.set("descripcion_web_adic", descripcion_web_adic);
                            datos.set("subcategory", subcategory);

                            datos.set("file1", file1[0]);
                            datos.set("file2", file2[0]);
                            datos.set("file3", file3[0]);
                            datos.set("file4", file4[0]);

                            datos.set("ingredientes", ingredientes);

                            let url = '/updateflavor/' + codigo_antiguo;

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
                                                    location.href = "/flavor/edit/"+codigo;
                                                    break;
                                                default:
                                                    location.href = "/flavor/edit/"+codigo;
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
                                    //console.log(response.data);
                                    document.getElementById('codigo_sabor').value = codigo;
                                    dataflavor();
                                });
                            }
                        }
                    }
                default:
                    break;
            }
        });

    }

    function deleteflavor(e,id){
        e.preventDefault();

        swal({
            //title: "Are you sure?",
            text: "¿Desea eliminar la imagen?",
            icon: "warning",
            buttons: { go: "¡Sí!", cancel: "No!" }
        }).then(value => {
            let codigo = document.getElementById('codigo_sabor').value;
            let url_deleteflavor = "/deleteimagenflavor/"+id;
            axios.get(url_deleteflavor).then(resp => {
                if (resp.data === 1) {
                    swal({
                        //title: "Good job!",
                        text: "La imagen se eliminó correctamente!",
                        icon: "success",
                        //button: "Aww yiss!"

                    }).then(value => {
                        switch (value) {
                            case "go":
                                location.href = "/flavor/edit/"+codigo;
                                break;
                            default:
                                location.href = "/flavor/edit/"+codigo;
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
    function flavor_create(e){
        e.preventDefault();

        swal({
            //title: "Are you sure?",
            text: "Desea crear el sabor?",
            icon: "warning",
            buttons: { go: "¡Sí!", cancel: "No!" }
        }).then(value => {
            switch (value) {
                case "go": {
                    let nombre = document.getElementById("nombre").value;
                    let codigo = document.getElementById("codigo").value;
                    let status = document.getElementById("status").value;
                    let descripcion_web = document.getElementById("descripcion_web").value;
                    let descripcion_web_adic = document.getElementById("descripcion_web_adic").value;
                    let subcategory = document.getElementById("subcategory").value;

                    let file1 = document.getElementById("file1").files;
                    let file2 = document.getElementById("file2").files;
                    let file3 = document.getElementById("file3").files;
                    let file4 = document.getElementById("file4").files;

                    let ingredientes = $("#ingredientes").val();

                    if(nombre.length<=0){
                        swal({
                            //title: "Are you sure?",
                            text: "Debe ingresar un nombre. ",
                            icon: "error",
                        });
                    }
                    else{

                        if (file1.length === 0) {
                            swal({
                                //title: "Are you sure?",
                                text: "Debe elegir al menos la primera imagen. ",
                                icon: "error",
                            })
                        }
                        else{
                            datos = new FormData();
                            datos.set("nombre", nombre);
                            datos.set("codigo", codigo);
                            datos.set("status", status);
                            datos.set("descripcion_web", descripcion_web);
                            datos.set("descripcion_web_adic", descripcion_web_adic);
                            datos.set("subcategory", subcategory);

                            datos.set("file1", file1[0]);
                            datos.set("file2", file2[0]);
                            datos.set("file3", file3[0]);
                            datos.set("file4", file4[0]);

                            datos.set("ingredientes", ingredientes);

                            let url = '/createflavor';

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
                                                    location.href = "/flavor/edit/"+codigo;
                                                    break;
                                                default:
                                                    location.href = "/flavor/edit/"+codigo;
                                            }
                                        });

                                    } else {
                                        swal({
                                            //title: "Good job!",
                                            text: "No se creó el sabor correctamente!",
                                            icon: "error",
                                            //button: "Aww yiss!"
                                        });
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


    function ingredients(){
        let url_allingredients = "/allingredients";
        axios.get(url_allingredients).then(resp => {
            let ingredients = resp.data;
            Object.values(ingredients).forEach(function(ingredient) {
                document.getElementById("ingredientes").innerHTML += `<option value="${ingredient.id}">${ingredient.nombre}</option>`;
            });

        });
    }

    ingredients();

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
}

function flavor_delete(e,codigo){
    e.preventDefault();
    swal({
        //title: "Are you sure?",
        text: "Desea eliminar el sabor?",
        icon: "warning",
        buttons: { go: "¡Sí!", cancel: "No!" }
    }).then(value => {
        switch (value) {
            case "go": {
                // datos = new FormData();
                // datos.set("nombre", nombre);

                let url = '/deleteflavor/'+codigo;

                axios.get(url)
                    .then(response => {
                        if (response.data === 1){
                            swal({
                                //title: "Good job!",
                                text: "El sabor se eliminó correctamente!",
                                icon: "success",
                                //button: "Aww yiss!"
                            }).then(value => {
                                switch (value) {
                                    case "go":
                                        location.href = "/flavors";
                                        break;
                                    default:
                                        location.href = "/flavors";
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
                        if (response.data === 3){
                            swal({
                                //title: "Good job!",
                                text: "No se puede eliminar. El sabor pertenece a un Baegel!",
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


