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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nisn')->nullable()->unique();
            $table->string('niy')->nullable()->unique();
            $table->string('nip')->nullable()->unique();
            $table->enum('role', ['user', 'admin', 'dudi']);
            $table->string('password');
            $table->string('nis')->unique()->nullable();
            $table->string('nama');
            $table->enum('jk', ['l', 'p'])->nullable();
            $table->enum('kelas', ['xi', 'xii'])->nullable();
            $table->enum('jurusan', ['tkj', 'lps', 'tjat', 'akt'])->nullable();
            $table->string('email')->unique();
            $table->string('telp')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('foto')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
