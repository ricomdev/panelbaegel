function dataqso(){
    let url = "/dataqso";
    axios.get(url).then(response => {
        document.getElementById("qso_tit").value = `${response.data[0].qso_tit}`;
        document.getElementById("qso_sub_tit").value = `${response.data[0].qso_sub_tit}`;
        document.getElementById("qso_txt").value = `${response.data[0].qso_txt}`;
    });
}
dataqso();

function about_qso(e){
    e.preventDefault();

    let qso_tit=document.getElementById("qso_tit").value;
    let qso_sub_tit=document.getElementById("qso_sub_tit").value;
    let qso_txt=document.getElementById("qso_txt").value;

    datos = new FormData();
    datos.set("qso_tit", qso_tit);
    datos.set("qso_sub_tit", qso_sub_tit);
    datos.set("qso_txt", qso_txt);

    axios.post("/updateqso", datos)
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
    dataqso();
}

function dataconocenos(){
    let url = "/dataqso";
    axios.get(url).then(response => {
        document.getElementById("conocenos_tit").value = `${response.data[0].conocenos_tit}`;
        document.getElementById("conocenos_sub_tit1").value = `${response.data[0].conocenos_sub_tit1}`;
        document.getElementById("conocenos_sub_tit2").value = `${response.data[0].conocenos_sub_tit2}`;
        document.getElementById("conocenos_txt_1").value = `${response.data[0].conocenos_txt_1}`;
        document.getElementById("conocenos_txt_2").value = `${response.data[0].conocenos_txt_2}`;
    });
}
dataconocenos();

function about_conocenos(e){
    e.preventDefault();

    let conocenos_tit=document.getElementById("conocenos_tit").value;
    let conocenos_sub_tit1=document.getElementById("conocenos_sub_tit1").value;
    let conocenos_sub_tit2=document.getElementById("conocenos_sub_tit2").value;
    let conocenos_txt_1=document.getElementById("conocenos_txt_1").value;
    let conocenos_txt_2=document.getElementById("conocenos_txt_2").value;

    let file1 = document.getElementById("file1").files;
    let file2 = document.getElementById("file2").files;

    datos = new FormData();
    datos.set("conocenos_tit", conocenos_tit);
    datos.set("conocenos_sub_tit1", conocenos_sub_tit1);
    datos.set("conocenos_sub_tit2", conocenos_sub_tit2);
    datos.set("conocenos_txt_1", conocenos_txt_1);
    datos.set("conocenos_txt_2", conocenos_txt_2);
    datos.set("file1", file1[0]);
    datos.set("file2", file2[0]);

    axios.post("/updateconocenos", datos)
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
    dataconocenos();
}

function dataprod(){
    let url = "/dataqso";
    axios.get(url).then(response => {
        document.getElementById("productos_tit").value = `${response.data[0].productos_tit}`;
        document.getElementById("productos_btn").value = `${response.data[0].productos_btn}`;
    });
}
dataprod();

function about_prod(e){
    e.preventDefault();

    let productos_tit=document.getElementById("productos_tit").value;
    let productos_btn=document.getElementById("productos_btn").value;

    datos = new FormData();
    datos.set("productos_tit", productos_tit);
    datos.set("productos_btn", productos_btn);

    axios.post("/updateprod", datos)
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
    dataprod();
}
