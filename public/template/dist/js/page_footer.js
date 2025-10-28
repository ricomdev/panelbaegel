
document.addEventListener("DOMContentLoaded", () => {
    if (window.bsCustomFileInput) bsCustomFileInput.init();

    const token = document.querySelector('meta[name="csrf-token"]');
    if (token) axios.defaults.headers.common["X-CSRF-TOKEN"] = token.getAttribute("content");
});


// ==========================
// FOOTER SETTINGS
// ==========================
function updateFooterSettings() {
    const formData = new FormData();
    formData.append("hours_desktop", $("input[name='hours_desktop']").val());
    formData.append("hours_mobile", $("textarea[name='hours_mobile']").val());
    formData.append("address", $("input[name='address']").val());
    formData.append("whatsapp", $("input[name='whatsapp']").val());
    formData.append("follow_text", $("input[name='follow_text']").val());
    formData.append("newsletter_title", $("input[name='newsletter_title']").val());
    formData.append("newsletter_text", $("input[name='newsletter_text']").val());

    axios.post("/footer/update-settings", formData)
        .then(res => {
            if (res.data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Guardado',
                    text: res.data.message,
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire("Error", "No se pudo actualizar los ajustes del footer.", "error");
        });
}



// ==========================
// REDES SOCIALES
// ==========================

// Agregar nueva fila de red social
function addSocialRow() {
    const newId = Date.now(); // identificador temporal único

    const newRow = `
        <div class="row align-items-center mb-3 border-bottom pb-2 social-row new" data-temp-id="${newId}">
            <div class="col-sm-2">
                <label>Nombre</label>
                <input type="text" name="social_platform_new_${newId}" class="form-control" placeholder="Instagram, Facebook…">
            </div>
            <div class="col-sm-4">
                <label>URL</label>
                <input type="url" name="social_url_new_${newId}" class="form-control" placeholder="https://...">
            </div>
            <div class="col-sm-3">
                <label>Clase del ícono (FontAwesome)</label>
                <input type="text" name="social_icon_new_${newId}" class="form-control" placeholder="fa-brands fa-instagram" oninput="previewIcon(this)">
                <div class="icon-preview mt-2" style="font-size: 1.4rem;"></div>
            </div>
            <div class="col-sm-1">
                <label>Orden</label>
                <input type="number" name="social_order_new_${newId}" class="form-control" min="0" value="0">
            </div>
            <div class="col-sm-1 d-flex align-items-center mt-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="social_active_new_${newId}" checked>
                    <label class="form-check-label">Activo</label>
                </div>
            </div>
            <div class="col-sm-12 d-flex justify-content-end mt-2">
                <button type="button" class="btn btn-sm btn-success mr-1" onclick="storeSocial(${newId})">
                    <i class="fa fa-save"></i>
                </button>
                <button type="button" class="btn btn-sm btn-danger" onclick="$(this).closest('.social-row').remove()">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </div>
    `;

    $("#social-list").append(newRow);
}



// Crear nueva red social
function storeSocial(tempId) {
    const row = $(`.social-row[data-temp-id='${tempId}']`);
    const formData = new FormData();

    formData.append("platform", row.find(`input[name='social_platform_new_${tempId}']`).val());
    formData.append("url", row.find(`input[name='social_url_new_${tempId}']`).val());
    formData.append("icon_class", row.find(`input[name='social_icon_new_${tempId}']`).val());
    formData.append("order_num", row.find(`input[name='social_order_new_${tempId}']`).val());
    formData.append("is_active", row.find(`input[name='social_active_new_${tempId}']`).is(":checked") ? 1 : 0);

    axios.post("/footer/socials", formData)
        .then(res => {
            if (res.data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Guardado',
                    text: res.data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => location.reload());
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire("Error", "No se pudo crear la red social.", "error");
        });
}



// Actualizar red social existente
function updateSocial(id) {
    const row = $(`.social-row[data-id='${id}']`);
    const formData = new FormData();

    formData.append("platform", row.find(`input[name='social_platform_${id}']`).val());
    formData.append("url", row.find(`input[name='social_url_${id}']`).val());
    formData.append("icon_class", row.find(`input[name='social_icon_${id}']`).val());
    formData.append("order_num", row.find(`input[name='social_order_${id}']`).val());
    formData.append("is_active", row.find(`input[name='social_active_${id}']`).is(":checked") ? 1 : 0);

    axios.post(`/footer/socials/${id}`, formData)
        .then(res => {
            if (res.data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Actualizado',
                    text: res.data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => location.reload());
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire("Error", "No se pudo actualizar la red social.", "error");
        });
}



// Eliminar red social
function deleteSocial(id) {
    Swal.fire({
        title: "¿Eliminar esta red social?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then(result => {
        if (result.isConfirmed) {
            axios.delete(`/footer/socials/${id}`)
                .then(res => {
                    if (res.data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Eliminado',
                            text: res.data.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => location.reload());
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire("Error", "No se pudo eliminar la red social.", "error");
                });
        }
    });
}



// ==========================
// PREVISUALIZAR CLASE DE ÍCONO
// ==========================
function previewIcon(input) {
    const iconClass = $(input).val().trim();
    const previewContainer = $(input).siblings(".icon-preview");
    if (iconClass) {
        previewContainer.html(`<i class="${iconClass}"></i>`);
    } else {
        previewContainer.html("");
    }
}
