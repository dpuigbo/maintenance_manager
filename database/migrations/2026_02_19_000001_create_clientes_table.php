<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('sede')->nullable();
            $table->decimal('tarifa_hora_trabajo', 10, 2)->nullable();
            $table->decimal('tarifa_hora_viaje', 10, 2)->nullable();
            $table->decimal('dietas', 10, 2)->nullable();
            $table->decimal('peajes', 10, 2)->nullable();
            $table->decimal('precio_km', 10, 2)->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
