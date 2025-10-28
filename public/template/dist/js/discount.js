if (document.getElementById('codigo_discount')) {

    // === MODO EDICIÓN ===
    function datadiscount() {
        let codigo = document.getElementById('codigo_discount').value;
        let url = "/datadiscount/" + codigo;

        axios.get(url).then(response => {
            document.getElementById("codigo").value = response.data[0].codigo;
            document.getElementById("discount").value = response.data[0].discount;

            let url_onlyuser = "/dataonlyuser";
            axios.get(url_onlyuser).then(resp => {
                let array = resp.data;
                for (let i = 0; i < array.length; i++) {
                    let selected = response.data[0].onlyuser_id === array[i].id ? "selected" : "";
                    document.getElementById("onlyuser").innerHTML +=
                        `<option ${selected} value="${array[i].id}">${array[i].nombre}</option>`;
                }
            });
        });
    }

    datadiscount();

    function discount_update(e) {
        e.preventDefault();

        let codigo_antiguo = document.getElementById('codigo_discount').value.trim();
        let codigo = document.getElementById("codigo").value.trim();
        let discount = document.getElementById("discount").value.trim();
        let onlyuser = document.getElementById("onlyuser").value;

        // 1️⃣ Validaciones iniciales
        if (codigo.length <= 0) {
            Swal.fire("", "Debe ingresar un código.", "error");
            return;
        }

        if (!discount) {
            Swal.fire("", "Debe ingresar el porcentaje de descuento.", "error");
            return;
        }

        let isValid = /^(\d+)$|^(\d+\.{1}\d{2})$/;
        if (!isValid.test(discount)) {
            Swal.fire( "","Porcentaje con formato inválido.", "error");
            return;
        }

        if (discount > 100) {
            Swal.fire( "","Porcentaje mayor a 100%.", "error");
            return;
        }

        // 2️⃣ Validar código duplicado si cambió
        if (codigo_antiguo.toUpperCase() !== codigo.toUpperCase()) {
            let url_checkcodediscount = "/checkcodediscount/" + codigo;
            axios.get(url_checkcodediscount).then(respuesta => {
                if (respuesta.data === 1) {
                    Swal.fire( "", "El cupón ya existe.","error");
                } else {
                    confirmarYActualizar(codigo_antiguo, codigo, discount, onlyuser);
                }
            });
        } else {
            confirmarYActualizar(codigo_antiguo, codigo, discount, onlyuser);
        }
    }

    function confirmarYActualizar(codigo_antiguo, codigo, discount, onlyuser) {
        Swal.fire({
            text: "¿Desea actualizar los datos del cupón?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "¡Sí!",
            cancelButtonText: "No!"
        }).then((result) => {
            if (result.isConfirmed) {
                let datos = new FormData();
                datos.set("codigo_antiguo", codigo_antiguo);
                datos.set("codigo", codigo);
                datos.set("discount", discount);
                datos.set("onlyuser", onlyuser);

                let url = '/updatediscount/' + codigo_antiguo;

                axios.post(url, datos).then(response => {
                    if (response.data === 1) {
                        Swal.fire("", "Los datos se actualizaron correctamente!", "success")
                            .then(() => location.href = "/discount/edit/" + codigo);
                    } else {
                        Swal.fire( "", "No se realizó la actualización correctamente!","error");
                    }
                });
            }
        });
    }

} else {

    // === MODO CREACIÓN ===
    function onlyusers() {
        let url_onlyuser = "/dataonlyuser";
        axios.get(url_onlyuser).then(resp => {
            let onlyusers = resp.data;
            Object.values(onlyusers).forEach(function (onlyuser) {
                document.getElementById("onlyuser").innerHTML +=
                    `<option value="${onlyuser.id}">${onlyuser.nombre}</option>`;
            });
        });
    }

    onlyusers();

    function discount_create(e) {
        e.preventDefault();

        let codigo = document.getElementById("codigo").value.trim();
        let discount = document.getElementById("discount").value.trim();
        let onlyuser = document.getElementById("onlyuser").value;

        // 1️⃣ Validaciones antes del Swal
        if (codigo.length <= 0) {
            Swal.fire("", "Debe ingresar un código.", "error");
            return;
        }

        if (!discount) {
            Swal.fire("", "Debe ingresar el porcentaje de descuento.", "error");
            return;
        }

        let isValid = /^(\d+)$|^(\d+\.{1}\d{2})$/;
        if (!isValid.test(discount)) {
            Swal.fire("", "Porcentaje con formato inválido.", "error");
            return;
        }

        if (discount > 100) {
            Swal.fire("", "Porcentaje mayor a 100%.", "error");
            return;
        }

        // 2️⃣ Verificar si el código ya existe
        let url_checkcodediscount = "/checkcodediscount/" + codigo;
        axios.get(url_checkcodediscount).then(respuesta => {
            if (respuesta.data === 1) {
                Swal.fire("", "El cupón ya existe.", "error");
            } else {
                // 3️⃣ Confirmar creación
                Swal.fire({
                    text: "¿Desea crear el cupón?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "¡Sí!",
                    cancelButtonText: "No!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        let datos = new FormData();
                        datos.set("codigo", codigo);
                        datos.set("discount", discount);
                        datos.set("onlyuser", onlyuser);

                        let url = '/creatediscount';
                        axios.post(url, datos)
                            .then(response => {
                                if (response.data === 1) {
                                    Swal.fire("","Los datos se registraron correctamente!",  "success")
                                        .then(() => location.href = "/discount/edit/" + codigo);
                                } else {
                                    Swal.fire( "","No se realizó el registro correctamente!", "error");
                                }
                            });
                    }
                });
            }
        });
    }

    function discount_delete(e, codigo) {
        e.preventDefault();

        Swal.fire({
            text: "¿Desea eliminar el cupón?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "¡Sí!",
            cancelButtonText: "No!"
        }).then((result) => {
            if (result.isConfirmed) {
                let url = '/deletediscount/' + codigo;
                axios.get(url)
                    .then(response => {
                        if (response.data === 1) {
                            Swal.fire( "","El cupón se eliminó correctamente!", "success")
                                .then(() => location.href = "/discounts");
                        } else {
                            Swal.fire( "", "La eliminación no se realizó correctamente!","error");
                        }
                    });
            }
        });
    }
}
