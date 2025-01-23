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
                @ModuleContent NVARCHAR(MAX),
                @filePath NVARCHAR(MAX)
            AS
            BEGIN
                -- Suppresses the "rows affected" messages
                SET NOCOUNT ON;

                --inserting kineme
                INSERT INTO Modules (title, content, courseID,filePath, createdAt)
                VALUES (@ModuleTitle, @ModuleContent, @CourseID,@filePath, GETDATE());
            END;
        ');



        
        DB::unprepared('DROP PROCEDURE IF EXISTS updateModule');
        DB::unprepared('
                            CREATE PROCEDURE updateModule
                @ModuleID INT,
                @CourseID INT,
                @ModuleTitle NVARCHAR(100),
                @ModuleContent NVARCHAR(MAX),
                @FilePath NVARCHAR(MAX)
            AS
            BEGIN
                -- Suppresses the "rows affected" messages
                SET NOCOUNT ON;

                -- Update the module in the Modules table
                UPDATE Modules
                SET 
                    title = @ModuleTitle,
                    content = @ModuleContent,
                    courseID = @CourseID,
                    filePath = @FilePath,
                    updatedAt = GETDATE()
                WHERE moduleID = @ModuleID;
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

        //Deletes a course
        DB::unprepared('DROP PROCEDURE IF EXISTS DeleteModule');
        DB::unprepared('
            CREATE PROCEDURE DeleteModule
            @ModuleID INT
            AS
            BEGIN
                DELETE FROM modules
                WHERE moduleID = @ModuleID;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {  
    }
       };

