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
        Schema::table('pengajuan_sertifikasi', function (Blueprint $table) {
            $table->foreign(['id_user'], 'pengajuan_sertifikasi_ibfk_1')->references(['id_user'])->on('m_user')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['id_vendor'], 'pengajuan_sertifikasi_ibfk_2')->references(['id_vendor'])->on('t_vendor')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_sertifikasi', function (Blueprint $table) {
            $table->dropForeign('pengajuan_sertifikasi_ibfk_1');
            $table->dropForeign('pengajuan_sertifikasi_ibfk_2');
        });
    }
};
