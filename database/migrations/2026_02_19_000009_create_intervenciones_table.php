<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('intervenciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->cascadeOnDelete();
            $table->enum('tipo', ['preventiva', 'correctiva']);
            $table->enum('estado', ['borrador', 'en_curso', 'completada', 'facturada'])->default('borrador');
            $table->string('referencia')->unique();
            $table->string('titulo');
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->text('notas')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('intervencion_sistema', function (Blueprint $table) {
            $table->id();
            $table->foreignId('intervencion_id')->constrained('intervenciones')->cascadeOnDelete();
            $table->foreignId('sistema_id')->constrained('sistemas')->cascadeOnDelete();

            $table->unique(['intervencion_id', 'sistema_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('intervencion_sistema');
        Schema::dropIfExists('intervenciones');
    }
};
