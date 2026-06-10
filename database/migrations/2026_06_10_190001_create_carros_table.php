<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('carros', function (Blueprint $table) {
            $table->string('placa')->primary();
            $table->string('modelo')->nullable();
            $table->string('marca')->nullable();
            $table->integer('ano')->nullable();
            $table->string('cor')->nullable();
            $table->decimal('valor_diaria', 10, 2)->nullable();
            $table->boolean('disponivel')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('carros');
    }
};
