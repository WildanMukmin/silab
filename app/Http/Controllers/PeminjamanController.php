<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->role !== 'student') {
            abort(403, 'Unauthorized action.');
        }

        $studentId = Auth::id();
        $tab = $request->get('tab', 'aktif'); 

        $totalPeminjaman = Peminjaman::where('user_id', $studentId)->count();
        $disetujui = Peminjaman::where('user_id', $studentId)->where('status', 'disetujui')->count();
        $menunggu = Peminjaman::where('user_id', $studentId)->where('status', 'menunggu')->count();
        $selesai = Peminjaman::where('user_id', $studentId)->where('status', 'selesai')->count();

        if ($tab === 'aktif') {
            $peminjaman = Peminjaman::where('user_id', $studentId)
                ->whereIn('status', ['disetujui', 'menunggu'])
                ->with('alat')
                ->orderBy('tanggal_peminjaman', 'desc')
                ->orderBy('waktu_mulai', 'desc')
                ->get();
        } else {
            $peminjaman = Peminjaman::where('user_id', $studentId)
                ->with('alat')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        $data = [
            'totalPeminjaman' => $totalPeminjaman,
            'disetujui' => $disetujui,
            'menunggu' => $menunggu,
            'selesai' => $selesai,
            'peminjaman' => $peminjaman,
            'tab' => $tab,
        ];

        return view('student.peminjaman.index', $data);
    }

    public function create()
    {
        if (Auth::user()->role !== 'student') {
            abort(403, 'Unauthorized action.');
        }

        $alatList = Alat::where('status', 'Tersedia')
            ->orderBy('nama_alat', 'asc')
            ->get();

        return view('student.peminjaman.create', compact('alatList'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'student') {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'alat_id' => 'required|exists:alat,id',
            'tanggal_peminjaman' => 'required|date|after_or_equal:today',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->waktu_mulai && $value && strtotime($value) <= strtotime($request->waktu_mulai)) {
                        $fail('Waktu selesai harus setelah waktu mulai.');
                    }
                },
            ],
            'tujuan_penggunaan' => 'required|string|max:255',
            'catatan_tambahan' => 'nullable|string',
            'lokasi_peminjaman' => 'nullable|string|max:255',
        ], [
            'alat_id.required' => 'Pilih alat yang ingin dipinjam',
            'alat_id.exists' => 'Alat yang dipilih tidak valid',
            'tanggal_peminjaman.required' => 'Tanggal peminjaman wajib diisi',
            'tanggal_peminjaman.date' => 'Format tanggal tidak valid',
            'tanggal_peminjaman.after_or_equal' => 'Tanggal peminjaman tidak boleh di masa lalu',
            'waktu_mulai.required' => 'Waktu mulai wajib diisi',
            'waktu_mulai.date_format' => 'Format waktu mulai tidak valid (HH:MM)',
            'waktu_selesai.required' => 'Waktu selesai wajib diisi',
            'waktu_selesai.date_format' => 'Format waktu selesai tidak valid (HH:MM)',
            'tujuan_penggunaan.required' => 'Tujuan penggunaan wajib diisi',
            'tujuan_penggunaan.max' => 'Tujuan penggunaan maksimal 255 karakter',
        ]);

        try {
            $peminjaman = Peminjaman::create([
                'user_id' => Auth::id(),
                'alat_id' => $validated['alat_id'],
                'tanggal_peminjaman' => $validated['tanggal_peminjaman'],
                'waktu_mulai' => $validated['waktu_mulai'],
                'waktu_selesai' => $validated['waktu_selesai'],
                'tujuan_penggunaan' => $validated['tujuan_penggunaan'],
                'catatan_tambahan' => $validated['catatan_tambahan'] ?? null,
                'lokasi_peminjaman' => $validated['lokasi_peminjaman'] ?? null,
                'status' => 'menunggu',
            ]);

            return redirect()->route('student.peminjaman')
                ->with('success', 'Peminjaman berhasil diajukan. Menunggu persetujuan admin.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal mengajukan peminjaman: ' . $e->getMessage());
        }
    }
}

