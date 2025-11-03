<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pratos', function (Blueprint $table) {
            // Adiciona o novo campo para o preço do prato pequeno
            // Deve ser nullable ou ter um default, mas para simplificar, usaremos nullable
            $table->decimal('preco_pequeno', 8, 2)->nullable()->after('preco');
        });
        // O campo 'preco' agora é implicitamente o preço 'grande' ou 'padrão'
    }

    public function down(): void
    {
        Schema::table('pratos', function (Blueprint $table) {
            $table->dropColumn('preco_pequeno');
        });
    }
};