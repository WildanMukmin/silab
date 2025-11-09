<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('role')) {
    $query->where('role', $request->role);
}

if ($request->filled('status')) {
    $query->where('is_active', $request->status === 'active' ? 1 : 0);
}

if ($request->filled('search')) {
    $search = $request->search;
    $query->where(function($q) use ($search) {
        $q->where('name', 'ILIKE', "%{$search}%")
          ->orWhere('email', 'ILIKE', "%{$search}%")
          ->orWhere('nim', 'ILIKE', "%{$search}%");
    });
}

$users = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();


        $stats = [
            'total' => User::count(),
            'admin' => User::where('role', 'admin')->count(),
            'student' => User::where('role', 'student')->count(),
            'active' => User::where('is_active', true)->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'min:8', 'confirmed', 'regex:/[0-9]/'],
            'role' => 'required|string|in:admin,student',
            'phone' => 'nullable|string|max:20',
            'nim' => 'nullable|string|max:20',
            'jurusan' => 'required|string|max:100',
            'angkatan' => 'required|digits:4',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];

        if ($request->role === 'student') {
            $rules['nim'] = 'required|string|max:20|unique:users,nim';
            $rules['jurusan'] = 'required|string|max:100';
            $rules['angkatan'] = 'required|digits:4';
        }

        $validated = $request->validate($rules);

        try {
            $validated['password'] = Hash::make($validated['password']);
            $validated['id'] = (string) Str::uuid();
            $validated['is_active'] = true;

            if ($request->hasFile('profile_photo')) {
                $file = $request->file('profile_photo');
                $filename = 'profile_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = 'profiles/' . $filename;
                
                $manager = new ImageManager(new Driver());
                $image = $manager->read($file);
                $image->cover(300, 300);
                Storage::disk('public')->put($path, $image->toJpeg());
                
                $validated['profile_photo'] = $path;
            }

            User::create($validated);

            return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', 'Gagal menambahkan user: ' . $e->getMessage());
        }
    }

    public function show(User $user)
    {
        $peminjamanStats = [
            'total' => $user->peminjaman()->count(),
            'active' => $user->peminjaman()->where('status', 'dipinjam')->count(),
            'completed' => $user->peminjaman()->where('status', 'dikembalikan')->count(),
            'pending' => $user->peminjaman()->where('status', 'menunggu')->count(),
        ];

        return view('admin.users.show', compact('user', 'peminjamanStats'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => ['nullable', 'min:8', 'confirmed', 'regex:/[0-9]/'],
            'role' => 'required|in:admin,student',
            'phone' => 'nullable|string|max:20',
            'is_active' => 'required',
            'jurusan' => 'required|string|max:100',
            'angkatan' => 'required|digits:4',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];

        if ($request->role === 'student') {
            $rules['nim'] = 'required|string|max:20|unique:users,nim,' . $user->id;
            $rules['jurusan'] = 'required|string|max:100';
            $rules['angkatan'] = 'required|digits:4';
        }

        $validated = $request->validate($rules);

        try {
            // Convert is_active to boolean
            $validated['is_active'] = filter_var($validated['is_active'], FILTER_VALIDATE_BOOLEAN);
            
            if (!empty($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                unset($validated['password']);
            }

            if ($request->hasFile('profile_photo')) {
                if ($user->profile_photo) {
                    Storage::disk('public')->delete($user->profile_photo);
                }

                $file = $request->file('profile_photo');
                $filename = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = 'profiles/' . $filename;

                $manager = new ImageManager(new Driver());
                $image = $manager->read($file);
                $image->cover(300, 300);
                Storage::disk('public')->put($path, $image->toJpeg());

                $validated['profile_photo'] = $path;
            }

            $user->update($validated);

            return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', 'Gagal memperbarui user: ' . $e->getMessage());
        }
    }

    public function destroy(User $user)
    {
        try {
            if ($user->id === auth()->id()) {
                return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
            }

            if (method_exists($user, 'peminjaman') && $user->peminjaman()->where('status', 'dipinjam')->exists()) {
                return back()->with('error', 'User masih memiliki peminjaman aktif.');
            }

            // Delete profile photo file if exists to avoid orphaned files
            if (!empty($user->profile_photo) && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $user->delete();

            return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }

    public function resetPassword(User $user)
    {
        try {
            $defaultPassword = 'password123';
            $user->update(['password' => Hash::make($defaultPassword)]);
            return back()->with('success', "Password user direset ke: {$defaultPassword}");
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal reset password: ' . $e->getMessage());
        }
    }

    public function toggleStatus(User $user)
    {
        try {
            $user->update(['is_active' => !$user->is_active]);
            $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
            return back()->with('success', "User berhasil {$status}.");
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal mengubah status: ' . $e->getMessage());
        }
    }
}
