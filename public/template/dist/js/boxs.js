// ==========================
// Configurar CSRF para Axios
// ==========================
axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

let pendingFiles = []; // 🔥 Acumula imágenes nuevas

// ==========================
// Validar si el código ya existe (en tiempo real)
// ==========================
const inputCode = document.getElementById("code");
if (inputCode) {
    inputCode.addEventListener("blur", function () {
        const code = this.value.trim();
        if (!code) return;

        axios.get(`/product/boxs/check-code/${code}`)
            .then(res => {
                if (res.data.exists) {
                    Swal.fire({
                        icon: "warning",
                        text: "El código ingresado ya está en uso. Por favor elige otro.",
                        confirmButtonText: "Entendido"
                    });
                    this.value = "";
                    this.focus();
                }
            })
            .catch(err => console.error("Error al validar código:", err));
    });
}

// ==========================
// Cargar datos del producto BOX-S (solo si estamos en editar)
// ==========================
if (document.getElementById('code_product')) {
    function dataproduct() {
        const codigo = document.getElementById('code_product').value;
        axios.get("/dataproduct/boxs/" + codigo).then(response => {
            const data = response.data;

            // ====== Campos básicos ======
            document.getElementById("subcategory_id").value = data.subcategory_id || "";
            document.getElementById("type").value = data.type || "box3s";
            document.getElementById("code").value = data.code || "";
            document.getElementById("short_name").value = data.short_name || "";
            document.getElementById("name").value = data.name || "";
            document.getElementById("content").value = data.content || "";
            document.getElementById("description").value = data.description || "";
            document.getElementById("description_002").value = data.description_002 || "";
            document.getElementById("price").value = data.price || 0;
            document.getElementById("is_active").checked = data.is_active == 1;
            document.getElementById("qty_bagel").value = data.qty_bagel || 0;

            // ====== Cargar productos UNIT ======
            loadUnitProducts(
                data.subcategory_id,
                data.box_items && data.box_items.length > 0 ? data.box_items[0].item_prod_id : null
            );

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

    // 🔥 Cargar productos UNIT según subcategoría
    function loadUnitProducts(subcategoryId, selectedId = null) {
        const select = document.getElementById("unit_product_id");
        select.innerHTML = `<option value="">-- Selecciona un producto UNIT --</option>`;
        if (!subcategoryId) return;

        axios.get(`/products/boxs/units-by-subcategory/${subcategoryId}`)
            .then(res => {
                res.data.forEach(u => {
                    const opt = document.createElement("option");
                    opt.value = u.id;
                    opt.textContent = u.name;
                    if (selectedId && selectedId == u.id) opt.selected = true;
                    select.appendChild(opt);
                });
            })
            .catch(err => console.error("Error cargando productos UNIT:", err));
    }

    document.getElementById("subcategory_id").addEventListener("change", function () {
        loadUnitProducts(this.value);
    });

    dataproduct();
}

// ==========================
// Inicializar SortableJS
// ==========================
function initSortable() {
    if (typeof Sortable !== "undefined" && document.getElementById("sortable-images")) {
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
    document.querySelectorAll("#sortable-images .image-item").forEach((item, index) => {
        const badge = item.querySelector(".badge");
        if (badge) {
            badge.className = "badge position-absolute " + (index === 0 ? "badge-success" : "badge-secondary");
            badge.textContent = index === 0 ? "PRINCIPAL" : "SECUNDARIA";
            badge.style.top = "5px";
            badge.style.left = "5px";
        }
    });
}

// ==========================
// Eliminar imagen existente
// ==========================
function initDeleteEvents() {
    document.querySelectorAll(".delete-image").forEach(btn => {
        btn.addEventListener("click", function (e) {
            e.preventDefault();

            const total = document.querySelectorAll("#sortable-images .image-item").length;
            if (total <= 1) {
                return Swal.fire({ icon: "warning", text: "Debe existir al menos una imagen." });
            }

            const id = this.dataset.id;
            Swal.fire({
                text: "¿Seguro que quieres eliminar esta imagen?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar"
            }).then(r => {
                if (r.isConfirmed) {
                    axios.delete(`/product/boxs/image/${id}`)
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
// Vista previa imágenes nuevas
// ==========================
const inputImages = document.getElementById("images");
if (inputImages) {
    inputImages.addEventListener("change", e => {
        const container = document.getElementById("sortable-images");
        Array.from(e.target.files).forEach(file => {
            pendingFiles.push(file);
            const reader = new FileReader();
            reader.onload = ev => {
                const col = document.createElement("div");
                col.className = "col-sm-3 text-center mb-3 image-item";
                col.dataset.id = `new_${pendingFiles.length - 1}`;
                col.innerHTML = `
                    <div class="card p-2">
                        <div class="position-relative">
                            <img src="${ev.target.result}" class="img-fluid img-thumbnail mb-2" style="max-height:150px;">
                            <span class="badge badge-secondary position-absolute" style="top:5px; left:5px;">SECUNDARIA</span>
                        </div>
                    </div>`;
                container.appendChild(col);
            };
            reader.readAsDataURL(file);
        });
        e.target.value = "";
        setTimeout(updateBadges, 200);
    });
}

// ==========================
// Actualizar producto existente
// ==========================
function product_update(e) {
    e.preventDefault();

    const existingImages = document.querySelectorAll('#sortable-images .image-item').length;
    if (existingImages + pendingFiles.length === 0) {
        return Swal.fire({ icon: "warning", text: "Debe subir al menos una imagen antes de actualizar." });
    }

    Swal.fire({
        text: "¿Desea actualizar el registro?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí",
        cancelButtonText: "No"
    }).then(result => {
        if (!result.isConfirmed) return;

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
        datos.append("qty_spreads", null);

        const unitSelected = document.getElementById("unit_product_id").value;
        if (unitSelected) {
            datos.append("box_items[0][item_prod_id]", unitSelected);
            datos.append("box_items[0][qty_stock]", document.getElementById("qty_bagel").value);
        }

        document.querySelectorAll('#sortable-images .image-item').forEach((el, index) => {
            datos.append(`order[${el.dataset.id}]`, index);
        });

        pendingFiles.forEach(file => datos.append("images[]", file));

        axios.post('/updateproduct/boxs/' + codigo_antiguo, datos)
            .then(res => {
                if (res.data === 1) {
                    Swal.fire({ text: "Los datos se actualizaron correctamente!", icon: "success" })
                        .then(() => location.href = "/product/boxs/edit/" + document.getElementById("code").value);
                    pendingFiles = [];
                } else {
                    Swal.fire({ text: "No se realizó la actualización correctamente!", icon: "error" });
                }
            })
            .catch(err => {
                Swal.fire({ text: "Error al actualizar el producto", icon: "error" });
                console.error(err);
            })
            .finally(() => {
                btn.disabled = false;
                btnText.innerHTML = "Guardar Cambios";
                btnSpinner.style.display = "none";
            });
    });
}

// ==========================
// Crear nuevo producto BOX-S
// ==========================
async function product_store(e) {
    e.preventDefault();

    const btn = document.getElementById("btn-save");
    const btnText = btn.querySelector(".btn-text");
    const btnSpinner = btn.querySelector(".btn-spinner");

    const subcategory = document.getElementById("subcategory_id").value.trim();
    const code = document.getElementById("code").value.trim();
    const name = document.getElementById("name").value.trim();
    const shortName = document.getElementById("short_name").value.trim();
    const price = document.getElementById("price").value.trim();
    const qtyBagel = document.getElementById("qty_bagel").value.trim();
    const unit = document.getElementById("unit_product_id").value.trim();
    const totalImages = document.querySelectorAll('#sortable-images .image-item').length + pendingFiles.length;

    if (!subcategory) return Swal.fire({ icon: "warning", text: "Seleccione una subcategoría" });
    if (!code) return Swal.fire({ icon: "warning", text: "Ingrese un código" });
    if (!shortName) return Swal.fire({ icon: "warning", text: "El campo 'Nombre Info' es obligatorio" });
    if (!name) return Swal.fire({ icon: "warning", text: "Ingrese el nombre del producto" });
    if (!qtyBagel || qtyBagel <= 0) return Swal.fire({ icon: "warning", text: "Ingrese la cantidad de bagels" });
    if (!price || price <= 0) return Swal.fire({ icon: "warning", text: "Ingrese un precio válido" });
    if (!unit) return Swal.fire({ icon: "warning", text: "Seleccione un producto UNIT contenido en la caja" });
    if (totalImages === 0) return Swal.fire({ icon: "warning", text: "Debe subir al menos una imagen" });

    try {
        const res = await axios.get(`/product/boxs/check-code/${code}`);
        if (res.data.exists) {
            Swal.fire({
                icon: "error",
                text: "El código ingresado ya existe. Por favor elige otro."
            });
            return;
        }
    } catch (error) {
        console.error("Error verificando el código:", error);
        Swal.fire({ icon: "error", text: "Error al verificar el código." });
        return;
    }

    Swal.fire({
        text: "¿Desea crear este nuevo producto?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, crear",
        cancelButtonText: "Cancelar"
    }).then(result => {
        if (!result.isConfirmed) return;

        btn.disabled = true;
        btnText.textContent = "Creando producto...";
        btnSpinner.style.display = "inline-block";

        const datos = new FormData();
        datos.append("subcategory_id", subcategory);
        datos.append("type", document.getElementById("type").value);
        datos.append("code", code);
        datos.append("short_name", shortName);
        datos.append("name", name);
        datos.append("description", document.getElementById("description").value);
        datos.append("description_002", document.getElementById("description_002").value);
        datos.append("price", price);
        datos.append("is_active", document.getElementById("is_active").checked ? 1 : 0);
        datos.append("qty_bagel", qtyBagel);
        datos.append("qty_spreads", null);
        datos.append("box_items[0][item_prod_id]", unit);
        datos.append("box_items[0][qty_stock]", qtyBagel);
        pendingFiles.forEach(file => datos.append("images[]", file));

        axios.post('/product/boxs/store', datos)
            .then(res => {
                if (res.data.success) {
                    Swal.fire({ icon: "success", text: "Producto creado correctamente" })
                        .then(() => location.href = `/product/boxs/edit/${code}`);
                } else {
                    Swal.fire({ icon: "error", text: res.data.message || "No se pudo crear el producto" });
                }
            })
            .catch(err => {
                Swal.fire({ icon: "error", text: "Error al crear el producto" });
                console.error(err);
            })
            .finally(() => {
                btn.disabled = false;
                btnText.innerHTML = '<i class="fa fa-save mr-2"></i> Crear Producto Box 1 Sabor';
                btnSpinner.style.display = "none";
            });
    });
}
