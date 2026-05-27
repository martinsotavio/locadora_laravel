<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->cascadeOnDelete();
            $table->foreignId('funcionario_id')->constrained('funcionarios')->cascadeOnDelete();
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->unsignedInteger('dias');
            $table->decimal('valor_diaria', 10, 2);
            $table->decimal('valor_total', 12, 2);
            $table->decimal('comissao_percent', 5, 2)->default(18);
            $table->decimal('valor_comissao', 12, 2);
            $table->string('status')->default('ativa');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locacoes');
    }
};
