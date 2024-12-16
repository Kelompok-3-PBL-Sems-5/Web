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
        Schema::create('m_user', function (Blueprint $table) {
            $table->integer('id_user', true);
            $table->integer('id_level')->nullable()->index('id_level');
            $table->integer('id_prodi')->nullable()->index('id_prodi');
            $table->integer('id_dabim')->nullable()->index('id_dabim');
            $table->integer('id_damat')->nullable()->index('id_damat');
            $table->string('nama_user', 100);
            $table->string('username', 50)->unique('username_user');
            $table->string('password');
            $table->string('nidn_user', 50)->nullable();
            $table->string('gelar_akademik', 50)->nullable();
            $table->string('email_user', 100)->nullable();
            $table->string('foto')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_user');
    }
};
