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
        Schema::create('nota_servicios', function (Blueprint $table) {
            $table->id();
            $table->integer('total');
            $table->string('descripcion')->nullable();
            $table->unsignedBigInteger('id_paciente');
            $table->unsignedBigInteger('id_cliente');
            $table->unsignedBigInteger('id_personal');
            $table->timestamps();

            $table->foreign('id_paciente')->references('id')->on('pacientes')->onDelete('cascade');
            $table->foreign('id_cliente')->references('id')->on('clientes')->onDelete('cascade');
            $table->foreign('id_personal')->references('id')->on('personals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nota_servicios');
    }
};
