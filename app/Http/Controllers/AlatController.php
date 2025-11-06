<?php
// NAMA FILE: app/Http/Controllers/AlatController.php
// (Disederhanakan sesuai model baru)

namespace App\Http\Controllers;

use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AlatController extends Controller
{
    /**
     * Menampilkan halaman utama manajemen alat.
     */
    public function index(Request $request)
    {
        $stats = [
            'tersedia' => Alat::where('status', 'Tersedia')->count(),
            'digunakan' => Alat::where('status', 'Sedang Digunakan')->count(),
            'maintenance' => Alat::where('status', 'Maintenance')->count(),
            'rusak' => Alat::where('status', 'Rusak')->count(),
        ];

        $query = Alat::query();

        // Filter pencarian berdasarkan nama
        if ($request->filled('search')) {
            $query->where('nama_alat', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan status
        if ($request->filled('status') && $request->status != 'Semua Status') {
            $query->where('status', $request->status);
        }

        $alatList = $query->latest()->paginate(9);
        return view('admin.alat.index', compact('stats', 'alatList'));
    }

    /**
     * Menampilkan formulir untuk menambah alat baru.
     */
    public function create()
    {
        return view('admin.alat.create');
    }

    /**
     * Menyimpan alat baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_alat' => 'required|string|max:255',
            'status' => ['required', Rule::in(['Tersedia', 'Sedang Digunakan', 'Maintenance', 'Rusak'])],
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('public/alat');
            $validated['gambar'] = $path;
        }

        Alat::create($validated);

        return redirect()->route('admin.alat.index')->with('success', 'Alat berhasil ditambahkan.');
    }

    /**
     * Menampilkan data alat (opsional, bisa diganti edit).
     */
    public function show(Alat $alat)
    {
        return redirect()->route('admin.alat.edit', $alat);
    }

    /**
     * Menampilkan formulir untuk mengedit alat.
     */
    public function edit(Alat $alat)
    {
        return view('admin.alat.edit', compact('alat'));
    }

    /**
     * Memperbarui data alat di database.
     */
    public function update(Request $request, Alat $alat)
    {
        $validated = $request->validate([
            'nama_alat' => 'required|string|max:255',
            'status' => ['required', Rule::in(['Tersedia', 'Sedang Digunakan', 'Maintenance', 'Rusak'])],
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($alat->gambar) {
                Storage::delete($alat->gambar);
            }
            $path = $request->file('gambar')->store('public/alat');
            $validated['gambar'] = $path;
        }

        $alat->update($validated);

        return redirect()->route('admin.alat.index')->with('success', 'Alat berhasil diperbarui.');
    }

    /**
     * Menghapus data alat dari database.
     */
    public function destroy(Alat $alat)
    {
        if ($alat->gambar) {
            Storage::delete($alat->gambar);
        }

        $alat->delete();

        return redirect()->route('admin.alat.index')->with('success', 'Alat berhasil dihapus.');
    }
}