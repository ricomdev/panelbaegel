document.addEventListener("DOMContentLoaded", () => {
    if (window.bsCustomFileInput) bsCustomFileInput.init();

    const token = document.querySelector('meta[name="csrf-token"]');
    if (token) axios.defaults.headers.common["X-CSRF-TOKEN"] = token.getAttribute("content");
});

// ==========================
// AGREGAR / ELIMINAR ÍTEMS DE LISTA
// ==========================
function addListItem() {
    const html = `
        <div class="row align-items-center mb-2 list-item-row">
            <div class="col-sm-10">
                <input type="text" class="form-control list-item-input" placeholder="Nuevo ítem...">
            </div>
            <div class="col-sm-2 d-flex justify-content-end">
                <button type="button" class="btn btn-sm btn-danger" onclick="removeListItem(this)">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </div>`;
    $('#list-items-container').append(html);
}

function removeListItem(btn) {
    $(btn).closest('.list-item-row').remove();
}

// ==========================
// ACTUALIZAR INFORMACIÓN DE CATERING
// ==========================
function updateCatering() {
    const listItems = [];
    $('.list-item-input').each(function () {
        const val = $(this).val().trim();
        if (val) listItems.push(val);
    });

    const formData = new FormData();
    formData.append('title', $('#title').val());
    formData.append('subtitle', $('#subtitle').val());
    formData.append('block_title', $('#block_title').val());
    formData.append('block_paragraph', $('#block_paragraph').val());
    formData.append('block_highlight', $('#block_highlight').val());
    formData.append('list_title', $('#list_title').val());
    formData.append('disclaimer', $('#disclaimer').val());
    formData.append('list_items', JSON.stringify(listItems));

    const file = $('#feature_image_path')[0].files[0];
    if (file) formData.append('feature_image_path', file);

    axios.post('/catering/update', formData)
        .then(res => {
            if (res.data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Guardado correctamente',
                    text: res.data.message,
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire('Error', 'No se pudo actualizar la información del catering.', 'error');
        });
}

// ==========================
// PREVISUALIZACIÓN DE IMAGEN
// ==========================
document.addEventListener("change", function (e) {
    if (e.target.matches('#feature_image_path')) {
        const input = e.target;
        const file = input.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (ev) {
            const preview = $(input).siblings("img");
            if (preview.length > 0) {
                preview.attr("src", ev.target.result);
            } else {
                $(input).after(`<img src="${ev.target.result}" class="mt-2 rounded" width="120">`);
            }
        };
        reader.readAsDataURL(file);
    }
});
