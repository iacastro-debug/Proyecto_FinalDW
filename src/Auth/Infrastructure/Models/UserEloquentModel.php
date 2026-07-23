<?php

namespace Src\Auth\Infrastructure\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Src\Auth\Domain\Enums\Role;

class UserEloquentModel extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, HasUuid;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'activo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'activo' => 'boolean',
        ];
    }

    public function role(): Role
    {
        return Role::from($this->role);
    }

    public function isAdmin(): bool
    {
        return $this->role === Role::Admin->value;
    }

    public function isRecepcionista(): bool
    {
        return $this->role === Role::Recepcionista->value;
    }

    public function isMedico(): bool
    {
        return $this->role === Role::Medico->value;
    }

    public function isPaciente(): bool
    {
        return $this->role === Role::Paciente->value;
    }
}
