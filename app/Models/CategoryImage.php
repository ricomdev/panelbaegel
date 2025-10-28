<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryImage extends Model
{
    protected $fillable = [
        'category_id',
        'type',       // principal o secundaria
        'path',       // ruta de la imagen
        'order'       // posición en el drag & drop
    ];

    public $timestamps = true;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
