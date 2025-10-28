@extends('layouts.template')

@section('cssstyles')
<link rel="stylesheet" href="/template/plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="/template/dist/css/adminlte.min.css">
<!-- <link rel="stylesheet" href="/template/plugins/bs-custom-file-input/bs-custom-file-input.min.css"> -->
@endsection

@section('body')
<div class="content-wrapper">

    <!-- HEADER / SLIDERS -->
    <section class="content-header">
        <div class="container-fluid">
            <h1>Gestión de Página Principal</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <!-- HOME HEADER -->
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">HEADER PRINCIPAL</h3>
                </div>
                <div class="card-body">
                    <div class="row align-items-center mb-3">
                        <div class="col-sm-6">
                            <label>Título</label>
                            <input type="text" name="title_header" value="{{ $header->title }}" class="form-control" placeholder="Título principal de la página">
                        </div>
                        <div class="col-sm-3 mt-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="active_header" {{ $header->is_active ? 'checked' : '' }}>
                                <label class="form-check-label">Activo</label>
                            </div>
                        </div>
                        <div class="col-sm-3 mt-4">
                            <button type="button" class="btn btn-primary btn-sm" onclick="updateHomeHeader()">
                                <i class="fa fa-save mr-1"></i> Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </div>


            
            <!-- SLIDERS -->
            <div class="card card-warning">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">SLIDERS PRINCIPALES</h3>
                    <button type="button" class="btn btn-sm btn-success" onclick="addSliderRow()">
                        <i class="fa fa-plus mr-1"></i> Nuevo Slider
                    </button>
                </div>

                <div class="card-body">
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

                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <label>Tipo</label>
                                            <select name="type_{{ $slide->id }}" class="form-control">
                                                <option value="image" {{ $slide->type === 'image' ? 'selected' : '' }}>Imagen</option>
                                                <option value="youtube" {{ $slide->type === 'youtube' ? 'selected' : '' }}>YouTube</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <label>Orden</label>
                                            <input type="number" name="order_{{ $slide->id }}" class="form-control" value="{{ $slide->order }}">
                                        </div>
                                        <div class="col-sm-3 d-flex align-items-center">
                                            <div class="form-check mt-4">
                                                <input class="form-check-input" type="checkbox" name="active_{{ $slide->id }}" {{ $slide->is_active ? 'checked' : '' }}>
                                                <label class="form-check-label">Activo</label>
                                            </div>
                                        </div>
                                    </div>

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

                                    <div class="row mt-3">
                                        <div class="col-sm-6">
                                            <label>Texto del botón</label>
                                            <input type="text" name="button_text_{{ $slide->id }}" class="form-control" value="{{ $slide->button_text }}">
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Enlace del botón</label>
                                            <input type="url" name="button_link_{{ $slide->id }}" class="form-control" value="{{ $slide->button_link }}">
                                        </div>
                                    </div>

                                    @if($slide->type === 'youtube')
                                    <div class="row mt-3">
                                        <div class="col-sm-6">
                                            <label>YouTube ID</label>
                                            <input type="text" name="youtube_id_{{ $slide->id }}" class="form-control" value="{{ $slide->youtube_id }}">
                                        </div>
                                    </div>
                                    @else
                                    <div class="row mt-3">
                                        <div class="col-sm-12">
                                            <label>Imagen o video 1920 x 1080 px (zona segura a los costados de 100px)</label>
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

                                    <div class="row mt-4">
                                        <div class="col-md-5 mr-auto ml-auto d-flex">
                                            <button type="button" class="btn btn-primary btn-block mr-2" onclick="updateSlider({{ $slide->id }})">
                                                <i class="fa fa-save mr-2"></i>Actualizar
                                            </button>
                                            <button type="button" class="btn btn-danger" onclick="deleteSlider({{ $slide->id }})">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
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

            <!-- TIMELINE -->
            <div class="card card-warning">
                <div class="card-header"><h3 class="card-title">TIMELINE</h3></div>
                <div class="card-body">
                    @foreach($events as $event)
                    <div class="row align-items-end mb-3 border-bottom pb-2">
                        <div class="col-sm-2"><input type="text" name="year_{{ $event->id }}" value="{{ $event->year }}" class="form-control"></div>
                        <div class="col-sm-6"><input type="text" name="desc_{{ $event->id }}" value="{{ $event->description }}" class="form-control"></div>
                        <div class="col-sm-3">
                            <div class="custom-file">
                                <input type="file" name="icon_{{ $event->id }}" class="custom-file-input">
                                <label class="custom-file-label">{{ basename($event->icon_path) }}</label>
                            </div>
                            @if($event->icon_path)
                                <img src="{{ $event->icon_path }}" class="mt-2" width="80">
                            @endif
                        </div>
                        <div class="col-sm-1">
                            <button type="button" class="btn btn-sm btn-primary" onclick="updateTimeline({{ $event->id }})">Guardar</button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- BRANDS -->
            <div class="card card-warning">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">MARCAS</h3>
                    <button type="button" class="btn btn-sm btn-success" onclick="addBrandRow()">
                        <i class="fa fa-plus mr-1"></i> Nueva Marca
                    </button>
                </div>
                <div class="card-body" id="brand-list">
                    @foreach($brands as $brand)
                    <div class="row align-items-center mb-3 border-bottom pb-2 brand-row" data-id="{{ $brand->id }}">
                        <div class="col-sm-3">
                            <input type="text" name="name_{{ $brand->id }}" value="{{ $brand->name }}" class="form-control" placeholder="Nombre de la marca">
                        </div>
                        <div class="col-sm-4">
                            <input type="url" name="url_{{ $brand->id }}" value="{{ $brand->url }}" class="form-control" placeholder="https://...">
                        </div>
                        <div class="col-sm-3">
                            <div class="custom-file">
                                <input type="file" name="logo_{{ $brand->id }}" class="custom-file-input">
                                <label class="custom-file-label">{{ basename($brand->logo_path) }}</label>
                            </div>
                            @if($brand->logo_path)
                                <img src="{{ $brand->logo_path }}" class="mt-2" width="120">
                            @endif
                        </div>
                        <div class="col-sm-2 d-flex">
                            <button type="button" class="btn btn-sm btn-primary mr-1" onclick="updateBrand({{ $brand->id }})">Guardar</button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteBrand({{ $brand->id }})"><i class="fa fa-trash"></i></button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>


            <!-- HOME BAGELS -->
            <div class="card card-warning">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">OUR BAGELS</h3>
                    <button type="button" class="btn btn-sm btn-success" onclick="addBagelRow()">
                        <i class="fa fa-plus"></i> Nuevo Bagel
                    </button>
                </div>

                <div class="card-body" id="bagel-list">
                    @foreach($bagels as $bagel)
                    <div class="row align-items-center mb-3 border-bottom pb-2 bagel-row" data-id="{{ $bagel->id }}">
                        
                        <!-- Nombre -->
                        <div class="col-sm-3">
                            <input 
                                type="text" 
                                name="bagel_title_{{ $bagel->id }}" 
                                value="{{ $bagel->title }}" 
                                class="form-control" 
                                placeholder="Nombre del Bagel">
                        </div>

                        <!-- Descripción -->
                        <div class="col-sm-4">
                            <input 
                                type="text" 
                                name="bagel_desc_{{ $bagel->id }}" 
                                value="{{ $bagel->description }}" 
                                class="form-control" 
                                placeholder="Descripción corta">
                        </div>

                        <!-- Imagen -->
                        <div class="col-sm-3">
                            <div class="custom-file">
                                <input 
                                    type="file" 
                                    name="bagel_image_{{ $bagel->id }}" 
                                    class="custom-file-input">
                                <label class="custom-file-label">
                                    {{ basename($bagel->image_path) }}
                                </label>
                            </div>
                            @if($bagel->image_path)
                                <img src="{{ $bagel->image_path }}" class="mt-2" width="120">
                            @endif
                        </div>

                        <!-- Botones -->
                        <div class="col-sm-2 d-flex">
                            <button 
                                type="button" 
                                class="btn btn-sm btn-primary mr-1" 
                                onclick="updateBagel({{ $bagel->id }})">
                                <i class="fa fa-save"></i>
                            </button>
                            <button 
                                type="button" 
                                class="btn btn-sm btn-danger" 
                                onclick="deleteBagel({{ $bagel->id }})">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>




            <!-- SERVICES -->
            <div class="card card-warning">
                <div class="card-header"><h3 class="card-title">SERVICIOS</h3></div>
                <div class="card-body">
                    @foreach($services as $srv)
                    <div class="row align-items-center mb-3 border-bottom pb-2">
                        <div class="col-sm-3">
                            <input type="text" name="title_order_{{ $srv->order }}" value="{{ $srv->title }}" class="form-control">
                        </div>
                        <div class="col-sm-5">
                            <input type="text" name="desc_order_{{ $srv->order }}" value="{{ $srv->description }}" class="form-control">
                        </div>
                        
                        <div class="col-sm-3">
                            <label> 350 x 350 px (sin zona segura)</label>
                            <div class="custom-file">
                                <input type="file" name="icon_order_{{ $srv->order }}" class="custom-file-input">
                                <label class="custom-file-label">{{ basename($srv->icon_path) }}</label>
                            </div>
                            @if($srv->icon_path)
                                <img src="{{ $srv->icon_path }}" class="mt-2" width="80">
                            @endif
                        </div>
                        <div class="col-sm-1">
                            <button type="button" class="btn btn-sm btn-primary" onclick="updateService({{ $srv->order }})">Guardar</button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>


            <!-- INSTAGRAM -->
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">INSTAGRAM (6 registros fijos)</h3>
                </div>
                <div class="card-body">
                    @foreach($tiles->sortBy('order') as $tile)
                    <div class="row align-items-center mb-3 border-bottom pb-2">
                        
                        <!-- Enlace del post -->
                        <div class="col-sm-4">
                            <label>Enlace del post #{{ $tile->order }}</label>
                            <input 
                                type="url" 
                                name="url_order_{{ $tile->order }}" 
                                value="{{ $tile->post_url }}" 
                                class="form-control" 
                                placeholder="https://www.instagram.com/p/..."
                            >
                        </div>

                        <!-- Imagen -->
                        <div class="col-sm-4">
                            <label>Imagen 809 x 1200 px (zona segura a los costados de 100px</label>
                            <div class="custom-file">
                                <input 
                                    type="file" 
                                    name="img_order_{{ $tile->order }}" 
                                    class="custom-file-input" 
                                    accept="image/*"
                                >
                                <label class="custom-file-label">
                                    {{ basename($tile->image_path) ?: 'Seleccionar imagen' }}
                                </label>
                            </div>

                            @if($tile->image_path)
                                <img 
                                    src="{{ $tile->image_path }}" 
                                    class="mt-2 img-thumbnail" 
                                    width="120" 
                                    alt="Instagram {{ $tile->order }}"
                                >
                            @endif
                        </div>

                        <!-- Botón de acción -->
                        <div class="col-sm-2 d-flex align-items-end">
                            <button 
                                type="button" 
                                class="btn btn-sm btn-primary w-100" 
                                onclick="updateInstagram({{ $tile->order }})"
                            >
                                <i class="fa fa-save mr-1"></i>Guardar
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>



            <!-- SETTINGS -->
            <div class="card card-warning">
                <div class="card-header"><h3 class="card-title">TEXTOS DE CONFIGURACIÓN</h3></div>
                <div class="card-body">
                    <form id="form-settings">

                        <div class="form-group">
                            <label>Título de Timeline</label>
                            <input type="text" name="timeline_title" class="form-control" value="{{ $settings['timeline_title'] ?? '' }}">
                        </div>

                        <div class="form-group">
                            <label>Botón de Timeline</label>
                            <input type="text" name="timeline_button" class="form-control" value="{{ $settings['timeline_button'] ?? '' }}">
                        </div>

                        <div class="form-group">
                            <label>Título: Encuéntranos en</label>
                            <input type="text" name="find_us_title" class="form-control" value="{{ $settings['find_us_title'] ?? '' }}">
                        </div>

                        <div class="form-group">
                            <label>Título: Our Bagels</label>
                            <input type="text" name="bagels_title" class="form-control" value="{{ $settings['bagels_title'] ?? '' }}">
                        </div>

                        <div class="form-group">
                            <label>Título: ¿Quieres Baegels?</label>
                            <input type="text" name="want_baegels_title" class="form-control" value="{{ $settings['want_baegels_title'] ?? '' }}">
                        </div>

                        <div class="form-group">
                            <label>Texto de atención</label>
                            <input type="text" name="attention_text" class="form-control" value="{{ $settings['attention_text'] ?? '' }}">
                        </div>

                        <div class="form-group">
                            <label>Título: Baegel Lovers</label>
                            <input type="text" name="lovers_title" class="form-control" value="{{ $settings['lovers_title'] ?? '' }}">
                        </div>

                        <div class="form-group">
                            <label>Texto: Instagram</label>
                            <input type="text" name="instagram_follow_text" class="form-control" value="{{ $settings['instagram_follow_text'] ?? '' }}">
                        </div>

                        <div class="col-md-5 mr-auto ml-auto mt-3">
                            <button type="button" class="btn btn-primary btn-block" onclick="updateSettings()">
                                <i class="fa fa-save mr-2"></i>Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </section>
</div>

<!-- Scripts -->
<script src="/template/plugins/jquery/jquery.min.js"></script>
<script src="/template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/template/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.20.0/axios.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="/template/dist/js/adminlte.js"></script>
<script src="/template/dist/js/page_index.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(function(){ bsCustomFileInput.init(); });
</script>
@endsection
