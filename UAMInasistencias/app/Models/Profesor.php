<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profesor extends Model
{
    protected $fillable = [
        'user_id',
        'apellido',
        'cif',
        'facultad',
    ];

    /**
     * Relación con el usuario
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con las solicitudes (como profesor que aprueba)
     */
    public function solicitudesAprobadas()
    {
        return $this->hasMany(Solicitud::class, 'profesor_id');
    }

    /**
     * Obtener el nombre completo del profesor
     */
    public function getNombreCompletoAttribute(): string
    {
        return $this->user->name . ' ' . $this->apellido;
    }
}
