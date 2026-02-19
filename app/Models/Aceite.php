<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aceite extends Model
{
    protected $fillable = ['nombre', 'fabricante', 'coste', 'precio', 'notas'];

    protected $casts = [
        'coste' => 'decimal:2',
        'precio' => 'decimal:2',
    ];
}
