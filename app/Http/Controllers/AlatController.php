<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AlatController extends Controller
{
    public function index(Request $request)
    {
        $stats = [
            'tersedia' => Alat::where('status', 'Tersedia')->count(),
            'digunakan' => Alat::where('status', 'Sedang Digunakan')->count(),
            'maintenance' => Alat::where('status', 'Maintenance')->count(),
            'rusak' => Alat::where('status', 'Rusak')->count(),
        ];

        $query = Alat::query();

        if ($request->filled('search')) {
            $query->where('nama_alat', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status') && $request->status != 'Semua Status') {
            $query->where('status', $request->status);
        }

        $alatList = $query->latest()->paginate(9);
        return view('admin.alat.index', compact('stats', 'alatList'));
    }

    public function create()
    {
        return view('admin.alat.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_alat' => 'required|string|max:255',
            'status' => ['required', Rule::in(['Tersedia', 'Sedang Digunakan', 'Maintenance', 'Rusak'])],
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            // Simpan langsung ke public/alat (lebih sederhana untuk pemula)
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('alat'), $filename);
            $validated['gambar'] = 'alat/' . $filename;
        }

        Alat::create($validated);

        return redirect()->route('admin.alat.index')->with('success', 'Alat berhasil ditambahkan.');
    }
    public function show(Alat $alat)
    {
        return redirect()->route('admin.alat.edit', $alat);
    }
    public function edit(Alat $alat)
    {
        return view('admin.alat.edit', compact('alat'));
    }
    public function update(Request $request, Alat $alat)
    {
        $validated = $request->validate([
            'nama_alat' => 'required|string|max:255',
            'status' => ['required', Rule::in(['Tersedia', 'Sedang Digunakan', 'Maintenance', 'Rusak'])],
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($alat->gambar && file_exists(public_path($alat->gambar))) {
                unlink(public_path($alat->gambar));
            }
            // Simpan gambar baru ke public/alat
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('alat'), $filename);
            $validated['gambar'] = 'alat/' . $filename;
        }

        $alat->update($validated);

        return redirect()->route('admin.alat.index')->with('success', 'Alat berhasil diperbarui.');
    }

    public function destroy(Alat $alat)
    {
        // Hapus gambar jika ada
        if ($alat->gambar && file_exists(public_path($alat->gambar))) {
            unlink(public_path($alat->gambar));
        }

        $alat->delete();

        return redirect()->route('admin.alat.index')->with('success', 'Alat berhasil dihapus.');
    }
    public function studentIndex(Request $request)
    {
        // Check if user is student
        if (Auth::user()->role !== 'student') {
            abort(403, 'Unauthorized action.');
        }

        $stats = [
            'tersedia' => Alat::where('status', 'Tersedia')->count(),
            'digunakan' => Alat::where('status', 'Sedang Digunakan')->count(),
            'maintenance' => Alat::where('status', 'Maintenance')->count(),
            'rusak' => Alat::where('status', 'Rusak')->count(),
        ];

        $query = Alat::query();

        if ($request->filled('search')) {
            $query->where('nama_alat', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status') && $request->status != 'Semua Status') {
            $query->where('status', $request->status);
        }

        $alatList = $query->latest()->paginate(9);
        return view('student.alat.index', compact('stats', 'alatList'));
    }
}