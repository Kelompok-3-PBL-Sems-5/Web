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
        Schema::table('t_periode', function (Blueprint $table) {
            $table->foreign(['id_sertifikasi'], 't_periode_ibfk_1')->references(['id_sertifikasi'])->on('t_data_sertifikasi')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['id_user'], 't_periode_ibfk_2')->references(['id_user'])->on('m_user')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_periode', function (Blueprint $table) {
            $table->dropForeign('t_periode_ibfk_1');
            $table->dropForeign('t_periode_ibfk_2');
        });
    }
};
