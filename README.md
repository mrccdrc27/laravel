1. composer instell
2. cp .env.example .env
3. npm install
4. php artisan key:generate
5. npm run build
6. npm run dev
7. php artisan storage:link

configure database sql server

stored procedure:
    - authentication features not in stored procedure
    - after authentication
        - no sql command within the laravel controllers/frontend
    - migration stored procedure
        - ensure stored procedure migrates seamlessly
        - sp_{table}, ex. sp_modules

how to use stored procedure:
    - used within the controller,
    - no model involved, violates MVC
        - ex.   DB::statement('EXEC CreateEnrollment ?, ?', [
                $request->course_id,  // Course ID
                $request->student_id, // Student ID
            ]);
    
disadvantage:
    - cannot use varbinary(max)
        workaround:
            - use laravel storage

- rework database to use filepath (if table requires data), no need for file name



routing:
    - routing path
    - fix routing



