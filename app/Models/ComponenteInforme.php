<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComponenteInforme extends Model
{
    use HasFactory;

    protected $table = 'componentes_informe';

    protected $fillable = [
        'informe_id', 'componente_sistema_id', 'tipo', 'etiqueta',
        'orden', 'version_template_id', 'schema_congelado', 'datos',
    ];

    protected $casts = [
        'schema_congelado' => 'array',
        'datos' => 'array',
    ];

    public function informe(): BelongsTo
    {
        return $this->belongsTo(Informe::class);
    }

    public function componenteSistema(): BelongsTo
    {
        return $this->belongsTo(ComponenteSistema::class);
    }

    public function versionTemplate(): BelongsTo
    {
        return $this->belongsTo(VersionTemplate::class);
    }
}
