<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Admin Dashboard
     */
    public function adminDashboard()
    {
        // Check if user is admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $data = [
            'totalUsers' => User::count()
        ];

        return view('admin.dashboard', $data);
    }

    /**
     * Student Dashboard
     */
    public function studentDashboard()
    {
        // Check if user is student
        if (Auth::user()->role !== 'student') {
            abort(403, 'Unauthorized action.');
        }

        $studentId = Auth::id();

        $data = [
            'totalUsers' => User::count()
        ];

        return view('student.dashboard', $data);
    }


    public function home()
    {
        $data = [
            'totalUsers' => User::count()
        ];

        return view('home', $data);
    }
}