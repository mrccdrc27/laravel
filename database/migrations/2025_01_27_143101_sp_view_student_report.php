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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
