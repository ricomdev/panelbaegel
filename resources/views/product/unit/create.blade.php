@extends('layouts.template')

@section('cssstyles')
    <!-- Mismos estilos que la vista de editar -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="/template/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="/template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="/template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="/template/plugins/jqvmap/jqvmap.min.css">
    <link rel="stylesheet" href="/template/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="/template/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="/template/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="/template/plugins/summernote/summernote-bs4.min.css">
    <link rel="stylesheet" href="/template/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/template/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="/template/plugins/ekko-lightbox/ekko-lightbox.css">
@endsection

@section('body')
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <h1>Crear Producto UNIT</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Nuevo Producto UNIT</h3>
                        </div>

                        <div class="card-body">
                            <form id="product-form">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Subcategoría</label>
                                            <select id="subcategory_id" class="form-control">
                                                <option value="">Seleccione una subcategoría</option>
                                                @foreach($subcategories as $sub)
                                                    <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Tipo</label>
                                            <input type="text" class="form-control" id="type" value="unit" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Activo</label><br>
                                            <input type="checkbox" id="is_active" data-bootstrap-switch data-off-color="danger" data-on-color="success" checked>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Código</label>
                                            <input type="text" class="form-control" id="code">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Nombre</label>
                                            <input type="text" class="form-control" id="name" maxlength="255" oninput="slug()">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Nombre Corto</label>
                                            <input type="text" class="form-control" id="short_name" maxlength="100">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Descripción Info 1</label>
                                            <textarea class="form-control" id="description" rows="2"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Descripción Info 2</label>
                                            <textarea class="form-control" id="description_002" rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Precio S/</label>
                                            <input type="number" class="form-control" id="price" step="0.01" min="0">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Stock</label>
                                            <input type="number" class="form-control" id="stock" min="0">
                                        </div>
                                    </div>
                                </div>

                                <!-- =================== IMÁGENES =================== -->
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h4 class="card-title">Imágenes</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="images">Imagen 1200 x 1200 px</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" accept="image/*" name="images[]" id="images" multiple>
                                                            <label class="custom-file-label" for="images">Seleccione imágenes</label>
                                                        </div>
                                                    </div>
                                                    <small class="form-text text-muted">
                                                        Puede subir varias imágenes. La primera será la principal.
                                                    </small>
                                                </div>

                                                <div id="sortable-images" class="row"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-4 ml-auto mr-auto">
                                        <button id="btn-save" type="button" class="btn btn-success btn-block" onclick="product_store(event)">
                                            <span class="btn-text"><i class="fa fa-save mr-2"></i> Crear Producto</span>
                                            <span class="btn-spinner spinner-border spinner-border-sm ml-2" style="display:none" role="status" aria-hidden="true"></span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div> <!-- card-body -->
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

<footer class="main-footer">
    BAEGEL - BAGEL SHOP &copy; <script>document.write(new Date().getFullYear());</script> Todos los derechos reservados | Developed by 
    <a href="https://www.wecodding.com/" target="_blank"><strong>wecodding</strong></a>
</footer>

<!-- Scripts comunes -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.20.0/axios.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="/template/plugins/jquery/jquery.min.js"></script>
<script src="/template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/template/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script src="/template/plugins/select2/js/select2.full.min.js"></script>
<script src="/template/dist/js/adminlte.js"></script>
<script>
    $(function () {
        bsCustomFileInput.init();
        $('.select2').select2()
    });
</script>

<script src="/template/dist/js/productunit.js"></script>
@endsection
