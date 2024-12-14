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
        Schema::table('data_prodi', function (Blueprint $table) {
            $table->foreign(['id_user'], 'data_prodi_ibfk_1')->references(['id_user'])->on('m_user')->onUpdate('no action')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_prodi', function (Blueprint $table) {
            $table->dropForeign('data_prodi_ibfk_1');
        });
    }
};
