<?php

namespace App\Http\Controllers;

use App\Models\Issuer;
use App\Http\Requests\Storeissuer_informationRequest;
use App\Http\Requests\Updateissuer_informationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IssuersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}


 
    function prepareOrganizationsWithIssuers()
    {
        $results = DB::connection('sqlsrv')
        ->select('EXEC GetOrganizationWithIssuers');
        $data = [];
        foreach ($results as $row) {
            $orgID = $row->organizationID;

            // Initialize if not exists
            if (!isset($data[$orgID])) {
                $data[$orgID] = [
                    'organizationID' => $orgID,
                    'name' => $row->OrganizationName,
                    'logo' => 'data:image/png;base64,' . base64_encode($row->OrganizationLogo),
                    'issuers' => [],
                ];
            }

            // Add issuer details if available
            if ($row->issuerID) {
                $data[$orgID]['issuers'][] = [
                    'issuerID' => $row->issuerID,
                    'firstName' => $row->firstName,
                    'middleName' => $row->middleName,
                    'lastName' => $row->lastName,
                    'signature' => 'data:image/png;base64,' . base64_encode($row->issuerSignature),
                ];
            }
        }

        return $data;
    }

    public function showOrganizationsWithIssuers()
{
    $data = $this->prepareOrganizationsWithIssuers();

    return view('dashboard.org', ['organizations' => $data]);
}

    /**
     * Store a newly created resource in storage.
     */
    // public function store() {}

    // /**
    //  * Display the specified resource.
    //  */
    // public function show()
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update()
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy()
    // {
    //     //
    // }
}
