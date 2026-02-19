<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('componentes_sistema', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sistema_id')->constrained('sistemas')->cascadeOnDelete();
            $table->enum('tipo', ['controller', 'mechanical_unit', 'drive_unit']);
            $table->foreignId('modelo_componente_id')->constrained('modelos_componente');
            $table->string('etiqueta');
            $table->string('numero_serie')->nullable();
            $table->integer('numero_ejes')->nullable();
            $table->json('metadatos')->nullable();
            $table->integer('orden')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('componentes_sistema');
    }
};
