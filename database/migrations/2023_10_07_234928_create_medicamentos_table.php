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
        Schema::create('medicamentos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('forma_farmaceutica')->nullable();
            $table->decimal('dosis', 10, 2)->nullable();
            $table->decimal('precio', 10, 2)->nullable();
            $table->integer('stock')->nullable();
            $table->unsignedBigInteger('id_laboratorio');
            $table->unsignedBigInteger('id_categoriamedicamento');
            $table->timestamps();
            // llaves foráneas
            $table->foreign('id_laboratorio')->references('id')->on('laboratorios');
            $table->foreign('id_categoriamedicamento')->references('id')->on('categoria_medicamentos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicamentos');
    }
};
