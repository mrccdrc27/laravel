<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use app\Models\User;

class RBAC extends Controller
{
    public function index()
    {
        if(Auth::id()){
            $role = Auth::user()->role;
            if($role == 'student'){
                return view ('dashboard.student');
            }
            if($role == 'admin'){
                return view ('dashboard.admin');
            }
            if($role == 'root'){
                return view ('dashboard.admin');
            }
            if($role == 'faculty'){
                return view ('dashboard.faculty');
            }
        }
        
    }

    public function Courses()
    {
        if(Auth::id()){
            $role = Auth::user()->role;
            if($role == 'student'){
                return view ('dashboard.student.courses');
            }
            if($role == 'faculty'){
                return view ('dashboard.faculty.courses');
            }
        }
    }
}
