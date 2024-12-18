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
        Schema::create('demandas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('unidade_id')->constrained();
            $table->foreignId('tipo_id')->constrained('tipos');
            $table->foreignId('violencia_id')->constrained('violencias');
            $table->string('local_armazenamento');
            $table->enum('classificacao', ['sem prioridade', 'prioritario', 'urgente']);
            $table->date('data_triagem');
            $table->date('data_demanda_reprimida')->nullable();
            $table->date('data_atribuicao')->nullable();
            $table->enum('status_administrativo', ['triagem', 'demanda reprimida', 'atribuido'])
                ->default('triagem');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demandas');
    }
};
