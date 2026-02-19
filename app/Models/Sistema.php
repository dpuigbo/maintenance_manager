<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sistema extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cliente_id', 'planta_id', 'maquina_id', 'fabricante_id',
        'nombre', 'descripcion', 'notas',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function planta(): BelongsTo
    {
        return $this->belongsTo(Planta::class);
    }

    public function maquina(): BelongsTo
    {
        return $this->belongsTo(Maquina::class);
    }

    public function fabricante(): BelongsTo
    {
        return $this->belongsTo(Fabricante::class);
    }

    public function componentes(): HasMany
    {
        return $this->hasMany(ComponenteSistema::class)->orderBy('orden');
    }

    public function intervenciones(): BelongsToMany
    {
        return $this->belongsToMany(Intervencion::class, 'intervencion_sistema');
    }

    public function informes(): HasMany
    {
        return $this->hasMany(Informe::class);
    }
}
