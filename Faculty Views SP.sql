-- faculty SP VIEW

-- select students who is enrolled to a professor
SELECT COUNT(S.id) AS NumberOfStudents
FROM enrollment AS E
INNER JOIN courses AS C ON E.courseID = C.courseID
INNER JOIN users AS S ON S.id = E.studentID
WHERE C.facultyID = 1 AND S.role = 'student';

go
-- stored procedure GetStudentCountByFaculty
CREATE PROCEDURE GetStudentCountByFaculty
    @FacultyID INT
AS
BEGIN
    SELECT COUNT(S.id) AS NumberOfStudents
    FROM enrollment AS E
    INNER JOIN courses AS C ON E.courseID = C.courseID
    INNER JOIN users AS S ON S.id = E.studentID
    WHERE C.facultyID = @FacultyID AND S.role = 'student';
END;




-- select students who is enrolled to a course
SELECT 
    CONCAT(UI.lastName, ', ', UI.firstName, ' ', COALESCE(UI.middleName, '')) AS FullName,
    E.enrolledAt
FROM users_info AS UI
INNER JOIN users AS S ON UI.userID = S.id
INNER JOIN enrollment AS E ON S.id = E.studentID
WHERE S.role = 'student'
AND E.courseID = 4
ORDER BY FullName ASC; -- Sort by concatenated name


-- selects latest submissions on a course
-- havent graded yet
-- (upcoming faculty)
SELECT 
    S.submissionID, 
    S.assignmentID, 
    A.title, 
    CONCAT(UI.firstName, ' ', COALESCE(UI.middleName, ''), ' ', UI.lastName) AS FullName
FROM submissions AS S
INNER JOIN assignments AS A ON S.assignmentID = A.assignmentID
INNER JOIN courses AS C ON A.courseID = C.courseID
INNER JOIN users AS ST ON ST.id = S.studentID
INNER JOIN users_info AS UI ON ST.id = UI.userID
WHERE ST.role = 'student' 
AND S.grade IS NULL
AND C.courseID = 2
ORDER BY S.submittedAt ASC;

go
-- stored procedure GetUngradedSubmissionsByCourse
CREATE PROCEDURE GetUngradedSubmissionsByCourse
    @CourseID INT
AS
BEGIN
    SELECT 
        S.submissionID, 
        S.assignmentID, 
        A.title,
        S.submittedAt,
        CONCAT(UI.firstName, ' ', COALESCE(UI.middleName, ''), ' ', UI.lastName) AS FullName
    FROM submissions AS S
    INNER JOIN assignments AS A ON S.assignmentID = A.assignmentID
    INNER JOIN courses AS C ON A.courseID = C.courseID
    INNER JOIN users AS ST ON ST.id = S.studentID
    INNER JOIN users_info AS UI ON ST.id = UI.userID
    WHERE ST.role = 'student' 
    AND S.grade IS NULL
    AND C.courseID = @CourseID
    ORDER BY S.submittedAt ASC;
END;

GetUngradedSubmissionsByCourse 2

go

-- selects all submission from student from a course
GetStudentSubmissions 2, 1;
go

-- insert grades
updateSubmissionGrade 4,60
go

-- select all submissions who submitted on time
SELECT
    A.dueDate,
    S.submittedAt,
    CASE 
        WHEN A.dueDate >= S.submittedAt THEN 'On Time'
        ELSE 'Late'
    END AS Remarks
FROM submissions AS S
INNER JOIN assignments AS A ON S.assignmentID = A.assignmentID
INNER JOIN courses AS C ON A.courseID = C.courseID
WHERE A.dueDate > S.submittedAt and C.courseID = 2
;

--select all student who havent yet submitted to the assignment

    -- all submissions associated on a course
    select
    S.assignmentID, S.submittedAt
    from submissions as S
    inner join assignments as A
    ON S.assignmentID = A.assignmentID
    inner join courses as C
    ON A.courseID = C.courseID
    where C.courseID = 2
    ORDER BY S.submittedAt

    -- all enrollment associated on a course
    select *
    from enrollment as E
    inner join courses as S
    on E.courseID = S.courseID
    where S.courseID = 2

    SELECT 
    A.assignmentID, 
    A.title, 
    A.dueDate,
    COUNT(DISTINCT S.studentID) AS SubmittedStudents,
    COUNT(DISTINCT E.studentID) - COUNT(DISTINCT S.studentID) AS NotSubmittedStudents
    FROM assignments AS A
    INNER JOIN courses AS C ON A.courseID = C.courseID
    INNER JOIN enrollment AS E ON E.courseID = C.courseID
    LEFT JOIN submissions AS S ON S.assignmentID = A.assignmentID AND S.studentID = E.studentID
    WHERE C.courseID = 2
    GROUP BY A.assignmentID, A.title, A.dueDate;

    Select * from courses


-- update assignment pass/fail
-- assignment has passing grade

GetStudentSubmissions 1

