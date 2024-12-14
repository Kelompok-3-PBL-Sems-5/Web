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
        Schema::create('t_data_sertifikasi', function (Blueprint $table) {
            $table->integer('id_sertifikasi', true);
            $table->integer('id_user')->nullable()->index('id_user');
            $table->integer('id_vendor')->nullable()->index('id_vendor');
            $table->integer('id_dabim')->nullable()->index('id_dabim');
            $table->integer('id_damat')->nullable()->index('id_damat');
            $table->string('nama_sertif', 100);
            $table->string('jenis_sertif', 50)->nullable();
            $table->date('tgl_mulai_sertif')->nullable();
            $table->date('tgl_akhir_sertif')->nullable();
            $table->string('jenis_pendanaan_sertif', 50)->nullable();
            $table->string('bukti_sertif')->nullable();
            $table->string('status', 50)->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();

            $table->index(['id_damat'], 'id_matkul');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_data_sertifikasi');
    }
};
