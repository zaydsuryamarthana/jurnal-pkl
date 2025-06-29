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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('judul')->nullable();
            $table->string('tujuan')->nullable();
            $table->string('dudi')->nullable();
            $table->text('deskripsi')->nullable();
            $table->boolean('izin')->default(false);
            $table->enum('proses', ['start', 'report', 'verification', 'finish'])->nullable();
            $table->enum('verifikasi', ['approved', 'rejected', 'pending', 'revision'])->nullable();
            $table->date('tgl')->nullable();
            $table->text('komentar')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
