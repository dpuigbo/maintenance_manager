<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modelos_componente', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fabricante_id')->constrained('fabricantes')->cascadeOnDelete();
            $table->enum('tipo', ['controller', 'mechanical_unit', 'drive_unit']);
            $table->string('nombre');
            $table->text('notas')->nullable();
            $table->json('config_aceites')->nullable();
            $table->timestamps();

            $table->unique(['fabricante_id', 'tipo', 'nombre']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modelos_componente');
    }
};
