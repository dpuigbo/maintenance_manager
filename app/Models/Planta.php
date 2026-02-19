<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Planta extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cliente_id', 'nombre', 'direccion', 'ciudad', 'codigo_postal', 'notas',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function maquinas(): HasMany
    {
        return $this->hasMany(Maquina::class);
    }

    public function sistemas(): HasMany
    {
        return $this->hasMany(Sistema::class);
    }
}
