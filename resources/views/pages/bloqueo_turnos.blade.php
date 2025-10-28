@extends('layouts.template')

@section('cssstyles')
<link rel="stylesheet" href="/template/plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="/template/dist/css/adminlte.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<!-- Datepicker -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<style>
.checkbox-group label {
    display: block;
    padding: 8px 0;
    cursor: pointer;
}

.checkbox-group input[type="checkbox"] {
    margin-right: 8px;
}

.bloqueo-item {
    padding: 15px;
    margin-bottom: 10px;
    background: #f8f9fa;
    border-left: 4px solid #dc3545;
    border-radius: 4px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.bloqueo-item-info {
    flex: 1;
}

.bloqueo-item-info strong {
    color: #333;
    font-size: 1.1rem;
}

.bloqueo-item-info small {
    color: #666;
    font-style: italic;
}

.btn-desbloquear {
    background: #28a745;
    color: white;
    border: none;
    padding: 8px 20px;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-desbloquear:hover {
    background: #218838;
}

.empty-state {
    text-align: center;
    padding: 40px;
    color: #999;
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 15px;
}
</style>
@endsection

@section('body')
<div class="content-wrapper">

    <!-- HEADER -->
    <section class="content-header">
        <div class="container-fluid">
            <h1><i class="fas fa-calendar-times"></i> Gestión de Bloqueo de Turnos</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <!-- FORMULARIO DE BLOQUEO -->
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-ban mr-2"></i>Bloquear Turnos por Fecha</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Fecha -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fecha_bloqueo">
                                    <i class="fas fa-calendar-alt mr-1"></i> Fecha
                                </label>
                                <input type="text" 
                                       id="fecha_bloqueo" 
                                       class="form-control" 
                                       placeholder="Seleccione una fecha"
                                       autocomplete="off">
                            </div>
                        </div>

                        <!-- Turnos -->
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>
                                    <i class="fas fa-clock mr-1"></i> Turnos a bloquear
                                </label>
                                <div class="checkbox-group">
                                    <label>
                                        <input type="checkbox" value="09:00 - 11:00" class="turno-check"> 
                                        <i class="fas fa-sun text-warning"></i> Turno 1: 09:00 - 11:00
                                    </label>
                                    <label>
                                        <input type="checkbox" value="11:00 - 13:00" class="turno-check"> 
                                        <i class="fas fa-sun text-warning"></i> Turno 2: 11:00 - 13:00
                                    </label>
                                    <label>
                                        <input type="checkbox" value="13:00 - 15:00" class="turno-check"> 
                                        <i class="fas fa-cloud-sun text-info"></i> Turno 3: 13:00 - 15:00
                                    </label>
                                    <label>
                                        <input type="checkbox" value="15:00 - 17:00" class="turno-check"> 
                                        <i class="fas fa-cloud-sun text-info"></i> Turno 4: 15:00 - 17:00
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Motivo -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="motivo_bloqueo">
                                    <i class="fas fa-comment-alt mr-1"></i> Motivo (opcional)
                                </label>
                                <input type="text" 
                                       id="motivo_bloqueo" 
                                       class="form-control" 
                                       placeholder="Ej: Feriado, Mantenimiento"
                                       maxlength="255">
                                <small class="text-muted">Máximo 255 caracteres</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button type="button" id="btn_bloquear" class="btn btn-danger btn-lg">
                                <i class="fas fa-ban mr-2"></i> Bloquear Turnos Seleccionados
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- LISTA DE TURNOS BLOQUEADOS -->
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-list mr-2"></i>Turnos Bloqueados Actualmente</h3>
                </div>

                <div class="card-body">
                    <div id="lista_bloqueos">
                        <div class="text-center py-4">
                            <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
                            <p class="mt-2 text-muted">Cargando turnos bloqueados...</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<!-- Scripts base -->
<script src="/template/plugins/jquery/jquery.min.js"></script>
<script src="/template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.es.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.20.0/axios.js"></script>
<script src="/template/dist/js/adminlte.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- JS del módulo de Bloqueo de Turnos -->
<script src="/template/dist/js/page_bloqueo_turnos.js"></script>

@endsection