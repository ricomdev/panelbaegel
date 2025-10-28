<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderhistory extends Model
{
    use HasFactory;

    protected $table = 'orders_history';
    protected $casts = [
        'fecha_orden' => 'datetime',
    ];

    
    public function details(){
        return $this->hasMany(Orderdetailshistory::class,'order_id');
    }

    public function discountcode(){
        return $this->belongsTo(Discount::class,'discount_code', 'codigo');
    }
}
