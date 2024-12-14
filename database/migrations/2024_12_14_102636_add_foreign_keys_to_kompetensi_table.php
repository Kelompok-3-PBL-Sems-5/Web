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
        Schema::table('kompetensi', function (Blueprint $table) {
            $table->foreign(['id_prodi'], 'kompetensi_ibfk_1')->references(['id_prodi'])->on('data_prodi')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_user'], 'kompetensi_ibfk_2')->references(['id_user'])->on('m_user')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kompetensi', function (Blueprint $table) {
            $table->dropForeign('kompetensi_ibfk_1');
            $table->dropForeign('kompetensi_ibfk_2');
        });
    }
};
