<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(User::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Username' => 'required|unique:users,Username|max:50',
            'PasswordHash' => 'required',
        ]);

        $user = User::create([
            'Username' => $request->Username,
            'PasswordHash' => bcrypt($request->PasswordHash),
        ]);

        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'Username' => 'required|max:50',
            'PasswordHash' => 'required',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'Username' => $request->Username,
            'PasswordHash' => bcrypt($request->PasswordHash),
        ]);

        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
