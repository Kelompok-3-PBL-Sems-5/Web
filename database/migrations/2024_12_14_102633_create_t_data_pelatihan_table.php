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
        Schema::create('t_data_pelatihan', function (Blueprint $table) {
            $table->integer('id_pelatihan', true);
            $table->integer('id_user')->nullable()->index('id_user');
            $table->integer('id_vendor')->nullable()->index('id_vendor');
            $table->integer('id_dabim')->nullable()->index('id_bidang_minat');
            $table->integer('id_damat')->nullable()->index('id_damat');
            $table->integer('id_jenpel')->nullable()->index('id_jenpel');
            $table->string('nama_pelatihan', 100);
            $table->date('tgl_mulai')->nullable();
            $table->date('tgl_akhir')->nullable();
            $table->string('level_pelatihan', 50)->nullable();
            $table->string('jenis_pendanaan', 50)->nullable();
            $table->binary('bukti_pelatihan')->nullable();
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
        Schema::dropIfExists('t_data_pelatihan');
    }
};
