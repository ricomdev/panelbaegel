<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'type',
        'title',
        'caption',
        'button_text',
        'button_link',
        'youtube_id',
        'image_path',
        'order',
        'is_active'
    ];
}
