<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Adiciona a coluna 'user_id' como nullable e cria a foreign key
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            // Adiciona a coluna 'unidade_id' como nullable e cria a foreign key
            $table->foreignId('unidade_id')->nullable()->constrained('unidades')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Primeiro, remova as chaves estrangeiras
            $table->dropForeign(['user_id']);
            $table->dropForeign(['unidade_id']);

            // Depois, remova as colunas
            $table->dropColumn('user_id');
            $table->dropColumn('unidade_id');
        });
    }
};
