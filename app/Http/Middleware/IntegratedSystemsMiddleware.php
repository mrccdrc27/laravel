<?php
// IntegratedSystemsMiddleware.php
namespace App\Http\Middleware;

use App\Models\user_info;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IntegratedSystemsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        //@todo: Based on lms, remove or modify 
        try {
            $user = auth()->user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Authentication required'
                ], 401);
            }

            // Get user info from certification system
            $userInfo = user_info::where('email', $user->email)->first();
            
            if (!$userInfo) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found in certification system'
                ], 404);
            }

            // Only check course enrollment for certification endpoints
            if ($request->is('api/certification/*') || $request->is('api/certification')) {
                if ($request->isMethod('post') || $request->isMethod('put')) {
                    $courseId = $request->input('courseID');
                    
                    // Check if course exists in LMS
                    $course = DB::connection('sqlsrv_lms')
                        ->table('courses')
                        ->where('courseID', $courseId)
                        ->first();

                    if (!$course) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Course not found in LMS'
                        ], 404);
                    }

                    // Check enrollment
                    $enrollment = DB::connection('sqlsrv_lms')
                        ->table('enrollment')
                        ->where('studentID', $userInfo->studentID)
                        ->where('courseID', $courseId)
                        ->where('isActive', true) // @todo Modify/remove this if necessary
                        ->first();

                    if (!$enrollment) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Student is not enrolled in this course'
                        ], 403);
                    }

                    // Check course completion
                    $assessments = DB::connection('sqlsrv_lms')
                        ->table('assessment')
                        ->join('submissions', 'assessment.assessmentID', '=', 'submissions.assessmentID')
                        ->where('submissions.studentID', $userInfo->studentID)
                        ->where('courseID', $courseId)
                        ->whereNotNull('submissions.grade')
                        ->get();

                    if ($assessments->isEmpty()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Course completion requirements not met'
                        ], 403);
                    }
                }
            }

            // Add user context to request
            $request->merge([
                'integrated_user' => $userInfo,
                'user_role' => $userInfo->Role ?? 'student'
            ]);

            return $next($request);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error processing request',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}