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
            <h1>Gestión de Políticas de Privacidad</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <!-- TEXTO GENERAL -->
            <div class="card card-warning" id="privacy-general-text">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Texto General de Políticas de Privacidad</h3>
                    <button type="button" class="btn btn-sm btn-primary" onclick="updatePrivacyGeneral({{ $generalText->id }})">
                        <i class="fa fa-save mr-1"></i> Guardar cambios
                    </button>
                </div>
                <div class="card-body" data-id="{{ $generalText->id }}">
                    <div class="form-group">
                        <label>Contenido del texto general:</label>
                        <textarea name="privacy_general_content_{{ $generalText->id }}" class="form-control" rows="6">{{ $generalText->content }}</textarea>
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" name="privacy_general_active_{{ $generalText->id }}" {{ $generalText->is_active ? 'checked' : '' }}>
                        <label class="form-check-label">Activo</label>
                    </div>
                </div>
            </div>


            <!-- SECCIONES DE POLÍTICAS -->
            <div class="card card-warning">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Secciones de Políticas</h3>
                    <button type="button" class="btn btn-sm btn-success" onclick="addPrivacyRow()">
                        <i class="fa fa-plus mr-1"></i> Nueva Sección
                    </button>
                </div>

                <div class="card-body" id="privacy-list">
                    @foreach($policies->sortBy('order_num') as $policy)
                    <div class="row align-items-start mb-3 border-bottom pb-2 privacy-row" data-id="{{ $policy->id }}">
                        <div class="col-sm-4">
                            <label>Título</label>
                            <input type="text" name="privacy_title_{{ $policy->id }}" value="{{ $policy->title }}" class="form-control" placeholder="Ej: I. ASPECTOS GENERALES">
                        </div>
                        <div class="col-sm-6">
                            <label>Contenido</label>
                            <textarea name="privacy_content_{{ $policy->id }}" class="form-control" rows="4" placeholder="Contenido de la sección...">{{ $policy->content }}</textarea>
                        </div>
                        <div class="col-sm-1">
                            <label>Orden</label>
                            <input type="number" name="privacy_order_{{ $policy->id }}" value="{{ $policy->order_num }}" class="form-control" min="0">
                        </div>
                        <div class="col-sm-1 d-flex align-items-center mt-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privacy_active_{{ $policy->id }}" {{ $policy->is_active ? 'checked' : '' }}>
                                <label class="form-check-label">Activo</label>
                            </div>
                        </div>
                        <div class="col-sm-12 d-flex justify-content-end mt-2">
                            <button type="button" class="btn btn-sm btn-primary mr-1" onclick="updatePrivacy({{ $policy->id }})">
                                <i class="fa fa-save"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="deletePrivacy({{ $policy->id }})">
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

<!-- JS del módulo de Políticas -->
<script src="/template/dist/js/page_privacypolicies.js"></script>

<script>
$(function(){ bsCustomFileInput.init(); });
</script>
@endsection
