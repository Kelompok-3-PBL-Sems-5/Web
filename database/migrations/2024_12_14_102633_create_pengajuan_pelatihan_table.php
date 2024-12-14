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
        Schema::create('pengajuan_pelatihan', function (Blueprint $table) {
            $table->integer('id_pengpelatihan', true);
            $table->integer('id_user')->nullable()->index('id_user');
            $table->string('judul', 50)->nullable();
            $table->integer('id_vendor')->nullable()->index('id_vendor');
            $table->string('tujuan', 100)->nullable();
            $table->string('relevansi', 100)->nullable();
            $table->date('tanggal')->nullable();
            $table->string('lokasi', 50)->nullable();
            $table->integer('biaya')->nullable();
            $table->string('dana', 50)->nullable();
            $table->string('implementasi', 100)->nullable();
            $table->string('link', 100)->nullable();
            $table->string('status', 50)->nullable();
            $table->string('komentar', 100)->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_pelatihan');
    }
};
