<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\UserInfo;

class LMSAuthorizationMiddlewareOld
{
    public function handle(Request $request, Closure $next)
    {
        try {
            // Get the authenticated user
            $user = auth()->user(); 
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Authentication required.'
                ], 401);
            }

            // Fetch the user role from the UserInfo model
            $userInfo = $user->userInfo()->first();
            
            if (!$userInfo) {
                return response()->json([
                    'success' => false,
                    'message' => 'User information not found.'
                ], 404);
            }

            $role = $userInfo->Role;

            if (!in_array($role, [UserInfo::ROLE_ADMIN, UserInfo::ROLE_FACULTY])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. Only Faculty and Admin can perform this action.'
                ], 403);
            }

            if ($request->isMethod('post') || $request->isMethod('put')) {
                $courseId = $request->input('CourseID');
                $studentId = $request->input('StudentID');

                $course = Course::with('enrollments.student', 'assessments.submissions')
                    ->find($courseId);

                if (!$course) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Course not found.'
                    ], 404);
                }

                if ($role === UserInfo::ROLE_FACULTY) {
                    if ($course->FacultyID !== $user->UserID) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Unauthorized. Faculty can only manage their own courses.'
                        ], 403);
                    }
                }

                // Check if the student is enrolled and active
                $enrollment = $course->enrollments()
                    ->where('StudentID', $studentId)
                    ->where('IsActive', true)
                    ->first();

                if (!$enrollment) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Student is not actively enrolled in this course.'
                    ], 403);
                }

                // Verify completion of assessments
                // Ensures student has at least one submission with non-null grade
                $completedAssessments = $course->assessments()
                    ->whereHas('submissions', function ($query) use ($studentId) {
                        $query->where('StudentID', $studentId)
                              ->whereNotNull('Grade');
                    })->exists();

                if (!$completedAssessments) { 
                    return response()->json([
                        'success' => false,
                        'message' => 'Student has not completed required assessments for certification.'
                    ], 403);
                }
            }

            // Merge role in request for middleware or controllers
            $request->merge(['lms_role' => $role]);

            return $next($request);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error validating LMS authorization.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
