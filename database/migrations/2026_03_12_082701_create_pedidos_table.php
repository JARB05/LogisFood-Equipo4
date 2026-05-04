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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->string('id_pedido', 15)->primary();
            $table->string('id_cliente', 15);
            // El repartidor puede ser nulo al inicio porque el pedido apenas se creó
            $table->string('id_repartidor', 15)->nullable(); 
            $table->dateTime('fecha');
            $table->decimal('total', 10, 2);
            $table->enum('estado', ['Creado', 'Pagado', 'En Preparación', 'En Camino', 'Entregado'])->default('Creado');
            $table->enum('tipo_entrega', ['Local', 'Domicilio']);
            $table->timestamps();

            // Llaves Foráneas
            $table->foreign('id_cliente')->references('id_usuario')->on('usuarios')->onDelete('restrict');
            $table->foreign('id_repartidor')->references('id_usuario')->on('usuarios')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
