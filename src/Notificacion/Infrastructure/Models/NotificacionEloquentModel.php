<?php

namespace Src\Notificacion\Infrastructure\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\Infrastructure\Models\UserEloquentModel;

class NotificacionEloquentModel extends Model
{
    use HasUuid;

    protected $table = 'notificaciones';

    protected $fillable = [
        'id',
        'user_id',
        'titulo',
        'mensaje',
        'tipo',
        'referencia_id',
        'leida',
    ];

    protected $casts = [
        'leida' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(UserEloquentModel::class, 'user_id');
    }
}
