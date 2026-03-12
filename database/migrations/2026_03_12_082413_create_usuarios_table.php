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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->string('id_usuario', 15)->primary(); 
            $table->string('nombre', 100); 
            $table->string('email', 100)->unique(); 
            $table->string('password_hash', 255); 
            $table->string('direccion', 255)->nullable(); 
            $table->enum('rol', ['Cliente', 'Administrador', 'Repartidor'])->default('Cliente'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};