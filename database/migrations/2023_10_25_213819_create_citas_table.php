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
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->time('hora');
            $table->string('descripcion')->nullable();
            $table->string('estado'); // pendiente, atrasada, realizada
            $table->integer('tipo')->nullable(); //tipo 0 cita normal, tipo 1 vacunacion, tipo 2 cirujia
            $table->datetime('visitado')->nullable();
            $table->unsignedBigInteger('id_personal');
            $table->unsignedBigInteger('id_paciente');
            $table->timestamps();

            $table->foreign('id_paciente')->references('id')->on('pacientes')->onDelete('cascade');
            $table->foreign('id_personal')->references('id')->on('personals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
