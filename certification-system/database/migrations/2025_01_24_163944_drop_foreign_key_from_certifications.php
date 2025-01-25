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
        Schema::table('certifications', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['userID']); // Foreign key name inferred from the column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('certifications', function (Blueprint $table) {
            // Re-add the foreign key constraint
            $table->foreign('userID')->references('userID')->on('user_info');
        });
    }
};
