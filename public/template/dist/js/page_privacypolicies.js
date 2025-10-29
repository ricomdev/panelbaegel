document.addEventListener("DOMContentLoaded", () => {
    if (window.bsCustomFileInput) bsCustomFileInput.init();

    const token = document.querySelector('meta[name="csrf-token"]');
    if (token) axios.defaults.headers.common["X-CSRF-TOKEN"] = token.getAttribute("content");
});

// ==========================
// TEXTO GENERAL (FIJO)
// ==========================
function updatePrivacyGeneral(id) {
    const row = $(`#privacy-general-text [data-id='${id}']`);
    const content = row.find(`textarea[name='privacy_general_content_${id}']`).val();
    const is_active = row.find(`input[name='privacy_general_active_${id}']`).is(":checked") ? 1 : 0;

    if (!content || content.trim().length === 0) {
        Swal.fire("Error", "Debe ingresar contenido antes de guardar.", "error");
        return;
    }

    const formData = new FormData();
    formData.append("content", content);
    formData.append("is_active", is_active);

    axios.post(`/privacy-policies/general/${id}?_method=PUT`, formData)
        .then(res => {
            if (res.data.success) {
                Swal.fire({
                    icon: "success",
                    title: "Actualizado",
                    text: res.data.message,
                    timer: 1500,
                    showConfirmButton: false
                });
            } else {
                Swal.fire("Error", "No se pudo actualizar el texto general.", "error");
            }
        })
        .catch(() => Swal.fire("Error", "No se pudo actualizar el texto general.", "error"));
}

// ==========================
// SECCIONES DE POLÍTICAS
// ==========================

// Agregar nueva sección temporal
function addPrivacyRow() {
    const newId = Date.now(); // id temporal

    const newRow = `
        <div class="row align-items-start mb-3 border-bottom pb-2 privacy-row new" data-temp-id="${newId}">
            <div class="col-sm-4">
                <label>Título</label>
                <input type="text" name="privacy_title_new_${newId}" class="form-control" placeholder="Ej: I. ASPECTOS GENERALES">
            </div>
            <div class="col-sm-6">
                <label>Contenido</label>
                <textarea name="privacy_content_new_${newId}" class="form-control" rows="4" placeholder="Contenido de la sección..."></textarea>
            </div>
            <div class="col-sm-1">
                <label>Orden</label>
                <input type="number" name="privacy_order_new_${newId}" class="form-control" min="0" value="0">
            </div>
            <div class="col-sm-1 d-flex align-items-center mt-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="privacy_active_new_${newId}" checked>
                    <label class="form-check-label">Activo</label>
                </div>
            </div>
            <div class="col-sm-12 d-flex justify-content-end mt-2">
                <button type="button" class="btn btn-sm btn-success mr-1" onclick="storePrivacy(${newId})">
                    <i class="fa fa-save"></i>
                </button>
                <button type="button" class="btn btn-sm btn-danger" onclick="$(this).closest('.privacy-row').remove()">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </div>
    `;

    $("#privacy-list").append(newRow);
}

// Crear sección
function storePrivacy(tempId) {
    const row = $(`.privacy-row[data-temp-id='${tempId}']`);
    const formData = new FormData();

    formData.append("title", row.find(`input[name='privacy_title_new_${tempId}']`).val());
    formData.append("content", row.find(`textarea[name='privacy_content_new_${tempId}']`).val());
    formData.append("order_num", row.find(`input[name='privacy_order_new_${tempId}']`).val());
    formData.append("is_active", row.find(`input[name='privacy_active_new_${tempId}']`).is(":checked") ? 1 : 0);

    axios.post("/privacy-policies/store", formData)
        .then(res => {
            if (res.data.success) {
                Swal.fire({
                    icon: "success",
                    title: "Guardado",
                    text: res.data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => location.reload());
            } else {
                Swal.fire("Error", "No se pudo crear la sección.", "error");
            }
        })
        .catch(() => Swal.fire("Error", "No se pudo crear la sección.", "error"));
}

// Actualizar sección
function updatePrivacy(id) {
    const row = $(`.privacy-row[data-id='${id}']`);
    const formData = new FormData();

    formData.append("title", row.find(`input[name='privacy_title_${id}']`).val());
    formData.append("content", row.find(`textarea[name='privacy_content_${id}']`).val());
    formData.append("order_num", row.find(`input[name='privacy_order_${id}']`).val());
    formData.append("is_active", row.find(`input[name='privacy_active_${id}']`).is(":checked") ? 1 : 0);

    axios.post(`/privacy-policies/${id}?_method=PUT`, formData)
        .then(res => {
            if (res.data.success) {
                Swal.fire({
                    icon: "success",
                    title: "Actualizado",
                    text: res.data.message,
                    timer: 1500,
                    showConfirmButton: false
                });
            } else {
                Swal.fire("Error", "No se pudo actualizar la sección.", "error");
            }
        })
        .catch(() => Swal.fire("Error", "No se pudo actualizar la sección.", "error"));
}

// Eliminar sección
function deletePrivacy(id) {
    Swal.fire({
        title: "¿Eliminar esta sección?",
        text: "Esta acción no se puede deshacer.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then(result => {
        if (result.isConfirmed) {
            axios.delete(`/privacy-policies/${id}`)
                .then(res => {
                    if (res.data.success) {
                        Swal.fire({
                            icon: "success",
                            title: "Eliminado",
                            text: res.data.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => location.reload());
                    } else {
                        Swal.fire("Error", "No se pudo eliminar la sección.", "error");
                    }
                })
                .catch(() => Swal.fire("Error", "No se pudo eliminar la sección.", "error"));
        }
    });
}
