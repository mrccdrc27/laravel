<?php

namespace App\Http\Controllers;

use App\Models\Toy; // Import the Toy model
use Illuminate\Http\Request;

class ToyController extends Controller
{
    public function index()
    {
        $toys = Toy::all(); // Get all toys from the database
        return view('toys', compact('toys')); // Send toy data to the view
    }
}