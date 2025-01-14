<?php

namespace App\Http\Controllers;

use App\Models\certifications;
use App\Models\issuer_information;
use App\Models\organization;
use App\Models\user_info;

use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class display extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $org = Organization::all();
    $userinfo = user_info::all();
    $cert = certifications::all();
    $issuer = issuer_information::all();

    // Return the data to the view with the compacted variables
    return view('dashboard.home', compact(
        'userinfo', 
        'cert',
        'org',
        'issuer'
        )
    );

    }

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
