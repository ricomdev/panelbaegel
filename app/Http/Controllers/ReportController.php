<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\OrdersReportExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Mostrar la vista de reportes con filtros de fecha.
     */
    public function ordersIndex(Request $request)
    {
        // Si no se envían fechas, se toman los últimos 7 días por defecto
        //$from = $request->get('from', now()->subDays(7)->toDateString());
        $from = $request->get('from', now()->toDateString());
        $to   = $request->get('to', now()->toDateString());

        return view('reports.orders', compact('from', 'to'));
    }

    /**
     * Exportar el reporte de pedidos a Excel.
     */
    public function ordersExport(Request $request)
    {
        $request->validate([
            'from' => ['required', 'date'],
            'to'   => ['required', 'date', 'after_or_equal:from'],
        ]);

        $from = $request->get('from');
        $to   = $request->get('to');

        // Nombre del archivo: Reporte_Pedidos_2025-10-01_a_2025-10-14.xlsx
        $filename = "Reporte_Pedidos_{$from}_a_{$to}.xlsx";

        return Excel::download(new OrdersReportExport($from, $to), $filename);
    }
}
