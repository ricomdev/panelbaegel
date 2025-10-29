<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurnosBloqueado extends Model
{
    use HasFactory;

    protected $table = 'turnos_bloqueados';
    
    protected $fillable = [
        'fecha',
        'turno'
    ];

    protected $casts = [
        'fecha' => 'date'
    ];

    // Scope para obtener bloqueos futuros
    public function scopeFuturos($query)
    {
        return $query->where('fecha', '>=', now()->toDateString())
                    ->orderBy('fecha', 'asc')
                    ->orderBy('turno', 'asc');
    }

    // Scope para obtener bloqueos por fecha
    public function scopePorFecha($query, $fecha)
    {
        return $query->where('fecha', $fecha);
    }
}