<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Ramsey\Uuid\Uuid;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        // Redirect if already authenticated
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }

        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        // Validate input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
        ]);

        $remember = $request->boolean('remember');

        // Attempt login
        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            
            // Check if account is active
            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun Anda nonaktif. Silakan hubungi admin No.WA 083813181318.'
                ])->onlyInput('email');
            }
            
            // Update last login timestamp
            $user->update([
                'last_login_at' => now()
            ]);

            $request->session()->regenerate();

            // Redirect based on user role
            return $this->redirectBasedOnRole();
        } 

        // Login failed
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Show register form
     */
    public function showRegister()
    {
        // Redirect if already authenticated
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }

        return view('auth.register');
    }

    /**
     * Handle register request
     */
    public function register(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'role' => ['sometimes', 'in:student'], // Only allow student registration
            'terms' => ['accepted'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi',
            'name.max' => 'Nama maksimal 255 karakter',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'password.min' => 'Password minimal 8 karakter',
            'role.in' => 'Role tidak valid',
            'terms.accepted' => 'Anda harus menyetujui syarat dan ketentuan',
        ]);

        // Set role to student for all registrations
        $role = 'student';

        // Buat user baru
        $user = User::create([
            'id' => Uuid::uuid4()->toString(), // UUID valid
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $role,
        ]);

        // Login otomatis
        Auth::login($user);

        // Regenerasi session
        $request->session()->regenerate();

        // Redirect sesuai role + pesan sukses
        return $this->redirectBasedOnRole()->with('success', 'Registrasi berhasil! Selamat datang di Silab.');
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('status', 'Anda telah berhasil logout.');
    }

    /**
     * Redirect user berdasarkan role
     */
    private function redirectBasedOnRole()
    {
        $user = Auth::user();

        // Jika user tidak punya role atau belum login (edge case)
        if (!$user || !$user->role) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Role tidak valid. Silakan hubungi administrator.');
        }

        // Validasi role
        if (!in_array($user->role, ['admin', 'student'])) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Role tidak valid. Silakan hubungi administrator.');
        }

        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'student':
                return redirect()->route('student.dashboard');
            default:
                Auth::logout();
                return redirect()->route('login')->with('error', 'Role tidak valid. Silakan hubungi administrator.');
        }
    }
 }