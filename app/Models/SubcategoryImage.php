<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubcategoryImage extends Model
{
    protected $fillable = [
        'subcategory_id',
        'type',       // principal o secundaria
        'path',       // ruta de la imagen
        'order'       // posición en el drag & drop
    ];

    public $timestamps = true;

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
}
