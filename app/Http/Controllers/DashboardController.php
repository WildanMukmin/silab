<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $data = [
            'totalUsers' => User::count()
        ];

        return view('admin.dashboard', $data);
    }

    public function studentDashboard()
    {
        if (Auth::user()->role !== 'student') {
            abort(403, 'Unauthorized action.');
        }

        $studentId = Auth::id();

        $totalPeminjaman = Peminjaman::where('user_id', $studentId)->count();
        $disetujui = Peminjaman::where('user_id', $studentId)->where('status', 'disetujui')->count();
        $menunggu = Peminjaman::where('user_id', $studentId)->where('status', 'menunggu')->count();
        $ditolak = Peminjaman::where('user_id', $studentId)->where('status', 'ditolak')->count();

        $recentLoans = Peminjaman::where('user_id', $studentId)
            ->with('alat')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $data = [
            'totalPeminjaman' => $totalPeminjaman,
            'disetujui' => $disetujui,
            'menunggu' => $menunggu,
            'ditolak' => $ditolak,
            'recentLoans' => $recentLoans,
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