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
            <h1>Gestión de Términos y Condiciones</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <!-- TEXTO GENERAL -->
            <div class="card card-warning" id="terms-general-text">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Texto General de Términos y Condiciones</h3>
                    <button type="button" class="btn btn-sm btn-primary" onclick="updateTermsGeneral({{ $generalText->id }})">
                        <i class="fa fa-save mr-1"></i> Guardar cambios
                    </button>
                </div>
                <div class="card-body" data-id="{{ $generalText->id }}">
                    <div class="form-group">
                        <label>Contenido del texto general:</label>
                        <textarea name="terms_general_content_{{ $generalText->id }}" class="form-control" rows="6">{{ $generalText->content }}</textarea>
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" name="terms_general_active_{{ $generalText->id }}" {{ $generalText->is_active ? 'checked' : '' }}>
                        <label class="form-check-label">Activo</label>
                    </div>
                </div>
            </div>


            <!-- SECCIONES DE TÉRMINOS -->
            <div class="card card-warning">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Secciones de Términos y Condiciones</h3>
                    <button type="button" class="btn btn-sm btn-success" onclick="addTermsRow()">
                        <i class="fa fa-plus mr-1"></i> Nueva Sección
                    </button>
                </div>

                <div class="card-body" id="terms-list">
                    @foreach($terms->sortBy('order_num') as $term)
                    <div class="row align-items-start mb-3 border-bottom pb-2 term-row" data-id="{{ $term->id }}">
                        <div class="col-sm-4">
                            <label>Título</label>
                            <input type="text" name="term_title_{{ $term->id }}" value="{{ $term->title }}" class="form-control" placeholder="Ej: Información General">
                        </div>
                        <div class="col-sm-6">
                            <label>Contenido</label>
                            <textarea name="term_content_{{ $term->id }}" class="form-control" rows="4" placeholder="Contenido de la sección...">{{ $term->content }}</textarea>
                        </div>
                        <div class="col-sm-1">
                            <label>Orden</label>
                            <input type="number" name="term_order_{{ $term->id }}" value="{{ $term->order_num }}" class="form-control" min="0">
                        </div>
                        <div class="col-sm-1 d-flex align-items-center mt-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="term_active_{{ $term->id }}" {{ $term->is_active ? 'checked' : '' }}>
                                <label class="form-check-label">Activo</label>
                            </div>
                        </div>
                        <div class="col-sm-12 d-flex justify-content-end mt-2">
                            <button type="button" class="btn btn-sm btn-primary mr-1" onclick="updateTerm({{ $term->id }})">
                                <i class="fa fa-save"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteTerm({{ $term->id }})">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </section>
</div>

<!-- Scripts base -->
<script src="/template/plugins/jquery/jquery.min.js"></script>
<script src="/template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/template/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.20.0/axios.js"></script>
<script src="/template/dist/js/adminlte.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- JS del módulo de Términos -->
<script src="/template/dist/js/page_termsconditions.js"></script>

<script>
$(function(){ bsCustomFileInput.init(); });
</script>
@endsection
