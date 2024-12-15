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
        Schema::create('data_dosen', function (Blueprint $table) {
        $table->id('id_data'); // Kolom id_data sebagai primary key
        $table->unsignedBigInteger('fk_id_user'); // Kolom id_user
        $table->unsignedBigInteger('fk_id_matkul'); // Kolom id_matkul
        $table->timestamps();

        $table->foreign('fk_id_user')->references('id')->on('m_user')->onDelete('cascade');
        $table->foreign('fk_id_matkul')->references('id')->on('mata_kuliah')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_dosen');
    }
};
