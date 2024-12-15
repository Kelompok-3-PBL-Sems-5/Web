<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
/**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuan_sertifikasi', function (Blueprint $table) {
            $table->id('id_peng_ser');
            $table->unsignedBigInteger('id_dosen');
            $table->text('desc_peng_ser')->nullable();
            $table->string('tujuan_peng_ser')->nullable();
            $table->decimal('anggaran_peng_ser', 15, 2)->nullable();
            $table->date('jadwal_peng_ser')->nullable();

            $table->foreign('id_dosen')->references('id_dosen')->on('data_dosen')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengajuan_sertifikasi');
    }
};
