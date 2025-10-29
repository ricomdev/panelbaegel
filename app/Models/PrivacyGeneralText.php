<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrivacyGeneralText extends Model
{
    use HasFactory;

    protected $table = 'privacy_general_texts';

    protected $fillable = [
        'content',
        'is_active'
    ];
}
