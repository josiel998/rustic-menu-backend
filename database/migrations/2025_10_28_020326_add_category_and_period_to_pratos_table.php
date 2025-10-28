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
            // Adiciona as colunas que faltam DEPOIS da coluna 'nome'
            
            $table->text('descricao')->nullable()->after('nome');
            $table->decimal('preco', 8, 2)->after('descricao');
            $table->string('category')->after('preco');
            $table->string('period')->after('category');
            $table->string('imagem_url')->nullable()->after('period');
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