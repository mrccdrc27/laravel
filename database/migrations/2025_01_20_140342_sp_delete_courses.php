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
        DB::unprepared('DROP PROCEDURE IF EXISTS DeleteCourse');
        DB::unprepared('
            CREATE PROCEDURE DeleteCourse
            @CourseID INT
            AS
            BEGIN
                DELETE FROM courses
                WHERE courseID = @CourseID;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS DeleteCourse');
    }
};
