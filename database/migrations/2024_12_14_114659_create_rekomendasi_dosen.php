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
        Schema::create('rekomendasi_dosen', function (Blueprint $table) {
            $table->integer('id_rekdosen')->primary();
            $table->integer('id_program')->nullable();
            $table->integer('id_user')->nullable();
            $table->enum('status', ['Ditolak','Diterima'])->nullable();

            $table->foreign('id_program')->references('id_program')->on('t_data_rekomendasi_program')->cascadeOnDelete();
            $table->foreign('id_user')->references('id_user')->on('m_user')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekomendasi_dosen');
    }
};
