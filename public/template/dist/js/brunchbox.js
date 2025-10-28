// ==========================
// Configurar CSRF para Axios
// ==========================
axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// ==========================
// Cargar datos del producto BRUNCH BOX
// ==========================
let pendingFiles = []; // 🔥 Acumula imágenes nuevas

if (document.getElementById('code_product')) {
    function dataproduct() {
        const codigo = document.getElementById('code_product').value;

        axios.get("/dataproduct/brunch/" + codigo).then(response => {
                    
            const data = response.data;

            // ====== Campos básicos ======
            document.getElementById("subcategory_id").value = data.subcategory_id || "";
            document.getElementById("type").value = data.type || "bb3b1s";
            document.getElementById("code").value = data.code || "";
            document.getElementById("short_name").value = data.short_name || "";
            document.getElementById("name").value = data.name || "";
            document.getElementById("content").value = data.content || "";
            document.getElementById("description").value = data.description || "";
            document.getElementById("description_002").value = data.description_002 || "";
            document.getElementById("price").value = data.price || 0;
            document.getElementById("is_active").checked = data.is_active == 1;
            document.getElementById("qty_bagel").value = data.qty_bagel || 0;
            document.getElementById("qty_spreads").value = data.qty_spreads || 0; 

            // ====== Imágenes ======
            const container = document.getElementById("sortable-images");
            container.innerHTML = "";

            if (data.images && data.images.length > 0) {
                data.images.forEach((img, index) => {
                    const col = document.createElement("div");
                    col.className = "col-sm-3 text-center mb-3 image-item";
                    col.dataset.id = img.id;

                    col.innerHTML = `
                        <div class="card p-2">
                            <div class="position-relative">
                                <img src="${img.path}" class="img-fluid img-thumbnail mb-2" style="max-height:150px;">
                                <span class="badge ${index === 0 ? 'badge-success' : 'badge-secondary'} position-absolute" style="top:5px; left:5px;">
                                    ${index === 0 ? 'PRINCIPAL' : 'SECUNDARIA'}
                                </span>
                            </div>
                            <button type="button" class="btn btn-danger btn-sm mt-2 delete-image" data-id="${img.id}">
                                <i class="fa fa-trash"></i> Eliminar
                            </button>
                        </div>
                    `;
                    container.appendChild(col);
                });

                initSortable();
                initDeleteEvents();
                updateBadges();
            }
        });
    }

    dataproduct();
}

// ==========================
// Inicializar SortableJS
// ==========================
function initSortable() {
    if (typeof Sortable !== "undefined") {
        Sortable.create(document.getElementById("sortable-images"), {
            animation: 150,
            handle: 'img',
            ghostClass: 'bg-light',
            onEnd: updateBadges
        });
    }
}

// ==========================
// Actualizar etiquetas PRINCIPAL/SECUNDARIA
// ==========================
function updateBadges() {
    const items = document.querySelectorAll("#sortable-images .image-item");
    items.forEach((item, index) => {
        const badge = item.querySelector(".badge");
        if (badge) {
            badge.className = "badge position-absolute";
            badge.classList.add(index === 0 ? "badge-success" : "badge-secondary");
            badge.textContent = index === 0 ? "PRINCIPAL" : "SECUNDARIA";
            badge.style.top = "5px";
            badge.style.left = "5px";
        }
    });
}

// ==========================
// Eventos de eliminación
// ==========================
function initDeleteEvents() {
    document.querySelectorAll(".delete-image").forEach(btn => {
        btn.addEventListener("click", function (e) {
            e.preventDefault();

            const totalImages = document.querySelectorAll("#sortable-images .image-item").length;
            if (totalImages <= 1) {
                Swal.fire({
                    icon: 'warning',
                    text: 'Debe existir al menos una imagen. No puedes eliminar la última.'
                });
                return;
            }

            const id = this.getAttribute("data-id");
            Swal.fire({
                text: "¿Seguro que quieres eliminar esta imagen?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar"
            }).then(result => {
                if (result.isConfirmed) {
                    axios.delete(`/product/brunch/image/${id}`)
                        .then(res => {
                            if (res.data.success) {
                                Swal.fire({ icon: "success", text: "Imagen eliminada" });
                                dataproduct();
                            }
                        })
                        .catch(err => {
                            Swal.fire({ icon: "error", text: "Error al eliminar la imagen" });
                            console.error(err);
                        });
                }
            });
        });
    });
}

// ==========================
// Vista previa imágenes NUEVAS
// ==========================
document.getElementById("images").addEventListener("change", function (e) {
    const container = document.getElementById("sortable-images");
    const files = Array.from(e.target.files);

    files.forEach(file => {
        pendingFiles.push(file);

        const reader = new FileReader();
        reader.onload = function (event) {
            const col = document.createElement("div");
            col.className = "col-sm-3 text-center mb-3 image-item";
            col.dataset.id = `new_${pendingFiles.length - 1}`;

            col.innerHTML = `
                <div class="card p-2">
                    <div class="position-relative">
                        <img src="${event.target.result}" class="img-fluid img-thumbnail mb-2" style="max-height:150px;">
                        <span class="badge badge-secondary position-absolute" style="top:5px; left:5px;">SECUNDARIA</span>
                    </div>
                </div>
            `;
            container.appendChild(col);
        };
        reader.readAsDataURL(file);
    });

    e.target.value = "";
    setTimeout(updateBadges, 200);
});

// ==========================
// Guardar cambios
// ==========================
function product_update(e) {
    e.preventDefault();

    const existingImages = document.querySelectorAll('#sortable-images .image-item').length;
    const newImages = pendingFiles.length;
    if (existingImages + newImages === 0) {
        Swal.fire({
            icon: 'warning',
            text: 'Debes subir al menos una imagen antes de actualizar el producto.'
        });
        return;
    }

    Swal.fire({
        text: "Desea actualizar el registro?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí",
        cancelButtonText: "No"
    }).then(result => {
        if (result.isConfirmed) {
            const btn = document.getElementById("btn-save");
            const btnText = btn.querySelector(".btn-text");
            const btnSpinner = btn.querySelector(".btn-spinner");
            btn.disabled = true;
            btnText.textContent = "Guardando cambios...";
            btnSpinner.style.display = "inline-block";

            const codigo_antiguo = document.getElementById('code_product').value;
            let datos = new FormData();
            datos.append("codigo_antiguo", codigo_antiguo);
            datos.append("subcategory_id", document.getElementById("subcategory_id").value);
            datos.append("type", document.getElementById("type").value);
            datos.append("code", document.getElementById("code").value);
            datos.append("short_name", document.getElementById("short_name").value);
            datos.append("name", document.getElementById("name").value);
            datos.append("content", document.getElementById("content").value);
            datos.append("description", document.getElementById("description").value);
            datos.append("description_002", document.getElementById("description_002").value);
            datos.append("price", document.getElementById("price").value);
            datos.append("is_active", document.getElementById("is_active").checked ? 1 : 0);
            datos.append("qty_bagel", document.getElementById("qty_bagel").value);
            datos.append("qty_spreads", document.getElementById("qty_spreads").value);

            document.querySelectorAll('#sortable-images .image-item').forEach((el, index) => {
                datos.append(`order[${el.dataset.id}]`, index);
            });

            pendingFiles.forEach(file => {
                datos.append("images[]", file);
            });

            axios.post('/updateproduct/brunch/' + codigo_antiguo, datos)
                .then(response => {
                    if (response.data === 1) {
                        Swal.fire({
                            text: "Los datos se actualizaron correctamente!",
                            icon: "success"
                        }).then(() => {
                            location.href = "/product/brunch/edit/" + document.getElementById("code").value;
                        });
                        pendingFiles = [];
                    } else {
                        Swal.fire({ text: "No se realizó la actualización correctamente!", icon: "error" });
                    }
                    document.getElementById('code_product').value = document.getElementById("code").value;
                    dataproduct();
                })
                .catch(error => {
                    Swal.fire({ text: "Hubo un error al actualizar el producto", icon: "error" });
                    console.error(error);
                })
                .finally(() => {
                    btn.disabled = false;
                    btnText.innerHTML = "Guardar Cambios";
                    btnSpinner.style.display = "none";
                });
        }
    });
}
