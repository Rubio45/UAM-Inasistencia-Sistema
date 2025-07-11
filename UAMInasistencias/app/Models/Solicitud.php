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
        'comentario_secretaria',
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
        'evidencia' => 'array',
    ];

    /**
     * Obtener las evidencias como array
     */
    public function getEvidenciasAttribute()
    {
        return $this->evidencia ?? [];
    }

    /**
     * Agregar una nueva evidencia
     */
    public function agregarEvidencia($archivo)
    {
        $evidencias = $this->evidencias;
        $evidencias[] = $archivo;
        $this->evidencia = $evidencias;
        $this->save();
    }

    /**
     * Eliminar una evidencia específica
     */
    public function eliminarEvidencia($indice)
    {
        $evidencias = $this->evidencias;
        if (isset($evidencias[$indice])) {
            unset($evidencias[$indice]);
            $this->evidencia = array_values($evidencias);
            $this->save();
        }
    }

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
