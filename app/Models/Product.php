<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'subcategory_id',
        'type',
        'code',
        'short_name',
        'name',
        'content',
        'description',
        'description_002',
        'price',
        'stock',
        'is_active',
        'qty_bagel',
        'qty_spreads'
    ];

    public $timestamps = true;

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function boxItems()
    {
        return $this->hasMany(ProductBoxItem::class, 'product_id');
    }

}
