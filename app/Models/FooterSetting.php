<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    /**
     * Tabla asociada al modelo
     */
    protected $table = 'footer_settings';

    /**
     * Campos que se pueden asignar masivamente
     */
    protected $fillable = [
        'hours_desktop',
        'hours_mobile',
        'address',
        'whatsapp',
        'follow_text',
        'newsletter_title',
        'newsletter_text',
    ];
}
