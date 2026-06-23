<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('carros', function (Blueprint $table) {
            $table->string('status')->default('disponivel')->after('disponivel');
        });

        DB::table('carros')->where('disponivel', true)->update(['status' => 'disponivel']);
        DB::table('carros')->where('disponivel', false)->update(['status' => 'locado']);

        Schema::table('carros', function (Blueprint $table) {
            $table->dropColumn('disponivel');
        });
    }

    public function down(): void
    {
        Schema::table('carros', function (Blueprint $table) {
            $table->boolean('disponivel')->default(true)->after('valor_diaria');
        });

        DB::table('carros')->where('status', 'disponivel')->update(['disponivel' => true]);
        DB::table('carros')->where('status', '!=', 'disponivel')->update(['disponivel' => false]);

        Schema::table('carros', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
