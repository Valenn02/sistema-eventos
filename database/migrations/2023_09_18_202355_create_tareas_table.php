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
        Schema::create('tareas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion');
            $table->date('fecha_limite');
            $table->enum('estado', ['pendiente', 'completada'])->default('pendiente');
            $table->unsignedBigInteger('asignacion_evento_id');
            $table->timestamps();

            $table->foreign('asignacion_evento_id')
                ->references('id')
                ->on('asignaciones_evento')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tareas');
    }
};
