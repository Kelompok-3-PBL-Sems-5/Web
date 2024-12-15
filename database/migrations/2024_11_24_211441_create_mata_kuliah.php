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
        Schema::create('mata_kuliah', function (Blueprint $table) {
            $table->id('id_matkul'); // Kolom id_matkul sebagai primary key
            $table->unsignedBigInteger('id_dosen'); // Kolom id_dosen
            $table->string('kode_matkul', 10); // Kolom kode_matkul, maksimal 10 karakter
            $table->string('nama_matkul', 100); // Kolom nama_matkul, maksimal 100 karakter
            $table->timestamps();

            $table->foreign('id_user')->references('idp')->on('dosen')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mata_kuliah');
    }
};
