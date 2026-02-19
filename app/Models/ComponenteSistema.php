<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComponenteSistema extends Model
{
    use HasFactory;

    protected $table = 'componentes_sistema';

    protected $fillable = [
        'sistema_id', 'tipo', 'modelo_componente_id', 'etiqueta',
        'numero_serie', 'numero_ejes', 'metadatos', 'orden',
    ];

    protected $casts = [
        'metadatos' => 'array',
    ];

    public function sistema(): BelongsTo
    {
        return $this->belongsTo(Sistema::class);
    }

    public function modeloComponente(): BelongsTo
    {
        return $this->belongsTo(ModeloComponente::class);
    }
}
