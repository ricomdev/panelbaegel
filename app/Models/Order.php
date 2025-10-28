<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'usuario_id',
        'fecha',
        'fecha_texto',
        'nombre',
        'apellido',
        'telefono',
        'correo',
        'tipodocumento_id',
        'tipodocumento_text',
        'documento',
        'subtotal',
        'total',
        'discount_code',
        'discount',
        'discount_total',
        'id_transaccion',
        'id_venta',
        'modalidad',
        'tipoentrega_id',
        'tipoentrega_text',
        'fechaentrega_value',
        'fechaentrega_date',
        'horarioentrega_text',
        'direccionrecojo',
        'distrito',
        'delivery_price',
        'direccion',
        'numero',
        'referencia',
        'observacion',
        'tipocomprobantepago_id',
        'tipocomprobantepago_text',
        'nombrecomprobante',
        'apellidocomprobante',
        'tipodocumentocomprobante_id',
        'tipodocumentocomprobante_text',
        'numerodocumentocomprobante',
        'razonsocialcomprobante',
        'ruccomprobante',
        'telefonocomprobante',
        'correocomprobante'
    ];

    protected $dates = ['fecha', 'fechaentrega_date', 'created_at', 'updated_at'];

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }


    public function getCreatedAtPeruAttribute()
    {
        return Carbon::parse($this->created_at)->setTimezone('America/Lima');
    }
}
