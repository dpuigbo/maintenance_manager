<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ModeloComponente extends Model
{
    use HasFactory;

    protected $table = 'modelos_componente';

    protected $fillable = [
        'fabricante_id', 'tipo', 'nombre', 'notas', 'config_aceites',
    ];

    protected $casts = [
        'config_aceites' => 'array',
    ];

    public function fabricante(): BelongsTo
    {
        return $this->belongsTo(Fabricante::class);
    }

    public function versionesTemplate(): HasMany
    {
        return $this->hasMany(VersionTemplate::class);
    }

    public function versionActiva(): HasOne
    {
        return $this->hasOne(VersionTemplate::class)->where('estado', 'activo');
    }

    public function componentesSistema(): HasMany
    {
        return $this->hasMany(ComponenteSistema::class);
    }
}
