<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeStoryBlock extends Model
{
    use HasFactory;

    protected $table = 'home_story_blocks';

    protected $fillable = [
        'title',
        'text_desktop',
        'text_mobile',
        'image_path',
        'position',
        'order',
        'is_active',
    ];
}
