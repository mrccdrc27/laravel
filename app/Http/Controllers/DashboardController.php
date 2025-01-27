<?php

namespace App\Http\Controllers;

use App\Models\Certifications;
use App\Models\IssuerInformation;
use App\Models\Organization;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /**
     * Display dashboard home with all entities.
     */
    public function index(): View
    {
        // Use cache to store frequently accessed data
        $cacheTime = now()->addMinutes(5);

        $data = Cache::remember('dashboard_data', $cacheTime, function () {
            return [
                'organizations' => Organization::with('issuers')->get(),
                'userInfo' => UserInfo::with('certifications')->get(),
                'certifications' => Certifications::with(['issuer', 'userinfo'])->get(),
                'issuers' => IssuerInformation::with(['organization', 'certifications'])->get(), //@todo Modify or Remove
            ];
        });

        return view('dashboard.home', $data);
    }

    /**
     * Display counts for dashboard metrics.
     */
    public function counts(): View
    {
        // Cache the counts for better performance
        $cacheTime = now()->addMinutes(5);

        $counts = Cache::remember('dashboard_counts', $cacheTime, function () {
            return [
                'organizations' => Organization::count(),
                'users' => UserInfo::count(),
                'certifications' => Certifications::count(),
                'issuers' => IssuerInformation::count(), //@todo Modify or Remove

                // Add additional statistics
                'activeUsers' => UserInfo::has('certifications')->count(),
                'recentCertifications' => Certifications::where('created_at', '>=', now()->subDays(30))->count(),
            ];
        });

        return view('dashboard.count', ['data' => $counts]);
    }

    /**
     * Get dashboard statistics for a specific time period.
     */
    public function getStats(Request $request): View
    {
        $period = $request->get('period', 'month'); // Default to monthly stats

        $stats = Cache::remember("dashboard_stats_{$period}", now()->addHours(1), function () use ($period) {
            $query = Certifications::query();

            // Apply time period filter
            switch ($period) {
                case 'week':
                    $query->where('created_at', '>=', now()->subWeek());
                    break;
                case 'month':
                    $query->where('created_at', '>=', now()->subMonth());
                    break;
                case 'year':
                    $query->where('created_at', '>=', now()->subYear());
                    break;
            }

            return [
                'total_certifications' => $query->count(),
                'unique_users' => $query->distinct('userID')->count(),
                'by_issuer' => $query->select('issuerID')
                    ->selectRaw('COUNT(*) as count')
                    ->groupBy('issuerID')
                    ->with('issuer:issuerID,firstName,lastName')
                    ->get(),
            ];
        });

        return view('dashboard.stats', ['stats' => $stats, 'period' => $period]);
    }






    //     public function index()
//     {
//     $org = Organization::all();
//     $userinfo = user_info::all();
//     $cert = certifications::all();
//     $issuer = issuer_information::all();

    //     // Return the data to the view with the compacted variables
//     return view('dashboard.home', compact(
//         'userinfo', 
//         'cert',
//         'org',
//         'issuer'
//         )
//     );

    //     }
//     public function count()
// {
//     $data = [
//         'orgCount' => Organization::count(),
//         'userinfoCount' => user_info::count(),
//         'certCount' => certifications::count(),
//         'issuerCount' => issuer_information::count(),
//     ];

    //     // Return the counts to the view with the compacted variable
//     return view('dashboard.count', compact('data'));
// }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
