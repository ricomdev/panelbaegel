@extends('layouts.template')

@section('cssstyles')
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/template/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="/template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="/template/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/template/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/template/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/template/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="/template/plugins/summernote/summernote-bs4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="/template/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/template/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Ekko Lightbox -->
    <link rel="stylesheet" href="/template/plugins/ekko-lightbox/ekko-lightbox.css">
@endsection

@section('body')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-12">
                        <h1>Producto UNIT</h1>
                    </div>
                </div>
            </div>
        </section>

        <input id="code_product" type="hidden" value="{{ $code }}" readonly>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Editar Producto UNIT</h3>
                            </div>
                            <div class="card-body">
                                <form id="product-form">
                                    <input type="hidden" id="code_product" value="{{ $code }}">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Subcategoría</label>
                                                <select id="subcategory_id" class="form-control">
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
                                                <input type="checkbox" id="is_active" data-bootstrap-switch data-off-color="danger" data-on-color="success">
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

                                    <!-- ===== Campos opcionales (ocultos por ahora) ===== -->
                                    <div style="display: none;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Contenido</label>
                                                    <textarea class="form-control" id="content" rows="2"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Cantidad Bagels</label>
                                                    <input type="number" class="form-control" id="qty_bagel" min="0">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Cantidad Spreads</label>
                                                    <input type="number" class="form-control" id="qty_spreads" min="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- ===== FIN Campos opcionales ===== -->

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
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label for="images">Imagen 1200 x 1200 px (zona segura a los costados de 100px)</label>
                                                                <div class="input-group">
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" accept="image/*" name="images[]" id="images" multiple>
                                                                        <label class="custom-file-label" for="images">Seleccione imágenes</label>
                                                                    </div>
                                                                </div>
                                                                <small class="form-text text-muted">
                                                                    Puedes subir varias imágenes. Arrastra para reordenar y la primera será la principal.
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div id="sortable-images" class="row"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-4 ml-auto mr-auto">
                                            <!-- <button onclick="product_update(event)" type="button" class="btn btn-primary btn-block">
                                                <i class="fa fa-save mr-2"></i> Guardar Cambios
                                            </button> -->
                                            <button id="btn-save" type="button" class="btn btn-primary btn-block" onclick="product_update(event)">
                                                <span class="btn-text"><i class="fa mr-2"></i> Guardar Cambios</span>
                                                <span class="btn-spinner spinner-border spinner-border-sm ml-2" style="display:none" role="status" aria-hidden="true"></span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </div>

    <!-- /.content-wrapper -->
    <footer class="main-footer">
        BAEGEL - BAGEL SHOP &copy; <script>document.write(new Date().getFullYear());</script> Todos los derechos reservados | Developed by <a href="https://www.wecodding.com/" target="_blank"><strong>wecodding</strong></a>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.20.0/axios.js" integrity="sha512-nqIFZC8560+CqHgXKez61MI0f9XSTKLkm0zFVm/99Wt0jSTZ7yeeYwbzyl0SGn/s8Mulbdw+ScCG41hmO2+FKw==" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- jQuery -->
    <script src="/template/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="/template/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="/template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="/template/plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="/template/plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="/template/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="/template/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="/template/plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="/template/plugins/moment/moment.min.js"></script>
    <script src="/template/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="/template/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="/template/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="/template/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/template/dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="/template/dist/js/demo.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="/template/dist/js/pages/dashboard.js"></script>
    <!-- bs-custom-file-input -->
    <script src="/template/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <!-- Select2 -->
    <script src="/template/plugins/select2/js/select2.full.min.js"></script>
    <!-- Ekko Lightbox -->
    <script src="/template/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
    <script>
        $(function () {
            bsCustomFileInput.init();

            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
            //Ekko Lightbox
            $(document).on('click', '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();
                $(this).ekkoLightbox({
                    alwaysShowClose: true
                });
            });
        })
    </script>

    <script src="/template/dist/js/productunit.js"></script>
    
    </body>
@endsection

