<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS createModule');
        DB::unprepared('
            CREATE PROCEDURE createModule
                @CourseID INT,
                @ModuleTitle NVARCHAR(100),
                @ModuleContent NVARCHAR(MAX)
            AS
            BEGIN
                SET NOCOUNT ON;

                 --IF NOT EXISTS (SELECT 1 FROM Courses WHERE id = @CourseID)
                --BEGIN
                    --THROW 50000, "The specified course does not exist.", 1;
                --END

                INSERT INTO Modules (title, content, courseID, createdAt)
                VALUES (@ModuleTitle, @ModuleContent, @CourseID, GETDATE());
            END;
        ');

        DB::unprepared('DROP PROCEDURE IF EXISTS GetModulesByCourse');
        DB::unprepared('
            CREATE PROCEDURE GetModulesByCourse
                @courseID INT
            AS
            BEGIN
                SELECT 
                    moduleID,
                    courseID,
                    title,
                    content,
                    filepath,
                    createdAt
                FROM modules
                WHERE courseID = @courseID;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS createModule');
    }
};
