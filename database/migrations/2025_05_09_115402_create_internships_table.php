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
        Schema::create('internships', function (Blueprint $table) {
            $table->id();
            $table->string('dudika')->unique();
            $table->text('alamat');
            $table->string('deskripsi')->nullable();
            $table->string('foto')->nullable();
            $table->string('map')->nullable();
            $table->date('tgl_masuk')->nullable();
            $table->date('tgl_penarikan')->nullable();
            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();
            $table->enum('verifikasi', ['approved', 'rejected', 'pending'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internships');
    }
};
