axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;

function deleteDistrict(id){
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esto eliminará el distrito permanentemente.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if(result.isConfirmed){
            axios.delete(`/districts/${id}`)
            .then(()=>{
                Swal.fire('Eliminado','El distrito fue eliminado correctamente','success')
                .then(()=>location.reload());
            })
            .catch(()=>{
                Swal.fire('Error','No se pudo eliminar el distrito','error');
            });
        }
    });
}


function delivery_update(e){
    e.preventDefault();

    const btn = e.currentTarget;
    btn.disabled = true;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin mr-2"></i>Actualizando...';

    const data = {
        id: document.getElementById('distrito_id').value,
        name: document.getElementById('nombre').value.trim(),
        province_id: document.getElementById('provincia').value,
        price: document.getElementById('precio').value || null,
        delivery: document.getElementById('delivery').value
    };

    if(!data.name || !data.province_id){
        Swal.fire('Campos incompletos', 'Debes completar al menos nombre y provincia.', 'warning');
        btn.disabled = false;
        btn.innerHTML = originalText;
        return;
    }

    axios.post(`/districts/update/${data.id}`, data)
    .then(res=>{
        Swal.fire('Actualizado', 'El distrito fue actualizado correctamente', 'success')
        .then(() => {
                      // Redirige al index
                      window.location.href = "/districts";
                  });
    })
    .catch(err=>{
        console.error(err);
        Swal.fire('Error', 'No se pudo actualizar el distrito', 'error');
    })
    .finally(()=>{
        btn.disabled = false;
        btn.innerHTML = originalText;
    });  
  }

  function delivery_create(e){
      e.preventDefault();

      const btn = e.currentTarget;
      btn.disabled = true;
      const originalText = btn.innerHTML;
      btn.innerHTML = '<i class="fa fa-spinner fa-spin mr-2"></i>Guardando...';

      const form  = document.getElementById('formDistritoCreate');
      const url   = form.getAttribute('data-action');

      const payload = {
          name:        document.getElementById('nombre').value.trim(),
          province_id: document.getElementById('provincia').value,
          delivery:    document.getElementById('delivery').value,
          price:       document.getElementById('precio').value || null
      };

      // Validaciones simples
      if (!payload.name || !payload.province_id){
          Swal.fire('Campos incompletos', 'Debes completar nombre y provincia.', 'warning');
          btn.disabled = false;
          btn.innerHTML = originalText;
          return;
      }

      axios.post(url, payload)
          .then(res => {
              Swal.fire('Creado', 'El distrito fue creado correctamente.', 'success')
                  .then(() => {
                      // Redirige al index
                      window.location.href = "/districts";
                  });
          })
          .catch(err => {
              console.error(err);
              let msg = 'Ocurrió un error al crear el distrito.';
              if (err.response && err.response.data && err.response.data.message) {
                  msg = err.response.data.message;
              }
              Swal.fire('Error', msg, 'error');
          })
          .finally(() => {
              btn.disabled = false;
              btn.innerHTML = originalText;
          });
  }