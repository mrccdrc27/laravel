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
        DB::unprepared('DROP PROCEDURE IF EXISTS GetIncompleteAssignments');
        DB::unprepared("
                CREATE PROCEDURE GetIncompleteAssignments
                    @facultyID INT
                AS
                BEGIN
                    SELECT 
                CONCAT(UI.firstName, 
                    CASE WHEN UI.middleName IS NOT NULL THEN ' ' + UI.middleName ELSE '' END, 
                    ' ', UI.lastName) AS fullName,
                C.title AS courseTitle,
                A.title AS assignmentTitle,
                S.submittedAt,
                A.dueDate,  
                CASE
                    WHEN S.submittedAt IS NULL THEN 'Not Submitted'
                    WHEN S.submittedAt <= A.dueDate THEN 'On Time'
                    WHEN S.submittedAt > A.dueDate THEN 'Late'
                END AS submissionStatus  -- Calculating submission status
            FROM courses AS C
            INNER JOIN assignments AS A
                ON C.courseID = A.courseID
            INNER JOIN submissions AS S
                ON S.assignmentID = A.assignmentID
            INNER JOIN users AS ST
                ON S.studentID = ST.id
            INNER JOIN users_info AS UI
                ON ST.id = UI.userID
            WHERE C.facultyID = @facultyID 
                AND grade IS NULL
            ORDER BY S.submittedAt;
            END;
        ");

        DB::unprepared('DROP PROCEDURE IF EXISTS GetFacultySubmissions');
        DB::unprepared("
                CREATE PROCEDURE GetFacultySubmissions
                @FacultyID INT,
                @CourseID INT = NULL
            AS
            BEGIN
                SELECT 
                    UI.firstName + ' ' + ISNULL(UI.middleName + ' ', '') + UI.lastName AS fullName,
                    A.assignmentID,
                    A.title,
                    A.instructions,
                    A.dueDate,
                    S.submissionID,
                    S.content,
                    S.submittedAt,
                    CASE 
                        WHEN S.submittedAt > A.dueDate THEN 'Late'
                        ELSE 'On Time'
                    END AS SubmissionStatus
                FROM users AS F
                INNER JOIN courses AS C ON F.id = C.facultyID
                INNER JOIN assignments AS A ON C.courseID = A.courseID
                INNER JOIN submissions AS S ON A.assignmentID = S.assignmentID
                INNER JOIN users AS ST ON ST.id = S.studentID
                INNER JOIN users_info AS UI ON UI.userID = ST.id
                WHERE F.id = @FacultyID
                AND (@CourseID IS NULL OR C.courseID = @CourseID)
            END
        ");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
