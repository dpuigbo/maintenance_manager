<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Informe extends Model
{
    use HasFactory;

    protected $fillable = [
        'intervencion_id', 'sistema_id', 'estado',
        'fecha_realizacion', 'notas', 'created_by',
    ];

    protected $casts = [
        'fecha_realizacion' => 'date',
    ];

    public function intervencion(): BelongsTo
    {
        return $this->belongsTo(Intervencion::class);
    }

    public function sistema(): BelongsTo
    {
        return $this->belongsTo(Sistema::class);
    }

    public function componentes(): HasMany
    {
        return $this->hasMany(ComponenteInforme::class)->orderBy('orden');
    }

    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
