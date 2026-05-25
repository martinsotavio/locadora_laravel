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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');            // Campo para o nome do cliente
            $table->string('cpf')->unique();   // CPF único (o banco não deixa cadastrar dois iguais)
            $table->string('telefone')->nullable(); // Telefone (nullable significa opcional)
            $table->string('email')->nullable();    // E-mail (opcional)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};