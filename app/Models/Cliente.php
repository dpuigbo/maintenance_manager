<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre', 'sede', 'tarifa_hora_trabajo', 'tarifa_hora_viaje',
        'dietas', 'peajes', 'precio_km', 'notas',
    ];

    protected $casts = [
        'tarifa_hora_trabajo' => 'decimal:2',
        'tarifa_hora_viaje' => 'decimal:2',
        'dietas' => 'decimal:2',
        'peajes' => 'decimal:2',
        'precio_km' => 'decimal:2',
    ];

    public function plantas(): HasMany
    {
        return $this->hasMany(Planta::class);
    }

    public function maquinas(): HasMany
    {
        return $this->hasMany(Maquina::class);
    }

    public function sistemas(): HasMany
    {
        return $this->hasMany(Sistema::class);
    }

    public function intervenciones(): HasMany
    {
        return $this->hasMany(Intervencion::class);
    }
}
