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
            $table->id('id_matkul');
            $table->integer('id_user')->nullable();
            $table->integer('id_damat')->nullable();
        
            $table->foreign('id_user')->references('id_user')->on('m_user')->cascadeOnDelete();
            $table->foreign('id_damat')->references('id_damat')->on('data_mata_kuliah')->cascadeOnDelete();
        
            $table->timestamps();
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
