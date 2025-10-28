<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CateringSetting extends Model
{
    use HasFactory;

    protected $table = 'catering_settings';

    protected $fillable = [
        'title',              // <li class="current">Catering</li>
        'subtitle',           // <h4>Disfruta la experiencia BAEGEL en tu evento</h4>
        'feature_image_path', // imagen principal
        'block_title',        // ¿Tienes una reunión, brunch, cumpleaños...?
        'block_paragraph',    // párrafo de descripción
        'block_highlight',    // Spoiler: todos van a querer repetir.
        'list_title',         // Cuéntanos todo sobre tu evento...
        'list_items',         // JSON de items de lista
        'disclaimer'          // *Sugerimos mínimo 1 semana de anticipación.
    ];

    protected $casts = [
        'list_items' => 'array', // convierte JSON a array automáticamente
    ];
}
