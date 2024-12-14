<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use KitLoong\MigrationsGenerator\Enum\Migrations\Method\Foreign;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bidang_minat', function (Blueprint $table) {
            $table->id('id_bidang_minat');
            $table->integer('id_user')->nullable();
            $table->integer('id_dabim')->nullable();
            $table->foreign('id_user')->references('id_user')->on('m_user')->cascadeOnDelete();
            $table->foreign('id_dabim')->references('id_dabim')->on('data_bidang_minat')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bidang_minat');
    }
};
