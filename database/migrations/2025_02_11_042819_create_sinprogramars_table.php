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
        Schema::create('sinprogramars', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('poliza');
            $table->string('cultivo', 50);
            $table->string('contratante', 50);
            $table->string('asegurado', 100);
            $table->string('departamento', 50);
            $table->string('provincia', 50);
            $table->string('distrito', 50);
            $table->string('direccion', 100);
            $table->enum('tipo_evento', ['GRANIZO', 'INCENDIO', 'INUNDACIÓN', 'SEQUIA', 'VIENTO', 'OTROS', 'TEMPERATURA BAJA', 'LLUVIA', 'HUAYCO'])->default('OTROS');
            $table->string('inspector', 50);
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sinprogramars');
    }
};
