function dataent(){
    let url = "/datacheckout";
    axios.get(url).then(response => {
        document.getElementById("ent_mod").value = `${response.data[0].ent_mod}`;
        document.getElementById("ent_fec").value = `${response.data[0].ent_fec}`;
    });
}
dataent();

function checkout_ent(e){
    e.preventDefault();

    let ent_mod=document.getElementById("ent_mod").value;
    let ent_fec=document.getElementById("ent_fec").value;

    datos = new FormData();
    datos.set("ent_mod", ent_mod);
    datos.set("ent_fec", ent_fec);

    axios.post("/updateent", datos)
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
    dataent();
}

function datapago(){
    let url = "/datacheckout";
    axios.get(url).then(response => {
        document.getElementById("pago_tit_001").value = `${response.data[0].pago_tit_001}`;
        document.getElementById("pago_btn_001").value = `${response.data[0].pago_btn_001}`;
        document.getElementById("pago_txt_001").value = `${response.data[0].pago_txt_001}`;
        document.getElementById("pago_tit_002").value = `${response.data[0].pago_tit_002}`;
        document.getElementById("pago_btn_002").value = `${response.data[0].pago_btn_002}`;
        document.getElementById("pago_txt_002").value = `${response.data[0].pago_txt_002}`;
    });
}
datapago();

function checkout_pago(e){
    e.preventDefault();

    let pago_tit_001=document.getElementById("pago_tit_001").value;
    let pago_btn_001=document.getElementById("pago_btn_001").value;
    let pago_txt_001=document.getElementById("pago_txt_001").value;
    let pago_tit_002=document.getElementById("pago_tit_002").value;
    let pago_btn_002=document.getElementById("pago_btn_002").value;
    let pago_txt_002=document.getElementById("pago_txt_002").value;

    datos = new FormData();
    datos.set("pago_tit_001", pago_tit_001);
    datos.set("pago_btn_001", pago_btn_001);
    datos.set("pago_txt_001", pago_txt_001);
    datos.set("pago_tit_002", pago_tit_002);
    datos.set("pago_btn_002", pago_btn_002);
    datos.set("pago_txt_002", pago_txt_002);

    axios.post("/updatepago", datos)
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
    datapago();
}

