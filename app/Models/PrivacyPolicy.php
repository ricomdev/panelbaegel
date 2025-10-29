<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrivacyPolicy extends Model
{
    use HasFactory;

    protected $table = 'privacy_policies';

    protected $fillable = [
        'title',
        'content',
        'order_num',
        'is_active'
    ];
}
