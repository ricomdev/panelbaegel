<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $fillable = [
        'category_id',
        'code',
        'description',
        'name',
        'level',
        'is_active',
        'link',
        'description'
    ];

    public $timestamps = true;

    public function images()
    {
        return $this->hasMany(SubcategoryImage::class)
            ->orderBy('order', 'asc'); // 👈 Siempre devolver ordenadas
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
