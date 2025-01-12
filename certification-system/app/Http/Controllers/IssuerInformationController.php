<?php

namespace App\Http\Controllers;

use App\Models\issuer_information;
use App\Http\Requests\Storeissuer_informationRequest;
use App\Http\Requests\Updateissuer_informationRequest;

class IssuerInformationController extends Controller
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
    public function store(Storeissuer_informationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(issuer_information $issuer_information)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updateissuer_informationRequest $request, issuer_information $issuer_information)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(issuer_information $issuer_information)
    {
        //
    }
}
