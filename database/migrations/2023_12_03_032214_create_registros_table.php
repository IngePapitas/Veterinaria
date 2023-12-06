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
        Schema::create('registros', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->string('path_archivo')->nullable();
            $table->string('tipo_archivo')->nullable();
            $table->unsignedBigInteger('id_nota');
            $table->timestamps();

            $table->foreign('id_nota')->references('id')->on('nota_servicios')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros');
    }
};
