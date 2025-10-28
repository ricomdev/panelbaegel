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
@endsection

@section('body')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-12">
                        <h1>Ventas Históricas</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <div class="desktop-view">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-warning">
                                <div class="card-header">
                                    <h3 class="card-title">LISTA DE VENTAS HISTÓRICAS</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table class="table table-bordered table-hover table-responsive p-0">
                                        <thead>
                                        <tr>
                                            <th># de Pedido</th>
                                            <th>Tipo</th>
                                            <th>Fecha de Pedido</th>
                                            <th>Nombre</th>
                                            <th>Apellido</th>
                                            <th>Correo</th>
                                            <th>Telefono</th>
                                            <th>Subtotal</th>
                                            <th>Cód. Descuento</th>
                                            <th>Descuento</th>
                                            <th>Delivery</th>
                                            <th>Total</th>
                                            <th>Fecha de Entrega</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($orders as $order)
                                        <tr data-widget="expandable-table" aria-expanded="false">
                                            <td>BAEGEL-{{str_pad($order->id,3,"0",STR_PAD_LEFT)}}</td>
                                            @if($order->type_id==1)
                                                <td>Venta</td>
                                            @else
                                                <td>Pedido</td>
                                            @endif
                                            <td>{{$order->fecha_orden->format('d/m/Y')}}</td>
                                            <td>{{$order->nombre}}</td>
                                            <td>{{$order->apellido}}</td>
                                            <td>{{$order->email}}</td>
                                            <td>{{$order->telefono}}</td>
                                            <td>S/ {{$order->subtotal}}</td>
                                            @if(isset($order->discountcode->codigo))
                                                <td>{{$order->discountcode->codigo}}</td>
                                            @else
                                                <td></td>
                                            @endif
                                            <td>S/ {{$order->discount}}</td>
                                            <td>S/ {{$order->delivery}}</td>
                                            <td>S/ {{$order->total}}</td>
                                            <td>{{$order->fecha_entrega}}</td>
                                        </tr>
                                        <tr class="expandable-body">
                                            <td colspan="13">
                                                <ul>
                                                    @foreach($order->details as $detail)
                                                        <li><strong>PRODUCTO: </strong>{{$detail->producto}}
                                                            @if($detail->descripcion != '-')
                                                                - {{$detail->descripcion}}
                                                            @endif</li>
                                                        <li><strong>CANTIDAD: </strong>{{$detail->cantidad}}</li>
                                                        <li><strong>SUBTOTAL: </strong>S/ {{$detail->subtotal}}</li><br>
                                                    @endforeach

                                                    <li><strong>DISTRITO: </strong>{{$order->distrito}}</li>
                                                    <li><strong>DIRECCIÓN: </strong>{{$order->direccion}}</li>
                                                    <li><strong>REFERENCIA: </strong>{{$order->referencia}}</li>
                                                     <li><strong>OBSERVACIONES: </strong>{{$order->observaciones}}</li>
                                                </ul>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
        </div>
        <div class="mobile-view">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-warning">
                                <div class="card-header">
                                    <h3 class="card-title">LISTA DE VENTAS</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="text-center mb-3"><-- Por favor desliza el cuadro de izquierda a derecha para ver toda la información --></div>
                                    <table class="table table-bordered table-hover table-responsive p-0">
                                        <thead>
                                        <tr>
                                            <th># de Pedido</th>
                                            <th>Tipo</th>
                                            <th>Fecha de Pedido</th>
                                            <th>Nombre</th>
                                            <th>Apellido</th>
                                            <th>Correo</th>
                                            <th>Telefono</th>
                                            <th>Subtotal</th>
                                            <th>Cód. Descuento</th>
                                            <th>Descuento</th>
                                            <th>Delivery</th>
                                            <th>Total</th>
                                            <th>Fecha de Entrega</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($orders as $order)
                                        <tr data-widget="expandable-table" aria-expanded="false">
                                            <td>BAEGEL-{{str_pad($order->id,3,"0",STR_PAD_LEFT)}}</td>
                                            @if($order->type_id==1)
                                                <td>Venta</td>
                                            @else
                                                <td>Pedido</td>
                                            @endif
                                            <td>{{$order->fecha_orden->format('d/m/Y')}}</td>
                                            <td>{{$order->nombre}}</td>
                                            <td>{{$order->apellido}}</td>
                                            <td>{{$order->email}}</td>
                                            <td>{{$order->telefono}}</td>
                                            <td>S/ {{$order->subtotal}}</td>
                                            @if(isset($order->discountcode->codigo))
                                                <td>{{$order->discountcode->codigo}}</td>
                                            @else
                                                <td></td>
                                            @endif
                                            <td>S/ {{$order->discount}}</td>
                                            <td>S/ {{$order->delivery}}</td>
                                            <td>S/ {{$order->total}}</td>
                                            <td>{{$order->fecha_entrega}}</td>
                                        </tr>
                                        <tr class="expandable-body">
                                            <td colspan="13">
                                                <ul>
                                                    @foreach($order->details as $detail)
                                                        <li><strong>PRODUCTO: </strong>{{$detail->producto}}
                                                            @if($detail->descripcion != '-')
                                                                - {{$detail->descripcion}}
                                                            @endif</li>
                                                        <li><strong>CANTIDAD: </strong>{{$detail->cantidad}}</li>
                                                        <li><strong>SUBTOTAL: </strong>S/ {{$detail->subtotal}}</li><br>
                                                    @endforeach

                                                    <li><strong>DISTRITO: </strong>{{$order->distrito}}</li>
                                                    <li><strong>DIRECCIÓN: </strong>{{$order->direccion}}</li>
                                                    <li><strong>REFERENCIA: </strong>{{$order->referencia}}</li>
                                                </ul>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
        </div>
        <!-- /.content -->
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
    <script src="/template/dist/js/testimonial.js"></script>
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
    <script src="/template/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/template/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script>
        $(function () {
            bsCustomFileInput.init();
        });
    </script>
    </body>
@endsection
