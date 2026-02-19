<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Maquina extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cliente_id', 'planta_id', 'nombre', 'descripcion', 'notas',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function planta(): BelongsTo
    {
        return $this->belongsTo(Planta::class);
    }

    public function sistemas(): HasMany
    {
        return $this->hasMany(Sistema::class);
    }
}
