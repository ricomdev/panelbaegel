<div class="mb-3">
  <strong>Cliente:</strong> {{ $order->nombre }} {{ $order->apellido }} |
  <strong>Tel:</strong> {{ $order->telefono }} |
  <strong>Email:</strong> {{ $order->correo }}
  <br>
  <strong>Entrega:</strong> {{ $order->tipoentrega_text }} 
  @if($order->direccion)
  |
  <strong>Dirección:</strong> {{ $order->direccion }} {{ $order->numero }} ({{ $order->distrito }})
  @endif
</div>

<table class="table table-sm table-bordered">
  <thead class="thead-light">
    <tr>
      <th>Producto</th>
      <!-- <th>Cantidad</th> -->
      <th>Subtotal</th>
    </tr>
  </thead>
  <tbody>
    @foreach($order->items as $item)
      <tr>
        <td>
          <strong>{{ $item->name }} ×{{ $item->quantity }} — S/.{{ number_format($item->subtotal,2) }}</strong>
          @if($item->details->count())
            <ul class="mb-0 small">
              @foreach($item->details as $det)
                <li>{{ $det->name }} ×{{ $det->quantity }}</li>
              @endforeach
            </ul>
          @endif
          @if($item->extras->count())
            <div class="small text-muted">Extras:</div>
            <ul class="mb-0 small">
              @foreach($item->extras as $extra)
                <li>{{ $extra->name }} ×{{ $extra->quantity }} — S/.{{ number_format($extra->subtotal,2) }}</li>
              @endforeach
            </ul>
          @endif
        </td>
        <!-- <td>{{ $item->quantity }}</td> -->
        <td>S/. {{ number_format($item->total,2) }}</td>
      </tr>
    @endforeach
  </tbody>
</table>

<div class="text-right">
  <strong>Subtotal:</strong> S/. {{ number_format($order->subtotal,2) }} <br>
  @if($order->discount_total>0)
    <strong>Descuento:</strong> -S/. {{ number_format($order->discount_total,2) }} <br>
  @endif
  @if($order->delivery_price>0)
    <strong>Delivery:</strong> S/. {{ number_format($order->delivery_price,2) }} <br>
  @endif
  <strong>Total:</strong> S/. {{ number_format($order->total,2) }}
</div>
