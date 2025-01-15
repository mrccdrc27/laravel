<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * 
     */
    public function up(): void
    {
        // Change binary columns to string
        Schema::table('courses', function (Blueprint $table) {
            $table->string('FileData')->nullable(false)->change();
        });
        Schema::table('modules', function (Blueprint $table) {
            $table->string('FileData')->nullable(false)->change();
        });
        Schema::table('assignments', function (Blueprint $table) {
            $table->string('FileData')->nullable(false)->change();
        });
        Schema::table('assessments', function (Blueprint $table) {
            $table->string('FileData')->nullable(false)->change();
        });
        Schema::table('submissions', function (Blueprint $table) {
            $table->string('FileData')->nullable(false)->change();
        });
        Schema::table('file_storage', function (Blueprint $table) {
            $table->string('FileData')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        // Revert string columns back to binary
        Schema::table('courses', function (Blueprint $table) {
            $table->binary('FileData')->nullable(false)->change();
        });
        Schema::table('modules', function (Blueprint $table) {
            $table->binary('FileData')->nullable(false)->change();
        });
        Schema::table('assignments', function (Blueprint $table) {
            $table->binary('FileData')->nullable(false)->change();
        });
        Schema::table('assessments', function (Blueprint $table) {
            $table->binary('FileData')->nullable(false)->change();
        });
        Schema::table('submissions', function (Blueprint $table) {
            $table->binary('FileData')->nullable(false)->change();
        });
        Schema::table('file_storage', function (Blueprint $table) {
            $table->binary('FileData')->nullable(false)->change();
        });
    }
};