@extends('layouts.template')

@section('cssstyles')
<link rel="stylesheet" href="/template/plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="/template/dist/css/adminlte.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<style>
.bloqueo-item {
    padding: 12px 15px;
    margin-bottom: 8px;
    background: #fff;
    border: 1px solid #dee2e6;
    border-left: 3px solid #dc3545;
    border-radius: 3px;
}

.bloqueo-item:hover {
    background: #f8f9fa;
}

.empty-state {
    text-align: center;
    padding: 40px;
    color: #6c757d;
}
</style>
@endsection

@section('body')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Gestión de Bloqueo de Turnos</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <!-- FORMULARIO PARA BLOQUEAR TURNOS -->
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Bloquear Turnos</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Fecha</label>
                            <input type="text" 
                                   id="fecha_bloqueo" 
                                   class="form-control" 
                                   placeholder="DD/MM/AAAA"
                                   autocomplete="off" 
                                   required>
                        </div>
                        <div class="col-md-9">
                            <label>Turnos a Bloquear</label>
                            <div class="form-group mb-0">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input turno-check" type="checkbox" value="09:00 - 11:00" id="turno1">
                                    <label class="form-check-label" for="turno1">09:00 - 11:00</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input turno-check" type="checkbox" value="11:00 - 13:00" id="turno2">
                                    <label class="form-check-label" for="turno2">11:00 - 13:00</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input turno-check" type="checkbox" value="13:00 - 15:00" id="turno3">
                                    <label class="form-check-label" for="turno3">13:00 - 15:00</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input turno-check" type="checkbox" value="15:00 - 17:00" id="turno4">
                                    <label class="form-check-label" for="turno4">15:00 - 17:00</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <button type="button" id="btn_bloquear" class="btn btn-danger">
                                <i class="fas fa-ban mr-1"></i> Bloquear Turnos Seleccionados
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- LISTA DE TURNOS BLOQUEADOS -->
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Turnos Bloqueados</h3>
                </div>
                <div class="card-body">
                    <div id="lista_bloqueos">
                        <div class="text-center py-3">
                            <i class="fas fa-spinner fa-spin"></i> Cargando...
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<script src="/template/plugins/jquery/jquery.min.js"></script>
<script src="/template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/template/dist/js/adminlte.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.es.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- JavaScript separado -->
<script src="/template/dist/js/bloqueo_turnos.js"></script>

@endsection