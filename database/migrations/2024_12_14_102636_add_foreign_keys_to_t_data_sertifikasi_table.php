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
        Schema::table('t_data_sertifikasi', function (Blueprint $table) {
            $table->foreign(['id_user'], 't_data_sertifikasi_ibfk_1')->references(['id_user'])->on('m_user')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['id_vendor'], 't_data_sertifikasi_ibfk_2')->references(['id_vendor'])->on('t_vendor')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['id_damat'], 't_data_sertifikasi_ibfk_3')->references(['id_damat'])->on('data_mata_kuliah')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_dabim'], 't_data_sertifikasi_ibfk_4')->references(['id_dabim'])->on('data_bidang_minat')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_data_sertifikasi', function (Blueprint $table) {
            $table->dropForeign('t_data_sertifikasi_ibfk_1');
            $table->dropForeign('t_data_sertifikasi_ibfk_2');
            $table->dropForeign('t_data_sertifikasi_ibfk_3');
            $table->dropForeign('t_data_sertifikasi_ibfk_4');
        });
    }
};