<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProfileController extends Controller
{
    /**
     * Show profile edit form
     */
    public function edit()
    {
        $user = auth()->user();
        
        // Validate role
        if (!$user->isAdmin() && !$user->isStudent()) {
            abort(403, 'Unauthorized. Role tidak valid.');
        }

        // Redirect based on role
        if ($user->isAdmin()) {
            return view('admin.profile.edit', compact('user'));
        }
        
        return view('student.profile.edit', compact('user'));
    }

    /**
     * Update profile
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => ['nullable','regex:/^08\\d{8,11}$/'],
            'nim' => ['nullable','digits:10'],
            'jurusan' => 'required|string|max:100',
            'angkatan' => 'required|digits:4',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'jurusan.required' => 'Program studi wajib diisi',
            'angkatan.required' => 'Angkatan wajib diisi',
            'angkatan.digits' => 'Angkatan harus 4 digit angka',
        ]);

        // Handle profile photo if uploaded
        if ($request->hasFile('profile_photo')) {
            // delete old
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $file = $request->file('profile_photo');
            $filename = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = 'profiles/' . $filename;

            // Resize using Intervention Image 3.x
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file);
            $image->cover(300, 300);
            Storage::disk('public')->put($path, $image->toJpeg());

            $data['profile_photo'] = $path;
        }

        $user->update($data);
        return back()->with('success', 'Profil berhasil diperbarui.');
}

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
            $request->validate([
                'current_password' => 'required',
                'new_password' => ['required', 'min:8', 'regex:/[0-9]/', 'confirmed'],
            ], [
                'new_password.min' => 'Password minimal 8 karakter',
                'new_password.regex' => 'Password harus mengandung angka',
                'new_password.confirmed' => 'Konfirmasi password tidak cocok'
            ]);

    $user = auth()->user();

    if (!Hash::check($request->current_password, $user->password)) {
        return back()->with('error', 'Password lama salah.');
    }

    $user->update(['password' => Hash::make($request->new_password)]);
    return back()->with('success', 'Password berhasil diganti.');
}

    /**
     * Upload profile photo
     */
    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], // max 2MB
    'name' => 'required|string|max:255',
    'email' => 'required|email',
    'phone' => ['nullable','regex:/^08\d{8,11}$/'],
    'nim' => ['nullable','digits:10'],
    'angkatan' => ['nullable','digits:4'],
        ], [
            'profile_photo.required' => 'Pilih foto profil terlebih dahulu.',
            'profile_photo.image' => 'File harus berupa gambar.',
            'profile_photo.mimes' => 'Format foto harus JPG, JPEG, atau PNG.',
            'profile_photo.max' => 'Ukuran foto maksimal 2MB.',
        ]);

        try {
            $user = auth()->user();

            // Delete old photo if exists
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            // Process and save new photo
            $file = $request->file('profile_photo');
            $filename = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = 'profiles/' . $filename;

            // Resize image to 300x300 using Intervention Image 3.x
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file);
            $image->cover(300, 300);
            Storage::disk('public')->put($path, $image->toJpeg());

            // Update user
            $user->update(['profile_photo' => $path]);

            return redirect()->back()->with('success', 'Foto profil berhasil diupload!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal upload foto: ' . $e->getMessage());
        }
    }

    /**
     * Delete profile photo
     */
    public function destroyPhoto()
{
    $user = auth()->user();
    if ($user->profile_photo) {
        Storage::disk('public')->delete($user->profile_photo);
        $user->update(['profile_photo' => null]);
    }
    return back()->with('success', 'Foto profil dihapus.');
}

    /**
     * Alias for route compatibility (some routes expect deletePhoto)
     */
    public function deletePhoto()
    {
        return $this->destroyPhoto();
    }
}
