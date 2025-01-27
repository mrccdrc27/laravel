<?php

namespace App\Http\Controllers;

use App\Models\Certification;
use App\Models\Issuer;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class DisplaysController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $org = Organization::all();
    $userinfo = User::all();
    $cert = Certification::all();
    $issuer = Issuer::all();

    // Return the data to the view with the compacted variables
    return view('dashboard.home', compact(
        'userinfo', 
        'cert',
        'org',
        'issuer'
        )
    );

    }
    public function count()
{
    $data = [
        'orgCount' => Organization::count(),
        'userinfoCount' => User::count(),
        'certCount' => Certification::count(),
        'issuerCount' => Issuer::count(),
    ];

    // Return the counts to the view with the compacted variable
    return view('dashboard.body', compact('data'));
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
