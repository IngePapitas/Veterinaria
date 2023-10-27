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
        Schema::create('nota_servicio_medicamentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_medicamento');
            $table->unsignedBigInteger('id_notaservicio');
            $table->integer('cantidad');
            $table->integer('subtotal');
            $table->timestamps();

            $table->foreign('id_medicamento')->references('id')->on('medicamentos')->onDelete('cascade');
            $table->foreign('id_notaservicio')->references('id')->on('nota_servicios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nota_servicio_medicamentos');
    }
};
