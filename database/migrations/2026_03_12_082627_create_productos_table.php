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
        Schema::create('productos', function (Blueprint $table) {
            $table->string('id_producto', 15)->primary(); 
            $table->string('nombre', 100); 
            $table->string('imagen_url', 255)->nullable();
            $table->decimal('precio', 10, 2); 
            $table->unsignedBigInteger('id_categoria');
            $table->timestamps();

            $table->foreign('id_categoria')->references('id_categoria')->on('categorias')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
