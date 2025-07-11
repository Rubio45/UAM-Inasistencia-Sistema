<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relación con el estudiante
     */
    public function estudiante(): HasOne
    {
        return $this->hasOne(Estudiante::class);
    }

    /**
     * Relación con el profesor
     */
    public function profesor(): HasOne
    {
        return $this->hasOne(Profesor::class);
    }

    /**
     * Relación con la secretaria académica
     */
    public function secretariaAcademica(): HasOne
    {
        return $this->hasOne(SecretariaAcademica::class);
    }

    /**
     * Verificar si el usuario es estudiante
     */
    public function isEstudiante(): bool
    {
        return $this->estudiante()->exists();
    }

    /**
     * Verificar si el usuario es profesor
     */
    public function isProfesor(): bool
    {
        return $this->profesor()->exists();
    }

    /**
     * Verificar si el usuario es secretaria académica
     */
    public function isSecretariaAcademica(): bool
    {
        return $this->secretariaAcademica()->exists();
    }


}
