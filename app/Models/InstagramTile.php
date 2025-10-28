<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstagramTile extends Model
{
    protected $table = 'instagram_tiles';

    protected $fillable = [
        'image_path',
        'post_url',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
