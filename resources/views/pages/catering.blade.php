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
            <h1>Gestión de Sección Catering</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <!-- SECCIÓN CATERING -->
            <div class="card card-warning">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Gestión de Contenido - Catering</h3>
                </div>

                <div class="card-body">
                    <div class="row">

                        <!-- Title -->
                        <div class="col-sm-6">
                            <label>Título (Etiqueta superior)</label>
                            <input type="text" id="title" value="{{ $catering->title ?? '' }}" class="form-control" placeholder="Ej: Catering">
                        </div>

                        <!-- Subtitle -->
                        <div class="col-sm-6">
                            <label>Subtítulo principal</label>
                            <input type="text" id="subtitle" value="{{ $catering->subtitle ?? '' }}" class="form-control" placeholder="Ej: Disfruta la experiencia BAEGEL en tu evento">
                        </div>

                        <!-- Bloque principal -->
                        <div class="col-sm-6 mt-3">
                            <label>Título del bloque</label>
                            <input type="text" id="block_title" value="{{ $catering->block_title ?? '' }}" class="form-control" placeholder="¿Tienes una reunión, brunch, cumpleaños...?">
                        </div>

                        <div class="col-sm-6 mt-3">
                            <label>Texto descriptivo del bloque</label>
                            <textarea id="block_paragraph" class="form-control" rows="3" placeholder="Texto descriptivo del bloque...">{{ $catering->block_paragraph ?? '' }}</textarea>
                        </div>

                        <div class="col-sm-6 mt-3">
                            <label>Texto destacado (highlight)</label>
                            <input type="text" id="block_highlight" value="{{ $catering->block_highlight ?? '' }}" class="form-control" placeholder="Spoiler: todos van a querer repetir.">
                        </div>

                        <!-- Imagen -->
                        <div class="col-sm-6 mt-3">
                            <label>Imagen / Ícono principal</label>
                            <input type="file" id="feature_image_path" class="form-control" accept="image/*">
                            @if(!empty($catering->feature_image_path))
                                <img src="{{ $catering->feature_image_path }}" class="mt-2 rounded" width="120">
                            @endif
                        </div>

                        <!-- Lista -->
                        <div class="col-sm-12 mt-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-2">Listado de puntos (elementos)</h5>
                                <button type="button" class="btn btn-sm btn-success" onclick="addListItem()">
                                    <i class="fa fa-plus mr-1"></i> Nuevo ítem
                                </button>
                            </div>

                            <label>Título del listado</label>
                            <input type="text" id="list_title" value="{{ $catering->list_title ?? '' }}" class="form-control mb-3" placeholder="Ej: Cuéntanos todo sobre tu evento...">

                            <div id="list-items-container" class="mt-2">
                                @if(!empty($catering->list_items))
                                    @foreach($catering->list_items as $index => $item)
                                        <div class="row align-items-center mb-2 list-item-row">
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control list-item-input" value="{{ $item }}">
                                            </div>
                                            <div class="col-sm-2 d-flex justify-content-end">
                                                <button type="button" class="btn btn-sm btn-danger" onclick="removeListItem(this)">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <!-- Disclaimer -->
                        <div class="col-sm-6 mt-4">
                            <label>Nota o Disclaimer</label>
                            <input type="text" id="disclaimer" value="{{ $catering->disclaimer ?? '' }}" class="form-control" placeholder="*Sugerimos mínimo 1 semana de anticipación.">
                        </div>

                        <!-- Guardar -->
                        <div class="col-md-4 mx-auto mt-4">
                            <button type="button" class="btn btn-primary btn-block" onclick="updateCatering()">
                                <i class="fa fa-save mr-1"></i> Guardar cambios
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

</div>

<!-- SCRIPTS BASE -->
<script src="/template/plugins/jquery/jquery.min.js"></script>
<script src="/template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/template/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.20.0/axios.js"></script>
<script src="/template/dist/js/adminlte.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- JS de la página Footer -->
<script src="/template/dist/js/page_catering.js"></script>
@endsection
