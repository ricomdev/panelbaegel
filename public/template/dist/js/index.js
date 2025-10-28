
//document.getElementById("txt_001_he1").value = 'NNNNN';

function dataindex(){
    let url = "/dataindex";
    axios.get(url).then(response => {
        document.getElementById("txt_001_he1").value = `${response.data[0].txt_001_he1}`;
        document.getElementById("txt_002_he1").value = `${response.data[0].txt_002_he1}`;
        document.getElementById("btn_he1").value = `${response.data[0].btn_he1}`;
        document.getElementById("url_he1").value = `${response.data[0].url_he1}`;
        //document.getElementById("ruta_he1").value = `${response.data[0].ruta_he1}`;
        document.getElementById("txt_001_he2").value = `${response.data[0].txt_001_he2}`;
        document.getElementById("txt_002_he2").value = `${response.data[0].txt_002_he2}`;
        document.getElementById("btn_he2").value = `${response.data[0].btn_he2}`;
        document.getElementById("url_he2").value = `${response.data[0].url_he2}`;
        //document.getElementById("ruta_he2").value = `${response.data[0].ruta_he2}`;
        document.getElementById("txt_001_he3").value = `${response.data[0].txt_001_he3}`;
        document.getElementById("txt_002_he3").value = `${response.data[0].txt_002_he3}`;
        document.getElementById("btn_he3").value = `${response.data[0].btn_he3}`;
        document.getElementById("url_he3").value = `${response.data[0].url_he3}`;
        //document.getElementById("ruta_he3").value = `${response.data[0].ruta_he3}`;
    });
}
dataindex();

function index_header(e){
    e.preventDefault();

    let filehe1 = document.getElementById("filehe1").files;
    let filehe2 = document.getElementById("filehe2").files;
    let filehe3 = document.getElementById("filehe3").files;

    let txt_001_he1=document.getElementById("txt_001_he1").value;
    let txt_002_he1=document.getElementById("txt_002_he1").value;
    let btn_he1=document.getElementById("btn_he1").value;
    let url_he1=document.getElementById("url_he1").value;
    let txt_001_he2=document.getElementById("txt_001_he2").value;
    let txt_002_he2=document.getElementById("txt_002_he2").value;
    let btn_he2=document.getElementById("btn_he2").value;
    let url_he2=document.getElementById("url_he2").value;
    let txt_001_he3=document.getElementById("txt_001_he3").value;
    let txt_002_he3=document.getElementById("txt_002_he3").value;
    let btn_he3=document.getElementById("btn_he3").value;
    let url_he3=document.getElementById("url_he3").value;

    datos = new FormData();
    datos.set("txt_001_he1", txt_001_he1);
    datos.set("txt_002_he1", txt_002_he1);
    datos.set("btn_he1", btn_he1);
    datos.set("url_he1", url_he1);
    datos.set("txt_001_he2", txt_001_he2);
    datos.set("txt_002_he2", txt_002_he2);
    datos.set("btn_he2", btn_he2);
    datos.set("url_he2", url_he2);
    datos.set("txt_001_he3", txt_001_he3);
    datos.set("txt_002_he3", txt_002_he3);
    datos.set("btn_he3", btn_he3);
    datos.set("url_he3", url_he3);

    datos.set("filehe1", filehe1[0]);
    datos.set("filehe2", filehe2[0]);
    datos.set("filehe3", filehe3[0]);

    axios.post("/updateindex", datos)
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

    dataindex();
}

function dataqso(){
    let url = "/dataindex";
    axios.get(url).then(response => {
        document.getElementById("qso_tit").value = `${response.data[0].qso_tit}`;
        document.getElementById("qso_sub_tit").value = `${response.data[0].qso_sub_tit}`;
        document.getElementById("qso_txt").value = `${response.data[0].qso_txt}`;
    });
}
dataqso();

function index_qso(e){
    e.preventDefault();

    let qso_tit=document.getElementById("qso_tit").value;
    let qso_sub_tit=document.getElementById("qso_sub_tit").value;
    let qso_txt=document.getElementById("qso_txt").value;

    datos = new FormData();
    datos.set("qso_tit", qso_tit);
    datos.set("qso_sub_tit", qso_sub_tit);
    datos.set("qso_txt", qso_txt);

    axios.post("/updateindexqso", datos)
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

function datatop(){
    let url = "/dataindex";
    axios.get(url).then(response => {
        document.getElementById("top_tit").value = `${response.data[0].top_tit}`;
        document.getElementById("top_sub_tit").value = `${response.data[0].top_sub_tit}`;
        document.getElementById("top_flavor_001").value = `${response.data[0].top_flavor_001}`;
        document.getElementById("top_flavor_002").value = `${response.data[0].top_flavor_002}`;
        document.getElementById("top_flavor_003").value = `${response.data[0].top_flavor_003}`;
    });
}
datatop();

function index_top(e){
    e.preventDefault();

    let top_tit=document.getElementById("top_tit").value;
    let top_sub_tit=document.getElementById("top_sub_tit").value;
    let top_flavor_001=document.getElementById("top_flavor_001").value;
    let top_flavor_002=document.getElementById("top_flavor_002").value;
    let top_flavor_003=document.getElementById("top_flavor_003").value;

    datos = new FormData();
    datos.set("top_tit", top_tit);
    datos.set("top_sub_tit", top_sub_tit);
    datos.set("top_flavor_001", top_flavor_001);
    datos.set("top_flavor_002", top_flavor_002);
    datos.set("top_flavor_003", top_flavor_003);

    axios.post("/updatetop", datos)
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

    datatop();
}

function datanov(){
    let url = "/datanov";
    axios.get(url).then(response => {
        document.getElementById("nov_tit").value = `${response.data[0].nov_tit}`;
        document.getElementById("nov_sub_tit").value = `${response.data[0].nov_sub_tit}`;
        document.getElementById("nov_btn").value = `${response.data[0].nov_btn}`;
        document.getElementById("nov_ruta").value = `${response.data[0].nov_ruta}`;
    });
}
datanov();

function index_nov(e){
    e.preventDefault();

    let filenov1 = document.getElementById("filenov1").files;

    let nov_tit=document.getElementById("nov_tit").value;
    let nov_sub_tit=document.getElementById("nov_sub_tit").value;
    let nov_btn=document.getElementById("nov_btn").value;

    datos = new FormData();
    datos.set("nov_tit", nov_tit);
    datos.set("nov_sub_tit", nov_sub_tit);
    datos.set("nov_btn", nov_btn);

    datos.set("filenov1", filenov1[0]);

    axios.post("/updatenov", datos)
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

    datanov();
}

function datasabores(){
    let url = "/dataindex";
    axios.get(url).then(response => {
        document.getElementById("qso_tit").value = `${response.data[0].qso_tit}`;
        document.getElementById("qso_sub_tit").value = `${response.data[0].qso_sub_tit}`;
        document.getElementById("qso_txt").value = `${response.data[0].qso_txt}`;
    });
}
datasabores();

function index_sabores(e){
    e.preventDefault();

    let sabores_tit=document.getElementById("sabores_tit").value;
    let sabores_sub_tit=document.getElementById("sabores_sub_tit").value;
    let sabores_btn=document.getElementById("sabores_btn").value;

    datos = new FormData();
    datos.set("sabores_tit", sabores_tit);
    datos.set("sabores_sub_tit", sabores_sub_tit);
    datos.set("sabores_btn", sabores_btn);

    axios.post("/updatesabores", datos)
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

    datasabores();
}

function dataig(){
    let url = "/dataindex";
    axios.get(url).then(response => {
        document.getElementById("ig_tit").value = `${response.data[0].ig_tit}`;
        document.getElementById("ig_sub_tit").value = `${response.data[0].ig_sub_tit}`;
        document.getElementById("ig_btn").value = `${response.data[0].ig_btn}`;
        document.getElementById("ig_url").value = `${response.data[0].ig_url}`;
    });
}
dataindex();

function index_ig(e){
    e.preventDefault();

    let fileig1 = document.getElementById("fileig1").files;
    let fileig2 = document.getElementById("fileig2").files;
    let fileig3 = document.getElementById("fileig3").files;
    let fileig4 = document.getElementById("fileig4").files;
    let fileig5 = document.getElementById("fileig5").files;
    let fileig6 = document.getElementById("fileig6").files;

    let ig_tit=document.getElementById("ig_tit").value;
    let ig_sub_tit=document.getElementById("ig_sub_tit").value;
    let ig_btn=document.getElementById("ig_btn").value;
    let ig_url=document.getElementById("ig_url").value;

    datos = new FormData();
    datos.set("ig_tit", ig_tit);
    datos.set("ig_sub_tit", ig_sub_tit);
    datos.set("ig_btn", ig_btn);
    datos.set("ig_url", ig_url);

    datos.set("fileig1", fileig1[0]);
    datos.set("fileig2", fileig2[0]);
    datos.set("fileig3", fileig3[0]);
    datos.set("fileig4", fileig4[0]);
    datos.set("fileig5", fileig5[0]);
    datos.set("fileig6", fileig6[0]);

    axios.post("/updateig", datos)
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

    dataindex();
}
