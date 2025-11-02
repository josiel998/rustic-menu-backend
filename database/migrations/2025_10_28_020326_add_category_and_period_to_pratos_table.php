<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * (Esta função ADICIONA as colunas)
     */
    public function up(): void
    {
     Schema::table('pratos', function (Blueprint $table) {
            // Adiciona SÓ O QUE FALTA
            $table->string('category')->after('preco');
            $table->string('period')->after('category');
        });
    }

    /**
     * Reverse the migrations.
     * (Esta função REMOVE as colunas se precisarmos reverter)
     */
    public function down(): void
    {
        Schema::table('pratos', function (Blueprint $table) {
            $table->dropColumn([
                'descricao',
                'preco',
                'category',
                'period',
                'imagem_url'
            ]);
        });
    }
};