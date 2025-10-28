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
                        <h1>Ventas</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                <div class="col-12">
                    <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">LISTA DE VENTAS</h3>
                    </div>
                    <div class="card-body">
                        <table id="orders-table" class="table table-bordered table-hover table-striped w-100">
                        <thead class="thead-light">
                            <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Modalidad</th>
                            <th>Entrega</th>
                            <th>Fec. Entrega</th>
                            <th>Horario</th>
                            <th>Total</th>
                            <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->fecha_texto }}</td>
                                <!-- <td>{{ $order->created_at->setTimezone('America/Lima')->format('d/m/Y H:i') }}</td> -->
                                <td>{{ $order->nombre }} {{ $order->apellido }}</td>
                                <td>{{ $order->telefono }}</td>
                                <td>{{ $order->correo }}</td>
                                <td>{{ $order->modalidad }}</td>
                                <td>{{ $order->tipoentrega_text }}</td>
                                <td>{{ $order->fechaentrega_value }}</td>
                                <td>{{ $order->horarioentrega_text }}</td>
                                <td>S/. {{ number_format($order->total, 2) }}</td>
                                <td>
                                <button class="btn btn-sm btn-primary btn-detail" data-id="{{ $order->id }}">
                                    <i class="fa fa-eye"></i> Ver detalle
                                </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </section>
        <!-- /.content -->

        <!-- MODAL DETALLE -->
        <div class="modal fade" id="orderDetailModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Detalle de la Venta</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="order-detail-content">
                    <div class="text-center text-muted">Cargando detalle...</div>
                    </div>
                </div>
                </div>
            </div>
        </div>

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

<script>
$(document).ready(function () {
  const table = $('#orders-table').DataTable({
    responsive: true,
    order: [[0, 'desc']],
    columnDefs: [{ targets: 0, type: 'num' }],
    language: {
      url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
    }
  });

  // ✅ Click en toda la fila
  $('#orders-table tbody').on('click', 'tr', function (e) {
    // Evita conflicto con botón interno
    if ($(e.target).closest('.btn-detail').length) return;

    const isMobile = window.innerWidth < 768;
    if (!isMobile) return; // solo en móvil

    const tr = $(this);
    const row = table.row(tr);

    // Si ya hay detalle visible → cerrarlo
    if (tr.hasClass('shown')) {
      tr.next('.details-row').remove();
      tr.removeClass('shown');
      return;
    }

    // Cerrar cualquier otro abierto
    $('#orders-table tbody tr.shown').each(function () {
      $(this).next('.details-row').remove();
      $(this).removeClass('shown');
    });

    // Obtener los datos
    const total = tr.find('td:nth-child(10)').text();
    const id = tr.find('.btn-detail').data('id');

    // Insertar la nueva fila expandible
    const detailsHtml = `
      <tr class="details-row">
        <td colspan="11">
          <div class="details-content">
            <p><strong>Total:</strong> ${total}</p>
            <button class="btn btn-sm btn-primary btn-detail" data-id="${id}">
              <i class="fa fa-eye"></i> Ver detalle
            </button>
          </div>
        </td>
      </tr>
    `;

    tr.after(detailsHtml);
    tr.addClass('shown');
  });

  // ✅ Evento del botón “Ver detalle”
  $(document).on('click', '.btn-detail', function (e) {
    e.stopPropagation(); // evita que el clic cierre la fila

    const orderId = $(this).data('id');
    $('#orderDetailModal').modal('show');
    $('#order-detail-content').html('<div class="text-center text-muted">Cargando detalle...</div>');

    axios.get(`/orders/${orderId}`)
      .then(res => {
        $('#order-detail-content').html(res.data.html);
      })
      .catch(err => {
        $('#order-detail-content').html('<div class="alert alert-danger">Error al cargar el detalle.</div>');
        console.error(err);
      });
  });
});
</script>






    </body>
@endsection
