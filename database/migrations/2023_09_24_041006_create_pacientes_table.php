<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_especie');
            $table->unsignedBigInteger('id_raza');
            $table->string('nombre');
            $table->integer('peso');
            $table->integer('tamano');
            $table->string('imagen_path')->nullable();

            $table->timestamps();

            // Claves foráneas hacia las tablas 'especies' y 'razas'
            $table->foreign('id_especie')->references('id')->on('especies')->onDelete('cascade');
            $table->foreign('id_raza')->references('id')->on('razas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
