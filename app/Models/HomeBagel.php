<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeBagel extends Model
{
    protected $table = 'home_bagels';

    protected $fillable = [
        'title',
        'description',
        'image_path',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];
}
