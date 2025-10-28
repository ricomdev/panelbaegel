<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'product_id',
        'name',
        'quantity',
        'subtotal',
        'total',
        'is_box'
    ];

    public function order()
    {
        //return $this->belongsTo(Order::class);
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function details()
    {
        return $this->hasMany(OrderItemDetail::class, 'order_item_id');
    }

    public function extras()
    {
        return $this->hasMany(OrderItemExtra::class, 'order_item_id');
    }
}
