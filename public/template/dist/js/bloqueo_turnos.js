// ====================================
// PANEL DE BLOQUEO DE TURNOS
// ====================================

// Configurar Axios con CSRF token
axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]')?.content;

$(function() {
    // Inicializar datepicker con navegación completa
    $('#fecha_bloqueo').datepicker({
        language: 'es',
        format: 'dd/mm/yyyy',
        autoclose: true,
        startDate: new Date(),
        todayHighlight: true,
        orientation: 'bottom auto',
        showOnFocus: true,
        // Habilitar navegación de mes/año
        calendarWeeks: false,
        clearBtn: true,
        disableTouchKeyboard: false,
        enableOnReadonly: true,
        // Mostrar botones de navegación
        templates: {
            leftArrow: '<i class="fas fa-chevron-left"></i>',
            rightArrow: '<i class="fas fa-chevron-right"></i>'
        }
    });

    // Cargar turnos bloqueados al iniciar
    cargarBloqueos();

    // Evento: Bloquear turnos
    $('#btn_bloquear').on('click', bloquearTurnos);

    // Evento delegado: Desbloquear turno
    $(document).on('click', '.btn-desbloquear', function() {
        const id = $(this).data('id');
        desbloquearTurno(id);
    });
});

/**
 * Bloquear turnos seleccionados
 */
async function bloquearTurnos() {
    const fecha = $('#fecha_bloqueo').val();
    const turnosSeleccionados = [];
    
    $('.turno-check:checked').each(function() {
        turnosSeleccionados.push($(this).val());
    });
    
    // Validaciones
    if (!fecha) {
        Swal.fire('Error', 'Por favor selecciona una fecha', 'error');
        return;
    }
    
    if (turnosSeleccionados.length === 0) {
        Swal.fire('Error', 'Por favor selecciona al menos un turno', 'error');
        return;
    }
    
    try {
        const response = await axios.post('/bloqueo-turnos/guardar', {
            fecha: fecha,
            turnos: turnosSeleccionados
        });
        
        if (response.data.success) {
            Swal.fire('Éxito', response.data.message, 'success');
            
            // Limpiar formulario
            $('#fecha_bloqueo').val('');
            $('.turno-check').prop('checked', false);
            
            // Recargar lista
            cargarBloqueos();
        } else {
            Swal.fire('Error', response.data.message, 'error');
        }
        
    } catch (error) {
        const message = error.response?.data?.message || 'No se pudo guardar el bloqueo';
        Swal.fire('Error', message, 'error');
    }
}

/**
 * Cargar lista de turnos bloqueados
 */
async function cargarBloqueos() {
    try {
        const response = await axios.get('/bloqueo-turnos/listar');
        
        if (response.data.success) {
            let html = '';
            
            if (response.data.bloqueos.length === 0) {
                html = `
                    <div class="empty-state">
                        <i class="fas fa-calendar-check fa-3x mb-3"></i>
                        <p>No hay turnos bloqueados</p>
                    </div>
                `;
            } else {
                response.data.bloqueos.forEach(function(bloqueo) {
                    html += `
                        <div class="bloqueo-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>${bloqueo.fecha_legible}</strong> - ${bloqueo.turno}
                            </div>
                            <button class="btn btn-sm btn-success btn-desbloquear" data-id="${bloqueo.id}">
                                <i class="fas fa-unlock mr-1"></i> Desbloquear
                            </button>
                            </div>
                        </div>
                    `;
                });
            }
            
            $('#lista_bloqueos').html(html);
        }
        
    } catch (error) {
        $('#lista_bloqueos').html('<div class="alert alert-danger">Error al cargar los turnos bloqueados</div>');
    }
}

/**
 * Desbloquear un turno específico
 */
async function desbloquearTurno(id) {
    const result = await Swal.fire({
        title: '¿Desbloquear este turno?',
        text: 'Esta acción eliminará el bloqueo permanentemente',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, desbloquear',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d'
    });
    
    if (result.isConfirmed) {
        try {
            const response = await axios.delete(`/bloqueo-turnos/eliminar/${id}`);
            
            if (response.data.success) {
                Swal.fire('Éxito', response.data.message, 'success');
                cargarBloqueos();
            } else {
                Swal.fire('Error', response.data.message, 'error');
            }
            
        } catch (error) {
            Swal.fire('Error', 'No se pudo desbloquear el turno', 'error');
        }
    }
}