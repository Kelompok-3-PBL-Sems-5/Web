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
        Schema::create('t_periode', function (Blueprint $table) {
            $table->integer('id_periode', true);
            $table->integer('id_sertifikasi')->nullable()->index('id_sertifikasi');
            $table->integer('id_user')->nullable()->index('id_user');
            $table->string('status', 50)->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_periode');
    }
};
