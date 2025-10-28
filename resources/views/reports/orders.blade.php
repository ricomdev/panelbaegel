@extends('layouts.template')

@section('cssstyles')
<link rel="stylesheet" href="/template/plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="/template/dist/css/adminlte.min.css">
@endsection

@section('body')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Reporte de Pedidos</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Generar Excel</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('reports.orders.export') }}" method="GET" class="row">
                        <div class="col-md-4">
                            <label>Fecha Inicio</label>
                            <input type="date" name="from" value="{{ $from }}" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label>Fecha Fin</label>
                            <input type="date" name="to" value="{{ $to }}" class="form-control" required>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-file-excel mr-1"></i> Exportar Excel
                            </button>
                        </div>
                    </form>

                    <!-- <div class="mt-4 small text-muted">
                        * El reporte lista cada <strong>ítem</strong> de cada pedido en el rango seleccionado (según <em>created_at</em>).<br>
                        * Incluye columnas de desglose B-PL, B-EV, B-WS, B-CR, B-CH, B-SX y CC-PL, CC-EV, CC-SM, CC-MH cuando se identifican en los detalles/extras.
                    </div> -->
                </div>
            </div>

        </div>
    </section>
</div>

<script src="/template/plugins/jquery/jquery.min.js"></script>
<script src="/template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/template/dist/js/adminlte.js"></script>
@endsection
