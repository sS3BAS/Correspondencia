<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('correspondencias', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['entrada', 'salida']);
            $table->string('numero_ficha', 20)->nullable();
            $table->string('numero_control', 20)->nullable();
            $table->dateTime('fecha_registro');
            $table->foreignId('area_id')->nullable()->constrained('areas');
            $table->foreignId('puesto_id')->nullable()->constrained('puestos');
            $table->string('nombre_remitente', 50)->nullable();
            $table->string('cargo_remitente', 50)->nullable();
            $table->string('institucion', 80)->nullable();
            $table->string('nombre_destinatario', 50)->nullable();
            $table->string('cargo_destinatario', 50)->nullable();
            $table->string('domicilio', 100)->nullable();
            $table->string('tipo_documento', 50)->nullable();
            $table->integer('numero_fojas')->default(0);
            $table->text('anexos')->nullable();
            $table->text('asunto');
            $table->string('prioridad');
            $table->string('estado');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('correspondencias');
    }
};