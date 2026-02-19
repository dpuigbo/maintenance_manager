<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VersionTemplate extends Model
{
    use HasFactory;

    protected $table = 'versiones_template';

    protected $fillable = [
        'modelo_componente_id', 'version', 'estado', 'schema', 'notas', 'created_by',
    ];

    protected $casts = [
        'schema' => 'array',
    ];

    public function modeloComponente(): BelongsTo
    {
        return $this->belongsTo(ModeloComponente::class);
    }

    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
