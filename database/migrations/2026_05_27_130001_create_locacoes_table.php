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
            // Cliente que está alugando e funcionário que atendeu a locação.
            // cascadeOnDelete: se o cliente/funcionário for removido, a locação some com ele.
            $table->foreignId('cliente_id')->constrained('clientes')->cascadeOnDelete();
            $table->foreignId('funcionario_id')->constrained('funcionarios')->cascadeOnDelete();
            $table->date('data_inicio');
            $table->date('data_fim');
            // Quantidade de diárias cobradas, calculada a partir do período.
            $table->unsignedInteger('dias');
            $table->decimal('valor_diaria', 10, 2);
            // valor_total = dias * valor_diaria (calculado na aplicação, não no banco).
            $table->decimal('valor_total', 12, 2);
            // Percentual de comissão do funcionário sobre o valor_total.
            $table->decimal('comissao_percent', 5, 2)->default(18);
            $table->decimal('valor_comissao', 12, 2);
            // "ativa": carro ocupado por esta locação. "finalizada": carro liberado.
            $table->string('status')->default('ativa');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locacoes');
    }
};
