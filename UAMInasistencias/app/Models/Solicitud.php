<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Solicitud extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'profesor_id',
        'secretaria_id',
        'comentario',
        'estado',
        'evidencia',
        'fechaSolicitud',
        'fechaAusencia',
        'resolucion',
        'tipoAusencia',
        'asignatura_id',
    ];

    protected $casts = [
        'fechaSolicitud' => 'date',
        'fechaAusencia' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function profesor(): BelongsTo
    {
        return $this->belongsTo(Profesor::class);
    }

    public function secretariaAcademica(): BelongsTo
    {
        return $this->belongsTo(SecretariaAcademica::class);
    }

    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(Estudiante::class, 'user_id', 'user_id');
    }

    public function asignatura(): BelongsTo
    {
        return $this->belongsTo(Asignatura::class);
    }
}
