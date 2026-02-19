<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('versiones_template', function (Blueprint $table) {
            $table->id();
            $table->foreignId('modelo_componente_id')->constrained('modelos_componente')->cascadeOnDelete();
            $table->integer('version');
            $table->enum('estado', ['borrador', 'activo', 'obsoleto'])->default('borrador');
            $table->json('schema')->nullable();
            $table->text('notas')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['modelo_componente_id', 'version']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('versiones_template');
    }
};
