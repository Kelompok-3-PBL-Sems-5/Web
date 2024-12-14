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
        Schema::table('m_user', function (Blueprint $table) {
            $table->foreign(['id_level'], 'm_user_ibfk_1')->references(['id_level'])->on('m_level')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['id_prodi'], 'm_user_ibfk_2')->references(['id_prodi'])->on('data_prodi')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_dabim'], 'm_user_ibfk_3')->references(['id_dabim'])->on('data_bidang_minat')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign(['id_damat'],'m_user_ibfk_4')->references(['id_damat'])->on('data_mata_kuliah')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_user', function (Blueprint $table) {
            $table->dropForeign('m_user_ibfk_1');
            $table->dropForeign('m_user_ibfk_2');
            $table->dropForeign('m_user_ibfk_3');
            $table->dropForeign('m_user_ibfk_4');
        });
    }
};
