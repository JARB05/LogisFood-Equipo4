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
        Schema::create('carritos', function (Blueprint $table) {
            $table->id('id_carrito'); 
            $table->string('id_usuario', 15); 
            $table->timestamp('ultima_actualizacion')->useCurrent();
            $table->timestamps();

            // Declaración de la Relación
            $table->foreign('id_usuario')
                  ->references('id_usuario')->on('usuarios')
                  ->onDelete('cascade'); // Si se borra el usuario, se borra su carrito
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carritos');
    }
};
