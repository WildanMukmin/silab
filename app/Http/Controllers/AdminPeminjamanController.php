<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PeminjamanExport;

class AdminPeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');

        // Hitung jumlah per status untuk card
        $menunggu = Peminjaman::where('status', 'menunggu')->count();
        $disetujui = Peminjaman::where('status', 'disetujui')->count();
        $selesai = Peminjaman::where('status', 'selesai')->count();
        $ditolak = Peminjaman::where('status', 'ditolak')->count();

        // Filter data berdasarkan status
        $query = Peminjaman::with(['user', 'alat']);
        if ($status && $status != 'semua') {
            $query->where('status', $status);
        }

        $peminjaman = $query->latest()->paginate(10);

        return view('admin.peminjaman', compact(
            'peminjaman', 'menunggu', 'disetujui', 'selesai', 'ditolak', 'status'
        ));
    }


    public function updateStatus(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $status = $request->input('status');

        // Validasi status yang boleh digunakan
        $allowedStatuses = ['menunggu', 'disetujui', 'ditolak', 'selesai'];

        if (!in_array($status, $allowedStatuses)) {
            return back()->with('error', 'Status tidak valid.');
        }

        $peminjaman->status = $status;
        $peminjaman->save();

        return back()->with('success', 'Status peminjaman berhasil diperbarui menjadi ' . ucfirst($status) . '.');
    }


    public function show($id)
    {
        $peminjaman = Peminjaman::with(['user', 'alat'])->findOrFail($id);
        return view('admin.detail-peminjaman', compact('peminjaman'));
    }

    public function verifikasi($id, $status, Request $request)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->status = $status;

        if ($status === 'ditolak') {
            $peminjaman->alasan_penolakan = $request->input('alasan_penolakan');
        } else {
            $peminjaman->alasan_penolakan = null;
        }

        $peminjaman->save();

        return redirect()->route('admin.peminjaman')->with('success', 'Status peminjaman berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->delete();
        return redirect()->route('admin.peminjaman')->with('success', 'Data peminjaman berhasil dihapus.');
    }

    public function export(Request $request)
    {
        return Excel::download(new PeminjamanExport, 'data_peminjaman.xlsx');
    }

}
