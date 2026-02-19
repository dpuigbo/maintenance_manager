<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fabricante extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'activo', 'orden'];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function modelosComponente(): HasMany
    {
        return $this->hasMany(ModeloComponente::class);
    }

    public function sistemas(): HasMany
    {
        return $this->hasMany(Sistema::class);
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}
