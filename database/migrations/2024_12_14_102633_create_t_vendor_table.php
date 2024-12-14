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
        Schema::create('t_vendor', function (Blueprint $table) {
            $table->integer('id_vendor', true);
            $table->string('nama_vendor', 100);
            $table->string('alamat_vendor')->nullable();
            $table->string('telp_vendor', 20)->nullable();
            $table->string('jenis_vendor', 50)->nullable();
            $table->string('alamat_web')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_vendor');
    }
};
