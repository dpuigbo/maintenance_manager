<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('componentes_informe', function (Blueprint $table) {
            $table->id();
            $table->foreignId('informe_id')->constrained('informes')->cascadeOnDelete();
            $table->foreignId('componente_sistema_id')->constrained('componentes_sistema');
            $table->enum('tipo', ['controller', 'mechanical_unit', 'drive_unit']);
            $table->string('etiqueta');
            $table->integer('orden')->default(0);
            $table->foreignId('version_template_id')->nullable()->constrained('versiones_template')->nullOnDelete();
            $table->json('schema_congelado');
            $table->json('datos')->nullable();
            $table->timestamps();

            $table->unique(['informe_id', 'componente_sistema_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('componentes_informe');
    }
};
