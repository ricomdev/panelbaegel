
if(document.getElementById('codigo_presentation')) {
    function datapresentation() {
        let codigo = document.getElementById('codigo_presentation').value;
        let url = "/datapresentation/" + codigo;

        axios.get(url).then(response => {

            document.getElementById("nombre").value = `${response.data[0].nombre}`;
            document.getElementById("codigo").value = `${response.data[0].codigo}`;

            let url_category = "/datacategorypresentation";
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


            document.getElementById("imagen").innerHTML = `<a href="${response.data[0].ruta}" data-toggle="lightbox" data-title="${response.data[0].nombre}" data-gallery="gallery">
                                                                    <img src="${response.data[0].ruta}" class="img-fluid mb-2" alt="${response.data[0].nombre}"/>
                                                                </a>`;
        });
    }

    datapresentation();
}

function presentation_update(e){
    e.preventDefault();

    swal({
        //title: "Are you sure?",
        text: "Desea actualizar el registro?",
        icon: "warning",
        buttons: { go: "¡Sí!", cancel: "No!" }
    }).then(value => {
        switch (value) {
            case "go": {
                let codigo_antiguo = document.getElementById('codigo_presentation').value;
                let nombre = document.getElementById("nombre").value;
                let file = document.getElementById("file").files;

                datos = new FormData();
                datos.set("codigo_antiguo", codigo_antiguo);
                datos.set("nombre", nombre);
                datos.set("file", file[0]);

                let url = '/updatepresentation/'+codigo_antiguo;

                axios.post(url, datos)
                    .then(response => {
                        if (response.data === 1){
                            swal({
                                //title: "Good job!",
                                text: "Los datos se actualizaron correctamente!",
                                icon: "success",
                                //button: "Aww yiss!"
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
                        document.getElementById('codigo_presentation').value = codigo_antiguo;
                        datapresentation();
                    });
            }
            default:
                break;
        }
    });
}

