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
        DB::unprepared('DROP PROCEDURE IF EXISTS createAssignment');
        DB::unprepared('
            CREATE PROCEDURE createAssignment
                @CourseID BIGINT,
                @Title NVARCHAR(100),
                @FilePath NVARCHAR(MAX),
                @Instructions NVARCHAR(MAX),
                @DueDate DATETIME
            AS
            BEGIN
                -- Suppresses the "rows affected" messages
                SET NOCOUNT ON;
        
                -- Insert a new assignment into the assignments table
                INSERT INTO assignments (courseID, title, filePath, instructions, dueDate,updatedAt, createdAt)
                VALUES (@CourseID, @Title, @FilePath, @Instructions, @DueDate, GETDATE(), GETDATE());
            END;
        ');
        DB::unprepared('DROP PROCEDURE IF EXISTS updateAssignment');
DB::unprepared('
    CREATE PROCEDURE updateAssignment
        @AssignmentID BIGINT,
        @CourseID BIGINT,
        @Title NVARCHAR(100),
        @FilePath NVARCHAR(MAX),
        @Instructions NVARCHAR(MAX),
        @DueDate DATETIME
    AS
    BEGIN
        -- Suppresses the "rows affected" messages
        SET NOCOUNT ON;

        -- Update the assignment in the assignments table
        UPDATE assignments
        SET 
            courseID = @CourseID,
            title = @Title,
            filePath = @FilePath,
            instructions = @Instructions,
            dueDate = @DueDate,
            updatedAt = GETDATE() -- Updates the timestamp to reflect the change
        WHERE assignmentID = @AssignmentID;
    END;
');

        //Deletes an assignment
        DB::unprepared('DROP PROCEDURE IF EXISTS DeleteAssignment');
        DB::unprepared('
            CREATE PROCEDURE DeleteAssignment
            @AssignmentID INT
            AS
            BEGIN
                DELETE FROM assignments
                WHERE assignmentID = @AssignmentID;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
