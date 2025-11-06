<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class AdminPeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'semua');

        $peminjaman = Peminjaman::with(['user', 'alat'])
            ->when($status !== 'semua', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10); 

        return view('admin.peminjaman', compact('peminjaman', 'status'));

        $counts = [
            'menunggu' => Peminjaman::where('status', 'menunggu')->count(),
            'disetujui' => Peminjaman::where('status', 'disetujui')->count(),
            'selesai' => Peminjaman::where('status', 'selesai')->count(),
            'ditolak' => Peminjaman::where('status', 'ditolak')->count(),
        ];

    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak,selesai',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status peminjaman berhasil diperbarui.');
    }
}
