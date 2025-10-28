@extends('layouts.template')

@section('cssstyles')
<link rel="stylesheet" href="/template/plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="/template/dist/css/adminlte.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endsection

@section('body')
<div class="content-wrapper">

    <!-- HEADER -->
    <section class="content-header">
        <div class="container-fluid">
            <h1>Mailing</h1>
        </div>
    </section>

    <!-- CONTENIDO PRINCIPAL -->
    <section class="content">
        <div class="container-fluid">

            <div class="card card-warning mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Imagen de Cabecera</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Subir Imagen -->
                        <div class="col-sm-6 mt-2">
                            <label for="image" class="fw-bold">Imagen 600 x 508 px (debe ser PNG)</label>
                            <input type="file" id="image" class="form-control" accept="image/*">
                        </div>

                        <!-- Vista Previa -->
                        <div class="col-sm-6 mt-2">
                            <label class="fw-bold">Vista Previa Actual</label>
                            <div id="preview-container" class="mt-2">
                                @if($header && $header->value)
                                    <img src="{{ $header->value }}" alt="Vista previa"
                                         class="rounded border shadow-sm"
                                         style="max-width: 100%; width: 300px; height: auto;">
                                @else
                                    <p class="text-muted">Aún no hay imagen configurada.</p>
                                @endif
                            </div>
                        </div>

                        <!-- Botón Guardar -->
                        <div class="col-md-4 mx-auto mt-4">
                            <button type="button" class="btn btn-primary btn-block" onclick="updateMailingHeader()">
                                <i class="fa fa-save mr-1"></i> Guardar cambios
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<!-- JS base -->
<script src="/template/plugins/jquery/jquery.min.js"></script>
<script src="/template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/template/dist/js/adminlte.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- JS específico de esta página -->
<script src="/template/dist/js/page_mailing.js"></script>
@endsection
