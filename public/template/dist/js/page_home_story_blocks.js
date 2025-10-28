// ==========================
// INICIALIZACIÓN BÁSICA
// ==========================
document.addEventListener("DOMContentLoaded", () => {
    // Inicializar plugin de inputs de archivo
    if (window.bsCustomFileInput) bsCustomFileInput.init();

    // Configurar token CSRF para Axios
    const token = document.querySelector('meta[name="csrf-token"]');
    if (token) {
        axios.defaults.headers.common["X-CSRF-TOKEN"] = token.getAttribute("content");
    }
});

// ==========================
// ACTUALIZAR BLOQUE DE HISTORIA
// ==========================
function updateBlock(id) {
    const formData = new FormData();
    formData.append('title', $(`#title_${id}`).val());
    formData.append('text_desktop', $(`#text_desktop_${id}`).val());
    formData.append('text_mobile', $(`#text_mobile_${id}`).val());
    formData.append('position', $(`#position_${id}`).val());
    formData.append('order', $(`#order_${id}`).val());
    formData.append('is_active', $(`#is_active_${id}`).is(':checked') ? 1 : 0);

    const file = document.getElementById(`image_${id}`).files[0];
    if (file) formData.append('image', file);

    axios.post(`/home-story-blocks/update/${id}`, formData)
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
            Swal.fire('Error', 'No se pudo actualizar el bloque.', 'error');
        });
}

// ==========================
// PREVISUALIZACIÓN DE IMAGEN
// ==========================
document.addEventListener("change", function (e) {
    if (e.target.matches('input[type="file"][id^="image_"]')) {
        const input = e.target;
        const file = input.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (ev) {
            const preview = $(input).siblings("img");
            if (preview.length > 0) {
                preview.attr("src", ev.target.result);
            } else {
                $(input).after(`<img src="${ev.target.result}" class="mt-2 rounded" width="140">`);
            }
        };
        reader.readAsDataURL(file);
    }
});
