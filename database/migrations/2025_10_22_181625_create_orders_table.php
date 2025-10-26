<?php

// No arquivo de migração ..._create_orders_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('cliente');
            $table->string('meio_pagamento');
            $table->decimal('total', 8, 2);
            $table->string('status')->default('pendente');
            $table->json('itens'); // O frontend envia um array 'itens'
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};