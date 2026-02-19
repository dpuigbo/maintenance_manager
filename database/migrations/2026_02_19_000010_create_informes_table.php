<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('informes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('intervencion_id')->constrained('intervenciones')->cascadeOnDelete();
            $table->foreignId('sistema_id')->constrained('sistemas')->cascadeOnDelete();
            $table->enum('estado', ['borrador', 'finalizado', 'entregado'])->default('borrador');
            $table->date('fecha_realizacion')->nullable();
            $table->text('notas')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['intervencion_id', 'sistema_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('informes');
    }
};
