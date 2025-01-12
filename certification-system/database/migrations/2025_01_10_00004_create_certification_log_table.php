<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('certification_log', function (Blueprint $table) {
            $table->id('logID');
            $table->unsignedBigInteger('certificationID');
            $table->enum('action', ['Created', 'Viewed', 'Downloaded']);
            $table->dateTime('actionDate')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign('certificationID')->references('certificationID')->on('certifications');
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certification_log');
    }
};
