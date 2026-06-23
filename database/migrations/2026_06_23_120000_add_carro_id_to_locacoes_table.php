<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('locacoes', function (Blueprint $table) {
            // Vincula a locação ao carro alugado (placa é a chave primária de carros).
            // Nullable só para não quebrar registros antigos; a aplicação exige o campo.
            $table->string('carro_id')->nullable()->after('funcionario_id');
            // restrictOnDelete: impede excluir um carro que tenha locações associadas.
            $table->foreign('carro_id')->references('placa')->on('carros')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('locacoes', function (Blueprint $table) {
            $table->dropForeign(['carro_id']);
            $table->dropColumn('carro_id');
        });
    }
};
