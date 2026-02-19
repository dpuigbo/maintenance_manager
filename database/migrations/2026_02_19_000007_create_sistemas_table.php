<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sistemas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->cascadeOnDelete();
            $table->foreignId('planta_id')->constrained('plantas')->cascadeOnDelete();
            $table->foreignId('maquina_id')->constrained('maquinas')->cascadeOnDelete();
            $table->foreignId('fabricante_id')->constrained('fabricantes');
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['cliente_id', 'fabricante_id', 'nombre']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sistemas');
    }
};
