<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class admin extends Controller
{
    public function Announcement($facultyID)
    {
        return view('');
    }

    public function insert(Request $request)
    {
        DB::statement('EXEC InsertAnnouncement ?, ?, ?, ?, ?, ?', [
            $request->title,
            $request->body,
            $request->author,
            $request->date_posted,
            $request->date_expiry,
            $request->is_active,
        ]);
        return redirect()->back()->with('success', 'Course created successfully.');
    }

    public function update($facultyID)
    {
        return view('');
    }

    public function delet($facultyID)
    {
        return view('');
    }


    
}
