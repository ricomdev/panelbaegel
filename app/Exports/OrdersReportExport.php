<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class OrdersReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected string $from;
    protected string $to;
    protected Collection $rows;
    protected int $rowNum = 0;

    public function __construct(string $from, string $to)
    {
        $this->from = $from;
        $this->to   = $to;
    }

    public function headings(): array
    {
        return [
            'N° PEDIDO',
            '#',
            'VIA',
            'DÍA PEDIDO',
            'TIPO DE ENTREGA',
            'DÍA ENTREGA',
            'HORARIO DE ENTREGA',
            'NOMBRE',
            'TELÉFONO',
            'DISTRITO',
            'DIRECCIÓN',
            'NÚMERO',
            'REFERENCIA',
            'OBSERVACIÓN',
            'TIPO',         // Producto / Adicional
            'CANTIDAD',     // ← antes del producto
            'PRODUCTO',
            'DETALLE',      // Sabores concatenados
            'PRECIO UNITARIO',
            'SUBTOTAL ITEM',
            'SUBTOTAL PEDIDO',
            'CÓDIGO DESCUENTO',
            'DESCUENTO (%)',
            'DESCUENTO (-)',
            'DELIVERY',
            'TOTAL PEDIDO',
        ];
    }

    public function collection()
    {
        $orders = Order::with(['items.details', 'items.extras'])
            ->whereDate('created_at', '>=', $this->from)
            ->whereDate('created_at', '<=', $this->to)
            ->orderBy('id', 'desc')
            ->get();

        $rows = collect();

        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                $rows->push([
                    'type'  => 'Producto',
                    'order' => $order,
                    'item'  => $item,
                ]);

                foreach ($item->extras as $extra) {
                    $rows->push([
                        'type'  => 'Adicional',
                        'order' => $order,
                        'item'  => $extra,
                        'parent' => $item->name,
                    ]);
                }
            }
        }

        $this->rows = $rows;
        return $this->rows;
    }

    public function map($row): array
    {
        $this->rowNum++;

        /** @var \App\Models\Order $order */
        $order = $row['order'];
        /** @var mixed $item */
        $item  = $row['item'];
        $type  = $row['type'];

        $pedidoNum = str_pad($order->id, 4, '0', STR_PAD_LEFT);
        $via       = $order->modalidad;
        $diaPedido = $order->fecha_texto;
        $tipoEntrega = $order->tipoentrega_text;
        $diaEntrega  = $order->fechaentrega_value;
        $horario     = $order->horarioentrega_text;
        $nombre      = trim(($order->nombre ?? '') . ' ' . ($order->apellido ?? ''));
        $telefono    = $order->telefono;
        $distrito    = $order->distrito;
        $direccion   = $order->direccion;
        $numero      = $order->numero;
        $referencia  = $order->referencia;
        $observacion = $order->observacion;

        $producto  = $item->name ?? '';
        $cantidad  = (int)($item->quantity ?? 0);
        $precioU   = (float)($item->price ?? 0);
        $subtotalI = (float)($item->subtotal ?? ($precioU * $cantidad));

        // Concatenar detalles si es producto
        $detalle = '';
        if ($type === 'Producto' && method_exists($item, 'details')) {
            $details = $item->details;
            if ($details && count($details) > 0) {
                $list = [];
                foreach ($details as $d) {
                    $q = (int)($d->quantity ?? 1);
                    $name = trim($d->name ?? '');
                    if ($name) $list[] = "{$q} {$name}";
                }
                $detalle = '(' . implode(', ', $list) . ')';
            }
        }

        // Formateos con prefijos y decimales
        $formatMoney = fn($v) => 'S/ ' . number_format((float)$v, 2, '.', '');
        $formatPercent = fn($v) => number_format((float)$v, 2, '.', '') . '%';

        return [
            $pedidoNum,                         // N° PEDIDO
            $this->rowNum,                      // #
            $via,                               // VIA
            $diaPedido,                         // DÍA PEDIDO
            $tipoEntrega,                       // TIPO DE ENTREGA
            $diaEntrega,                        // DÍA ENTREGA
            $horario,                           // HORARIO DE ENTREGA
            $nombre,                            // NOMBRE
            $telefono,                          // TELÉFONO
            $distrito,                          // DISTRITO
            $direccion,                         // DIRECCIÓN
            $numero,                            // NÚMERO
            $referencia,                        // REFERENCIA
            $observacion,                       // OBSERVACIÓN
            $type,                              // TIPO
            $cantidad,                          // CANTIDAD
            $producto,                          // PRODUCTO
            $detalle,                           // DETALLE
            $formatMoney($precioU),             // PRECIO UNITARIO
            $formatMoney($subtotalI),           // SUBTOTAL ITEM
            $formatMoney($order->subtotal),     // SUBTOTAL PEDIDO
            $order->discount_code,              // CÓDIGO DESCUENTO
            $formatPercent($order->discount),   // DESCUENTO (%)
            $formatMoney($order->discount_total), // DESCUENTO (-)
            $formatMoney($order->delivery_price), // DELIVERY
            $formatMoney($order->total),        // TOTAL PEDIDO
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastColIndex = 26;
        $lastColLetter = Coordinate::stringFromColumnIndex($lastColIndex);

        // Cabecera en negrita y autofiltro
        $sheet->getStyle("A1:{$lastColLetter}1")->getFont()->setBold(true);
        $sheet->setAutoFilter("A1:{$lastColLetter}1");

        // Ajuste automático y texto envuelto
        for ($i = 1; $i <= $lastColIndex; $i++) {
            $sheet->getColumnDimensionByColumn($i)->setAutoSize(true);
        }

        // Alineación y ajuste del texto
        $sheet->getStyle("A1:{$lastColLetter}" . $sheet->getHighestRow())
            ->getAlignment()
            ->setWrapText(true)
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setHorizontal(Alignment::HORIZONTAL_LEFT);

        return [];
    }
}
