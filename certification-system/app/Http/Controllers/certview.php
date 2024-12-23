<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\V2\CertificationController;
class certview extends Controller
{
    public function showCertificate()
    {
        // Returning the view
        return view('dashboard/certview');
    }

    public function showDashboard(){
        // Returning the view
        return view('dashboard/home');
    }

    public function searchCertificate(){
        //return 
        return view(view: 'dashboard/searchcertification');
    }
}
