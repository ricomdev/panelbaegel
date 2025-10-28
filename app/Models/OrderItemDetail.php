<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItemDetail extends Model
{
    protected $table = 'order_item_details';

    protected $fillable = [
        'order_item_id',
        'product_id',
        'name',
        'quantity'
    ];

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function item()
    {
        return $this->belongsTo(OrderItem::class, 'order_item_id');
    }
}
