<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            
        });
    }

    public function down()
    {
        // Optional: Add the column back if rolling back the migration
        Schema::table('users', function (Blueprint $table) {
            
        });
    }
};
