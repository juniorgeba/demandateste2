<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('medidas', function (Blueprint $table) {
            $table->id();

            // Chaves estrangeiras
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('unidade_id')->constrained('unidades')->onDelete('restrict');
            $table->foreignId('tecnico_user_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('pessoa_id')->constrained('pessoas')->onDelete('restrict');
            // Campos principais
            $table->integer('prazo_meses');
            $table->boolean('egresso')->default(false);
            $table->date('data_entrada_no_creas')->nullable();
            $table->string('motivo_infracao')->nullable();
            $table->boolean('possui_irmao_em_atedimento')->default(false);
            $table->string('local_armazenamento')->nullable();
            // Datas de controle
            $table->date('data_ativacao');
            $table->date('data_desligamento')->nullable();
            // Status da medida
            $table->enum('status', ['ativo', 'adj', 'desligado'])->default('ativo');
            // Timestamps e Soft Delete
            $table->timestamps();
            $table->softDeletes();
            // Índices
            $table->index('status');
            $table->index('data_entrada_no_creas');
            $table->index('data_ativacao');
            $table->index('data_desligamento');
        });

        // Tabela para observações
        Schema::create('medidas_observacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('medida_id')->constrained('medidas')->onDelete('cascade');
            $table->text('observacao');
            $table->timestamps();
            // Índice
            $table->index(['medida_id', 'created_at']);
        });

        // Tabela para documentos
        Schema::create('medidas_documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('medida_id')->constrained('medidas')->onDelete('cascade');
            $table->string('documento'); // Caminho do arquivo
            $table->string('nome_original'); // Nome original do arquivo
            $table->string('mime_type'); // Tipo do arquivo
            $table->integer('tamanho'); // Tamanho em bytes
            $table->timestamps();
            // Índice
            $table->index(['medida_id', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('medidas_documentos');
        Schema::dropIfExists('medidas_observacoes');
        Schema::dropIfExists('medidas');
    }
};
