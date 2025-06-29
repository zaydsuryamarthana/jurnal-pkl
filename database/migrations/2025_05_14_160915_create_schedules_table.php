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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->date('week_start_date');
            $table->time('senin_masuk')->nullable();
            $table->time('senin_keluar')->nullable();
            $table->time('selasa_masuk')->nullable();
            $table->time('selasa_keluar')->nullable();
            $table->time('rabu_masuk')->nullable();
            $table->time('rabu_keluar')->nullable();
            $table->time('kamis_masuk')->nullable();
            $table->time('kamis_keluar')->nullable();
            $table->time('jumat_masuk')->nullable();
            $table->time('jumat_keluar')->nullable();
            $table->time('sabtu_masuk')->nullable();
            $table->time('sabtu_keluar')->nullable();
            $table->time('minggu_masuk')->nullable();
            $table->time('minggu_keluar')->nullable();
            $table->enum('status_verifikasi', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
