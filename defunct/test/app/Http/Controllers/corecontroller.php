<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\core;

class corecontroller extends Controller
{
    public function index(){
        $core = core::all();
        return view('test', compact('core'));
    }
}
