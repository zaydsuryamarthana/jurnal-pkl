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
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            $table->string('judul')->nullable();
            $table->text('isi')->nullable();
            $table->date('tgl');
            $table->enum('verifikasi', ['belum', 'sudah', 'tolak', 'revisi'])->default('belum');
            $table->text('komentar')->nullable();
            $table->string('foto')->nullable();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('journals');
    }
};
