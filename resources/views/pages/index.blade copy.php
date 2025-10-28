@extends('layouts.template')

@section('cssstyles')
<link rel="stylesheet" href="/template/plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="/template/dist/css/adminlte.min.css">
@endsection

@section('body')
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Preloader -->
    <div id="baegel-preloader" class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="/template/dist/img/AdminLTELogo.png" alt="BaegelLogo" height="60" width="60">
        <p class="mt-3 text-muted">Cargando panel BAEGEL...</p>
    </div>

    <!-- Contenido principal -->
    <div class="content-wrapper" style="display:none;"> <!-- ocultamos hasta que cargue -->
        <!-- HEADER / SLIDERS -->
        <section class="content-header">
            <div class="container-fluid">
                <h1>Gestión de Página Principal</h1>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                <!-- SLIDERS -->
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">HEADER (Sliders)</h3>
                    </div>
                    <div class="card-body">
                        <form id="form-sliders" enctype="multipart/form-data">
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="slider-tab" role="tablist">
                                        @foreach($sliders as $index => $slide)
                                            <li class="nav-item">
                                                <a class="nav-link {{ $index===0 ? 'active':'' }}" data-toggle="pill" href="#slider-{{ $slide->id }}">
                                                    Slider {{ $index+1 }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        @foreach($sliders as $index => $slide)
                                        <div class="tab-pane fade {{ $index===0 ? 'show active':'' }}" id="slider-{{ $slide->id }}">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Título</label>
                                                    <input type="text" name="title_{{ $slide->id }}" class="form-control" value="{{ $slide->title }}">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Subtítulo</label>
                                                    <input type="text" name="caption_{{ $slide->id }}" class="form-control" value="{{ $slide->caption }}">
                                                </div>
                                            </div>
                                            @if($slide->type==='youtube')
                                            <div class="row mt-2">
                                                <div class="col-sm-6">
                                                    <label>YouTube ID</label>
                                                    <input type="text" name="youtube_id_{{ $slide->id }}" class="form-control" value="{{ $slide->youtube_id }}">
                                                </div>
                                            </div>
                                            @else
                                            <div class="row mt-2">
                                                <div class="col-sm-12">
                                                    <label>Imagen (1920x700)</label>
                                                    <div class="custom-file">
                                                        <input type="file" accept="image/*" name="image_{{ $slide->id }}" class="custom-file-input">
                                                        <label class="custom-file-label">{{ basename($slide->image_path) }}</label>
                                                    </div>
                                                    @if($slide->image_path)
                                                        <img src="{{ $slide->image_path }}" class="mt-2" width="200">
                                                    @endif
                                                </div>
                                            </div>
                                            @endif
                                            <div class="row mt-3">
                                                <div class="col-md-5 mr-auto ml-auto">
                                                    <button type="button" class="btn btn-primary btn-block" onclick="updateSlider({{ $slide->id }})">
                                                        <i class="fa fa-save mr-2"></i>Actualizar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- OUR STORY -->
                <div class="card card-warning">
                    <div class="card-header"><h3 class="card-title">QUIÉNES SOMOS</h3></div>
                    <div class="card-body">
                        <form id="form-ourstory">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Título</label>
                                    <input type="text" name="h1" class="form-control" value="{{ $story->h1 }}">
                                </div>
                                <div class="col-sm-6">
                                    <label>Subtítulo</label>
                                    <input type="text" name="h3_desktop" class="form-control" value="{{ $story->h3_desktop }}">
                                </div>
                            </div>
                            <div class="form-group mt-2">
                                <label>Texto</label>
                                <textarea name="p" class="form-control">{{ $story->p }}</textarea>
                            </div>
                            <div class="col-md-5 mr-auto ml-auto mt-3">
                                <button type="button" class="btn btn-primary btn-block" onclick="updateOurStory()"><i class="fa fa-save mr-2"></i>Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Las demás secciones (Timeline, Brands, Services, Instagram, Settings) quedan igual -->
                @include('pages.partials.index_sections')

            </div>
        </section>
    </div>
</div>

<!-- Scripts -->
<script src="/template/plugins/jquery/jquery.min.js"></script>
<script src="/template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/template/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.20.0/axios.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="/template/dist/js/page_index.js"></script>

<script>
$(function() {
    bsCustomFileInput.init();

    // Oculta el preloader cuando todo ha cargado
    $(window).on('load', function() {
        $('#baegel-preloader').fadeOut(400, function() {
            $(this).remove();
            $('.content-wrapper').fadeIn(300);
        });
    });
});
</script>
@endsection
