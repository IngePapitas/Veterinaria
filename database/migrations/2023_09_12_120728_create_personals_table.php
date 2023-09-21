<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.npm update
     */
    public function up(): void
    {
        Schema::create('personals', function (Blueprint $table) {
            $table->id();
            $table->string('ci');
            $table->string('nombre');
            $table->string('imagen_path')->nullable();
            $table->string('telefono');
            $table->string('sexo');
            $table->integer('sueldo')->nullable();
            $table->boolean('estado');
            $table->boolean('baja');
            $table->unsignedBigInteger('id_especialidad'); // Debe ser unsigned
            $table->timestamps();

            // Definir la relación con la tabla 'especialidades'
            $table->foreign('id_especialidad')->references('id')->on('especialidads');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personals');
    }
};
