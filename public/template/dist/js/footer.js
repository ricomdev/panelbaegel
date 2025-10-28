
//document.getElementById("txt_001_he1").value = 'NNNNN';

function datacontacto(){
    let url = "/datafooter";
    axios.get(url).then(response => {
        document.getElementById("tit_horario").value = `${response.data[0].tit_horario}`;
        document.getElementById("info_horario").value = `${response.data[0].info_horario}`;
        document.getElementById("tit_contactanos").value = `${response.data[0].tit_contactanos}`;
        document.getElementById("txt_contactanos").value = `${response.data[0].txt_contactanos}`;
    });
}
datacontacto();

function footer_contacto(e){
    e.preventDefault();

    let tit_horario=document.getElementById("tit_horario").value;
    let info_horario=document.getElementById("info_horario").value;
    let tit_contactanos=document.getElementById("tit_contactanos").value;
    let txt_contactanos=document.getElementById("txt_contactanos").value;

    datos = new FormData();
    datos.set("tit_horario", tit_horario);
    datos.set("info_horario", info_horario);
    datos.set("tit_contactanos", tit_contactanos);
    datos.set("txt_contactanos", txt_contactanos);

    axios.post("/updatecontacto", datos)
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
            });

    datacontacto();
}

function dataredes(){
    let url = "/datafooter";
    axios.get(url).then(response => {
        document.getElementById("txt_redes").value = `${response.data[0].txt_redes}`;
        document.getElementById("fb_url").value = `${response.data[0].fb_url}`;
        document.getElementById("ig_url").value = `${response.data[0].ig_url}`;
    });
}
dataredes();

function footer_redes(e){
    e.preventDefault();

    let txt_redes=document.getElementById("txt_redes").value;
    let fb_url=document.getElementById("fb_url").value;
    let ig_url=document.getElementById("ig_url").value;

    datos = new FormData();
    datos.set("txt_redes", txt_redes);
    datos.set("fb_url", fb_url);
    datos.set("ig_url", ig_url);

    axios.post("/updateredes", datos)
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
        });

    dataredes();
}

function datanovedades(){
    let url = "/datafooter";
    axios.get(url).then(response => {
        document.getElementById("tit_novedades").value = `${response.data[0].tit_novedades}`;
        document.getElementById("txt_novedades").value = `${response.data[0].txt_novedades}`;
    });
}
datanovedades();

function footer_novedades(e){
    e.preventDefault();

    let tit_novedades=document.getElementById("tit_novedades").value;
    let txt_novedades=document.getElementById("txt_novedades").value;

    datos = new FormData();
    datos.set("tit_novedades", tit_novedades);
    datos.set("txt_novedades", txt_novedades);

    axios.post("/updatenovedades", datos)
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
        });

    datanovedades();
}

