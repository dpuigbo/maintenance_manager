<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aceites', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('fabricante')->nullable();
            $table->decimal('coste', 10, 2)->nullable();
            $table->decimal('precio', 10, 2)->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();
        });

        Schema::create('consumibles', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('fabricante')->nullable();
            $table->decimal('coste', 10, 2)->nullable();
            $table->decimal('precio', 10, 2)->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();
        });

        Schema::create('configuracion', function (Blueprint $table) {
            $table->id();
            $table->string('clave')->unique();
            $table->text('valor')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configuracion');
        Schema::dropIfExists('consumibles');
        Schema::dropIfExists('aceites');
    }
};
