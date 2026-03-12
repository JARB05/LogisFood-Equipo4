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
        Schema::create('detalles_carrito', function (Blueprint $table) {
            $table->id('id_detalle_carrito');
            $table->unsignedBigInteger('id_carrito'); 
            $table->string('id_producto', 15);
            $table->integer('cantidad');
            $table->timestamps();

            // Llaves Foráneas
            $table->foreign('id_carrito')->references('id_carrito')->on('carritos')->onDelete('cascade');
            $table->foreign('id_producto')->references('id_producto')->on('productos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_carritos');
    }
};
