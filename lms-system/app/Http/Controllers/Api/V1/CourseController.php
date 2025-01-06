<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use DB;

class CourseController
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
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            $validated = $request->validate([
                'Title' => 'required|string|max:100',
                'Description' => 'nullable|string|max:65535',
                'FacultyID' => 'nullable|integer|exists:users,UserID',
                'StudentID' => 'nullable|integer|exists:users,UserID',
                'IsPublic' => 'required|boolean',
                'FileName' => 'required|string|max:255',
                'FileType' => 'required|string|max:50',
                'FileData' => '',
                'CreatedAt' => 'required|date'
            ]);

        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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
