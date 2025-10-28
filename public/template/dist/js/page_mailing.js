// ==========================
// INICIALIZACIÓN
// ==========================
document.addEventListener("DOMContentLoaded", () => {
  console.log("[mailing_header] DOM listo");

  // CSRF para Axios
  const token = document.querySelector('meta[name="csrf-token"]');
  if (token) {
    axios.defaults.headers.common["X-CSRF-TOKEN"] = token.getAttribute("content");
    console.log("[mailing_header] CSRF token configurado");
  } else {
    console.warn("[mailing_header] No se encontró meta csrf-token");
  }
});

// ==========================
// VISTA PREVIA (DELEGACIÓN)
// ==========================
document.addEventListener("change", function (e) {
  if (!e.target) return;

  // Acepta #image o name="image" por si cambia el id en el futuro
  const isImageInput =
    e.target.matches("#image") || (e.target.name && e.target.name === "image");

  if (!isImageInput) return;

  const input = e.target;
  const file = input.files && input.files[0];

  console.log("[mailing_header] change en input file", input.id || input.name, file);

  if (!file) return;

  // Validaciones básicas opcionales (tamaño 2MB, tipos)
  const validTypes = ["image/jpeg", "image/png", "image/webp", "image/jpg"];
  if (!validTypes.includes(file.type)) {
    Swal.fire("Formato no válido", "Usa JPG, PNG o WEBP.", "warning");
    input.value = "";
    return;
  }
  if (file.size > 2 * 1024 * 1024) {
    Swal.fire("Archivo muy grande", "Máximo 2MB.", "warning");
    input.value = "";
    return;
  }

  const reader = new FileReader();
  reader.onload = function (ev) {
    const preview = document.getElementById("preview-container");
    if (!preview) {
      console.error("[mailing_header] No existe #preview-container en el DOM");
      return;
    }
    preview.innerHTML = `
      <img src="${ev.target.result}"
           alt="Vista previa"
           class="rounded border shadow-sm"
           style="max-width:100%; width:300px; height:auto;">
    `;
    console.log("[mailing_header] Vista previa actualizada");
  };
  reader.onerror = function (err) {
    console.error("[mailing_header] Error FileReader:", err);
    Swal.fire("Error", "No se pudo leer el archivo seleccionado.", "error");
  };

  reader.readAsDataURL(file);
});

// ==========================
// GUARDAR IMAGEN
// ==========================
function updateMailingHeader() {
  const input = document.getElementById("image");
  if (!input) {
    console.error("[mailing_header] No se encontró el input #image");
    Swal.fire("Error", "No se encontró el campo de imagen en la página.", "error");
    return;
  }

  const file = input.files && input.files[0];
  if (!file) {
    Swal.fire("Sin archivo", "Selecciona una imagen antes de guardar.", "warning");
    return;
  }

  const formData = new FormData();
  formData.append("image", file);

  console.log("[mailing_header] Enviando imagen al servidor...");

  axios.post("/mailing-settings/update", formData, {
    headers: { "Content-Type": "multipart/form-data" },
  })
  .then((res) => {
    console.log("[mailing_header] Respuesta servidor:", res.data);
    if (res.data && res.data.success) {
      Swal.fire({
        icon: "success",
        title: "Imagen actualizada",
        text: res.data.message || "Se guardó correctamente.",
        timer: 1600,
        showConfirmButton: false,
      });
      setTimeout(() => window.location.reload(), 1200);
    } else {
      Swal.fire("Error", res.data.message || "No se pudo guardar.", "error");
    }
  })
  .catch((err) => {
    console.error("[mailing_header] Error al subir:", err);
    Swal.fire("Error", "Ocurrió un problema al subir la imagen.", "error");
  });
}
