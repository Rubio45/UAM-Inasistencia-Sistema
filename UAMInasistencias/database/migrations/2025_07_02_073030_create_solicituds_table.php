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
        Schema::create('solicituds', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('profesor_id')->nullable();
            $table->unsignedBigInteger('secretaria_id')->nullable();
            $table->string('comentario');
            $table->string('estado')->default('Pendiente');
            $table->string('evidencia')->nullable();
            $table->date('fechaSolicitud');
            $table->date('fechaAusencia');
            $table->string('resolucion')->nullable();
            $table->string('tipoAusencia');
            $table->unsignedBigInteger('asignatura_id')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('profesor_id')->references('id')->on('profesores')->onDelete('set null');
            $table->foreign('secretaria_id')->references('id')->on('secretaria_academicas')->onDelete('set null');
            $table->foreign('asignatura_id')->references('id')->on('asignaturas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicituds');
    }
};
