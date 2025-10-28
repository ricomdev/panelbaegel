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
            <h1>Gestión de Sección “Our Story”</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            @foreach($blocks as $block)
            <div class="card card-warning mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Bloque {{ $block->order }} - {{ $block->title }}</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Título -->
                        <div class="col-sm-6">
                            <label>Título / Año</label>
                            <input type="text" id="title_{{ $block->id }}" class="form-control" value="{{ $block->title }}">
                        </div>

                        <!-- Posición -->
                        <div class="col-sm-3">
                            <label>Posición (solo desktop)</label>
                            <select id="position_{{ $block->id }}" class="form-control">
                                <option value="left" {{ $block->position == 'left' ? 'selected' : '' }}>Izquierda</option>
                                <option value="right" {{ $block->position == 'right' ? 'selected' : '' }}>Derecha</option>
                            </select>
                        </div>

                        <!-- Orden -->
                        <div class="col-sm-3">
                            <label>Orden</label>
                            <input type="number" id="order_{{ $block->id }}" value="{{ $block->order }}" class="form-control">
                        </div>

                        <!-- Texto Desktop -->
                        <div class="col-sm-6 mt-3">
                            <label>Texto para Desktop</label>
                            <textarea id="text_desktop_{{ $block->id }}" rows="4" class="form-control" placeholder="Texto visible en versión Desktop...">{{ $block->text_desktop }}</textarea>
                        </div>

                        <!-- Texto Mobile -->
                        <div class="col-sm-6 mt-3">
                            <label>Texto para Mobile</label>
                            <textarea id="text_mobile_{{ $block->id }}" rows="4" class="form-control" placeholder="Texto visible en versión Mobile...">{{ $block->text_mobile }}</textarea>
                        </div>

                        <!-- Imagen -->
                        <div class="col-sm-6 mt-3">
                            <label>Imagen 1000 x 1000 px (zona segura a los costados de 50px)</label>
                            <input type="file" id="image_{{ $block->id }}" class="form-control" accept="image/*">
                            @if($block->image_path)
                                <img src="{{ $block->image_path }}" class="mt-2 rounded" width="140">
                            @endif
                        </div>

                        <!-- Estado -->
                        <div class="col-sm-6 mt-3 d-flex align-items-end">
                            <div class="form-check">
                                <input type="checkbox" id="is_active_{{ $block->id }}" class="form-check-input" {{ $block->is_active ? 'checked' : '' }}>
                                <label class="form-check-label">Activo</label>
                            </div>
                        </div>

                        <!-- Botón Guardar -->
                        <div class="col-md-4 mx-auto mt-4">
                            <button type="button" class="btn btn-primary btn-block" onclick="updateBlock({{ $block->id }})">
                                <i class="fa fa-save mr-1"></i> Guardar cambios
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </section>
</div>

<!-- JS base -->
<script src="/template/plugins/jquery/jquery.min.js"></script>
<script src="/template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/template/dist/js/adminlte.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- JS de la página Footer -->
<script src="/template/dist/js/page_home_story_blocks.js"></script>

@endsection
