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
            <h1>Gestión de Footer</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <!-- CONTACTO / FOOTER SETTINGS -->
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Contacto (Footer Settings)</h3>
                </div>
                <div class="card-body">
                    <div class="row">

                        <div class="col-sm-6">
                            <label>Horarios (Desktop)</label>
                            <input type="text" name="hours_desktop" value="{{ $footer->hours_desktop ?? '' }}" class="form-control" placeholder="Ej: Lun a vie - 9am a 5pm | Sáb a dom - 9am a 1pm">
                        </div>

                        <div class="col-sm-6">
                            <label>Horarios (Mobile)</label>
                            <textarea name="hours_mobile" class="form-control" rows="2" placeholder="Ej: Lun a vie - 9am a 5pm&#10;Sáb a dom - 9am a 1pm">{{ $footer->hours_mobile ?? '' }}</textarea>
                        </div>

                        <div class="col-sm-4 mt-3">
                            <label>Dirección</label>
                            <input type="text" name="address" value="{{ $footer->address ?? '' }}" class="form-control" placeholder="Ej: Surquillo: Taller a puerta cerrada">
                        </div>

                        <div class="col-sm-4 mt-3">
                            <label>WhatsApp</label>
                            <input type="text" name="whatsapp" value="{{ $footer->whatsapp ?? '' }}" class="form-control" placeholder="+51 999 999 999">
                        </div>

                        <div class="col-sm-4 mt-3">
                            <label>Texto “Síguenos”</label>
                            <input type="text" name="follow_text" value="{{ $footer->follow_text ?? '' }}" class="form-control" placeholder="¡Síguenos y conoce todas nuestras novedades!">
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-sm-6">
                            <label>Título Novedades</label>
                            <input type="text" name="newsletter_title" value="{{ $footer->newsletter_title ?? 'Novedades' }}" class="form-control" placeholder="Novedades">
                        </div>
                        <div class="col-sm-6">
                            <label>Texto Novedades</label>
                            <input type="text" name="newsletter_text" value="{{ $footer->newsletter_text ?? '¡Suscríbete a nuestra lista de correos!' }}" class="form-control" placeholder="¡Suscríbete a nuestra lista de correos!">
                        </div>
                    </div>

                    <div class="col-md-4 mr-auto ml-auto mt-4">
                        <button type="button" class="btn btn-primary btn-block" onclick="updateFooterSettings()">
                            <i class="fa fa-save mr-1"></i> Guardar ajustes de contacto
                        </button>
                    </div>
                </div>
            </div>


            <!-- REDES SOCIALES -->
            <div class="card card-warning">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Redes Sociales</h3>
                    <button type="button" class="btn btn-sm btn-success" onclick="addSocialRow()">
                        <i class="fa fa-plus mr-1"></i> Nueva Red
                    </button>
                </div>

                <div class="card-body" id="social-list">
                    @foreach($socials->sortBy('order_num') as $social)
                    <div class="row align-items-center mb-3 border-bottom pb-2 social-row" data-id="{{ $social->id }}">

                        <div class="col-sm-2">
                            <label>Nombre</label>
                            <input type="text" name="social_platform_{{ $social->id }}" 
                                value="{{ $social->platform }}" 
                                class="form-control" 
                                placeholder="Instagram, Facebook…">
                        </div>

                        <div class="col-sm-4">
                            <label>URL</label>
                            <input type="url" name="social_url_{{ $social->id }}" 
                                value="{{ $social->url }}" 
                                class="form-control" 
                                placeholder="https://...">
                        </div>

                        <div class="col-sm-3">
                            <label>Clase del ícono (FontAwesome)</label>
                            <input type="text" name="social_icon_{{ $social->id }}" 
                                value="{{ $social->icon_class }}" 
                                class="form-control" 
                                placeholder="fa-brands fa-instagram" 
                                oninput="previewIcon(this)">
                            <div class="icon-preview mt-2" style="font-size: 1.4rem;">
                                <i class="{{ $social->icon_class }}"></i>
                            </div>
                        </div>

                        <div class="col-sm-1">
                            <label>Orden</label>
                            <input type="number" name="social_order_{{ $social->id }}" 
                                value="{{ $social->order_num }}" 
                                class="form-control" min="0">
                        </div>

                        <div class="col-sm-1 d-flex align-items-center mt-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" 
                                    name="social_active_{{ $social->id }}" 
                                    {{ $social->is_active ? 'checked' : '' }}>
                                <label class="form-check-label">Activo</label>
                            </div>
                        </div>

                        <div class="col-sm-12 d-flex justify-content-end mt-2">
                            <button type="button" class="btn btn-sm btn-primary mr-1" onclick="updateSocial({{ $social->id }})">
                                <i class="fa fa-save"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteSocial({{ $social->id }})">
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

<!-- JS de la página Footer -->
<script src="/template/dist/js/page_footer.js"></script>

<script>
$(function(){ bsCustomFileInput.init(); });
</script>
@endsection
