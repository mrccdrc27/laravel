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
        DB::unprepared('DROP PROCEDURE IF EXISTS GetAssignmentStatusForStudent');
        DB::unprepared("
        CREATE PROCEDURE GetAssignmentStatusForStudent
        @studentID INT
        AS
        BEGIN
        SELECT 
        C.title,
        A.dueDate,
            CASE
            WHEN S.submissionID IS NULL THEN 'Pending'
            ELSE 'Submitted'
            END AS assignment_status
        FROM enrollment E
        INNER JOIN courses C ON E.courseID = C.courseID
        INNER JOIN assignments A ON C.courseID = A.courseID
        LEFT JOIN submissions S ON A.assignmentID = S.assignmentID AND E.studentID = S.studentID
        WHERE E.studentID = @studentID;
        END;
        ");
        
        DB::unprepared('DROP PROCEDURE IF EXISTS GetStudentDetailsByCourse');
        DB::unprepared("
            CREATE PROCEDURE GetStudentDetailsByCourse
                @CourseID INT
            AS
            BEGIN
                SELECT 
                    S.id,
                    UI.firstName,
                    UI.middleName,
                    UI.lastName,
                    UI.birthDate,
                    UI.sex,
                    UI.nationality,
                    UI.birthPlace,
                    S.email
                FROM users AS S
                INNER JOIN users_info AS UI ON S.id = UI.userID
                INNER JOIN enrollment AS E ON S.id = E.studentID
                WHERE E.courseID = @CourseID;
            END;
        ");

        DB::unprepared('DROP PROCEDURE IF EXISTS GetPendingAssignmentsStudent');
        DB::unprepared("
        CREATE PROCEDURE GetPendingAssignmentsStudent
        @studentID INT
        AS
        BEGIN
        SELECT 
            C.title AS CourseTitle,
            A.title AS AssignmentTitle,
            A.dueDate,
            CASE
                WHEN A.dueDate < GETDATE() THEN 'Past Due'
                ELSE 'Pending'
            END AS SubmissionStatus
        FROM enrollment AS E
        INNER JOIN courses AS C
            ON E.courseID = C.courseID
        INNER JOIN assignments AS A
            ON C.courseID = A.courseID
        LEFT JOIN submissions AS S
            ON A.assignmentID = S.assignmentID
            AND S.studentID = @StudentID
        WHERE E.studentID = @StudentID
            AND S.submissionID IS NULL
        ORDER BY A.dueDate;
    END;

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
