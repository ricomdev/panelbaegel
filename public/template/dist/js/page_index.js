// ============================
// BAEGEL - PANEL ADMIN
// Control de secciones del index (SweetAlert2)
// ============================

document.addEventListener("DOMContentLoaded", () => {
    if (window.bsCustomFileInput) bsCustomFileInput.init();

    const token = document.querySelector('meta[name="csrf-token"]');
    if (token) axios.defaults.headers.common["X-CSRF-TOKEN"] = token.getAttribute("content");
});

// =====================================================
// SLIDERS (CRUD /sliders)
// =====================================================

// Actualizar slider existente (PUT /sliders/{id})
function updateSlider(id) {
    const formData = new FormData();
    formData.append("_method", "PUT");
    formData.append("type", $(`[name=type_${id}]`).val());
    formData.append("order", $(`[name=order_${id}]`).val() || 0);
    formData.append("is_active", $(`[name=active_${id}]`).is(":checked") ? 1 : 0);
    formData.append("title", $(`[name=title_${id}]`).val());
    formData.append("caption", $(`[name=caption_${id}]`).val());
    formData.append("button_text", $(`[name=button_text_${id}]`).val());
    formData.append("button_link", $(`[name=button_link_${id}]`).val());
    formData.append("youtube_id", $(`[name=youtube_id_${id}]`).val() || "");

    const fileInput = $(`[name=image_${id}]`)[0];
    if (fileInput && fileInput.files.length > 0) {
        formData.append("image", fileInput.files[0]);
    }

    axios.post(`/sliders/${id}`, formData, { headers: { "Content-Type": "multipart/form-data" } })
        .then(response => {
            Swal.fire("Actualizado", "El slider se actualizó correctamente", "success");

            // ✅ Actualizar label del input file
            const label = $(`[name=image_${id}]`).siblings(".custom-file-label");
            if (fileInput?.files.length > 0) {
                label.text(fileInput.files[0].name);
            }

            // ✅ Refrescar imagen mostrada (coincide con tu HTML: .col-sm-12)
            if (response.data.slider && response.data.slider.image_path) {
                const img = $(`[name=image_${id}]`).closest(".col-sm-12").find("img");
                if (img.length > 0) {
                    img.attr("src", response.data.slider.image_path + "?t=" + new Date().getTime());
                }
            }
        })
        .catch(() => Swal.fire("Error", "No se pudo actualizar el slider", "error"));
}



// Crear una nueva pestaña temporal para un nuevo slider
function addSliderRow() {
    const container = document.querySelector("#slider-list") || document.querySelector(".tab-content");
    const tempId = Date.now();

    const row = document.createElement("div");
    row.className = "tab-pane fade show active slider-row";
    row.id = `slider-temp-${tempId}`;
    row.innerHTML = `
        <div class="row mb-3">
            <div class="col-sm-3">
                <label>Tipo</label>
                <select name="type_new_${tempId}" class="form-control">
                    <option value="image">Imagen</option>
                    <option value="youtube">YouTube</option>
                </select>
            </div>
            <div class="col-sm-3">
                <label>Orden</label>
                <input type="number" name="order_new_${tempId}" class="form-control" value="0">
            </div>
            <div class="col-sm-3 d-flex align-items-center">
                <div class="form-check mt-4">
                    <input class="form-check-input" type="checkbox" name="active_new_${tempId}" checked>
                    <label class="form-check-label">Activo</label>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <label>Título</label>
                <input type="text" name="title_new_${tempId}" class="form-control" placeholder="Título del slider">
            </div>
            <div class="col-sm-6">
                <label>Subtítulo</label>
                <input type="text" name="caption_new_${tempId}" class="form-control" placeholder="Texto secundario">
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-sm-6">
                <label>Texto del botón</label>
                <input type="text" name="button_text_new_${tempId}" class="form-control" placeholder="Texto del botón">
            </div>
            <div class="col-sm-6">
                <label>Enlace del botón</label>
                <input type="url" name="button_link_new_${tempId}" class="form-control" placeholder="https://...">
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-sm-6">
                <label>YouTube ID</label>
                <input type="text" name="youtube_id_new_${tempId}" class="form-control" placeholder="Solo si es tipo YouTube">
            </div>
            <div class="col-sm-6">
                <label>Imagen (1920x700)</label>
                <div class="custom-file">
                    <input type="file" accept="image/*" name="image_new_${tempId}" class="custom-file-input">
                    <label class="custom-file-label">Seleccionar imagen</label>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-5 mr-auto ml-auto d-flex">
                <button type="button" class="btn btn-success btn-block mr-2" onclick="saveNewSlider(${tempId})">
                    <i class="fa fa-save mr-2"></i>Guardar
                </button>
                <button type="button" class="btn btn-secondary" onclick="removeNewSliderRow(this)">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>
    `;

    container.appendChild(row);
    if (window.bsCustomFileInput) bsCustomFileInput.init();
}

// Guardar un nuevo slider (POST /sliders)
function saveNewSlider(tempId) {
    const formData = new FormData();
    formData.append("type", $(`[name=type_new_${tempId}]`).val());
    formData.append("order", $(`[name=order_new_${tempId}]`).val() || 0);
    formData.append("is_active", $(`[name=active_new_${tempId}]`).is(":checked") ? 1 : 0);
    formData.append("title", $(`[name=title_new_${tempId}]`).val());
    formData.append("caption", $(`[name=caption_new_${tempId}]`).val());
    formData.append("button_text", $(`[name=button_text_new_${tempId}]`).val());
    formData.append("button_link", $(`[name=button_link_new_${tempId}]`).val());
    formData.append("youtube_id", $(`[name=youtube_id_new_${tempId}]`).val() || "");

    const fileInput = $(`[name=image_new_${tempId}]`)[0];
    if (fileInput?.files.length > 0) formData.append("image", fileInput.files[0]);

    axios.post(`/sliders`, formData, { headers: { "Content-Type": "multipart/form-data" } })
        .then(() => Swal.fire("Creado", "Nuevo slider agregado correctamente", "success")
            .then(() => location.reload()))
        .catch(() => Swal.fire("Error", "No se pudo crear el slider", "error"));
}

// Eliminar slider (DELETE /sliders/{id})
function deleteSlider(id) {
    Swal.fire({
        title: "¿Eliminar slider?",
        text: "Esta acción no se puede deshacer.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Eliminar",
        cancelButtonText: "Cancelar"
    }).then(result => {
        if (result.isConfirmed) {
            axios.delete(`/sliders/${id}`)
                .then(() => Swal.fire("Eliminado", "El slider fue eliminado correctamente", "success")
                    .then(() => location.reload()))
                .catch(() => Swal.fire("Error", "No se pudo eliminar el slider", "error"));
        }
    });
}

// Eliminar fila temporal antes de guardar
function removeNewSliderRow(btn) {
    btn.closest(".slider-row").remove();
}


// =====================================================
// OUR STORY (PUT /our-story/{id})
// =====================================================
function updateOurStory() {
    const form = document.getElementById("form-ourstory");
    const id = form.dataset.id || 1;
    const formData = new FormData(form);
    formData.append("_method", "PUT");

    axios.post(`/our-story/${id}`, formData)
        .then(() => Swal.fire("Actualizado", "Sección 'Quiénes Somos' actualizada", "success"))
        .catch(() => Swal.fire("Error", "No se pudo actualizar 'Quiénes Somos'", "error"));
}

// =====================================================
// TIMELINE (PUT /timeline-events/{id})
// =====================================================
function updateTimeline(id) {
    const formData = new FormData();
    formData.append("_method", "PUT");
    formData.append("year", $(`[name=year_${id}]`).val());
    formData.append("description", $(`[name=desc_${id}]`).val());

    const fileInput = $(`[name=icon_${id}]`)[0];
    if (fileInput?.files.length > 0) formData.append("icon", fileInput.files[0]);

    axios.post(`/timeline-events/${id}`, formData, { headers: { "Content-Type": "multipart/form-data" } })
        .then(response => {
            Swal.fire("Guardado", "Evento del timeline actualizado correctamente", "success");

            // ✅ Actualizar label del input file
            const label = $(`[name=icon_${id}]`).siblings(".custom-file-label");
            if (fileInput?.files.length > 0) {
                label.text(fileInput.files[0].name);
            }

            // ✅ Refrescar la miniatura si se ha actualizado el icono
            if (response.data.event && response.data.event.icon_path) {
                const img = $(`[name=icon_${id}]`).closest(".col-sm-3").find("img");
                if (img.length > 0) {
                    img.attr("src", response.data.event.icon_path + "?t=" + new Date().getTime());
                }
            }
        })
        .catch(() => Swal.fire("Error", "No se pudo actualizar el evento", "error"));
}

// =====================================================
// BRANDS (CRUD /brands)
// =====================================================
function updateBrand(id) {
    const formData = new FormData();
    formData.append("_method", "PUT");
    formData.append("name", $(`[name=name_${id}]`).val());
    formData.append("url", $(`[name=url_${id}]`).val());
    formData.append("is_active", '1');

    const fileInput = $(`[name=logo_${id}]`)[0];
    if (fileInput?.files.length > 0) formData.append("logo", fileInput.files[0]);

    axios.post(`/brands/${id}`, formData, { headers: { "Content-Type": "multipart/form-data" } })
        .then(response => {
            Swal.fire("Actualizado", "Marca actualizada correctamente", "success");

            // ✅ Actualizar el label del input file
            const label = $(`[name=logo_${id}]`).siblings(".custom-file-label");
            if (fileInput?.files.length > 0) {
                label.text(fileInput.files[0].name);
            }

            // ✅ Actualizar la imagen mostrada (sin recargar)
            if (response.data.brand && response.data.brand.logo_path) {
                const img = $(`[name=logo_${id}]`).closest(".col-sm-3").find("img");
                if (img.length > 0) {
                    // Se actualiza la imagen forzando refresco del caché con timestamp
                    img.attr("src", response.data.brand.logo_path + "?t=" + new Date().getTime());
                }
            }
        })
        .catch(() => Swal.fire("Error", "No se pudo actualizar la marca", "error"));
}


function addBrandRow() {
    const container = document.getElementById("brand-list");
    const tempId = Date.now();
    const row = document.createElement("div");
    row.className = "row align-items-center mb-3 border-bottom pb-2 brand-row";
    row.innerHTML = `
        <div class="col-sm-3"><input type="text" name="name_new_${tempId}" class="form-control" placeholder="Nombre de la marca"></div>
        <div class="col-sm-4"><input type="url" name="url_new_${tempId}" class="form-control" placeholder="https://..."></div>
        <div class="col-sm-3">
            <div class="custom-file">
                <input type="file" name="logo_new_${tempId}" class="custom-file-input">
                <label class="custom-file-label">Imagen logo 300 x 187 px</label>
            </div>
        </div>
        <div class="col-sm-2 d-flex">
            <button type="button" class="btn btn-sm btn-success mr-1" onclick="saveNewBrand(${tempId})"><i class="fa fa-save"></i></button>
            <button type="button" class="btn btn-sm btn-secondary" onclick="removeNewBrandRow(this)"><i class="fa fa-times"></i></button>
        </div>`;
    container.appendChild(row);
    bsCustomFileInput.init();
}

function saveNewBrand(tempId) {
    const formData = new FormData();
    formData.append("name", $(`[name=name_new_${tempId}]`).val());
    formData.append("url", $(`[name=url_new_${tempId}]`).val());
    formData.append("is_active", '1');
    const fileInput = $(`[name=logo_new_${tempId}]`)[0];
    if (fileInput?.files.length > 0) formData.append("logo", fileInput.files[0]);

    axios.post(`/brands`, formData, { headers: { "Content-Type": "multipart/form-data" } })
        .then(() => Swal.fire("Creado", "Marca agregada correctamente", "success").then(() => location.reload()))
        .catch(() => Swal.fire("Error", "No se pudo crear la marca", "error"));
}

function deleteBrand(id) {
    Swal.fire({
        title: "¿Eliminar marca?",
        text: "Esta acción no se puede deshacer.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Eliminar",
        cancelButtonText: "Cancelar"
    }).then(result => {
        if (result.isConfirmed) {
            axios.delete(`/brands/${id}`)
                .then(() => Swal.fire("Eliminado", "La marca fue eliminada correctamente", "success").then(() => location.reload()))
                .catch(() => Swal.fire("Error", "No se pudo eliminar la marca", "error"));
        }
    });
}

function removeNewBrandRow(btn) {
    btn.closest(".brand-row").remove();
}

// =====================================================
// SERVICES (3 fijos) - PUT /services/order/{order}
// =====================================================
function updateService(order) {
    const formData = new FormData();
    formData.append("_method", "PUT");
    formData.append("title", $(`[name=title_order_${order}]`).val());
    formData.append("description", $(`[name=desc_order_${order}]`).val());

    const fileInput = $(`[name=icon_order_${order}]`)[0];
    if (fileInput?.files.length > 0) formData.append("icon", fileInput.files[0]);

    axios.post(`/services/order/${order}`, formData, {
        headers: { "Content-Type": "multipart/form-data" }
    })
    .then(response => {
        Swal.fire("Guardado", "Servicio actualizado correctamente", "success");

        // ✅ Actualizar label del input file
        const label = $(`[name=icon_order_${order}]`).siblings(".custom-file-label");
        if (fileInput?.files.length > 0) label.text(fileInput.files[0].name);

        // ✅ Refrescar miniatura sin recargar
        if (response.data.service && response.data.service.icon_path) {
            const img = $(`[name=icon_order_${order}]`).closest(".col-sm-3").find("img");
            if (img.length > 0) {
                img.attr("src", response.data.service.icon_path + "?t=" + new Date().getTime());
            }
        }
    })
    .catch(() => Swal.fire("Error", "No se pudo actualizar el servicio", "error"));
}



// =====================================================
// INSTAGRAM TILES (6 fijos) - PUT /instagram-tiles/order/{order}
// =====================================================
function updateInstagram(order) {
    const formData = new FormData();
    formData.append("_method", "PUT");
    formData.append("post_url", $(`[name=url_order_${order}]`).val());

    const fileInput = $(`[name=img_order_${order}]`)[0];
    if (fileInput?.files.length > 0) formData.append("image", fileInput.files[0]);

    axios.post(`/instagram-tiles/order/${order}`, formData, { headers: { "Content-Type": "multipart/form-data" } })
        .then(response => {
            Swal.fire("Actualizado", "Registro de Instagram actualizado correctamente", "success");

            // ✅ Actualizar label del input
            const label = $(`[name=img_order_${order}]`).siblings(".custom-file-label");
            if (fileInput?.files.length > 0) {
                label.text(fileInput.files[0].name);
            }

            // ✅ Actualizar la miniatura (sin recargar)
            if (response.data.tile && response.data.tile.image_path) {
                const img = $(`[name=img_order_${order}]`).closest(".col-sm-4").find("img");
                if (img.length > 0) {
                    img.attr("src", response.data.tile.image_path + "?t=" + new Date().getTime());
                }
            }
        })
        .catch(() => Swal.fire("Error", "No se pudo actualizar el registro", "error"));
}



// =====================================================
// SETTINGS (PUT /settings)
// =====================================================
function updateSettings() {
    const data = {
        timeline_title: $('[name=timeline_title]').val(),
        timeline_button: $('[name=timeline_button]').val(),
        find_us_title: $('[name=find_us_title]').val(),
        bagels_title: $('[name=bagels_title]').val(),
        want_baegels_title: $('[name=want_baegels_title]').val(),
        attention_text: $('[name=attention_text]').val(),
        lovers_title: $('[name=lovers_title]').val(),
        instagram_follow_text: $('[name=instagram_follow_text]').val(),
    };

    axios.put('/settings', data)
        .then(() => Swal.fire("Guardado", "Configuraciones actualizadas correctamente", "success"))
        .catch(() => Swal.fire("Error", "No se pudieron guardar las configuraciones", "error"));
}


// =====================================================
// HOME HEADER (PUT /home-header)
// =====================================================
function updateHomeHeader() {
    const formData = new FormData();
    formData.append("_method", "PUT");
    formData.append("title", $(`[name=title_header]`).val());
    formData.append("is_active", $(`[name=active_header]`).is(":checked") ? 1 : 0);

    axios.post(`/home-header`, formData)
        .then(() => Swal.fire("Actualizado", "Header principal actualizado correctamente", "success"))
        .catch(() => Swal.fire("Error", "No se pudo actualizar el header", "error"));
}

// =====================================================
// HOME BAGELS (CRUD /home-bagels) — versión aislada y segura
// =====================================================

// ✅ Actualizar un Bagel existente (PUT /home-bagels/{id})
function updateBagel(id) {
    const row = $(`.bagel-row[data-id="${id}"]`);
    const formData = new FormData();

    formData.append("_method", "PUT");
    formData.append("title", row.find(`[name=bagel_title_${id}]`).val());
    formData.append("description", row.find(`[name=bagel_desc_${id}]`).val());

    const fileInput = row.find(`[name=bagel_image_${id}]`)[0];
    if (fileInput?.files.length > 0) formData.append("image", fileInput.files[0]);

    axios.post(`/home-bagels/${id}`, formData, { headers: { "Content-Type": "multipart/form-data" } })
        .then(response => {
            Swal.fire("Actualizado", "Bagel actualizado correctamente", "success");

            // ✅ Actualizar label del input file
            const label = row.find(`[name=bagel_image_${id}]`).siblings(".custom-file-label");
            if (fileInput?.files.length > 0) label.text(fileInput.files[0].name);

            // ✅ Refrescar imagen sin recargar
            if (response.data.bagel && response.data.bagel.image_path) {
                const img = row.find("img");
                if (img.length > 0) {
                    img.attr("src", response.data.bagel.image_path + "?t=" + new Date().getTime());
                }
            }
        })
        .catch(() => Swal.fire("Error", "No se pudo actualizar el bagel", "error"));
}

// ✅ Crear nueva fila temporal para agregar un nuevo bagel
function addBagelRow() {
    const container = document.getElementById("bagel-list");
    const tempId = Date.now();

    const row = document.createElement("div");
    row.className = "row align-items-center mb-3 border-bottom pb-2 bagel-row";
    row.dataset.id = tempId;
    row.innerHTML = `
        <div class="col-sm-3">
            <input type="text" name="bagel_title_new_${tempId}" class="form-control" placeholder="Nombre del Bagel">
        </div>
        <div class="col-sm-4">
            <input type="text" name="bagel_desc_new_${tempId}" class="form-control" placeholder="Descripción corta">
        </div>
        <div class="col-sm-3">
            <div class="custom-file">
                <input type="file" accept="image/*" name="bagel_image_new_${tempId}" class="custom-file-input">
                <label class="custom-file-label">Seleccionar imagen</label>
            </div>
        </div>
        <div class="col-sm-2 d-flex">
            <button type="button" class="btn btn-sm btn-success mr-1" onclick="saveNewBagel(${tempId})">
                <i class="fa fa-save"></i>
            </button>
            <button type="button" class="btn btn-sm btn-secondary" onclick="removeNewBagelRow(this)">
                <i class="fa fa-times"></i>
            </button>
        </div>`;
    container.appendChild(row);
    if (window.bsCustomFileInput) bsCustomFileInput.init();
}

// ✅ Guardar nuevo Bagel (POST /home-bagels)
function saveNewBagel(tempId) {
    const row = $(`.bagel-row[data-id="${tempId}"]`);
    const formData = new FormData();

    formData.append("title", row.find(`[name=bagel_title_new_${tempId}]`).val());
    formData.append("description", row.find(`[name=bagel_desc_new_${tempId}]`).val());

    const fileInput = row.find(`[name=bagel_image_new_${tempId}]`)[0];
    if (fileInput?.files.length > 0) formData.append("image", fileInput.files[0]);

    axios.post(`/home-bagels`, formData, { headers: { "Content-Type": "multipart/form-data" } })
        .then(() => Swal.fire("Creado", "Bagel agregado correctamente", "success")
            .then(() => location.reload()))
        .catch(() => Swal.fire("Error", "No se pudo crear el bagel", "error"));
}

// ✅ Eliminar Bagel (DELETE /home-bagels/{id})
function deleteBagel(id) {
    Swal.fire({
        title: "¿Eliminar bagel?",
        text: "Esta acción no se puede deshacer.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Eliminar",
        cancelButtonText: "Cancelar"
    }).then(result => {
        if (result.isConfirmed) {
            axios.delete(`/home-bagels/${id}`)
                .then(() => Swal.fire("Eliminado", "Bagel eliminado correctamente", "success")
                    .then(() => location.reload()))
                .catch(() => Swal.fire("Error", "No se pudo eliminar el bagel", "error"));
        }
    });
}

// ✅ Eliminar fila temporal antes de guardar
function removeNewBagelRow(btn) {
    btn.closest(".bagel-row").remove();
}



// =====================================================
// PREVISUALIZAR IMAGEN AL SELECCIONAR (Sliders y similares)
// =====================================================
document.addEventListener("change", function (e) {
    // Incluye sliders, bagels, timeline, servicios e instagram
    if (
        e.target.matches(
            'input[type="file"][name^="image_"], ' +
            'input[type="file"][name^="image_new_"], ' +
            'input[type="file"][name^="bagel_image_"], ' +
            'input[type="file"][name^="bagel_image_new_"], ' +
            'input[type="file"][name^="icon_"], ' +
            'input[type="file"][name^="img_order_"]'
        )
    ) {
        const input = e.target;
        const file = input.files[0];
        if (!file) return;

        // Actualiza el label con el nombre del archivo
        const label = $(input).siblings(".custom-file-label");
        label.text(file.name);

        // Crea la vista previa con FileReader
        const reader = new FileReader();
        reader.onload = function (ev) {
            const container = $(input).closest(".col-sm-12, .col-sm-6, .col-sm-4, .col-sm-3");
            let img = container.find("img");

            if (img.length > 0) {
                img.attr("src", ev.target.result);
            } else {
                const width =
                    input.name.startsWith("icon_") ? 80 :
                    input.name.startsWith("img_order_") ? 120 :
                    120;
                container.append(`<img src="${ev.target.result}" class="mt-2" width="${width}">`);
            }
        };
        reader.readAsDataURL(file);
    }
});




