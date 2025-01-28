<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestsControllers extends Controller
{
    public function testCertificateNotFound()
{
    return view('errors.error', ['certificateId' => 123]); // Pass any ID
}

public function testGenericError()
{
    return view('errors.generic_error');
}
}
