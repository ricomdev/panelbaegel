// ==========================
// CSRF para Axios
// ==========================
axios.defaults.headers.common['X-CSRF-TOKEN'] =
  document.querySelector('meta[name="csrf-token"]').getAttribute('content');

let pendingFiles = []; // Acumula imágenes nuevas

// ==========================
// Validar código único (blur)
// ==========================
const inputCode = document.getElementById("code");
if (inputCode) {
  inputCode.addEventListener("blur", function () {
    const code = this.value.trim();
    if (!code) return;

    axios.get(`/product/brunch/check-code/${code}`)
      .then(res => {
        if (res.data.exists) {
          Swal.fire({
            icon: "warning",
            text: "El código ingresado ya está en uso. Por favor, elige otro.",
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
// Cargar datos (solo en editar)
// ==========================
if (document.getElementById('code_product')) {
  function dataproduct() {
    const codigo = document.getElementById('code_product').value;

    axios.get("/dataproduct/brunch/" + codigo).then(response => {
      const data = response.data || {};

      // Campos básicos
      if (document.getElementById("subcategory_id"))
        document.getElementById("subcategory_id").value = data.subcategory_id ?? "";
      if (document.getElementById("type"))
        document.getElementById("type").value = data.type ?? "bb3b1s";
      if (document.getElementById("code"))
        document.getElementById("code").value = data.code ?? "";
      if (document.getElementById("short_name"))
        document.getElementById("short_name").value = data.short_name ?? "";
      if (document.getElementById("name"))
        document.getElementById("name").value = data.name ?? "";
      if (document.getElementById("content"))
        document.getElementById("content").value = data.content ?? "";
      if (document.getElementById("description"))
        document.getElementById("description").value = data.description ?? "";
      if (document.getElementById("description_002"))
        document.getElementById("description_002").value = data.description_002 ?? "";
      if (document.getElementById("price"))
        document.getElementById("price").value = data.price ?? 0;
      if (document.getElementById("is_active"))
        document.getElementById("is_active").checked = (data.is_active == 1);
      if (document.getElementById("qty_bagel"))
        document.getElementById("qty_bagel").value = data.qty_bagel ?? 0;
      if (document.getElementById("qty_spreads"))
        document.getElementById("qty_spreads").value = data.qty_spreads ?? 0;

      // Imágenes
      const container = document.getElementById("sortable-images");
      if (!container) return;

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
// SortableJS
// ==========================
function initSortable() {
  const el = document.getElementById("sortable-images");
  if (typeof Sortable !== "undefined" && el) {
    Sortable.create(el, {
      animation: 150,
      handle: 'img',
      ghostClass: 'bg-light',
      onEnd: updateBadges
    });
  }
}

// ==========================
// Actualizar badges
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
          axios.delete(`/product/brunch/image/${id}`)
            .then(res => {
              if (res.data.success) {
                Swal.fire({ icon: "success", text: "Imagen eliminada" });
                if (typeof dataproduct === 'function') dataproduct();
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
// Previsualización de imágenes nuevas
// ==========================
const inputImages = document.getElementById("images");
if (inputImages) {
  inputImages.addEventListener("change", e => {
    const container = document.getElementById("sortable-images");
    if (!container) return;

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
// Actualizar producto (editar)
// ==========================
function product_update(e) {
  e.preventDefault();

  const existingImages = document.querySelectorAll('#sortable-images .image-item').length;
  const newImages = pendingFiles.length;
  if (existingImages + newImages === 0) {
    return Swal.fire({ icon: 'warning', text: 'Debes subir al menos una imagen antes de actualizar.' });
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
    datos.append("subcategory_id", (document.getElementById("subcategory_id")?.value ?? ""));
    datos.append("type", (document.getElementById("type")?.value ?? ""));
    datos.append("code", (document.getElementById("code")?.value ?? ""));
    datos.append("short_name", (document.getElementById("short_name")?.value ?? ""));
    datos.append("name", (document.getElementById("name")?.value ?? ""));
    datos.append("content", (document.getElementById("content")?.value ?? ""));
    datos.append("description", (document.getElementById("description")?.value ?? ""));
    datos.append("description_002", (document.getElementById("description_002")?.value ?? ""));
    datos.append("price", (document.getElementById("price")?.value ?? 0));
    datos.append("is_active", document.getElementById("is_active")?.checked ? 1 : 0);
    datos.append("qty_bagel", (document.getElementById("qty_bagel")?.value ?? 0));
    datos.append("qty_spreads", (document.getElementById("qty_spreads")?.value ?? 0));

    // Orden de imágenes (existentes + nuevas en DOM)
    document.querySelectorAll('#sortable-images .image-item').forEach((el, index) => {
      datos.append(`order[${el.dataset.id}]`, index);
    });

    // Nuevas imágenes
    pendingFiles.forEach(file => datos.append("images[]", file));

    axios.post('/updateproduct/brunch/' + codigo_antiguo, datos)
      .then(response => {
        if (response.data === 1) {
          Swal.fire({ text: "Los datos se actualizaron correctamente!", icon: "success" })
            .then(() => location.href = "/product/brunch/edit/" + document.getElementById("code").value);
          pendingFiles = [];
        } else {
          Swal.fire({ text: "No se realizó la actualización correctamente!", icon: "error" });
        }
        const newCode = document.getElementById("code").value;
        if (newCode && document.getElementById('code_product')) {
          document.getElementById('code_product').value = newCode;
        }
        if (typeof dataproduct === 'function') dataproduct();
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
  });
}

// ==========================
// Crear producto (create)
// ==========================
async function product_store(e) {
  e.preventDefault();

  const btn = document.getElementById("btn-save");
  const btnText = btn.querySelector(".btn-text");
  const btnSpinner = btn.querySelector(".btn-spinner");

  const subcategory = (document.getElementById("subcategory_id")?.value ?? "").trim();
  const type = (document.getElementById("type")?.value ?? "").trim();
  const code = (document.getElementById("code")?.value ?? "").trim();
  const shortName = (document.getElementById("short_name")?.value ?? "").trim();
  const name = (document.getElementById("name")?.value ?? "").trim();
  const desc1 = (document.getElementById("description")?.value ?? "").trim();
  const desc2 = (document.getElementById("description_002")?.value ?? "").trim();
  const price = (document.getElementById("price")?.value ?? "").trim();
  const qtyBagel = (document.getElementById("qty_bagel")?.value ?? "").trim();
  const qtySpreads = (document.getElementById("qty_spreads")?.value ?? "").trim();
  const totalImages = document.querySelectorAll('#sortable-images .image-item').length + pendingFiles.length;

  if (!subcategory) return Swal.fire({ icon: "warning", text: "Seleccione una subcategoría" });
  if (!type) return Swal.fire({ icon: "warning", text: "Seleccione el tipo (bb3b1s o bb6b2s)" });
  if (!code) return Swal.fire({ icon: "warning", text: "Ingrese un código" });
  if (!shortName) return Swal.fire({ icon: "warning", text: "El campo 'Nombre Info' es obligatorio" });
  if (!name) return Swal.fire({ icon: "warning", text: "Ingrese el nombre del producto" });
  if (!qtyBagel || Number(qtyBagel) <= 0) return Swal.fire({ icon: "warning", text: "Ingrese la cantidad de bagels" });
  if (!qtySpreads || Number(qtySpreads) <= 0) return Swal.fire({ icon: "warning", text: "Ingrese la cantidad de spreads" });
  if (!price || Number(price) <= 0) return Swal.fire({ icon: "warning", text: "Ingrese un precio válido" });
  if (totalImages === 0) return Swal.fire({ icon: "warning", text: "Debe subir al menos una imagen" });

  // Validar código único
  try {
    const res = await axios.get(`/product/brunch/check-code/${code}`);
    if (res.data.exists) {
      Swal.fire({ icon: "error", text: "El código ingresado ya existe. Por favor elige otro." });
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
    datos.append("type", type);
    datos.append("code", code);
    datos.append("short_name", shortName);
    datos.append("name", name);
    datos.append("description", desc1);
    datos.append("description_002", desc2);
    datos.append("price", price);
    datos.append("is_active", document.getElementById("is_active")?.checked ? 1 : 0);
    datos.append("qty_bagel", qtyBagel);
    datos.append("qty_spreads", qtySpreads);

    pendingFiles.forEach(file => datos.append("images[]", file));

    axios.post('/product/brunch/store', datos)
      .then(res => {
        if (res.data === 1 || res.data.success) {
          Swal.fire({ icon: "success", text: "Producto creado correctamente" })
            .then(() => location.href = `/product/brunch/edit/${code}`);
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
        btnText.innerHTML = '<i class="fa fa-save mr-2"></i> Crear Producto Brunch Box';
        btnSpinner.style.display = "none";
      });
  });
}
