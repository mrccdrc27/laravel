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
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id('SettingID'); // Primary key
            $table->string('SettingName', 100)->unique()->nullable(false);
            $table->text('SettingValue')->nullable(false); // NVARCHAR(MAX)
            $table->timestamp('UpdatedAt')->useCurrent();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filestorage');
    }
};
