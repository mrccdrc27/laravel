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

        //Creates a submission table
        DB::unprepared('DROP PROCEDURE IF EXISTS createSubmission');
        DB::unprepared('
            CREATE PROCEDURE createSubmission
                @AssignmentID BIGINT,
                @StudentID BIGINT,
                @Content NVARCHAR(MAX),
                @FilePath NVARCHAR(MAX),
                @Grade FLOAT
            AS
            BEGIN
                -- Suppresses the "rows affected" messages
                SET NOCOUNT ON;
        
                -- Insert a new submission into the submissions table
                INSERT INTO submissions (assignmentID, studentID, content, filePath, submittedAt,grade)
                VALUES (@AssignmentID, @StudentID, @Content, @FilePath, GETDATE(),@Grade);
            END;
        ');
        
        //creates an update table  
        DB::unprepared('DROP PROCEDURE IF EXISTS updateSubmission');
        DB::unprepared('
            CREATE PROCEDURE updateSubmission
                @SubmissionID BIGINT,
                @AssignmentID BIGINT,
                @StudentID BIGINT,
                @Content NVARCHAR(MAX),
                @FilePath NVARCHAR(MAX),
                @Grade FLOAT
            AS
            BEGIN
                -- Suppresses the "rows affected" messages
                SET NOCOUNT ON;

                -- Update the submission in the submissions table
                UPDATE submissions
                SET 
                    assignmentID = @AssignmentID,
                    studentID = @StudentID,
                    content = @Content,
                    filePath = @FilePath,
                    grade = @Grade,
                    submittedAt = GETDATE() -- Updates the submission timestamp
                WHERE submissionID = @SubmissionID;
            END;
        ');

        //Deletes a submission
        DB::unprepared('DROP PROCEDURE IF EXISTS DeleteSubmission');
        DB::unprepared('
            CREATE PROCEDURE DeleteSubmission
            @submissionID INT
            AS
            BEGIN
                DELETE FROM submissions
                WHERE submissionID = @submissionID;
            END;
        ');

        // updateSubmissionGrade
        DB::unprepared('DROP PROCEDURE IF EXISTS updateSubmissionGrade');
        DB::unprepared('
            CREATE PROCEDURE updateSubmissionGrade
                @SubmissionID BIGINT,
                @Grade FLOAT
            AS
            BEGIN
                -- Suppresses the "rows affected" messages
                SET NOCOUNT ON;

                -- Update only the grade in the submissions table
                UPDATE submissions
                SET 
                    grade = @Grade,
                    submittedAt = GETDATE() -- Updates the timestamp to reflect grade modification
                WHERE submissionID = @SubmissionID;
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
