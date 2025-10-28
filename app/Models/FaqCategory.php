<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FaqCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon_class',
        'order_num',
        'is_active'
    ];

    public function faqs()
    {
        return $this->hasMany(Faq::class, 'faq_category_id')
                    ->orderBy('order_num', 'asc');
    }
}
