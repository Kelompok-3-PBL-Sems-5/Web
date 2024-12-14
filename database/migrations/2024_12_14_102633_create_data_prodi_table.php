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
        Schema::create('data_prodi', function (Blueprint $table) {
            $table->integer('id_prodi', true);
            $table->string('nama_prodi', 100)->nullable();
            $table->string('kode_prodi', 50)->nullable();
            $table->integer('id_user')->nullable()->index('id_user');
            $table->string('nidn_user', 20)->nullable();
            $table->string('jenjang', 50)->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_prodi');
    }
};
