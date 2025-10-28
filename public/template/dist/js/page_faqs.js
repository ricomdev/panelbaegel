
document.addEventListener("DOMContentLoaded", () => {
    if (window.bsCustomFileInput) bsCustomFileInput.init();

    const token = document.querySelector('meta[name="csrf-token"]');
    if (token) axios.defaults.headers.common["X-CSRF-TOKEN"] = token.getAttribute("content");
});

// ==========================
// CATEGORÍAS DE FAQ
// ==========================

// Agregar nueva categoría temporal
function addFaqCategoryRow() {
    const newId = Date.now(); // id temporal

    const newRow = `
        <div class="row align-items-center mb-3 border-bottom pb-2 faq-category-row new" data-temp-id="${newId}">
            <div class="col-sm-3">
                <label>Nombre</label>
                <input type="text" name="faqcat_name_new_${newId}" class="form-control" placeholder="Ej: Pedido, Envío...">
            </div>
            <div class="col-sm-3">
                <label>Clase del ícono (FontAwesome / MDI)</label>
                <input type="text" name="faqcat_icon_new_${newId}" class="form-control" placeholder="mdi mdi-help-circle" oninput="previewFaqIcon(this)">
                <div class="icon-preview mt-2" style="font-size:1.4rem;"></div>
            </div>
            <div class="col-sm-2">
                <label>Orden</label>
                <input type="number" name="faqcat_order_new_${newId}" class="form-control" min="0" value="0">
            </div>
            <div class="col-sm-2 d-flex align-items-center mt-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="faqcat_active_new_${newId}" checked>
                    <label class="form-check-label">Activo</label>
                </div>
            </div>
            <div class="col-sm-2 d-flex justify-content-end mt-2">
                <button type="button" class="btn btn-sm btn-success mr-1" onclick="storeFaqCategory(${newId})">
                    <i class="fa fa-save"></i>
                </button>
                <button type="button" class="btn btn-sm btn-danger" onclick="$(this).closest('.faq-category-row').remove()">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </div>
    `;

    $("#faq-category-list").append(newRow);
}

// Crear categoría
function storeFaqCategory(tempId) {
    const row = $(`.faq-category-row[data-temp-id='${tempId}']`);
    const formData = new FormData();

    formData.append("name", row.find(`input[name='faqcat_name_new_${tempId}']`).val());
    formData.append("icon_class", row.find(`input[name='faqcat_icon_new_${tempId}']`).val());
    formData.append("order_num", row.find(`input[name='faqcat_order_new_${tempId}']`).val());
    formData.append("is_active", row.find(`input[name='faqcat_active_new_${tempId}']`).is(":checked") ? 1 : 0);

    axios.post("/faqs/categories", formData)
        .then(res => {
            if (res.data.success) {
                Swal.fire({
                    icon: "success",
                    title: "Guardado",
                    text: res.data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => location.reload());
            }
        })
        .catch(() => {
            Swal.fire("Error", "No se pudo crear la categoría.", "error");
        });
}

// Actualizar categoría
function updateFaqCategory(id) {
    const row = $(`.faq-category-row[data-id='${id}']`);
    const formData = new FormData();

    formData.append("name", row.find(`input[name='faqcat_name_${id}']`).val());
    formData.append("icon_class", row.find(`input[name='faqcat_icon_${id}']`).val());
    formData.append("order_num", row.find(`input[name='faqcat_order_${id}']`).val());
    formData.append("is_active", row.find(`input[name='faqcat_active_${id}']`).is(":checked") ? 1 : 0);

    axios.post(`/faqs/categories/${id}?_method=PUT`, formData)
        .then(res => {
            if (res.data.success) {
                Swal.fire({
                    icon: "success",
                    title: "Actualizado",
                    text: res.data.message,
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        })
        .catch(() => {
            Swal.fire("Error", "No se pudo actualizar la categoría.", "error");
        });
}

// Eliminar categoría
function deleteFaqCategory(id) {
    Swal.fire({
        title: "¿Eliminar esta categoría?",
        text: "Se eliminarán también sus preguntas asociadas.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then(result => {
        if (result.isConfirmed) {
            axios.delete(`/faqs/categories/${id}`)
                .then(res => {
                    if (res.data.success) {
                        Swal.fire({
                            icon: "success",
                            title: "Eliminado",
                            text: res.data.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => location.reload());
                    }
                })
                .catch(() => {
                    Swal.fire("Error", "No se pudo eliminar la categoría.", "error");
                });
        }
    });
}



// ==========================
// PREGUNTAS Y RESPUESTAS
// ==========================

// Agregar nueva pregunta
function addFaqRow() {
    const newId = Date.now();
    let categoryOptions = "";

    $(".faq-category-row[data-id]").each(function() {
        const id = $(this).data("id");
        const name = $(this).find("input[name^='faqcat_name_']").val();
        categoryOptions += `<option value="${id}">${name}</option>`;
    });

    const newRow = `
        <div class="row align-items-start mb-3 border-bottom pb-2 faq-row new" data-temp-id="${newId}">
            <div class="col-sm-3">
                <label>Categoría</label>
                <select name="faq_category_new_${newId}" class="form-control">${categoryOptions}</select>
            </div>
            <div class="col-sm-4">
                <label>Pregunta</label>
                <input type="text" name="faq_question_new_${newId}" class="form-control" placeholder="¿Cuál es el tiempo de entrega?">
            </div>
            <div class="col-sm-4">
                <label>Respuesta</label>
                <textarea name="faq_answer_new_${newId}" class="form-control" rows="2" placeholder="Texto de la respuesta..."></textarea>
            </div>
            <div class="col-sm-1 d-flex flex-column align-items-center">
                <label>Orden</label>
                <input type="number" name="faq_order_new_${newId}" class="form-control" min="0" value="0">
                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" name="faq_active_new_${newId}" checked>
                    <label class="form-check-label">Activo</label>
                </div>
            </div>
            <div class="col-sm-12 d-flex justify-content-end mt-2">
                <button type="button" class="btn btn-sm btn-success mr-1" onclick="storeFaq(${newId})">
                    <i class="fa fa-save"></i>
                </button>
                <button type="button" class="btn btn-sm btn-danger" onclick="$(this).closest('.faq-row').remove()">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </div>
    `;

    $("#faq-list").append(newRow);
}

// Crear pregunta
function storeFaq(tempId) {
    const row = $(`.faq-row[data-temp-id='${tempId}']`);
    const formData = new FormData();

    formData.append("faq_category_id", row.find(`select[name='faq_category_new_${tempId}']`).val());
    formData.append("question", row.find(`input[name='faq_question_new_${tempId}']`).val());
    formData.append("answer", row.find(`textarea[name='faq_answer_new_${tempId}']`).val());
    formData.append("order_num", row.find(`input[name='faq_order_new_${tempId}']`).val());
    formData.append("is_active", row.find(`input[name='faq_active_new_${tempId}']`).is(":checked") ? 1 : 0);

    axios.post("/faqs/questions", formData)
        .then(res => {
            if (res.data.success) {
                Swal.fire({
                    icon: "success",
                    title: "Guardado",
                    text: res.data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => location.reload());
            }
        })
        .catch(() => {
            Swal.fire("Error", "No se pudo crear la pregunta.", "error");
        });
}

// Actualizar pregunta
function updateFaq(id) {
    const row = $(`.faq-row[data-id='${id}']`);
    const formData = new FormData();

    formData.append("question", row.find(`input[name='faq_question_${id}']`).val());
    formData.append("answer", row.find(`textarea[name='faq_answer_${id}']`).val());
    formData.append("order_num", row.find(`input[name='faq_order_${id}']`).val());
    formData.append("is_active", row.find(`input[name='faq_active_${id}']`).is(":checked") ? 1 : 0);

    axios.post(`/faqs/questions/${id}?_method=PUT`, formData)
        .then(res => {
            if (res.data.success) {
                Swal.fire({
                    icon: "success",
                    title: "Actualizado",
                    text: res.data.message,
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        })
        .catch(() => {
            Swal.fire("Error", "No se pudo actualizar la pregunta.", "error");
        });
}

// Eliminar pregunta
function deleteFaq(id) {
    Swal.fire({
        title: "¿Eliminar esta pregunta?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then(result => {
        if (result.isConfirmed) {
            axios.delete(`/faqs/questions/${id}`)
                .then(res => {
                    if (res.data.success) {
                        Swal.fire({
                            icon: "success",
                            title: "Eliminado",
                            text: res.data.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => location.reload());
                    }
                })
                .catch(() => {
                    Swal.fire("Error", "No se pudo eliminar la pregunta.", "error");
                });
        }
    });
}

// ==========================
// PREVISUALIZACIÓN DE ÍCONO
// ==========================
function previewFaqIcon(input) {
    const icon = $(input).val();
    const container = $(input).siblings(".icon-preview");
    container.html(`<i class="${icon}"></i>`);
}
