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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('internship_id')->nullable()->after('id')->nullable();
            $table->unsignedBigInteger('verified_id')->nullable()->after('id');
            $table->unsignedBigInteger('admin_id')->nullable()->after('id');
            $table->foreign('internship_id')->references('id')->on('internships')->onDelete('set null');
            $table->foreign('verified_id')->references('id')->on('verifications')->onDelete('set null');
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('set null');
        });


        Schema::table('verifications', function (Blueprint $table) {
            $table->unsignedBigInteger('dudi_id')->nullable()->after('id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->after('id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('dudi_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('grades', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('journals', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('schedules', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('reports', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id')->unique();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['verified_id']);
            $table->dropColumn('verified_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['internship_id']);
            $table->dropColumn('internship_id');
        });
    }
};
