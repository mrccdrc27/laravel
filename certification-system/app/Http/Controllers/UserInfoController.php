<?php

namespace App\Http\Controllers;

use App\Models\user_info;
use App\Http\Requests\Storeuser_infoRequest;
use App\Http\Requests\Updateuser_infoRequest;

class UserInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Storeuser_infoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(user_info $user_info)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updateuser_infoRequest $request, user_info $user_info)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(user_info $user_info)
    {
        //
    }
}
