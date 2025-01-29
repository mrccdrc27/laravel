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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Announcement title
            $table->text('body'); // Detailed body of the announcement
            $table->string('author')->nullable(); // Optional author name
            $table->date('date_posted'); // Date when the announcement was posted
            $table->date('date_expiry')->nullable(); // Expiry date for the announcement, if applicable
            $table->boolean('is_active')->default(true); // To mark if the announcement is still active or not
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
