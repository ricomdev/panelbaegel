<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OurStoryBlock extends Model
{
    protected $table = 'our_story_blocks';

    protected $fillable = [
        'h3_desktop',
        'h3_mobile',
        'h1',
        'p',
        'btn_label',
        'btn_route',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
