
function updatetestimonial(e,id,show){
    e.preventDefault();

    if(show==1){
        Swal.fire({
                text: "¿Desea ocultar el testimonio?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí",
                cancelButtonText: "No"
        }).
        // swal({
        //     //title: "Are you sure?",
        //     text: "Desea ocultar el testimonio?",
        //     icon: "warning",
        //     buttons: { go: "¡Sí!", cancel: "No!" }
        // }).
        then(result => {
                if (result.isConfirmed) {
                    datos = new FormData();
                    datos.set("id", id);
                    datos.set("show", 2);

                    let url = '/updatetestimonial';

                    axios.post(url, datos)
                        .then(response => {
                            location.href = "/testimonials"
                        });
                }
        });
    }
    if(show==2){
        Swal.fire({
                text: "¿Desea mostrar el testimonio?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí",
                cancelButtonText: "No"
        }).
        // swal({
        //     //title: "Are you sure?",
        //     text: "Desea mostrar el testimonio?",
        //     icon: "warning",
        //     buttons: { go: "¡Sí!", cancel: "No!" }
        // }).
        then(result => {
                if (result.isConfirmed) {
                    datos = new FormData();
                    datos.set("id", id);
                    datos.set("show", 1);

                    let url = '/updatetestimonial';

                    axios.post(url, datos)
                        .then(response => {
                            location.href = "/testimonials"
                        });
                }
        });
    }

}

