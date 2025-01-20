<?php
CREATE PROCEDURE InsertEnrollment
                @CourseID BIGINT,
                @StudentID BIGINT,
                @IsActive BIT = 1  -- Default value is true (active)
            AS
            BEGIN
                -- Insert a new record into the enrollments table
                INSERT INTO enrollments (courseID, studentID, enrolledAt, isActive)
                VALUES (@CourseID, @StudentID, GETDATE(), @IsActive);
                
                -- Optional: Return the enrollmentID (if needed)
                SELECT SCOPE_IDENTITY() AS EnrollmentID;
            END;