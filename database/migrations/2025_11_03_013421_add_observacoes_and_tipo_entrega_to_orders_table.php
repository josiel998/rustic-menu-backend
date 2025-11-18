<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Adiciona o tipo de entrega depois do meio_pagamento
            $table->string('tipo_entrega')->default('entrega')->after('meio_pagamento');
            // Adiciona observações (nullable = opcional)
            $table->text('observacoes')->nullable()->after('tipo_entrega');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['tipo_entrega', 'observacoes']);
        });
    }
};