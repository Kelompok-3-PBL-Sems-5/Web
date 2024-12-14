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
        Schema::create('t_data_rekomendasi_program', function (Blueprint $table) {
            $table->integer('id_program', true);
            $table->integer('id_vendor')->nullable()->index('id_vendor');
            $table->string('jenis_program', 50)->nullable();
            $table->string('nama_program', 100)->nullable();
            $table->integer('id_damat')->nullable()->index('id_damat');
            $table->integer('id_dabim')->nullable()->index('id_bidang_minat');
            $table->integer('id_user')->nullable()->index('id_user');
            $table->date('tanggal_program')->nullable();
            $table->string('level_program', 50)->nullable();
            $table->string('kuota_program', 100)->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_data_rekomendasi_program');
    }
};
